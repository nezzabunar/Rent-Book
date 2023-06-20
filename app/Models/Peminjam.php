<?php

namespace App\Models;

use App\Models\User;
use App\Models\Books;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjam extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'buku_id',
        'user_id',
        'status',
    ];

    public function buku(){
            return $this->belongsTo(Books::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
