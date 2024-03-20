<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Icon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class IconsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (Storage::files('public/images/icons/') as $file) {
            $fileName = File::name($file);
            $res[] = [
                'name' => $fileName,
                'time_of_day' => self::getTimeOfDay($fileName),
                'path' => 'storage/images/icons/' . $fileName . '.png',
                'description' => self::getDescription($fileName)
            ];
        }
        Icon::insert($res);
    }

    private static function getTimeOfDay($filename): string
    {
        if (str_ends_with($filename, 'd')) {
            return 'day';
        } else {
            return 'night';
        }
    }

    private static function getDescription($filename): string
    {
        switch (substr($filename, 0, 2)) {
            case '01':
                return 'clear sky';
            case '02':
                return 'few clouds';
            case '03':
                return 'scattered clouds';
            case '04':
                return 'broken clouds';
            case '09':
                return 'shower rain';
            case '10':
                return 'rain';
            case '11':
                return 'thunderstorm';
            case '13':
                return 'snow';
            case '50':
                return 'mist';
        }
    }
}
