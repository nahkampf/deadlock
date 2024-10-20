<?php
require __DIR__ . "/../vendor/autoload.php";

use Bramus\Ansi\Ansi;
use Nahkampf\Deadlock\Ansifile;
use Nahkampf\Deadlock\Utils;
use Nahkampf\Deadlock\Input;

start:
$parser->parse("%r%%c%");
if ($showsplash) {
    Ansifile::play("intro.ans");
    $str = "%f14%dead%f15%lock %f7%version %f15%" . VERSION . "%f7% by %f14%tz %f8%<%f15%kreuzweg@gmail.com%f8%>%lf%";
    Utils::center($parser, $str, "horizontal");
    $parser->parse("%lf%");
    sleep(2);
}
$showsplash = false;
$parser->parse("%r%%c%");
$input = new Input();
Ansifile::play("menu_1.ans");
$x=1;
while(true) {
    switch ($input->key()) {
        case "up":
            $x--;
            if ($x < 1) {
                $x = 4;
            }
            $parser->parse("%c%");
            Ansifile::play("menu_{$x}.ans");
            break;
        case "down":
            $x++;
            if ($x > 4) {
                $x = 1;
            }
            $parser->parse("%c%");
            Ansifile::play("menu_{$x}.ans");
            break;
        case "enter":
            switch($x) {
                case 1: // ENTER GAME
                    require "mainmenu.php";
                    break;
                case 2: // NEW GAME
                    require "newgame.php";
                    break;
                case 3: // HELP
                    require "help.php";
                    break;
                case 4: // EXIT
                default:
                    Utils::hangup("Jacking out...");
                    break;
            }
            break;
        }
}
