<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Favorite;

class Book extends Model
{
    protected $fillable = [

        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'stok',
        'cover',
        'file_buku',
        'tipe',

    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function readingProgress()
    {
        return $this->hasMany(ReadingProgress::class);
    }
}