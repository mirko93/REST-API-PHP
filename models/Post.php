<?php


class Post
{
    // db stuff
    private $conn;

    // Post properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Posts
    public function read()
    {
        // create query
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM posts p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC';

        $statement = $this->conn->prepare($query);
        $statement->execute();

        return $statement;
    }

    // get single post
    public function read_single()
    {
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at FROM posts p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1';
        $statement = $this->conn->prepare($query);
        $statement->bindParam(1, $this->id);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    public function create()
    {
        $query = 'INSERT INTO posts SET title = :title, body = :body, author = :author, category_id = :category_id';
        $statement = $this->conn->prepare($query);

        // clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':body', $this->body);
        $statement->bindParam(':author', $this->author);
        $statement->bindParam(':category_id', $this->category_id);

        if ($statement->execute()) {
            return true;
        } else {
            printf("ERROR: %s.\n", $statement->error);
            return false;
        }
    }
}