<?php

use App\Enums\NintendoFileExtension;

test('values() returns all four supported extensions', function () {
    expect(NintendoFileExtension::values())->toBe(['nsp', 'nsz', 'xci', 'xcz']);
});

test('isSupported() returns true for each supported extension', function (string $filename) {
    expect(NintendoFileExtension::isSupported($filename))->toBeTrue();
})->with(['game.nsp', 'game.nsz', 'game.xci', 'game.xcz']);

test('isSupported() is case-insensitive', function (string $filename) {
    expect(NintendoFileExtension::isSupported($filename))->toBeTrue();
})->with(['game.NSP', 'game.NSZ', 'game.XCI', 'game.XCZ', 'game.Nsp', 'game.Xci']);

test('isSupported() returns false for unsupported extensions', function (string $filename) {
    expect(NintendoFileExtension::isSupported($filename))->toBeFalse();
})->with(['game.txt', 'game.exe', 'game.zip', 'game.iso', 'game.php', 'game.rom']);

test('isSupported() returns false for files without an extension', function () {
    expect(NintendoFileExtension::isSupported('gamefile'))->toBeFalse();
});

test('isSupported() works with paths containing directory separators', function () {
    expect(NintendoFileExtension::isSupported('folder/game.nsp'))->toBeTrue();
    expect(NintendoFileExtension::isSupported('folder/sub/game.xci'))->toBeTrue();
    expect(NintendoFileExtension::isSupported('folder/game.txt'))->toBeFalse();
});
