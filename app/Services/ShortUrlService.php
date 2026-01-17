<?php

namespace App\Services;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Str;

class ShortUrlService
{

    private const CODE_LENGTH = 8;

    /**
     * Create a short URL for a user
     */

    public function create(User $user, string $originalUrl): ShortUrl
    {

        if ($user->isSuperAdmin()) {

            throw new AuthorizationException('SuperAdmin cannot create short URLs.');
        }

        return ShortUrl::create([
            'user_id' => $user->id,
            'company_id' => $user->company_id,
            'original_url' => $originalUrl,
            'short_code' => $this->generateUniqueCode(),
        ]);

    }

    /**
     * Generate a globally unique short code
     */

    private function generateUniqueCode(): string
    {

        do {

            $code = Str::random(self::CODE_LENGTH);

        } while (ShortUrl::where('short_code', $code)->exists());

        return $code;

    }
}
