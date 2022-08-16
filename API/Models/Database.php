<?php


class Database
{
    protected PDO $conn;

    public function __construct()
    {
        $this->connect();
    }

 
}
