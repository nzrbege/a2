<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_opd',
        'kode_unit',
        'nama_unit'
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'id_opd', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'unit_id', 'id');
    }
}
