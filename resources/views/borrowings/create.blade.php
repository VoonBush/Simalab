@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')
@section('page-title', 'Form Peminjaman Barang')
@section('page-subtitle', 'Lengkapi data untuk mengajukan peminjaman alat lab.')

@section('content')
<div class="max-w-3xl mx-auto" x-data="borrowingForm()">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 bg-blue-600 flex items-center gap-4">
            <div class="flex-1 min-w-0">
                <p class="text-blue-100 text-xs font-bold uppercase tracking-wider mb-0.5">Transaksi Baru</p>
                <h3 class="text-white font-bold truncate">Peminjaman Multi-Barang</h3>
                <p class="text-blue-200 text-xs">Pilih barang dan tentukan jumlahnya.</p>
            </div>
        </div>

        <form action="{{ route('borrowings.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="space-y-4">
                <h4 class="text-sm font-semibold text-gray-700">Daftar Barang</h4>
                
                <template x-for="(item, index) in selectedItems" :key="index">
                    <div class="flex items-start gap-4 p-4 border border-gray-100 rounded-xl bg-gray-50/50">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Barang</label>
                            <select x-model="item.id" :name="`items[${index}][id]`" required
                                    @change="updateMaxQuantity(index)"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($items as $availableItem)
                                    <option value="{{ $availableItem->id }}" data-stock="{{ $availableItem->available_stock }}">
                                        {{ $availableItem->name }} (Stok: {{ $availableItem->available_stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-24">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Jumlah</label>
                            <input type="number" x-model="item.quantity" :name="`items[${index}][quantity]`" required min="1" :max="item.max_stock"
                                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400">
                        </div>
                        <button type="button" @click="removeItem(index)" x-show="selectedItems.length > 1" class="mt-6 text-red-500 hover:text-red-700 p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </template>

                <button type="button" @click="addItem()" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Barang Lain
                </button>
                <x-input-error :messages="$errors->get('items')" class="mt-1" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                {{-- Tanggal Pinjam --}}
                <div>
                    <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                    <input type="date" name="borrow_date" id="borrow_date" required
                           value="{{ old('borrow_date', date('Y-m-d')) }}"
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    <x-input-error :messages="$errors->get('borrow_date')" class="mt-1" />
                </div>

                {{-- Tanggal Kembali --}}
                <div>
                    <label for="return_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                    <input type="date" name="return_date" id="return_date" required
                           value="{{ old('return_date', date('Y-m-d', strtotime('+1 day'))) }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    <x-input-error :messages="$errors->get('return_date')" class="mt-1" />
                </div>

                {{-- Keperluan --}}
                <div class="sm:col-span-2">
                    <label for="purpose" class="block text-sm font-medium text-gray-700 mb-1">Keperluan Peminjaman</label>
                    <textarea name="purpose" id="purpose" rows="4" required
                              placeholder="Contoh: Untuk keperluan praktikum mata kuliah Sistem Digital..."
                              class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">{{ old('purpose') }}</textarea>
                    <x-input-error :messages="$errors->get('purpose')" class="mt-1" />
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('katalog') }}"
                   class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="px-8 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 active:scale-95 shadow-md shadow-blue-500/20 transition-all">
                    Kirim Permintaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('borrowingForm', () => ({
            selectedItems: [
                { id: '{{ $initialItem ? $initialItem->id : "" }}', quantity: 1, max_stock: {{ $initialItem ? $initialItem->available_stock : 999 }} }
            ],
            addItem() {
                this.selectedItems.push({ id: '', quantity: 1, max_stock: 999 });
            },
            removeItem(index) {
                this.selectedItems.splice(index, 1);
            },
            updateMaxQuantity(index) {
                // Find the selected option's data-stock attribute
                let selectElement = event.target;
                let selectedOption = selectElement.options[selectElement.selectedIndex];
                let maxStock = selectedOption.getAttribute('data-stock');
                this.selectedItems[index].max_stock = maxStock ? parseInt(maxStock) : 999;
                if(this.selectedItems[index].quantity > this.selectedItems[index].max_stock) {
                    this.selectedItems[index].quantity = this.selectedItems[index].max_stock;
                }
            }
        }));
    });
</script>
@endsection
