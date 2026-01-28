<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'bidang';
    protected $primaryKey = 'id_bidang';

    protected $fillable = [
        'id_opd',
        'kode_bidang',
        'nama_bidang'
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'id_opd', 'id_opd');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_bidang', 'id_bidang');
    }
}
