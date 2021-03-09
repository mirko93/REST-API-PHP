<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PATCH');
header('Access-Control_Allow-Headers: Access-Control_Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// db connect
$database = new Database();
$db = $database->connect();

$post = new Post($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// set ID to update
$post->id = $data->id;
$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

// update post
if ($post->update()) {
    echo json_encode(['message' => 'Post Update']);
} else {
    echo json_encode(['message' => 'Post Not Update']);
}
