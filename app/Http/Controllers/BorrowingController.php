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

        if ($user->hasRole(['asisten_lab', 'plp', 'koordinator'])) {
            $borrowings = Borrowing::with(['user', 'item'])
                ->latest()
                ->paginate(15);
        } else {
            $borrowings = Borrowing::with(['item'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);
        }

        return view('borrowings.index', compact('borrowings'));
    }

    public function create(Request $request)
    {
        $item = Item::findOrFail($request->item_id);
        return view('borrowings.create', compact('item'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id'     => 'required|exists:items,id',
            'quantity'    => 'required|integer|min:1',
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrow_date',
            'purpose'     => 'required|string|max:500',
            'notes'       => 'nullable|string|max:500',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($item->available_stock < $validated['quantity']) {
            return back()->withErrors(['quantity' => "Stok tersedia hanya {$item->available_stock} unit."])
                ->withInput();
        }

        $borrowing = Borrowing::create([
            ...$validated,
            'borrow_code' => Borrowing::generateCode(),
            'user_id'     => auth()->id(),
            'status'      => 'pending',
        ]);

        // 🔥 Kurangi stok sementara & broadcast ke Asisten Lab
        $item->decrement('available_stock', $validated['quantity']);
        BorrowingSubmitted::dispatch($borrowing->load('user', 'item'));

        return redirect()->route('borrowings.index')
            ->with('success', "Permintaan peminjaman {$borrowing->borrow_code} berhasil dikirim! Menunggu persetujuan Asisten Lab.");
    }

    public function show(Borrowing $borrowing)
    {
        abort_unless(
            auth()->id() === $borrowing->user_id || auth()->user()->hasRole(['asisten_lab', 'plp', 'koordinator']),
            403
        );
        $borrowing->load('user', 'item.location', 'approver');
        return view('borrowings.show', compact('borrowing'));
    }

    public function approve(Borrowing $borrowing)
    {
        abort_unless(auth()->user()->hasRole(['asisten_lab', 'plp', 'koordinator']), 403);

        $borrowing->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', "Peminjaman {$borrowing->borrow_code} disetujui!");
    }

    public function reject(Request $request, Borrowing $borrowing)
    {
        abort_unless(auth()->user()->hasRole(['asisten_lab', 'plp', 'koordinator']), 403);

        $request->validate(['rejection_reason' => 'required|string|max:500']);

        // Kembalikan stok
        $borrowing->item->increment('available_stock', $borrowing->quantity);

        $borrowing->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by'      => auth()->id(),
        ]);

        return back()->with('success', "Peminjaman {$borrowing->borrow_code} ditolak.");
    }

    public function markReturned(Borrowing $borrowing)
    {
        abort_unless(auth()->user()->hasRole(['asisten_lab', 'plp', 'koordinator']), 403);

        $borrowing->item->increment('available_stock', $borrowing->quantity);
        $borrowing->update([
            'status'             => 'returned',
            'actual_return_date' => today(),
        ]);

        return back()->with('success', "Barang {$borrowing->item->name} berhasil dikembalikan.");
    }
}
