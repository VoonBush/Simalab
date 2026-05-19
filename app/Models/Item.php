<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'image',
        'qr_code',
        'location_id',
        'condition',
        'total_stock',
        'available_stock',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function borrowingDetails()
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    public function activeBorrowings()
    {
        return $this->hasManyThrough(Borrowing::class, BorrowingDetail::class, 'item_id', 'id', 'id', 'borrowing_id')
            ->whereIn('status', ['approved', 'borrowed']);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/item-placeholder.png');
    }

    public function getConditionBadgeAttribute(): array
    {
        return match ($this->condition) {
            'baik'      => ['label' => 'Baik',       'class' => 'badge-success'],
            'rusak'     => ['label' => 'Rusak',      'class' => 'badge-danger'],
            'perbaikan' => ['label' => 'Perbaikan',  'class' => 'badge-warning'],
            default     => ['label' => 'Unknown',    'class' => 'badge-gray'],
        };
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->available_stock > 0;
    }
}
