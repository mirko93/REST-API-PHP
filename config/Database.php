<?php


class Database
{
    // DB params
    private $dbHost = 'localhost';
    private $dbName = 'blog_rest_api';
    private $dbUsername = 'root';
    private $dbPassword = '';

    private $conn;

    // DB connect
    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbUsername, $this->dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $this->conn;
    }
}