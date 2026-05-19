<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowingDetail extends Model
{
    protected $fillable = [
        'borrowing_id',
        'item_id',
        'quantity',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
