<?php
$parser->parse("%c%");
$parser->parse("%f13%WARNING! %f7%Creating a new game will irrevokably wipe everything associated with your current character (if you have one).%lf%%lf%");
$parser->parse("%f7%Create new game? %f8%[%f15%y%f8%/%f7%N] ");
while($key = $input->key()) {
    if (strtoupper($key) == "N") {
        require "intro.php";
        return;
    }
    if (strtoupper($key) == "Y") {
        goto newgame;
    }
}
newgame:
$parser->parse("%c%New game...");
