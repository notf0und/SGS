<?php

use App\Helpers\FileSize;

test('formats zero bytes as "0"', function () {
    expect(FileSize::format(0))->toBe('0');
});

test('formats byte values without decimal places', function () {
    expect(FileSize::format(1))->toBe('1');
    expect(FileSize::format(512))->toBe('512');
    expect(FileSize::format(1001))->toBe('1001');
    expect(FileSize::format(1023))->toBe('1023');
});

test('formats kilobytes', function () {
    expect(FileSize::format(1024))->toBe('1.00K');
    expect(FileSize::format(1536))->toBe('1.50K');
});

test('formats megabytes', function () {
    expect(FileSize::format(1024 * 1024))->toBe('1.00M');
    expect(FileSize::format((int) (1.5 * 1024 * 1024)))->toBe('1.50M');
});

test('formats gigabytes', function () {
    expect(FileSize::format(1024 * 1024 * 1024))->toBe('1.00G');
});

test('formats terabytes', function () {
    expect(FileSize::format(1024 * 1024 * 1024 * 1024))->toBe('1.00T');
});
