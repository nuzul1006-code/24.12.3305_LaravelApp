<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'date',
        'location',
        'price',
        'stock',
        'poster_path',
    ];

    // Relasi: satu event milik satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: satu event punya banyak transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}