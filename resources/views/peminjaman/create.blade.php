<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Peminjaman Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('peminjaman.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <x-input-label for="id_barang" :value="__('Pilih Barang')" />
                            <select id="id_barang" name="id_barang" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                                <option value="" disabled selected>Pilih barang yang tersedia...</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id_barang }}" {{ old('id_barang') == $barang->id_barang ? 'selected' : '' }}>
                                        {{ $barang->nama_barang }} (Tersedia: {{ $barang->stok_tersedia }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_barang')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="jumlah" :value="__('Jumlah Pinjam')" />
                            <x-text-input id="jumlah" class="block mt-1 w-full" type="number" min="1" name="jumlah" :value="old('jumlah', 1)" required />
                            <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="batas_peminjaman" :value="__('Batas Tanggal Peminjaman')" />
                            <x-text-input id="batas_peminjaman" class="block mt-1 w-full" type="date" name="batas_peminjaman" :value="old('batas_peminjaman')" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" />
                            <x-input-error :messages="$errors->get('batas_peminjaman')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 mr-2">Batal</a>
                            <x-primary-button>
                                {{ __('Ajukan Pinjaman') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
