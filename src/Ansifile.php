<?php

namespace Nahkampf\Deadlock;

class Ansifile
{
    public static function play(string $file): void
    {
        $contents = file_get_contents(__DIR__ . "/../assets/" . $file);
        echo $contents;
    }
}
