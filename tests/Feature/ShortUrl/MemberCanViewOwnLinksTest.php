<?php

namespace Tests\Feature\ShortUrl;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MemberCanViewOwnLinksTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test that a member can only see links created by themselves.
     *
     * */

    public function test_member_can_only_see_links_created_by_themselves()
    {

        // Arrange

        $company = Company::factory()->create();

        $memberA = User::factory()->member()->create([
            'company_id' => $company->id,
        ]);

        $memberB = User::factory()->member()->create([
            'company_id' => $company->id,
        ]);

        // Links created by member A (should be visible)

        $memberALinks = ShortUrl::factory()->count(3)->create([
            'company_id' => $company->id,
            'user_id'    => $memberA->id,
        ]);

        // Links created by member B in same company (should NOT be visible)

        $memberBLinks = ShortUrl::factory()->count(2)->create([
            'company_id' => $company->id,
            'user_id'    => $memberB->id,
        ]);

        // Links from another company (should NOT be visible)

        $otherCompany = Company::factory()->create();

        $otherCompanyLinks = ShortUrl::factory()->count(2)->create([
            'company_id' => $otherCompany->id,
            'user_id'    => User::factory()->member()->create([
                'company_id' => $otherCompany->id,
            ])->id,
        ]);

        // Act

        $response = $this->actingAs($memberA)
            ->get('/member/links');

        // Assert

        $response->assertStatus(200);

        // Member A SHOULD see their own links

        foreach ($memberALinks as $link) {
            $response->assertSee($link->original_url);
        }

        // Member A MUST NOT see links from other users (same company)

        foreach ($memberBLinks as $link) {
            $response->assertDontSee($link->original_url);
        }

        // Member A MUST NOT see links from other companies

        foreach ($otherCompanyLinks as $link) {
            $response->assertDontSee($link->original_url);
        }
    }
}
