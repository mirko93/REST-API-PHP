<?php

// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// db connect
$database = new Database();
$db = $database->connect();

// blog post object
$post = new Post($db);
$result = $post->read();
$num = $result->rowCount();

if ($num > 0) {
    $posts_array = [];
    $posts_array['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = [
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name,
        ];

        // push to "data"
        array_push($posts_array['data'], $post_item);
    }

    // turn to JSON and output
    echo json_encode($posts_array);

} else {
    echo json_encode(['message' => 'No Posts Found']);
}

