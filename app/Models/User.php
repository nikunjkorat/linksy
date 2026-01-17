<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_SUPER_ADMIN = 'super_admin';

    const ROLE_ADMIN = 'admin';

    const ROLE_MEMBER = 'member';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
        'company_id',
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
     * Relationships
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Role helpers
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isMember(): bool
    {
        return $this->role === self::ROLE_MEMBER;
    }

    public function belongsToCompany(): bool
    {
        return ! is_null($this->company_id);
    }

    public function dashboardRoute(): string
    {
        if ($this->isSuperAdmin()) {
            return 'superadmin.dashboard';
        }

        if ($this->isAdmin()) {
            return 'admin.dashboard';
        }

        return 'member.dashboard';
    }

    public function shortUrls()
    {
        return $this->hasMany(ShortUrl::class);
    }

    /**
     * Scope to include URL statistics visible to the viewer
     *
     * Adds counts for total short URLs and total URL hits
     *
     * Example usage:
     * $users = User::withUrlStatsVisibleTo($viewer)->get();
     */
    public function scopeWithUrlStatsVisibleTo(Builder $query, User $viewer): Builder
    {

        // SuperAdmin: sees everyone

        if ($viewer->isSuperAdmin()) {
            return $query->withCount([
                'shortUrls',
                'shortUrls as total_url_hits' => function ($q) {
                    $q->join('short_url_hits', 'short_urls.id', '=', 'short_url_hits.short_url_id');
                },
            ]);
        }

        // Admin: users of same company

        if ($viewer->isAdmin()) {
            return $query
                ->where('company_id', $viewer->company_id)
                ->withCount([
                    'shortUrls',
                    'shortUrls as total_url_hits' => function ($q) {
                        $q->join('short_url_hits', 'short_urls.id', '=', 'short_url_hits.short_url_id');
                    },
                ]);
        }

        // Member: only themselves

        return $query
            ->where('id', $viewer->id)
            ->withCount([
                'shortUrls',
                'shortUrls as total_url_hits' => function ($q) {
                    $q->join('short_url_hits', 'short_urls.id', '=', 'short_url_hits.short_url_id');
                },
            ]);
    }
}
