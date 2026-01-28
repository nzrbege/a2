<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianRka extends Model
{
    use HasFactory;

    protected $table = 'rincian_rka';
    protected $primaryKey = 'id_rinci_sub_bl';

    protected $fillable = [
        'nama_program',
        'nama_giat',
        'nama_sub_giat',
        'kode_akun',
        'nama_akun',
        'satuan',
        'nama_komponen',
        'volume',
        'harga_satuan',
        'total_harga',
        'id_versi_anggaran',
    ];
}
