<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerificationOtp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }
}
