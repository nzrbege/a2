<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpp extends Model
{
    use HasFactory;

    protected $table = 'dpp';

    protected $fillable = [
        'jenis_potongan',
        'kode_potongan',
    ];
}
