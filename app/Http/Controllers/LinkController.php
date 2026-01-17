<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Link\Store;
use App\Models\ShortUrl;
use App\Services\ShortUrlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{

    // Display a listing of the short URLs with filtering options

    public function index(Request $request)
    {

        // Get filter from request, default to 'all'

        $filter = $request->get('filter', 'all');

        // Validate filter value

        abort_unless(in_array($filter, ['today', 'week', 'month', 'all']), 400);

        // Build query with visibility scope and filtering

        $query = ShortUrl::query()
            ->visibleTo(Auth::user())
            ->when($filter === 'today', fn ($q) => $q->whereDate('created_at', today())
            )
            ->when($filter === 'week', fn ($q) => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            )
            ->when($filter === 'month', fn ($q) => $q->whereMonth('created_at', now()->month)
            )
            ->withCount('hits')
            ->latest();

        // Paginate results and append filter to pagination links

        $links = $query->paginate(5)
            ->appends([
                'filter' => $filter,
            ]);

        if ($request->ajax()) {
            return view('links.table', compact('links'))->render();
        }

        return view('links.index', compact('links', 'filter'));
    }

    // Store a newly created short URL

    public function store(Store $request, ShortUrlService $shortUrlService)
    {

        $requestData = $request->validated();

        try {

            // Create short URL using the service

            $shortUrl = $shortUrlService->create(
                Auth::user(),
                $requestData['original_url']
            );

            // Determine redirect route based on user role

            $redirect = route('member.links.index');

            if (Auth::user()->isAdmin()) {
                $redirect = route('admin.links.index');
            }

            return response()->json([
                'message' => 'Short URL created successfully.',
                'status' => true,
                'redirect' => $redirect,
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'message' => 'Unable to create short URL.',
            ], 500);

        }

    }
}
