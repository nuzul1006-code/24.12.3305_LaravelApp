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

    protected $casts = [
        'date' => 'datetime',
    ];

    // 1 Event terpaut pada satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 1 Event punya banyak Transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}