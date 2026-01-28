<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranA2 extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_a2';

    protected $fillable = [
        'id_versi_anggaran',
        'nomor_dpa',
        'tanggal',
        'program',
        'kegiatan',
        'sub_kegiatan',
        'kode_akun',
        'id_penerima',
        'nama_penerima_snapshot',
        'npwp_snapshot',
        'bank_snapshot',
        'norek_snapshot',
        'alamat_snapshot',
        'keperluan',
        'vol_riil',
        'harga_riil',
        'total_riil',
        'pph_golongan',
        'pph_vol',
        'pph_besaran',
        'pph_jumlah',
        'kode_potongan_pajak',
        'nominal_pajak_potongan',
        'bruto',
        'pajak',
        'netto',
        'terbilang',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'vol_riil' => 'decimal:2',
        'harga_riil' => 'decimal:2',
        'total_riil' => 'decimal:2',
        'pph_jumlah' => 'decimal:2',
        'bruto' => 'decimal:2',
        'pajak' => 'decimal:2',
        'netto' => 'decimal:2',
    ];
}
