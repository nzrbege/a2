<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersiAnggaran extends Model
{
    use HasFactory;

    protected $table = 'versi_anggaran';
    protected $primaryKey = 'id_versi_anggaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_versi_anggaran',
        'nomor_anggaran',
    ];
}
