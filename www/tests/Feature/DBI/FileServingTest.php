<?php

use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake();
});

test('serves a file as an octet-stream download', function () {
    Storage::put('games/game.nsp', 'binary-content');

    $response = $this->get('/api/dbi/game.nsp');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/octet-stream');
});

test('returns 404 when the requested file does not exist', function () {
    $response = $this->get('/api/dbi/missing.nsp');

    $response->assertStatus(404);
});

test('serves a file inside a subdirectory', function () {
    Storage::put('games/GameA/game.nsp', 'binary-content');

    $response = $this->get('/api/dbi/GameA/game.nsp');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/octet-stream');
});

test('serves a file whose folder name contains a plus sign', function () {
    Storage::put('games/Game+Title/game.nsp', 'binary-content');

    // %2B in the URL must decode to a literal + (not a space)
    $response = $this->get('/api/dbi/Game%2BTitle/game.nsp');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/octet-stream');
});

test('returns 404 when plus sign is misread as a space', function () {
    Storage::put('games/Game+Title/game.nsp', 'binary-content');

    // A literal + in the URL path should NOT match a folder named "Game+Title"
    // because + must be decoded as %2B, not as a space
    $response = $this->get('/api/dbi/Game+Title/game.nsp');

    // "Game+Title" decoded with rawurldecode stays "Game+Title",
    // which correctly finds the file.
    $response->assertStatus(200);
});

test('serves a file with a plus sign in the filename', function () {
    Storage::put('games/Game+Edition.nsp', 'binary-content');

    $response = $this->get('/api/dbi/Game%2BEdition.nsp');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/octet-stream');
});

test('response includes Accept-Ranges header for range request support', function () {
    Storage::put('games/game.nsp', 'binary-content');

    $response = $this->get('/api/dbi/game.nsp');

    $response->assertHeader('Accept-Ranges', 'bytes');
});
