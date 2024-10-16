<?php

declare(strict_types=1);

namespace Nahkampf\Deadlock;

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
        readline_callback_handler_install('', function () {});
        do {
            $input .= fgetc(STDIN);
        } while (stream_select($read, $write, $except, 0, 1));
        readline_callback_handler_remove();
        $asciiArr = [];
        for ($i = 0; $i < strlen($input); $i++) {
            $asciiArr[$i] = ord($input[$i]);
        }
        switch ($input) {
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
            case chr(27) . chr(91) . chr(49) . chr(49) . chr(126):
                return "f1";
            case chr(27) . chr(91) . chr(49) . chr(50) . chr(126):
                return "f2";
            case chr(27) . chr(91) . chr(49) . chr(51) . chr(126):
                return "f3";
            case chr(27) . chr(91) . chr(49) . chr(52) . chr(126):
                return "f4";
            case chr(27) . chr(91) . chr(49) . chr(53) . chr(126):
                return "f5";
            case chr(27) . chr(91) . chr(49) . chr(54) . chr(126):
                return "f6";
            case chr(27) . chr(91) . chr(49) . chr(54) . chr(126):
                return "f7";
            case chr(27) . chr(91) . chr(49) . chr(54) . chr(126):
                return "f8";
            case chr(27) . chr(91) . chr(49) . chr(54) . chr(126):
                return "f9";
            case chr(27) . chr(91) . chr(49) . chr(54) . chr(126):
                return "f10";
            default:
                return $input;
                break;
        }
    }
}
