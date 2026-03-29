<?php

use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake();
});

test('returns a JSON response with files and success keys', function () {
    Storage::put('game.nsp', 'data');

    $response = $this->get('/api/tinfoil');

    $response->assertStatus(200);
    $response->assertJsonStructure(['files', 'success']);
});

test('success value equals the application name', function () {
    $response = $this->get('/api/tinfoil');

    $response->assertJsonPath('success', config('app.name'));
});

test('returns an empty files array when there are no installable files', function () {
    $response = $this->get('/api/tinfoil');

    $response->assertJsonPath('files', []);
});

test('each file entry contains a url and a size', function () {
    Storage::put('game.nsp', 'binary-content');

    $response = $this->get('/api/tinfoil');

    $response->assertJsonStructure(['files' => [['url', 'size']]]);
});

test('only includes files with supported Nintendo Switch extensions', function () {
    Storage::put('game.nsp', 'data');
    Storage::put('game.nsz', 'data');
    Storage::put('game.xci', 'data');
    Storage::put('game.xcz', 'data');
    Storage::put('readme.txt', 'data');
    Storage::put('cover.jpg', 'data');

    $response = $this->get('/api/tinfoil');

    $files = collect($response->json('files'));
    expect($files)->toHaveCount(4);
    expect($files->pluck('url')->every(fn ($url) => !str_ends_with($url, '.txt') && !str_ends_with($url, '.jpg')))->toBeTrue();
});

test('file url is an absolute URL', function () {
    Storage::put('game.nsp', 'data');

    $response = $this->get('/api/tinfoil');

    $url = $response->json('files.0.url');
    expect($url)->toStartWith('http');
});

test('file size matches the stored file size', function () {
    $content = str_repeat('x', 1024);
    Storage::put('game.nsp', $content);

    $response = $this->get('/api/tinfoil');

    $size = $response->json('files.0.size');
    expect($size)->toBe(1024);
});
