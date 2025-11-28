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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // 1. Link to the User who wrote it
            // 'constrained()' ensures the user_id actually exists in the users table.
            // 'onDelete cascade' means if the User is deleted, their reviews are deleted too.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. The Product info
            $table->string('product_name');
            $table->text('review_text');

            // 3. Link to the Category
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
