<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Models\ShortUrlHit;
use Illuminate\Http\Request;

class ShortUrlRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $code)
    {

        $shortUrl = ShortUrl::where('short_code', $code)
            ->first();

        if (! $shortUrl) {
            abort(404);
        }

        // Track hit (non-blocking logic)

        $this->trackHit($shortUrl, $request);

        return redirect()->away($shortUrl->original_url);
    }

    // Track the hit for analytics

    protected function trackHit(ShortUrl $shortUrl, Request $request): void
    {
        try {

            ShortUrlHit::create([
                'short_url_id' => $shortUrl->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->headers->get('referer'),
            ]);

        } catch (\Throwable $e) {

            // Never break redirect because of analytics

            report($e);

        }

    }
}
