<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::with('location')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('code', 'like', "%{$request->search}%"))
            ->when($request->condition, fn($q) => $q->where('condition', $request->condition))
            ->when($request->location_id, fn($q) => $q->where('location_id', $request->location_id))
            ->latest()
            ->paginate(12);

        $locations = Location::all();

        return view('items.index', compact('items', 'locations'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('items.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'            => 'required|string|unique:items,code',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'location_id'     => 'nullable|exists:locations,id',
            'condition'       => 'required|in:baik,rusak,perbaikan',
            'total_stock'     => 'required|integer|min:1',
            'available_stock' => 'required|integer|min:0',
        ]);

        // Upload gambar
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $item = Item::create($validated);

        // Generate QR Code
        $this->generateQrCode($item);

        return redirect()->route('admin.items.index')
            ->with('success', "Barang {$item->name} berhasil ditambahkan!");
    }

    public function show(Item $item)
    {
        $item->load('location', 'borrowings.user');
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $locations = Location::all();
        return view('items.edit', compact('item', 'locations'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'code'            => 'required|string|unique:items,code,' . $item->id,
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'location_id'     => 'nullable|exists:locations,id',
            'condition'       => 'required|in:baik,rusak,perbaikan',
            'total_stock'     => 'required|integer|min:1',
            'available_stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image) Storage::disk('public')->delete($item->image);
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($validated);

        return redirect()->route('admin.items.index')
            ->with('success', "Barang {$item->name} berhasil diupdate!");
    }

    public function destroy(Item $item)
    {
        if ($item->image) Storage::disk('public')->delete($item->image);
        if ($item->qr_code) Storage::disk('public')->delete($item->qr_code);
        $item->delete();

        return redirect()->route('admin.items.index')
            ->with('success', 'Barang berhasil dihapus.');
    }

    private function generateQrCode(Item $item): void
    {
        $url      = route('admin.items.show', $item->id);
        $filename = 'qrcodes/item-' . $item->id . '.svg';
        $path     = storage_path('app/public/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->generate($url, $path);

        $item->update(['qr_code' => $filename]);
    }
}
