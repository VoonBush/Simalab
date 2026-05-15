<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrowing extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'borrow_code',
        'user_id',
        'item_id',
        'quantity',
        'borrow_date',
        'return_date',
        'actual_return_date',
        'purpose',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'notes',
    ];

    protected $casts = [
        'borrow_date'        => 'date',
        'return_date'        => 'date',
        'actual_return_date' => 'date',
        'approved_at'        => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'pending'  => ['label' => 'Menunggu',    'class' => 'badge-warning'],
            'approved' => ['label' => 'Disetujui',   'class' => 'badge-success'],
            'rejected' => ['label' => 'Ditolak',     'class' => 'badge-danger'],
            'borrowed' => ['label' => 'Dipinjam',    'class' => 'badge-blue'],
            'returned' => ['label' => 'Dikembalikan','class' => 'badge-gray'],
            'late'     => ['label' => 'Terlambat',   'class' => 'badge-danger'],
            default    => ['label' => $this->status, 'class' => 'badge-gray'],
        };
    }

    public function getIsLateAttribute(): bool
    {
        return in_array($this->status, ['approved', 'borrowed'])
            && now()->isAfter($this->return_date);
    }

    public static function generateCode(): string
    {
        $date  = now()->format('Ymd');
        $count = static::whereDate('created_at', today())->count() + 1;
        return 'BRW-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
