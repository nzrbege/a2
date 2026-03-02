<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBelanja extends Model
{
    use HasFactory;

    protected $table = 'detail_belanja';

    protected $fillable = [
        'id_reg',
        'no_reg',
        'set_gu',
        'tgl_gu',
        'kd_subkeg',
        'kd_rek',
        'id_rinci_sub_bl',
        'volume',
        'ppn',
        'harga_riil',
        'total_dpp',
        'total_dibayar',
        'look_komponen',
        'cek_status',
        'ctc_lookup',
    ];
    public function register()
    {
        return $this->belongsTo(
            Register::class,
            'id_reg',   // foreign key
            'id_reg'    // owner key
        );
    }
    
    public function rincianRka()
    {
        return $this->belongsTo(
            RincianRka::class,
            'id_rinci_sub_bl',
            'id_rinci_sub_bl'
        );
    }
}
