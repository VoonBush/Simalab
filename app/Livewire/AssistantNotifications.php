<?php

namespace App\Livewire;

use App\Models\Borrowing;
use Livewire\Component;
use Livewire\Attributes\On;

class AssistantNotifications extends Component
{
    public array $notifications  = [];
    public int   $unreadCount    = 0;
    public bool  $showPanel      = false;
    public bool  $hasNewAlert    = false;

    public ?int $confirmingRejectId = null;
    public string $rejectionReason = '';

    public function mount(): void
    {
        $this->loadPendingBorrowings();
    }

    public function loadPendingBorrowings(): void
    {
        $this->notifications = Borrowing::with(['user', 'details.item'])
            ->where('status', 'pending')
            ->latest()
            ->take(15)
            ->get()
            ->map(fn($b) => [
                'id'           => $b->id,
                'borrow_code'  => $b->borrow_code,
                'student_name' => $b->user->name,
                'student_npm'  => $b->user->npm ?? '-',
                'item_name'    => $b->details->count() > 0 ? $b->details->first()->item->name . ($b->details->count() > 1 ? ' (+'.($b->details->count()-1).' lainnya)' : '') : '-',
                'item_code'    => $b->details->count() > 0 ? $b->details->first()->item->code : '-',
                'quantity'     => $b->details->sum('quantity'),
                'purpose'      => $b->purpose,
                'borrow_date'  => $b->borrow_date->format('d/m/Y'),
                'return_date'  => $b->return_date->format('d/m/Y'),
                'submitted_at' => $b->created_at->diffForHumans(),
            ])
            ->toArray();

        $this->unreadCount = count($this->notifications);
    }

    // ✅ Listener dari Laravel Echo (Reverb)
    #[On('echo-private:lab-assistants,.borrowing.submitted')]
    public function onBorrowingSubmitted(array $data): void
    {
        // Cek duplikat
        $exists = collect($this->notifications)->firstWhere('id', $data['id']);
        if ($exists) return;

        array_unshift($this->notifications, $data);
        $this->unreadCount++;
        $this->hasNewAlert = true;

        // Dispatch browser event untuk notifikasi toast
        $this->dispatch('new-borrowing-toast', [
            'student' => $data['student_name'],
            'item'    => $data['item_name'],
        ]);
    }

    public function approve(int $borrowingId): void
    {
        $borrowing = Borrowing::findOrFail($borrowingId);
        $borrowing->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        $this->loadPendingBorrowings();
        $this->dispatch('borrowing-updated');
    }

    public function confirmReject(int $borrowingId): void
    {
        $this->confirmingRejectId = $borrowingId;
        $this->rejectionReason = '';
    }

    public function cancelReject(): void
    {
        $this->confirmingRejectId = null;
        $this->rejectionReason = '';
    }

    public function reject(int $borrowingId): void
    {
        $this->validate([
            'rejectionReason' => 'required|string|max:500',
        ]);

        $borrowing = Borrowing::findOrFail($borrowingId);
        foreach ($borrowing->details as $detail) {
            $detail->item->increment('available_stock', $detail->quantity);
        }
        $borrowing->update([
            'status' => 'rejected',
            'rejection_reason' => $this->rejectionReason,
            'approved_by' => auth()->id()
        ]);
        
        $this->confirmingRejectId = null;
        $this->rejectionReason = '';

        $this->loadPendingBorrowings();
        $this->dispatch('borrowing-updated');
    }

    public function togglePanel(): void
    {
        $this->showPanel      = !$this->showPanel;
        $this->hasNewAlert    = false;
    }

    public function render()
    {
        return view('livewire.assistant-notifications');
    }
}
