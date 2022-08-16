<?php


require_once 'Database.php';

class Countries extends Database
{
    protected string $table = "Countries";

    public function __construct($dbPath)
    {
        parent::__construct($dbPath);
        $this->createTable();
    }

}