<?php

namespace App\Helpers;

class FileSize
{
    private const UNITS = ['', 'K', 'M', 'G', 'T'];
    private const THRESHOLD = 1024;

    /**
     * Format bytes into human-readable file size.
     */
    public static function format(int $bytes): string
    {
        if ($bytes === 0) {
            return '0';
        }

        $unitIndex = (int) floor(log($bytes, self::THRESHOLD));
        $unitIndex = min($unitIndex, count(self::UNITS) - 1);
        
        $size = $bytes / pow(self::THRESHOLD, $unitIndex);
        
        return number_format($size, 2) . self::UNITS[$unitIndex];
    }
}
