<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;
    protected $table = 'pengumumans';
    protected $fillable = [
        'judul', 'dokumen','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
