<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIMALAB') }} — @yield('title', 'Dashboard')</title>
    <meta name="description" content="Sistem Manajemen Inventaris Lab Teknik Digital, Universitas Lampung">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-gray-50 font-inter antialiased" x-data="{ sidebarOpen: false }">

<x-splash-screen />

<div class="flex h-full">

    {{-- ═══════════════════ SIDEBAR ═══════════════════ --}}
    <aside class="w-64 bg-white border-r border-gray-100 shadow-sm flex flex-col fixed h-full z-30
                  transition-transform duration-300 lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        {{-- Brand --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
            {{-- Logo Placeholder --}}
            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center flex-shrink-0">
                <img src="{{ asset('img/LogoLab.png') }}" class="w-10 h-10 object-contain" alt="Logo">
            </div>
            <div>
                <h1 class="font-bold text-gray-900 text-lg leading-none">SIMALAB</h1>
                <p class="text-xs text-gray-400 mt-0.5">Laboratorium Teknik Digital</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

            @php $role = auth()->user()?->getRoleNames()->first() ?? 'mahasiswa'; @endphp

            @if(in_array($role, ['asisten_lab', 'plp', 'koordinator']))
                {{-- Staff Navigation --}}
                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="dashboard">
                    Dashboard
                </x-nav-link>
                <x-nav-link :href="route('admin.items.index')" :active="request()->routeIs('admin.items.*')" icon="items">
                    Manajemen Barang
                </x-nav-link>
                <x-nav-link :href="route('borrowings.index')" :active="request()->routeIs('borrowings.*')" icon="borrowing">
                    Peminjaman
                </x-nav-link>
                <x-nav-link :href="route('modules.index')" :active="request()->routeIs('modules.*')" icon="module">
                    Modul Praktikum
                </x-nav-link>
                @if(in_array($role, ['plp', 'koordinator']))
                <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')" icon="users">
                    Manajemen User
                </x-nav-link>
                @endif
            @else
                {{-- Mahasiswa Navigation --}}
                <x-nav-link :href="route('katalog')" :active="request()->routeIs('katalog')" icon="items">
                    Katalog Barang
                </x-nav-link>
                <x-nav-link :href="route('borrowings.index')" :active="request()->routeIs('borrowings.*')" icon="borrowing">
                    Peminjaman Saya
                </x-nav-link>
                <x-nav-link :href="route('modules.index')" :active="request()->routeIs('modules.*')" icon="module">
                    Modul Praktikum
                </x-nav-link>
            @endif
        </nav>

        {{-- User Profile --}}
        <div class="border-t border-gray-100 px-4 py-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 flex-1 min-w-0 group cursor-pointer" title="Lihat Profil">
                    <img src="{{ auth()->user()?->avatar_url }}" alt="Avatar"
                         class="w-9 h-9 rounded-full object-cover group-hover:ring-2 ring-blue-500 ring-offset-1 transition-all">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate group-hover:text-blue-600 transition-colors">{{ auth()->user()?->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()?->role_display }}</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                    @csrf
                    <button type="submit" title="Logout"
                            class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Sidebar Overlay (Mobile) --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-20 lg:hidden" x-transition></div>

    {{-- ═══════════════════ MAIN CONTENT ═══════════════════ --}}
    <div class="flex-1 flex flex-col lg:ml-64 min-h-full">

        {{-- Top Bar --}}
        <header class="sticky top-0 z-10 bg-white border-b border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-6 h-16">
                {{-- Mobile burger --}}
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="hidden lg:block">
                    <h2 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-xs text-gray-400">@yield('page-subtitle', 'SIMALAB · Lab Teknik Digital Unila')</p>
                </div>

                <div class="flex items-center gap-3 ml-auto">
                    {{-- Notification Bell (Asisten only) --}}
                    @role('asisten_lab|plp|koordinator')
                        @livewire('assistant-notifications')
                    @endrole
                </div>
            </div>
        </header>

        {{-- Page Content + Watermark --}}
        <main class="flex-1 p-6 relative overflow-auto">
            {{-- Watermark Background Logo --}}
            <div class="pointer-events-none fixed inset-0 lg:ml-64 flex items-center justify-center z-0 opacity-[0.03]">
                <img src="{{ asset('img/LogoLab.png') }}" class="w-850 h-850 object-contain" alt="Logo">
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     x-transition class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="relative z-10">
                @yield('content')
            </div>
        </main>
    </div>
</div>

{{-- Toast Notification Container --}}
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"
     x-data="toastHandler()"
     @new-borrowing-toast.window="addToast($event.detail)">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show" x-transition
             class="flex items-start gap-3 bg-white border border-blue-100 rounded-xl p-4 shadow-lg max-w-sm">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800">Permintaan Peminjaman Baru!</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    <span x-text="toast.student"></span> meminjam <span class="font-medium" x-text="toast.item"></span>
                </p>
            </div>
        </div>
    </template>
</div>

@livewireScripts
<script>
function toastHandler() {
    return {
        toasts: [],
        addToast(data) {
            const toast = { id: Date.now(), show: true, ...data };
            this.toasts.push(toast);
            setTimeout(() => {
                toast.show = false;
                setTimeout(() => this.toasts = this.toasts.filter(t => t.id !== toast.id), 500);
            }, 5000);
        }
    };
}
</script>
</body>
</html>
