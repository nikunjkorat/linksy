<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected static function booted()
    {
        static::creating(function ($company) {
            $company->uid = self::generateUid();
        });
    }

    private static function generateUid(): string
    {
        return str()->random(10);
    }

    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function admins()
    {
        return $this->users()->where('role', User::ROLE_ADMIN);
    }

    public function members()
    {
        return $this->users()->where('role', User::ROLE_MEMBER);
    }
}
