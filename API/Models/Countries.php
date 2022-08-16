<?php


require_once 'Database.php';

class Countries extends Database
{
    protected string $table = "Countries";

    public function __construct()
    {
        parent::__construct();
        $this->createTable();
    }

}