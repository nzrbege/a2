<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    protected $table = 'opd';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_opd',
        'nama_opd'
    ];

    public function unit()
    {
        return $this->hasMany(Unit::class, 'opd_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'opd_id', 'id');
    }
}
