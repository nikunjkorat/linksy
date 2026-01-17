<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('original_url');
            $table->string('short_code')->unique();
            $table->timestamps();

            $table->unique(['user_id', 'original_url']);
            $table->unique(['company_id', 'original_url']);

            // Useful indexes for querying

            $table->index('company_id');
            $table->index('user_id');
            $table->index('created_at');

        });

        Schema::create('short_url_hits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('short_url_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('referer')->nullable();
            $table->timestamps();

            // Useful indexes for querying

            $table->index('short_url_id');
            $table->index('created_at');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_urls');
        Schema::dropIfExists('short_url_hits');
    }
};
