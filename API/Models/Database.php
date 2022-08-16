<?php


class Database
{
    private string $DB_NAME = "/PetroliumDB.db";
    protected PDO $conn;

    public function __construct($dbPath)
    {
   		$this->DB_NAME = $dbPath.$this->DB_NAME;
        $this->connect();
    }

    public function connect(): bool|PDO
    {
        try {
            $this->conn = new PDO("sqlite:" . $this->DB_NAME);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Connection error:" . $e->getMessage();
            return false;
        }
    }


    //Almost Common methods
    function createTable(): bool
    {
        $queries = [
            "CREATE TABLE IF NOT EXISTS Countries (ID INTEGER NOT NULL, Name Char(50) UNIQUE, PRIMARY KEY(ID))",
            "CREATE TABLE IF NOT EXISTS Petroleum_Product (ID INTEGER NOT NULL, Name Char(50) UNIQUE, PRIMARY KEY(ID))",
            "CREATE TABLE IF NOT EXISTS Sales (ID INTEGER NOT NULL, Year INTEGER, Petroleum_Id INTEGER, Sale INTEGER, Country_Id INTEGER, FOREIGN KEY(Country_Id) REFERENCES Countries(ID), FOREIGN KEY(Petroleum_Id) REFERENCES Petroleum_Product(ID), PRIMARY KEY(ID))"
        ];
        switch ($this->table) {
            case "Countries":
                $stmt = $this->conn->prepare($queries[0]);
                return $stmt->execute() ?? false;
            case "Petroleum_Product":
                $stmt = $this->conn->prepare($queries[1]);
                return $stmt->execute() ?? false;
            case "Sales":
                $stmt = $this->conn->prepare($queries[2]);
                return $stmt->execute() ?? false;
            default:
                return false;
        }
    }
    
    function getIdByName($name)
    {
        if ($this->table != "Sales") {
            $query = "SELECT ID FROM {$this->table} WHERE name LIKE :name LIMIT 1";
            $name = "%{$name}%";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam("name", $name);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['ID'];
        }
        return false;
    }

}
