<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control_Allow-Headers: Access-Control_Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// db connect
$database = new Database();
$db = $database->connect();

$post = new Post($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

// create post
if ($post->create()) {
    echo json_encode(['message' => 'Post Created']);
} else {
    echo json_encode(['message' => 'Post Not Created']);
}