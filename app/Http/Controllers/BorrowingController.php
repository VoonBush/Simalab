<?php

namespace App\Http\Controllers;

use App\Events\BorrowingSubmitted;
use App\Models\Borrowing;
use App\Models\Item;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole(['asisten_lab', 'pj'])) {
            $borrowings = Borrowing::with(['user', 'details.item'])
                ->latest()
                ->paginate(15);
        } else {
            $borrowings = Borrowing::with(['details.item'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);
        }

        return view('borrowings.index', compact('borrowings'));
    }

    public function create(Request $request)
    {
        $initialItem = $request->item_id ? Item::findOrFail($request->item_id) : null;
        $items = Item::where('available_stock', '>', 0)->get();
        return view('borrowings.create', compact('initialItem', 'items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'borrow_date'      => 'required|date|after_or_equal:today',
            'return_date'      => 'required|date|after:borrow_date',
            'purpose'          => 'required|string|max:500',
            'notes'            => 'nullable|string|max:500',
        ]);

        // Validasi stok semua item sebelum membuat transaksi
        foreach ($validated['items'] as $itemData) {
            $item = Item::findOrFail($itemData['id']);
            if ($item->available_stock < $itemData['quantity']) {
                return back()->withErrors(['items' => "Stok {$item->name} tersedia hanya {$item->available_stock} unit."])->withInput();
            }
        }

        $borrowing = Borrowing::create([
            'borrow_date' => $validated['borrow_date'],
            'return_date' => $validated['return_date'],
            'purpose'     => $validated['purpose'],
            'notes'       => $validated['notes'] ?? null,
            'borrow_code' => Borrowing::generateCode(),
            'user_id'     => auth()->id(),
            'status'      => 'pending',
        ]);

        foreach ($validated['items'] as $itemData) {
            $borrowing->details()->create([
                'item_id'  => $itemData['id'],
                'quantity' => $itemData['quantity'],
            ]);
            // 🔥 Kurangi stok sementara
            $item = Item::find($itemData['id']);
            $item->decrement('available_stock', $itemData['quantity']);
        }

        BorrowingSubmitted::dispatch($borrowing->load('user', 'details.item'));

        return redirect()->route('borrowings.index')
            ->with('success', "Permintaan peminjaman {$borrowing->borrow_code} berhasil dikirim! Menunggu persetujuan Asisten Lab.");
    }

    public function show(Borrowing $borrowing)
    {
        abort_unless(
            auth()->id() === $borrowing->user_id || auth()->user()->hasRole(['asisten_lab', 'pj']),
            403
        );
        $borrowing->load('user', 'details.item.location', 'approver');
        return view('borrowings.show', compact('borrowing'));
    }

    public function approve(Borrowing $borrowing)
    {
        abort_unless(auth()->user()->hasRole(['asisten_lab', 'pj']), 403);

        $borrowing->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', "Peminjaman {$borrowing->borrow_code} disetujui!");
    }

    public function reject(Request $request, Borrowing $borrowing)
    {
        abort_unless(auth()->user()->hasRole(['asisten_lab', 'pj']), 403);

        $request->validate(['rejection_reason' => 'required|string|max:500']);

        // Kembalikan stok
        foreach ($borrowing->details as $detail) {
            $detail->item->increment('available_stock', $detail->quantity);
        }

        $borrowing->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by'      => auth()->id(),
        ]);

        return back()->with('success', "Peminjaman {$borrowing->borrow_code} ditolak.");
    }

    public function markReturned(Borrowing $borrowing)
    {
        abort_unless(auth()->user()->hasRole(['asisten_lab', 'pj']), 403);

        foreach ($borrowing->details as $detail) {
            $detail->item->increment('available_stock', $detail->quantity);
        }
        
        $borrowing->update([
            'status'             => 'returned',
            'actual_return_date' => today(),
        ]);

        return back()->with('success', "Peminjaman {$borrowing->borrow_code} berhasil dikembalikan.");
    }
}
