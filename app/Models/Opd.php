<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    protected $table = 'opd';
    protected $primaryKey = 'id_opd';

    protected $fillable = [
        'kode_opd',
        'nama_opd'
    ];

    public function bidang()
    {
        return $this->hasMany(Bidang::class, 'id_opd', 'id_opd');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_opd', 'id_opd');
    }
}
