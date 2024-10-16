<?php

declare(strict_types=1);

namespace Nahkampf\Deadlock;

class DB
{
    public \PDO $conn;

    public function __construct(string $dbfile)
    {
        $this->conn = new \PDO('sqlite:' . $dbfile);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function query(string $sql)
    {
        $res = [];
        foreach ($this->conn->query($sql) as $row) {
            foreach ($row as $key => $val) {
                $res[$key] = $val;
            }
        }
        return $res;
    }
}
