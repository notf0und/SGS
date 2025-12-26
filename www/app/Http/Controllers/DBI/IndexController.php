<?php

namespace App\Http\Controllers\DBI;

use App\Enums\NintendoFileExtension;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    private const GAMES_DIRECTORY = 'games';

    /**
     * Handle DBI file browser requests.
     * Serves either file downloads or Apache-style directory listings.
     */
    public function __invoke(Request $request): Response|BinaryFileResponse
    {
        $path = $this->getRequestPath($request);

        if ($this->isFileRequest($path)) {
            return $this->serveFile($path);
        }

        return $this->serveDirectoryListing($path, $request);
    }

    /**
     * Extract and decode the path from the request.
     */
    private function getRequestPath(Request $request): ?string
    {
        $path = $request->route('path');
        return $path ? urldecode($path) : null;
    }

    /**
     * Determine if the request is for a file download.
     */
    private function isFileRequest(?string $path): bool
    {
        return $path && NintendoFileExtension::isSupported($path);
    }

    /**
     * Serve a file download response.
     */
    private function serveFile(string $path): Response|BinaryFileResponse
    {
        $storagePath = self::GAMES_DIRECTORY . '/' . $path;

        if (!Storage::exists($storagePath)) {
            return response('File not found', 404);
        }

        return response()->file(Storage::path($storagePath), [
            'Content-Type' => 'application/octet-stream',
            'Accept-Ranges' => 'bytes',
        ]);
    }

    /**
     * Serve an Apache-style directory listing.
     */
    private function serveDirectoryListing(?string $path, Request $request): Response
    {
        $storagePath = $path 
            ? self::GAMES_DIRECTORY . '/' . $path 
            : self::GAMES_DIRECTORY;

        $directories = $this->getDirectories($storagePath);
        $files = $this->getFiles($storagePath);
        
        // Determine if this is a DBI client or regular browser
        $isDBI = str_starts_with($request->userAgent() ?? '', 'DBI/');
        
        // Determine base URL for links based on request path
        $baseUrl = str_starts_with($request->path(), 'api/dbi') ? '/api/dbi/' : '/';
        
        $html = $this->buildDirectoryListingHtml($directories, $files, $path ?? '', $baseUrl, $isDBI);

        return response($html)->header('Content-Type', 'text/html');
    }

    /**
     * Get directories that contain allowed file types.
     */
    private function getDirectories(string $path): Collection
    {
        return collect(Storage::directories($path))
            ->filter(fn ($dir) => $this->containsInstallableFiles($dir))
            ->map(fn ($dir) => [
                'name' => basename($dir),
                'mtime' => Storage::lastModified($dir),
            ])
            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    }

    /**
     * Get files with allowed extensions.
     */
    private function getFiles(string $path): Collection
    {
        return collect(Storage::files($path))
            ->filter(fn ($file) => NintendoFileExtension::isSupported($file))
            ->map(fn ($file) => [
                'name' => basename($file),
                'mtime' => Storage::lastModified($file),
                'size' => Storage::size($file),
            ])
            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    }

    /**
     * Check if a directory contains any installable files.
     */
    private function containsInstallableFiles(string $directory): bool
    {
        return collect(Storage::allFiles($directory))
            ->contains(fn ($file) => NintendoFileExtension::isSupported($file));
    }

    /**
     * Build Apache-style HTML directory listing compatible with DBI.
     */
    private function buildDirectoryListingHtml(Collection $directories, Collection $files, string $currentPath, string $baseUrl, bool $isDBI): string
    {
        $displayPath = $currentPath 
            ? '/games/' . urldecode($currentPath) . '/' 
            : '/games/';

        return view('dbi.directory-listing', [
            'displayPath' => $displayPath,
            'currentPath' => $currentPath,
            'baseUrl' => rtrim($baseUrl, '/'),
            'isDBI' => $isDBI,
            'parentUrl' => $this->getParentDirectoryUrl($currentPath, $baseUrl, $isDBI),
            'directories' => $directories,
            'files' => $files,
        ])->render();
    }

    /**
     * Get the URL for the parent directory.
     */
    private function getParentDirectoryUrl(string $currentPath, string $baseUrl, bool $isDBI): ?string
    {
        if (!$currentPath) {
            return null;
        }

        // DBI needs relative paths
        if ($isDBI) {
            return '../';
        }

        // Browsers need absolute paths
        $parentPath = dirname($currentPath);

        if ($parentPath === '.') {
            return $baseUrl;
        }

        return rtrim($baseUrl, '/') . '/' . collect(explode('/', $parentPath))
            ->map(fn ($segment) => rawurlencode($segment))
            ->implode('/');
    }
}