<?php
/**
 * Run this file from your BBS door setup to check that your system is
 * actually compatible!
 */

// Does this look like CP437 ansi to you?
echo "The line below should be a solid block plus three lighter shaded blocks. If it is not that, you probably have a charset problem (should be CP437):\n";
echo chr(219) . chr(178) . chr(177) . chr(176) . "\n\n";
echo "The line below should be the text DEADLOCK in bright white on a grey background. If it is something else then you probably have an ANSI problem:\n";
echo "\e[1;37m\e[0;47mDEADLOCK\e[0m\n\n";

// Are we on at least php 7.1?
if (!function_exists('phpversion')) {
    echo "[!] Your PHP is too old (requires at least php 7.1\n";
}
if (function_exists('phpversion')) {
    $ver = explode(".", phpversion());
    if ($ver[0] + $ver[1] < 8) { // 7.1 = 8, 8.0 = 8 etc
        echo "[!] Your PHP is too old (requires at least php 7.1\n";
    }
}

// Do we have the required readline stuff?
if (!extension_loaded('readline')) {
    echo "[!] Your PHP doesn't have the readline extension.\n";
}
if (!function_exists('readline_callback_read_char') || !function_exists('readline_callback_handler_install')) {
    echo "[!] Your PHP version does not support readline_callback_read_char() or readline_callback_handler_install(). They are not supported on Windows!\n";
}

// do we have PDO and sqlite3?
if (!extension_loaded('pdo')) {
    echo "[!] Your PHP doesn't have the PDO extension.\n";
}
if (!extension_loaded('sqlite3')) {
    echo "[!] Your PHP doesn't have the sqlite3 extension.\n";
}

echo "If everything looks allright and you had no errors, you should be good to go!\n";
echo "Sleeping for 10 seconds before returning (in case you forgot to add pause after exiting a door).\n";
sleep(10);
