<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo_url',
        'phone',
        'status',
    ];

    // 1 Partner punya banyak anggota/admin (Users)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // 1 Partner punya banyak Event
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // 1 Partner punya banyak Ulasan lewat Event yang diselenggarakan
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Event::class);
    }
}