<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'partner_id',
        'google_id',
        'google_token',
        'google_avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: User milik 1 Partner (jika role-nya partner/organizer)
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    // --- Helper Check Role ---

    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isPartner(): bool
    {
        return $this->role === 'partner';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}