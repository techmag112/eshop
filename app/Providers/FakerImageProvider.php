<?php

namespace App\Providers;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FakerImageProvider extends Base
{
    public function loremflickr(string $dir = '', int $width = 500, int $height = 500): string
    {
        $name = $dir . '/' . Str::random(6) . '.jpg';

        Storage::put(
            $name,
            file_get_contents('https://loremflickr.com/$width/$height')
        );

        return 'storage' . $name;
    }

    public function fixturesImage(string $fixturesDir, string $storageDir): string
    {
        if(!Storage::exists($storageDir)) {
            Storage::makeDirectory($storageDir);
        }

        $file = $this->generator->file(
            base_path("tests/Fixtures/images/$fixturesDir"),
            Storage::path($storageDir),
            false
        );

        return '/storage/' . trim($storageDir, '/') . '/' . $file;

    }
}
