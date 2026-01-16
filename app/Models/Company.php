<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name'];

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
