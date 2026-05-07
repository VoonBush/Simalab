@extends('user')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('page-subtitle', 'Selamat datang di InventarisLab')

@section('content')

<div class="space-y-6">

    {{-- Welcome Card --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200">
        <h2 class="text-2xl font-bold text-slate-800">
            Selamat datang, {{ Auth::user()->name }} 👋
        </h2>

        <p class="text-slate-500 mt-2">
            Anda login sebagai
            <span class="font-semibold text-blue-700 capitalize">
                {{ Auth::user()->role }}
            </span>
        </p>
    </div>

    {{-- Menu Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Barang --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-4">
                📦
            </div>

            <h3 class="font-bold text-lg text-slate-800">
                Menu Barang
            </h3>

            <p class="text-sm text-slate-500 mt-2">
                Lihat dan cek ketersediaan barang laboratorium.
            </p>

            <a href="{{ route('barang.index') }}"
               class="inline-block mt-4 text-blue-600 font-semibold hover:underline">
                Buka Menu →
            </a>
        </div>

        {{-- Peminjaman --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mb-4">
                📋
            </div>

            <h3 class="font-bold text-lg text-slate-800">
                Peminjaman
            </h3>

            <p class="text-sm text-slate-500 mt-2">
                Ajukan atau kelola status peminjaman barang.
            </p>

            <a href="{{ route('peminjaman.index') }}"
               class="inline-block mt-4 text-green-600 font-semibold hover:underline">
                Buka Menu →
            </a>
        </div>

        {{-- Modul --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center mb-4">
                📚
            </div>

            <h3 class="font-bold text-lg text-slate-800">
                Modul Praktikum
            </h3>

            <p class="text-sm text-slate-500 mt-2">
                Akses modul praktikum untuk pembelajaran.
            </p>

            <a href="{{ route('modul.index') }}"
               class="inline-block mt-4 text-purple-600 font-semibold hover:underline">
                Buka Menu →
            </a>
        </div>

    </div>

</div>

@endsection