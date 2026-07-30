<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'event_id',
        'transaction_id',
        'user_id',
        'rating',
        'review',
        'customer_name',
    ];

    // Relasi: review ini milik satu event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relasi: review ini milik satu transaksi tiket
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi: review ini dibuat oleh satu user (opsional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
