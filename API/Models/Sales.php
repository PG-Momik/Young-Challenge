<?php

require_once 'Database.php';

class Sales extends Database
{
    protected string $table = "Sales";

    public function __construct()
    {
        parent::__construct();
        $this->createTable();
    }

    public function getAll($page = 1, $limit = 15): bool|array
    {
        $offset = ($limit * $page) - $limit;
        $query = "SELECT 
                        SP.year,
                        CP.Name as Country, 
                        PP.Name as Product, 
                         
                        SP.Sale 
                    From {$this->table} SP 
                    LEFT Join Petroleum_Product PP on PP.ID = SP.Petroleum_Id
                    LEFT Join Countries CP on CP.ID = SP.Country_Id
                    ORDER BY year asc LIMIT $limit OFFSET $offset";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalSalesByProducts(): bool|array
    {
        $query = "SELECT
                        PP.Name, 
                        Sum(SP.Sale) AS Total_Sales
	                FROM {$this->table} SP 
	                JOIN Petroleum_Product PP ON PP.ID = SP.Petroleum_Id 
	                GROUP By SP.Petroleum_Id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWinners($num = 3): bool|array
    {
        $query = "SELECT
                        PP.Name, 
                        Sum(SP.Sale) AS Total_Sales
	                FROM {$this->table} SP 
	                JOIN Petroleum_Product PP ON PP.ID = SP.Petroleum_Id 
	                GROUP By SP.Petroleum_Id Order BY Total_Sales DESC LIMIT {$num}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLosers($num = 3): bool|array
    {
        $query = "SELECT
                        PP.Name, 
                        Sum(SP.Sale) AS Total_Sales
	                FROM {$this->table} SP 
	                JOIN Petroleum_Product PP ON PP.ID = SP.Petroleum_Id 
	                GROUP By SP.Petroleum_Id Order BY Total_Sales ASC LIMIT {$num}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAverage($start, $end): bool|array
    {
        $query = "Select PP.Name Name, 
                    avg(SP.sale) Average 
                FROM sales SP
                JOIN Petroleum_Product PP on PP.ID = SP.Petroleum_Id
                WHERE (SP.year BETWEEN {$start} AND {$end}) 
                  AND (SP.Sale>0) 
                GROUP BY Petroleum_ID";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountOfRecord($avoidZero = false): int
    {
        $query = "SELECT count(*) as count from $this->table";
        if ($avoidZero) {
            $query = "SELECT count(*) as count from $this->table Where sale > 0";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

}