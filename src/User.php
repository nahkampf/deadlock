<?php

declare(strict_types=1);

namespace Nahkampf\Deadlock;

use Nahkampf\Deadlock\DB;

class User
{
    public static function getUser(int $id)
    {
        $db = new DB(__DIR__ . "/../deadlock.db");
        return $db->query("SELECT * FROM users WHERE userid={$id}");
    }
}
