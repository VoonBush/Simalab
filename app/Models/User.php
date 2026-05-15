<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'npm',
        'jurusan',
        'prodi',
        'email',
        'password',
        'avatar',
        'phone',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function approvedBorrowings()
    {
        return $this->hasMany(Borrowing::class, 'approved_by');
    }

    public function modules()
    {
        return $this->hasMany(Module::class, 'created_by');
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3b82f6&color=fff&size=128';
    }

    public function getRoleDisplayAttribute(): string
    {
        $map = [
            'mahasiswa'    => 'Mahasiswa',
            'asisten_lab'  => 'Asisten Lab',
            'plp'          => 'PLP',
            'koordinator'  => 'Koordinator Lab',
        ];
        $roleName = $this->getRoleNames()->first() ?? 'mahasiswa';
        return $map[$roleName] ?? ucfirst($roleName);
    }
}
