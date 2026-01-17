<?php

namespace Database\Factories;

use App\Models\ShortUrl;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShortUrl>
 */

class ShortUrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = ShortUrl::class;

    public function definition(): array
    {
        return [
            'user_id' => null,      // will be set explicitly
            'company_id' => null,   // will be set explicitly
            'original_url' => $this->faker->url(),
            'short_code' => Str::random(8),
        ];
    }

}
