<?php


class Database
{
    private string $DB_NAME = "/PetroliumDB.db";
    protected PDO $conn;

    public function __construct($dbPath)
    {
        $this->DB_NAME =$dbPath.$this->DB_NAME;
        $this->connect();
    }

    public function connect(): bool|PDO
    {
        try {
            $this->conn = new PDO("sqlite:" . $this->DB_NAME);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Vayo";
        } catch (PDOException $e) {
            echo "Connection error:" . $e->getMessage();
            return false;
        }
    }


   
}
