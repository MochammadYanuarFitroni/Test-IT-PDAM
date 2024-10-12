<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai extends Model
{
    use HasFactory;

    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'integer';

    // protected $fillable = ['nama', 'alamat', 'tgl_lahir', 'id_ruangan'];
    protected $guarded = ['nip'];

    public function ruangan() {
        return $this->belongsTo(ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}
