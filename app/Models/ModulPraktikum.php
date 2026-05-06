<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModulPraktikum extends Model
{
    protected $table = 'modul_praktikums';
    protected $primaryKey = 'id_modul';

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path'
    ];
}
