<?php

declare(strict_types=1);

const VERSION = "0.0.1";

require "vendor/autoload.php";

use Bramus\Ansi\Ansi;
use Bramus\Ansi\Writers\StreamWriter;
use Bramus\Ansi\Parser;

use Nahkampf\Deadlock\Dropfile;
use Nahkampf\Deadlock\DropfileType;
use Nahkampf\Deadlock\Ansifile;
use Nahkampf\Deadlock\DB;
use Nahkampf\Deadlock\User;
use Nahkampf\Deadlock\Effects;

$ansi = new Ansi(new StreamWriter('php://stdout'));
$parser = new Parser($ansi, Parser::MODE_ANSIBBS);
Effects::whiteFlash();
for ($f = 0; $f < 10; $f++) {
    Ansifile::play('ad_1.ans');
    usleep(50000);
    Ansifile::play('ad_2.ans');
    usleep(50000);    
}
Effects::deadScreen();
$args = getopt(
    "",
    [
      "dropfile::",
      "type::",
      "userid::",
      "minutes::",
      "handle::"
    ]
);
$ansi->eraseDisplay();
if (empty($args)) {
    $parser->parse("%c%%r%%n%");
    $parser->parse("%f11%dead%f14%lock %f7%v%f15%" . VERSION . "%r%%lf%");
    $parser->parse("Deadlock needs to be run with arguments!%lf%%lf%");
    $parser->parse("%f15%--dropfile%r%\tPath to dropfile (e.g /sbbs/%lf");
    $parser->parse("%f15%--type%r%\t\tType of dropfile (door32 or doorsys)%lf%");
    $parser->parse("%lf%It is also possible to skip the dropfile and use these options instead:%lf%");
    $parser->parse("%f15%--userid%r%\tNumeric ID of the BBS user%lf%");
    $parser->parse("%f15%--minutes%r%\tMinutes left (this call)%lf%");
    $parser->parse("%f15%--handle%r%\tUsers handle (optional)%lf");
    sleep(3);
    exit;
}
// if dropfile path is set, this overrides other arguments and instantiates like normal
if (isset($args["dropfile"])) {
    $parser->parse("%f8%> Reading dropfile...%lf%");
    switch ($args["type"]) {
        case "door32":
            echo "parsing door32.sys";
            $type = DropfileType::DOOR32SYS;
            break;
        case "doorsys":
            echo "parsing door.sys";
            $type = DropfileType::DOORSYS;
            break;
        default:
            throw new \Error(Dropfile::ERR_UNSUPPORTEDFORMAT);
            break;
    }
    $dropfile = new Dropfile($args["dropfile"], $type);
}
if (isset($args["userid"])) {
    $dropfile = new Dropfile("", DropfileType::DOOR32SYS, $args);
}

// Read the config file and/or set defaults
$config = [
    "playTimeLimit" => 60,
    "startingCash" => 5000,
    "startingAttributePoints" => 25
];
if (file_exists("config.ini")) {
    $parser->parse("%f8%> Reading config...%lf%");
    $configFromFile = parse_ini_file("config.ini");
    // overwrite defaults
    foreach ($configFromFile as $key => $val) {
        $config[$key] = $val;
    }
}

// Load the intro screen
//Ansifile::play("intro.ans");
$parser->parse("%f8%> Initializing user...%lf%");
//$user = User::getUser((int)$args["userid"]);
usleep(500000);
require "screens/intro.php";
