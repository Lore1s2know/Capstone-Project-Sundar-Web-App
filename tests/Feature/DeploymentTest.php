<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\File;

test('health check endpoint is available', function () {
    $this->get('/up')->assertSuccessful();
});

test('render deployment files exist', function () {
    expect(File::exists(base_path('Dockerfile')))->toBeTrue();
    expect(File::exists(base_path('render.yaml')))->toBeTrue();
    expect(File::exists(base_path('scripts/00-laravel-deploy.sh')))->toBeTrue();
    expect(File::exists(base_path('resources/js/app.js')))->toBeTrue();

    $dockerfile = File::get(base_path('Dockerfile'));

    expect($dockerfile)->toContain('composer install');
    expect($dockerfile)->toContain('vendor/livewire/flux/dist/flux.css');
    expect($dockerfile)->toContain('npm run build');
});

test('database seeder skips when users already exist', function () {
    User::factory()->create();

    $this->seed(DatabaseSeeder::class);

    expect(User::count())->toBe(1);
});

test('database config supports render database url env var', function () {
    config([
        'database.connections.pgsql.url' => 'postgresql://user:pass@host:5432/dbname',
    ]);

    expect(config('database.connections.pgsql.url'))->toBe('postgresql://user:pass@host:5432/dbname');
});
