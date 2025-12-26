<?php

namespace App\Http\Controllers\Tinfoil;

use App\Enums\NintendoFileExtension;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    /**
     * Handle the incoming request from Tinfoil client.
     * Returns a JSON list of available Nintendo Switch installation files.
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'files' => $this->getInstallableFiles()->values(),
            'success' => config('app.name')
        ]);
    }

    /**
     * Get all Nintendo Switch installable files from storage.
     */
    private function getInstallableFiles(): Collection
    {
        return collect(Storage::allFiles())
            ->filter(fn ($path) => NintendoFileExtension::isSupported($path))
            ->map(fn ($path) => [
                'url' => url($path),
                'size' => Storage::size($path)
            ]);
    }
}
