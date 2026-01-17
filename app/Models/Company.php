<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

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

    /**
     * Scope to include URL statistics
     *
     * Adds counts for total short URLs and total URL hits
     *
     * Usage: Company::withUrlStats()->get();
     */
    public function scopeWithUrlStats(Builder $query): Builder
    {

        // Add count of short URLs and total URL hits

        return $query
            ->withCount('shortUrls')
            ->withCount([
                'shortUrls as total_url_hits' => function ($q) {
                    $q->join(
                        'short_url_hits',
                        'short_urls.id',
                        '=',
                        'short_url_hits.short_url_id'
                    );
                },
            ]);
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

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function pendingInvitations()
    {
        return $this->invitations()->whereNull('accepted_at');
    }

    public function shortUrls()
    {
        return $this->hasMany(ShortUrl::class);
    }
}
