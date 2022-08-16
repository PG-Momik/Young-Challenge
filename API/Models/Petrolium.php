<?php


require_once 'Database.php';

class Petrolium extends Database
{
    protected string $table = "Petroleum_Product";

    public function __construct($dbPath)
    {
        parent::__construct($dbPath);
        $this->createTable();
    }

}