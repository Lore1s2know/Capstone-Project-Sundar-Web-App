<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use App\Models\Upvote;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (User::query()->exists()) {
            return;
        }

        // ==========================================
        // PART 1: Run your existing CategorySeeder
        // ==========================================
        // This executes the file you already created to fill the categories table
        $this->call(CategorySeeder::class);

        // Retrieve the categories from the DB so we have their IDs for the reviews
        $makeup = Category::where('name', 'Makeup')->first();
        $skincare = Category::where('name', 'Skincare')->first();

        // ==========================================
        // PART 2: Create the 4 Demo Users
        // ==========================================
        $alice = User::factory()->create(['name' => 'Alice Rivera', 'email' => 'alice@example.com']);
        $bob = User::factory()->create(['name' => 'Bob Smith', 'email' => 'bob@example.com']);
        $charlie = User::factory()->create(['name' => 'Charlie Kim', 'email' => 'charlie@example.com']);
        $diana = User::factory()->create(['name' => 'Diana Prince', 'email' => 'diana@example.com']);

        $allUsers = [$alice, $bob, $charlie, $diana];

        // ==========================================
        // PART 3: Create Reviews (2 per User)
        // ==========================================
        
        foreach ($allUsers as $user) {
            // Review 1: Makeup Category
            Review::create([
                'user_id' => $user->id,
                'category_id' => $makeup->id,
                'product_name' => 'SuperStay Matte Ink (' . $user->name . '\'s pick)',
                'review_text' => 'I bought this lipstick last week and the color is amazing. It really stays on all day!',
            ]);

            // Review 2: Skincare Category
            Review::create([
                'user_id' => $user->id,
                'category_id' => $skincare->id,
                'product_name' => 'Hydrating Gel Cream (' . $user->name . '\'s pick)',
                'review_text' => 'My skin feels so soft after using this. Highly recommend for dry skin types.',
            ]);
        }

        // ==========================================
        // PART 4: Add Random Upvotes/Downvotes
        // ==========================================
        
        $allReviews = Review::all();

        foreach ($allReviews as $review) {
            foreach ($allUsers as $voter) {
                
                // Skip if the user is voting on their own review
                if ($voter->id === $review->user_id) {
                    continue;
                }

                // 50% chance they vote at all
                if (rand(0, 1)) { 
                    Upvote::create([
                        'user_id' => $voter->id,
                        'review_id' => $review->id,
                        'vote' => (bool)rand(0, 1), // Randomly true or false
                    ]);
                }
            }
        }
    }
}
