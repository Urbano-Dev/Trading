<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
// initializing api
include_once ('../core/initialize.php');

// instantiate post
$post = new Post($db);

// get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (
    isset($data->name, $data->storage, $data->memory, $data->color, $data->price, $data->serial_number, $data->notes, $data->brand_id)
    && !empty($data->name)
    && !empty($data->storage)
    && !empty($data->memory)
    && !empty($data->color)
    && !empty($data->price)
    && !empty($data->serial_number)
    && !empty($data->notes)
    && !empty($data->brand_id)
) {
    // Assign sanitized data to object properties
    $post->product_name = htmlspecialchars(strip_tags($data->name));
    $post->storage = htmlspecialchars(strip_tags($data->storage));
    $post->memory = htmlspecialchars(strip_tags($data->memory));
    $post->color = htmlspecialchars(strip_tags($data->color));
    $post->price = htmlspecialchars(strip_tags($data->price));
    $post->serial_number = htmlspecialchars(strip_tags($data->serial_number));
    $post->notes = htmlspecialchars(strip_tags($data->notes));
    $post->brand_id = htmlspecialchars(strip_tags($data->brand_id));

    // create post
    if ($post->create()) {
        echo json_encode(
            array('message' => 'Product added.')
        );
    } else {
        echo json_encode(array('message' => 'Product add error.'));
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(array('message' => 'Invalid input data.'));
}