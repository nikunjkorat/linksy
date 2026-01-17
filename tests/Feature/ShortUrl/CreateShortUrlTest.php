<?php

namespace Tests\Feature\ShortUrl;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateShortUrlTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test that both admin and member users can create short URLs.
     */
    public function test_admin_and_member_can_create_short_urls(): void
    {

        // Create a company

        $company = Company::factory()->create();

        // Create an admin and a member user for the company

        $admin = User::factory()->admin()->create([
            'company_id' => $company->id,
        ]);

        $member = User::factory()->member()->create([
            'company_id' => $company->id,
        ]);

        // Define test cases for both roles

        $cases = [
            [
                'user' => $admin,
                'route' => '/admin/links',
            ],
            [
                'user' => $member,
                'route' => '/member/links',
            ],
        ];

        // Test short URL creation for both admin and member

        foreach ($cases as $case) {

            $url = $this->faker->url();

            // Make POST request to create short URL

            $response = $this->actingAs($case['user'])
                ->post($case['route'], [
                    'original_url' => $url,
                ]);

            // Assert the response status is 200 OK

            $response->assertStatus(200);

            // Assert the short URL is stored in the database

            $this->assertDatabaseHas('short_urls', [
                'original_url' => $url,
                'company_id' => $company->id,
                'user_id' => $case['user']->id,
            ]);
        }
    }
}
