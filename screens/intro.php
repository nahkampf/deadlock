<?php
require __DIR__ . "/../vendor/autoload.php";
use Nahkampf\Deadlock\Ansifile;
use Nahkampf\Deadlock\Utils;
use Nahkampf\Deadlock\Input;

start:
$parser->parse("%r%%c%");
Ansifile::play("intro.ans");
$str = "%f14%dead%f15%lock %f7%version %f15%" . VERSION . "%f7% by %f14%tz %f8%<%f15%kreuzweg@gmail.com%f8%>%lf%";
Utils::center($parser, $str, "horizontal");
$parser->parse("%lf%");
Utils::center($parser, "%f8%[%f15%N%f7%] New game       %lf%");
if ($user["userId"]) {
    Utils::center($parser, "%f8%[%f15%E%f7%] %f14%Enter the world%lf%");
    Utils::center($parser, "%f8%[%f15%C%f7%] %r%My character   %lf%");
}
Utils::center($parser, "%f8%[%f15%H%f7%] Help           %lf%");
Utils::center($parser, "%f8%[%f15%P%f7%] Player list     %lf%");
Utils::center($parser, "%f8%[%f15%X%f7%] %f12%Exit           %lf%");
$input = new Input();
switch ($input->key()) {
    case "n":
    case "N":
        echo "New game!";
        break;
    case "x":
    case "X":
        Utils::hangup("Jacking out...");
        break;
    default:
        goto start;
        break;
}
