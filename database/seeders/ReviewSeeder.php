<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Review;
use App\Models\Upvote;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $skincare = Category::where('name', 'Skincare')->firstOrFail();
        $eyeMakeup = Category::where('name', 'Eye Makeup')->firstOrFail();

        $alice = User::where('email', 'alice@example.com')->firstOrFail();
        $bob = User::where('email', 'bob@example.com')->firstOrFail();
        $charlie = User::where('email', 'charlie@example.com')->firstOrFail();
        $diana = User::where('email', 'diana@example.com')->firstOrFail();

        $reviews = [
            [
                'user_id' => $alice->id,
                'category_id' => $skincare->id,
                'product_name' => 'CeraVe Hydrating Cleanser',
                'review_text' => 'Picked this up at Shoppers Drug Mart on Bank Street in Ottawa. Gentle on my dry skin and easy to find across the city.',
            ],
            [
                'user_id' => $bob->id,
                'category_id' => $skincare->id,
                'product_name' => 'The Ordinary Niacinamide 10% + Zinc 1%',
                'review_text' => 'Available at Sephora in the Rideau Centre. Affordable serum that helped calm redness during Ottawa\'s dry winter months.',
            ],
            [
                'user_id' => $charlie->id,
                'category_id' => $skincare->id,
                'product_name' => 'La Roche-Posay Anthelios SPF 50',
                'review_text' => 'Got mine at Pharmaprix on Wellington West. Lightweight sunscreen that wears well under makeup for sunny days on the Ottawa River pathway.',
            ],
            [
                'user_id' => $diana->id,
                'category_id' => $skincare->id,
                'product_name' => 'Neutrogena Hydro Boost Water Gel',
                'review_text' => 'In stock at Walmart on Merivale Road. Absorbs quickly and keeps my skin hydrated without feeling greasy in humid Ottawa summers.',
            ],
            [
                'user_id' => $alice->id,
                'category_id' => $skincare->id,
                'product_name' => 'Bioderma Sensibio H2O Micellar Water',
                'review_text' => 'Found at Jean Coutu in Orléans. Perfect for removing makeup after long days downtown without irritating sensitive skin.',
            ],
            [
                'user_id' => $bob->id,
                'category_id' => $eyeMakeup->id,
                'product_name' => 'Maybelline Lash Sensational Mascara',
                'review_text' => 'Grabbed this at Rexall on Bank Street. Great volume for everyday wear and always on the shelf at Ottawa drugstores.',
            ],
            [
                'user_id' => $charlie->id,
                'category_id' => $eyeMakeup->id,
                'product_name' => 'L\'Oréal Paris Voluminous Original Mascara',
                'review_text' => 'Available at Sephora Rideau Centre and most Shoppers locations in Ottawa. Builds length without clumping on my straight lashes.',
            ],
            [
                'user_id' => $diana->id,
                'category_id' => $eyeMakeup->id,
                'product_name' => 'NYX Epic Ink Liner',
                'review_text' => 'Bought at Shoppers Drug Mart in the Rideau area. The brush tip makes sharp wings that last through a full shift in Centretown.',
            ],
            [
                'user_id' => $alice->id,
                'category_id' => $eyeMakeup->id,
                'product_name' => 'MAC Eye Kohl in Teddy',
                'review_text' => 'Picked up at MAC Cosmetics in the Rideau Centre. Soft brown liner that smudges beautifully for a quick smoky eye before evenings out in the ByWard Market.',
            ],
            [
                'user_id' => $diana->id,
                'category_id' => $eyeMakeup->id,
                'product_name' => 'Essence Lash Princess False Lash Effect Mascara',
                'review_text' => 'Always in stock at Shoppers in Barrhaven. Budget-friendly mascara with dramatic lift—perfect for students shopping locally in Ottawa.',
            ],
        ];

        foreach ($reviews as $reviewData) {
            Review::firstOrCreate(
                [
                    'user_id' => $reviewData['user_id'],
                    'product_name' => $reviewData['product_name'],
                ],
                [
                    'category_id' => $reviewData['category_id'],
                    'review_text' => $reviewData['review_text'],
                ],
            );
        }

        $this->seedVotes([$alice, $bob, $charlie, $diana]);
    }

    /**
     * @param  array<int, User>  $users
     */
    private function seedVotes(array $users): void
    {
        foreach (Review::all() as $review) {
            foreach ($users as $voter) {
                if ($voter->id === $review->user_id) {
                    continue;
                }

                Upvote::firstOrCreate(
                    [
                        'user_id' => $voter->id,
                        'review_id' => $review->id,
                    ],
                    [
                        'vote' => (bool) random_int(0, 1),
                    ],
                );
            }
        }
    }
}
