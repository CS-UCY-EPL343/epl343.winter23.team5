<?php 

class Dbh {
    
    private $host = 'localhost';
    private $dbname = 'tutoring';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function executeQuery($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            echo 'Query failed: ' . $e->getMessage();
            return false;
        }
    }
}
/*
// Example usage:
$database = new Database();

// Insert data
$sql = "INSERT INTO your_table (column1, column2) VALUES (:value1, :value2)";
$params = [':value1' => 'some_value', ':value2' => 'another_value'];
$database->executeQuery($sql, $params);

// Select data
$sql = "SELECT * FROM your_table";
$result = $database->executeQuery($sql);

// Fetch data
$data = $result->fetchAll(PDO::FETCH_ASSOC);

// Use the fetched data as needed
*/
?>