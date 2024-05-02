<?php

class DatabaseConnection {
    private $server = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'taxiorders';
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->conn = new mysqli($this->server, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("ERROR: Could not connect. " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

}

$db = new DatabaseConnection();
$conn = $db->getConnection();
