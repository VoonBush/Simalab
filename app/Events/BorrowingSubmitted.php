<?php

namespace App\Events;

use App\Models\Borrowing;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BorrowingSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Borrowing $borrowing)
    {
        //
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('lab-assistants')];
    }

    public function broadcastAs(): string
    {
        return 'borrowing.submitted';
    }

    public function broadcastWith(): array
    {
        return [
            'id'           => $this->borrowing->id,
            'borrow_code'  => $this->borrowing->borrow_code,
            'student_name' => $this->borrowing->user->name,
            'student_npm'  => $this->borrowing->user->npm,
            'item_name'    => $this->borrowing->details->count() > 0 ? $this->borrowing->details->first()->item->name . ($this->borrowing->details->count() > 1 ? ' (+'.($this->borrowing->details->count()-1).' lainnya)' : '') : '-',
            'item_code'    => $this->borrowing->details->count() > 0 ? $this->borrowing->details->first()->item->code : '-',
            'quantity'     => $this->borrowing->details->sum('quantity'),
            'purpose'      => $this->borrowing->purpose,
            'borrow_date'  => $this->borrowing->borrow_date->format('d/m/Y'),
            'return_date'  => $this->borrowing->return_date->format('d/m/Y'),
            'submitted_at' => $this->borrowing->created_at->diffForHumans(),
        ];
    }
}
