<?php

use App\Http\Middleware\EnsureIsDbiClient;
use App\Http\Middleware\EnsureIsTinfoilClient;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->middleware([
    EnsureIsDbiClient::class,
    EnsureIsTinfoilClient::class
]);

Route::get('/docs/{page}', function ($page) {
    $allowedPages = ['TINFOIL', 'DBI'];
    if (!in_array($page, $allowedPages)) {
        abort(404);
    }
    
    $content = file_get_contents(base_path("docs/{$page}.md"));
    
    // Convert relative image paths to absolute paths for web viewing
    $content = str_replace(
        '](images/',
        '](/docs-images/',
        $content
    );
    
    return view('docs', ['content' => $content, 'title' => $page]);
})->name('docs');

Route::get('/docs-images/{path}', function ($path) {
    $imagePath = base_path("docs/images/{$path}");
    
    if (!file_exists($imagePath)) {
        abort(404);
    }
    
    return response()->file($imagePath);
})->where('path', '.*')->name('docs.images');

Route::get('/{path}', fn() => response('Not Found', 404))
    ->where('path', '(?!api|docs-images).*')
    ->middleware(EnsureIsDbiClient::class);
