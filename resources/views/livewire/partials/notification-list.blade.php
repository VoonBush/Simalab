<div class="divide-y divide-gray-50">
    @forelse($notifications as $notif)
    <div class="flex items-start gap-3 p-4 hover:bg-gray-50 transition-colors"
         wire:key="notif-{{ $notif['id'] }}">

        {{-- Avatar initial --}}
        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center
                    text-blue-700 font-bold text-sm flex-shrink-0">
            {{ strtoupper(mb_substr($notif['student_name'], 0, 1)) }}
        </div>

        {{-- Info --}}
        <div class="flex-1 min-w-0">
            <p class="text-sm text-gray-800 leading-snug">
                <span class="font-semibold text-blue-600">{{ $notif['student_name'] }}</span>
                meminjam
                <span class="font-semibold">{{ $notif['item_name'] }}</span>
                × {{ $notif['quantity'] }}
            </p>
            <p class="text-xs text-gray-400 mt-0.5">
                {{ $notif['borrow_date'] }} – {{ $notif['return_date'] }} &middot; {{ $notif['submitted_at'] }}
            </p>
            <p class="text-xs text-gray-500 mt-1 italic truncate">"{{ $notif['purpose'] }}"</p>

            {{-- Action Buttons --}}
            @if($confirmingRejectId === $notif['id'])
                <div class="mt-3 bg-white p-3 rounded-xl border border-red-100 shadow-sm animate-fade-in-up">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Alasan Penolakan</label>
                    <textarea wire:model="rejectionReason" rows="2" class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500/20 focus:border-red-400" placeholder="Masukkan alasan penolakan..."></textarea>
                    @error('rejectionReason') <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    
                    <div class="flex gap-2 mt-2 justify-end">
                        <button wire:click="cancelReject" class="px-3 py-1 text-xs font-medium text-gray-500 hover:text-gray-700 transition-colors">
                            Batal
                        </button>
                        <button wire:click="reject({{ $notif['id'] }})"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 active:scale-95 transition-all">
                            <span wire:loading.remove wire:target="reject({{ $notif['id'] }})">Kirim Penolakan</span>
                            <span wire:loading wire:target="reject({{ $notif['id'] }})">Memproses...</span>
                        </button>
                    </div>
                </div>
            @else
                <div class="flex gap-2 mt-2">
                    <button wire:click="approve({{ $notif['id'] }})"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-white
                                   bg-blue-500 rounded-lg hover:bg-blue-600 active:scale-95 transition-all">
                        <svg wire:loading.remove wire:target="approve({{ $notif['id'] }})"
                             class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span wire:loading.remove wire:target="approve({{ $notif['id'] }})">Approve</span>
                        <span wire:loading wire:target="approve({{ $notif['id'] }})">...</span>
                    </button>

                    <button wire:click="confirmReject({{ $notif['id'] }})"
                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-gray-600
                                   bg-gray-100 rounded-lg hover:bg-red-50 hover:text-red-600 active:scale-95 transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>Tolak</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    @empty
    <div class="py-10 text-center text-gray-400">
        <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm">Tidak ada permintaan pending</p>
    </div>
    @endforelse
</div>
