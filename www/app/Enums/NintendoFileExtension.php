<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum NintendoFileExtension: string
{
    case NSP = 'nsp';
    case NSZ = 'nsz';
    case XCI = 'xci';
    case XCZ = 'xcz';

    /**
     * Get all supported file extensions.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    /**
     * Check if a filename has a supported extension.
     */
    public static function isSupported(string $filename): bool
    {
        $extension = Str::lower(Str::afterLast($filename, '.'));

        return in_array($extension, self::values(), true);
    }
}
