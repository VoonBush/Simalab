<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang Lab') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('barang.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <x-input-label for="kode_barang" :value="__('Kode Barang')" />
                            <x-text-input id="kode_barang" class="block mt-1 w-full" type="text" name="kode_barang" :value="old('kode_barang')" required autofocus />
                            <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                            <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang')" required />
                            <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="stok_total" :value="__('Stok Total')" />
                            <x-text-input id="stok_total" class="block mt-1 w-full" type="number" min="0" name="stok_total" :value="old('stok_total')" required />
                            <x-input-error :messages="$errors->get('stok_total')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="lokasi" :value="__('Lokasi Penyimpanan')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi')" required />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="kondisi" :value="__('Kondisi')" />
                            <select id="kondisi" name="kondisi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="Normal">Normal</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Error">Error</option>
                            </select>
                            <x-input-error :messages="$errors->get('kondisi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('barang.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 mr-2">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
