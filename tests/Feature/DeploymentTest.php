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

    expect($dockerfile)->toContain('FROM composer:2 AS vendor');
    expect($dockerfile)->toContain('vendor/livewire/flux/dist/flux.css');
    expect($dockerfile)->toContain('npm run build');
    expect($dockerfile)->toContain('serversideup/php:8.4-fpm-nginx-bookworm');
    expect($dockerfile)->toContain('NGINX_WEBROOT');
    expect(File::exists(base_path('docker/nginx/flux.conf')))->toBeTrue();

    $deployScript = File::get(base_path('scripts/00-laravel-deploy.sh'));

    expect($deployScript)->not->toContain('view:cache');
    expect($deployScript)->toContain('public/build/manifest.json');
});

test('database seeder does not duplicate demo users', function () {
    User::factory()->create(['email' => 'alice@example.com']);

    $this->seed(DatabaseSeeder::class);

    expect(User::where('email', 'alice@example.com')->count())->toBe(1);
    expect(User::count())->toBe(4);
});

test('database seeder creates demo users without faker', function () {
    $this->seed(DatabaseSeeder::class);

    expect(User::count())->toBe(4);
    expect(User::where('email', 'alice@example.com')->exists())->toBeTrue();
});

test('database config supports render database url env var', function () {
    config([
        'database.connections.pgsql.url' => 'postgresql://user:pass@host:5432/dbname',
    ]);

    expect(config('database.connections.pgsql.url'))->toBe('postgresql://user:pass@host:5432/dbname');
});
