<?php

class Database {

    private $db_server = 'localhost';
    private $db_user   = 'your username';
    private $db_pass   = 'your password';
    private $db_name   = 'todolistdb';
    private $conn;

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $dsn = "mysql:host={$this->db_server};dbname={$this->db_name};charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false, // Use real prepared statements
                ];

                $this->conn = new PDO($dsn, $this->db_user, $this->db_pass, $options);

            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return $this->conn;
    }
}

?>
