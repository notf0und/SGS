<?php

test('a request with a theme header on the web root redirects to the tinfoil route', function () {
    $response = $this->get('/', ['HTTP_THEME' => 'default']);

    $response->assertRedirect(route('tinfoil'));
});

test('a request without a theme header on the web root is not redirected', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
