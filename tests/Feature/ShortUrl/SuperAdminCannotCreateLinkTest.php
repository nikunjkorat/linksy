<?php

namespace Tests\Feature\ShortUrl;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SuperAdminCannotCreateLinkTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test that super admin users cannot create short URLs.
     */
    public function test_super_admin_cannot_create_short_urls(): void
    {
        $company = Company::factory()->create();

        $superAdmin = User::factory()->superAdmin()->create([
            'company_id' => $company->id,
        ]);

        $routes = [
            '/admin/links',
            '/member/links',
        ];

        foreach ($routes as $route) {

            $response = $this->actingAs($superAdmin)

                ->post($route, [
                    'original_url' => $this->faker->url(),
                ]);

            $response->assertStatus(403);
        }

        $this->assertDatabaseCount('short_urls', 0);
    }
}
