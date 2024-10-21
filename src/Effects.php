<?php

declare(strict_types=1);

namespace Nahkampf\Deadlock;

use \Bramus\Ansi\Ansi as Ansi;
use \Bramus\Ansi\Writers\StreamWriter as StreamWriter;
use \Bramus\Ansi\Parser as Parser;

class Effects
{
    /**
     * Assumes 80x25 (but can easily be modified for dynamic screen size)
     */
    public static function deadScreen()
    {
        $ansi = new Ansi(new StreamWriter('php://stdout'));
        $parser = new Parser($ansi, Parser::MODE_ANSIBBS);
        $parser->parse("%r%"); // we don't want any pesky leftover background colors
        $parser->parse("%f15%");
        $x = 0;
        start:
        $parser->parse("%c%");
        for ($row = 1; $row < 26; $row++) {
            for ($column = 1; $column < 80; $column++) {
                // make a random noise here
                // either █, ▀ or ▄ in white or black
                $color = random_int(0, 1);
                $glyphs = [0 => chr(219), 1 => chr(220), 2 => chr(223)];
                $glyph = $glyphs[random_int(0, 2)];
                if ($color == 0) {
                    $parser->parse(" ");
                    continue;
                } else {
                    $parser->parse($glyph);
                }
            }
        }
        while ($x < 10) {
            usleep(50000);
            $x++;
            goto start;
        }
        $parser->parse("%c%%xy1,1%");
    }

    public static function expandFill($char = "$", $color = 15, $bgcolor = 0, $delay = 5000)
    {
        $ansi = new Ansi(new StreamWriter('php://stdout'));
        $parser = new Parser($ansi, Parser::MODE_ANSIBBS);
        $parser->parse("%r%%n%"); // we don't want any pesky leftover background colors
        $parser->parse("%f{$color}%");
        $parser->parse("%b{$bgcolor}%");
        $parser->parse("%xy12,1%");
        self::drawLine($char, 80);
        for ($x = 1; $x < 13; $x++) {
            $parser->parse("%xy" . 12 + $x . ",1%");
            self::drawLine($char, 80);
            $parser->parse("%xy" . 12 - $x . ",1%");
            self::drawLine($char, 80);
            usleep($delay);
        }
    }

    public static function whiteFlash() {
        // dark grey
        self::expandFill(chr(176), 8, 0, 2000);
        self::expandFill(chr(177), 8, 0, 2000);
        self::expandFill(chr(178), 8, 0, 2000);
        self::expandFill(chr(219), 8, 0, 2000);
        // dark grey with light grey bg
        self::expandFill(chr(178), 8, 7, 2000);
        self::expandFill(chr(177), 8, 7, 2000);
        self::expandFill(chr(176), 8, 7, 2000);
        self::expandFill(chr(219), 7, 0, 2000);
        // white with light grey bg
        self::expandFill(chr(176), 15, 7, 2000);
        self::expandFill(chr(177), 15, 7, 2000);
        self::expandFill(chr(178), 15, 7, 2000);
        self::expandFill(chr(219), 15, 0, 2000);
        // and then reverse
        self::expandFill(chr(177), 15, 7, 2000);
        self::expandFill(chr(178), 15, 7, 2000);
        self::expandFill(chr(176), 15, 7, 2000);
        self::expandFill(chr(219), 7, 0, 2000);
        self::expandFill(chr(176), 8, 7, 2000);
        self::expandFill(chr(177), 8, 7, 2000);
        self::expandFill(chr(178), 8, 7, 2000);
        self::expandFill(chr(219), 8, 0, 2000);
        self::expandFill(chr(178), 8, 0, 2000);
        self::expandFill(chr(177), 8, 0, 2000);
        self::expandFill(chr(176), 8, 0, 2000);
        self::expandFill(chr(219), 0, 0, 2000);
    }
    public static function drawLine($char = "-", $len = 80)
    {
        echo str_repeat($char, $len);
    }
}