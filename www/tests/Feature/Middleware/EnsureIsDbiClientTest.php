<?php

use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake();
});

test('a DBI user-agent on the web root gets a DBI directory listing', function () {
    Storage::put('games/game.nsp', 'data');

    $response = $this->get('/', ['HTTP_USER_AGENT' => 'DBI/1.0']);

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/html; charset=utf-8');
    $response->assertSee('Index of /games/');
});

test('a non-DBI user-agent on the web root is passed through', function () {
    $response = $this->get('/', ['HTTP_USER_AGENT' => 'Mozilla/5.0']);

    // The welcome view or the next middleware handles the request (not DBI)
    $response->assertDontSee('Index of /games/');
});

test('a DBI user-agent on an arbitrary web path gets a DBI directory listing', function () {
    Storage::put('games/GameA/game.nsp', 'data');

    $response = $this->get('/anything', ['HTTP_USER_AGENT' => 'DBI/2.5']);

    $response->assertStatus(200);
    $response->assertSee('Index of /games/');
});
