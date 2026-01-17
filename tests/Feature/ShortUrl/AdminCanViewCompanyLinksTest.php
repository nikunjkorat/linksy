<?php

namespace Tests\Feature\ShortUrl;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Tests\TestCase;

class AdminCanViewCompanyLinksTest extends TestCase
{
    /**
     * Test that an admin can only see links from their own company.
     */

    public function test_admin_can_only_see_links_from_their_own_company()
    {
        // Arrange: create two companies

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        // Admin A belongs to company A

        $adminA = User::factory()->admin()->create([
            'company_id' => $companyA->id,
        ]);

        // Links for company A (should be visible)

        $companyALinks = ShortUrl::factory()->count(3)->create([
            'company_id' => $companyA->id,
            'user_id' => $adminA->id,
        ]);

        // Admin B belongs to company B

        $adminB = User::factory()->admin()->create([
            'company_id' => $companyB->id,
        ]);

        // Links for company B (should NOT be visible)

        $companyBLinks = ShortUrl::factory()->count(2)->create([
            'company_id' => $companyB->id,
            'user_id' => $adminB->id,
        ]);

        // Act

        $response = $this->actingAs($adminA)
            ->get('/admin/links');

        // Assert

        $response->assertStatus(200);

        // Admin A SHOULD see their own company links

        foreach ($companyALinks as $link) {
            $response->assertSee($link->original_url);
        }

        // Admin A MUST NOT see other company links

        foreach ($companyBLinks as $link) {
            $response->assertDontSee($link->original_url);
        }

    }
}
