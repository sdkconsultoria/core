<?php

namespace Sdkconsultoria\Core\Service;

class FileManager
{
    public static function create(string $file_path): void
    {
        $file = fopen($file_path, "w") or die("Unable to open file!");
        fclose($file);
    }

    public static function append(string $file_path, string $text): void
    {
        $file = fopen($file_path, "a") or die("Unable to open file!");
        fwrite($file, $text);
        fclose($file);
    }

    public static function replace(string $search, string $replace, string $path): void
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    public static function loadJsonFile(): void
    {
    }

    public static function fixString()
    {
    }
}
