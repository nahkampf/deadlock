<?php

declare(strict_types=1);

namespace Nahkampf\Deadlock;

use Bramus\Ansi\Ansi;
use Bramus\Ansi\Writers\StreamWriter;
use Bramus\Ansi\Parser;

class Input
{
    public function __construct()
    {
    }
    /**
     * Waits for a key press and returns the result
     */
    public function key()
    {
        $input = '';
        $read = [STDIN];
        $write = null;
        $except = null;
        readline_callback_handler_install('', function () {
        });
        do {
            $input .= fgetc(STDIN);
        } while (stream_select($read, $write, $except, 0, 1));
        readline_callback_handler_remove();
        $asciiArr = [];
        for ($i = 0; $i < strlen($input); $i++) {
            $asciiArr[$i] = ord($input[$i]);
        }
        switch ($input) {
            case "0":
                return "0";
            case chr(27):
                return "esc";
            case chr(27) . chr(91) . chr(65):
                return "up";
            case chr(27) . chr(91) . chr(66):
                return "down";
            case chr(27) . chr(91) . chr(68):
                return "left";
            case chr(27) . chr(91) . chr(67):
                return "right";
            case ord($input) == 10:
            case ord($input) == 13:
                return "enter";
            case ord($input) == 9:
                return "tab";
            case chr(8):
                return "backspace";
            case chr(127):
                return "backspace";
            case chr(27) . chr(79) . chr(80):
                return "f1";
            case chr(27) . chr(79) . chr(81):
                return "f2";
            case chr(27) . chr(79) . chr(82):
                return "f3";
            case chr(27) . chr(79) . chr(83):
                return "f4";
            case chr(27) . chr(91) . chr(49) . chr(53) . chr(126):
                return "f5";
            case chr(27) . chr(91) . chr(49) . chr(55) . chr(126):
                return "f6";
            case chr(27) . chr(91) . chr(49) . chr(56) . chr(126):
                return "f7";
            case chr(27) . chr(91) . chr(49) . chr(57) . chr(126):
                return "f8";
            case chr(27) . chr(91) . chr(50) . chr(48) . chr(126):
                return "f9";
            case chr(27) . chr(91) . chr(50) . chr(49) . chr(126):
                return "f10";
            default:
                return $input;
        }
    }

    public function inputField($parser, $row = 1, $column = 1, $maxlength = 32, $fill = " ")
    {
        // we can't draw a wrapped/multiline input field
        if ($column + $maxlength > 80) {
            throw new \Error("Input field too long (breaks row)");
        }
        $ansi = new Ansi(new StreamWriter('php://stdout'));
        $parser = new Parser($ansi, Parser::MODE_ANSIBBS);

        $pos = 0;
        $input = "";

        // draw the field (bg + fg)
        $parser->parse("%xy{$row},{$column}%%b4%%f14%");
        $parser->parse(str_repeat($fill, $maxlength));
        // place the cursor at the start of the field
        $parser->parse("%xy{$row},{$column}%");
        while (true) {
            $key = $this->key();
            switch ($key) {
                case "esc":
                case "f1":
                case "f2":
                case "f3":
                case "f4":
                case "f5":
                case "f6":
                case "f7":
                case "f8":
                case "f9":
                case "f10":
                case "up":
                case "down":
                case "left":
                case "right":
                case "tab":
                    break;
                case "backspace":
                    // just throw a bell if we're at pos 0
                    if ($pos < 1) {
                        $ansi->bell();
                        break;
                    }
                    // pop off the last character
                    $input = substr($input, 0, strlen($input) - 1);
                    // move cursor back 1 step, print a fill, move back 1 step again
                    $parser->parse("%cb1%{$fill}%cb1%");
                    $pos--;
                    break;
                case "enter":
                    return $input;
                default:
                    // are we at max length?
                    if ($pos >= $maxlength) {
                        $ansi->bell();
                        break;
                    }
                    $pos++;
                    echo $key;
                    $input .= $key;
                    break;
            }
        }
    }
}
