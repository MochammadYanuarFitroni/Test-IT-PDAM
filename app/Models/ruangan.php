<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ruangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ruangan';
    public $incrementing = false;
    protected $keyType = 'integer';

    // protected $fillable = ['keterangan'];
    protected $guarded = ['id_ruangan'];


    public function pegawais() {
        return $this->hasMany(pegawai::class, 'id_ruangan', 'id_ruangan');
    }
}
