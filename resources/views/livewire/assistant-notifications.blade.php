<div>
    {{-- Notification Bell (Header Mode) --}}
    @if(!isset($embedded))
    <div x-data="{ open: @entangle('showPanel') }" class="relative">
        <button @click="$wire.togglePanel()"
                class="relative p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-150">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            @if($unreadCount > 0)
            <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center text-white text-[10px] font-bold
                         {{ $hasNewAlert ? 'animate-bounce' : '' }}">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
            @endif
        </button>

        {{-- Dropdown Panel --}}
        <div x-show="open" @click.outside="open = false"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95 translate-y-1"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute right-0 top-full mt-2 w-96 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">

            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                <h4 class="font-semibold text-gray-800 text-sm">Permintaan Peminjaman</h4>
                @if($unreadCount > 0)
                <span class="text-xs text-blue-600 font-medium">{{ $unreadCount }} pending</span>
                @endif
            </div>

            <div class="max-h-80 overflow-y-auto">
                @include('livewire.partials.notification-list')
            </div>

            <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
                <a href="{{ route('borrowings.index') }}"
                   class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat semua peminjaman →</a>
            </div>
        </div>
    </div>
    @else
    {{-- Embedded Mode (Dashboard Panel) --}}
    <div class="max-h-96 overflow-y-auto">
        @include('livewire.partials.notification-list')
    </div>
    @endif
</div>
