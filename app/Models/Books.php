<?php

namespace App\Models;

use App\Models\Peminjam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Books extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'kode_buku',
        'judul_buku',
        'tahun_terbit',
        'penulis',
        'stok_buku',
    ];

    public function peminjam () {
        return $this->hashMany(Peminjam::class);
    }
}
