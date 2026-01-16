<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'company_id', 
        'email', 
        'role',
        'token', 
        'expires_at', 
        'created_by',
        'accepted_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function isExpired(): bool
    {
        return now()->gt($this->expires_at);
    }

    public function isAccepted(): bool
    {
        return ! is_null($this->accepted_at);
    }
}
