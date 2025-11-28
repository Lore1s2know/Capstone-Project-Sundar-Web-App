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
        Schema::create('upvotes', function (Blueprint $table) {
            $table->id();
            // 1. Who voted?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. Which review is this for? (Renamed from post_id to review_id)
            $table->foreignId('review_id')->constrained()->onDelete('cascade');

            // 3. Is it an Upvote (true) or Downvote (false)?
            $table->boolean('vote');


            // 4. THE CONSTRAINT: A user can only vote ONCE per review.
            // This prevents duplicate rows for the same user+review combo.
            $table->unique(['user_id', 'review_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upvotes');
    }
};
