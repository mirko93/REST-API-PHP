<?php


class Category
{
    // DB stuff
    private $conn;
    public $id;
    public $name;
    public $created_at;

    // construct db connect
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // get categories
    public function read()
    {
        $query = 'SELECT * FROM categories ORDER BY created_at DESC';
        $statement = $this->conn->prepare($query);
        $statement->execute();

        return $statement;
    }
}