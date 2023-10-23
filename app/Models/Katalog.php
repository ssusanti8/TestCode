<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal', 'gambar','harga', 'deskripsi', 'stok', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
