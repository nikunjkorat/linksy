<?php

namespace Tests\Feature\ShortUrl;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class PublicRedirectTest extends TestCase
{
    use RefreshDatabase;

    /***
     * Test that a short URL redirects to its original URL.
     */

    public function test_short_url_redirects_to_original_url()
    {

        // Create a company

        $company = Company::factory()->create();

        // Create an admin user for the company

        $admin = User::factory()->admin()->create([
            'company_id' => $company->id,
        ]);

        // Arrange

        $shortUrl = ShortUrl::factory()->create([
            'user_id'     => $admin->id,
            'company_id'  => $company->id,
            'original_url' => 'https://laravel.com',
            'short_code'   => Str::random(8),
        ]);

        // Act

        $response = $this->get('/' . $shortUrl->short_code);

        // Assert

        $response->assertRedirect($shortUrl->original_url);

    }

    /**
     * Test that accessing an invalid short code returns a 404 response.
     */

    public function test_invalid_short_code_returns_404()
    {

        // Act + Assert

        $this->get('/this-code-does-not-exist')
            ->assertStatus(404);

    }
}
