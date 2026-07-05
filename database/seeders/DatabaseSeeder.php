<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CategorySeeder::class);

        $this->createDemoUser('Alice Rivera', 'alice@example.com');
        $this->createDemoUser('Bob Smith', 'bob@example.com');
        $this->createDemoUser('Charlie Kim', 'charlie@example.com');
        $this->createDemoUser('Diana Prince', 'diana@example.com');

        $this->call(ReviewSeeder::class);
    }

    private function createDemoUser(string $name, string $email): User
    {
        return User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'email_verified_at' => now(),
                'password' => 'password',
            ],
        );
    }
}
