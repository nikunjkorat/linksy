<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrlHit extends Model
{
    protected $fillable = [
        'short_url_id',
        'ip_address',
        'user_agent',
        'referer',
    ];

    public function shortUrl()
    {
        return $this->belongsTo(ShortUrl::class);
    }
}
