<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat datang, {{ Auth::user()->nama }}!</h3>
                    <p>Anda login sebagai: <span class="font-semibold text-indigo-600 capitalize">{{ Auth::user()->role }}</span></p>
                    
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-100 p-4 rounded-lg shadow">
                            <h4 class="font-bold text-blue-800">Menu Barang</h4>
                            <p class="text-sm mt-2 text-blue-700">Lihat dan cek ketersediaan barang laboratorium.</p>
                            <a href="{{ route('barang.index') }}" class="mt-4 inline-block text-blue-600 font-semibold text-sm hover:underline">Buka Menu &rarr;</a>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow">
                            <h4 class="font-bold text-green-800">Peminjaman</h4>
                            <p class="text-sm mt-2 text-green-700">Ajukan atau kelola status peminjaman barang.</p>
                            <a href="{{ route('peminjaman.index') }}" class="mt-4 inline-block text-green-600 font-semibold text-sm hover:underline">Buka Menu &rarr;</a>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-lg shadow">
                            <h4 class="font-bold text-purple-800">Modul Praktikum</h4>
                            <p class="text-sm mt-2 text-purple-700">Akses modul praktikum untuk pembelajaran.</p>
                            <a href="{{ route('modul.index') }}" class="mt-4 inline-block text-purple-600 font-semibold text-sm hover:underline">Buka Menu &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
