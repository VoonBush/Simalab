<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'room', 'description'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->room ? "{$this->name} ({$this->room})" : $this->name;
    }
}
