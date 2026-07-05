<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

test('database seeder creates skincare and eye makeup categories', function () {
    $this->seed(DatabaseSeeder::class);

    expect(Category::where('name', 'Skincare')->exists())->toBeTrue();
    expect(Category::where('name', 'Eye Makeup')->exists())->toBeTrue();
});

test('database seeder creates ten ottawa community reviews', function () {
    $this->seed(DatabaseSeeder::class);

    $skincare = Category::where('name', 'Skincare')->firstOrFail();
    $eyeMakeup = Category::where('name', 'Eye Makeup')->firstOrFail();

    expect(Review::count())->toBe(10);
    expect(Review::where('category_id', $skincare->id)->count())->toBe(5);
    expect(Review::where('category_id', $eyeMakeup->id)->count())->toBe(5);
});

test('alice has community reviews in both categories', function () {
    $this->seed(DatabaseSeeder::class);

    $alice = User::where('email', 'alice@example.com')->firstOrFail();

    expect(Review::where('user_id', $alice->id)->count())->toBe(3);
    expect(Review::where('user_id', $alice->id)->where('review_text', 'like', '%Ottawa%')->count())->toBeGreaterThan(0);
});
