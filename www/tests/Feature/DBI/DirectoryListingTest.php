<?php

use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake();
});

test('returns an HTML directory listing for the games root', function () {
    Storage::put('games/GameA/game.nsp', 'data');

    $response = $this->get('/api/dbi/');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/html; charset=utf-8');
    $response->assertSee('Index of /games/');
});

test('lists directories that contain installable files', function () {
    Storage::put('games/GameA/game.nsp', 'data');
    Storage::put('games/GameB/game.xci', 'data');

    $response = $this->get('/api/dbi/');

    $response->assertSee('GameA');
    $response->assertSee('GameB');
});

test('excludes directories with no installable files', function () {
    Storage::put('games/HasGames/game.nsp', 'data');
    Storage::put('games/NoGames/readme.txt', 'data');

    $response = $this->get('/api/dbi/');

    $response->assertSee('HasGames');
    $response->assertDontSee('NoGames');
});

test('lists only files with supported extensions', function () {
    Storage::put('games/game.nsp', 'data');
    Storage::put('games/game.nsz', 'data');
    Storage::put('games/game.xci', 'data');
    Storage::put('games/game.xcz', 'data');
    Storage::put('games/readme.txt', 'data');

    $response = $this->get('/api/dbi/');

    $response->assertSee('game.nsp');
    $response->assertSee('game.nsz');
    $response->assertSee('game.xci');
    $response->assertSee('game.xcz');
    $response->assertDontSee('readme.txt');
});

test('shows a parent directory link when inside a subdirectory', function () {
    Storage::put('games/GameA/game.nsp', 'data');

    $response = $this->get('/api/dbi/GameA/');

    $response->assertSee('Parent Directory');
});

test('does not show a parent directory link at the root', function () {
    Storage::put('games/GameA/game.nsp', 'data');

    $response = $this->get('/api/dbi/');

    $response->assertDontSee('Parent Directory');
});

test('directory links use rawurlencode so special characters are encoded', function () {
    Storage::put('games/Game Title/game.nsp', 'data');
    Storage::put('games/Special & Chars/game.nsp', 'data');

    $response = $this->get('/api/dbi/');

    $response->assertSee('Game%20Title');
    $response->assertSee('Special%20%26%20Chars');
});

test('folder names with a plus sign are encoded as %2B in links, not as a space', function () {
    Storage::put('games/Game+Title/game.nsp', 'data');

    $response = $this->get('/api/dbi/');

    // The href must use %2B, not a literal + (which urlencode would produce)
    $response->assertSee('Game%2BTitle');
    // The display name is rendered as-is; only the href encoding matters
    $response->assertDontSee('Game%20Title');
    $response->assertDontSee('Game Title');
});

test('navigating into a folder with a plus sign returns a listing', function () {
    Storage::put('games/Game+Title/game.nsp', 'data');

    // The client follows the %2B-encoded link
    $response = $this->get('/api/dbi/Game%2BTitle/');

    $response->assertStatus(200);
    $response->assertSee('game.nsp');
});

test('DBI user-agent receives relative links', function () {
    Storage::put('games/GameA/game.nsp', 'data');

    $response = $this->get('/api/dbi/', ['HTTP_USER_AGENT' => 'DBI/1.0']);

    // DBI clients need a relative href like "GameA/" not an absolute path
    $response->assertSee('href="'.rawurlencode('GameA').'/"', false);
});

test('browser user-agent receives absolute links', function () {
    Storage::put('games/GameA/game.nsp', 'data');

    $response = $this->get('/api/dbi/');

    $response->assertSee('href="/api/dbi/'.rawurlencode('GameA').'"', false);
});

test('displays the current subdirectory path in the page title', function () {
    Storage::put('games/GameA/game.nsp', 'data');

    $response = $this->get('/api/dbi/GameA/');

    $response->assertSee('Index of /games/GameA/');
});
