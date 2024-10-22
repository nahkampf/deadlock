<?php

use Nahkampf\Deadlock\Ansifile;
use Nahkampf\Deadlock\Input;

$parser->parse("%c%");
$parser->parse("%f12%WARNING! %f7%Creating a new game will irrevokably wipe everything associated with your current character (if you have one).%lf%%lf%");
$parser->parse("%f7%Create new game? %f8%[%f15%y%f8%/%f7%N] ");
while ($key = $input->key()) {
    if (strtoupper($key) === "N") {
        require __DIR__ . "/intro.php";
        return;
    }
    if (strtoupper($key) === "Y") {
        goto newgame;
    }
}
newgame:
$parser->parse("%c%%r%");
Ansifile::play("newchar.ans");
$input = new Input();
$input->anykey();
$parser->parse("%c%");
// archetype selector
$archetypes = [
    "arch01.ans",
    "arch02.ans",
    "arch03.ans",
    "arch04.ans",
    "arch05.ans",
    "arch06.ans",
];
$x=1;
Ansifile::play("arch01.ans");
while(true) {
    $key = $input->key();
    switch($key) {
        case "right":
            $x++;
            if ($x >= count($archetypes)) {
                $ansi->bell();
                $x = count($archetypes);
                break;
            }
            Ansifile::play("arch0{$x}.ans");
            break;
        case "left":
            $x--;
            if ($x < 1) {
                $ansi->bell();
                $x = 1;
                break;
            }
            Ansifile::play("arch0{$x}.ans");
            break;
    }
}
