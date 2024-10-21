<?php

declare(strict_types=1);

namespace Nahkampf\Deadlock;

class Utils
{
    /**
     * The hangup handler (graceful exit). If there is any book-keeping or cleanup to do, we'll call it from here
     */
    public static function hangup(string $reason = "Hung up with no reason given")
    {
        exit($reason);
    }

    /**
     * Calculates the length of a string minus all the ANSI shortcodes
     */
    public static function calcStrLen(string $str)
    {
        return strlen(preg_replace("/%[^%]*%/i", "", $str));
    }
    public static function center(\Bramus\Ansi\Parser $parser, string $str, string $type = "horizontal")
    {
        // calculate the length of the string minus ansi shortcodes
        $strlen = Utils::calcStrLen($str);
        // this assumes an 80x25 display
        $toowide = 0;
        if ($strlen > 80) {
            $toowide = 1;
        }
        switch ($type) {
            case "vertical":
                echo "\e[12;H;";
                $parser->parse($str);
                break;
            case "both":
                if ($toowide !== 0) {
                    return false;
                }
                echo "\e[12;" . floor(40 - ($strlen / 2)) . "H;";
                $parser->parse($str);
                break;
            case "horizontal":
            default:
                if ($toowide !== 0) {
                    return false;
                }
                echo "\e[" . floor(40 - ($strlen / 2)) . "G"; // this might not be ANSI.SYS compatible
                $parser->parse($str);
                break;
        }
        return null;
    }
}
