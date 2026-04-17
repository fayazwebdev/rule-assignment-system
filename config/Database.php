<?php

namespace App\Config;

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "rule_assignment_system";

    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->connection = new \mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        // Check connection
        if ($this->connection->connect_error) {
            die("Database Connection Failed: " . $this->connection->connect_error);
        }

        // Set charset
        $this->connection->set_charset("utf8mb4");
    }

    public function getConnection()
    {
        return $this->connection;
    }
}