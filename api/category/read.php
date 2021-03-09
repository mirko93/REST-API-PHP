<?php

// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// db connect
$database = new Database();
$db = $database->connect();

$category = new Category($db);

$result = $category->read();
$num = $result->rowCount();

if ($num > 0) {
    $category_array = [];
    $category_array['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = [
            'id' => $id,
            'name' => $name,
        ];

        // push to "data"
        array_push($category_array['data'], $category_item);
    }

    // turn to JSON and output
    echo json_encode($category_array);

} else {
    echo json_encode(['message' => 'No Categories Found']);
}