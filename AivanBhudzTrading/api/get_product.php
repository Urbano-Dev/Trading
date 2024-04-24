<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// initializing api
include_once ('../core/initialize.php');

// instantiate post
$post = new Post($db);

$post->serial_number = isset($_GET['serial_number']) ? $_GET['serial_number'] : die();
$post->serial_number = filter_var($post->serial_number, FILTER_SANITIZE_STRING);
try {
    $post->get_product();
    if (!empty($post->id)) {
        $post_arr = array(
            'id' => $post->id,
            'brand' => $post->brand_id,
            'product_name' => $post->product_name,
            'storage' => $post->storage,
            'memory' => $post->memory,
            'color' => $post->color,
            'price' => $post->price,
            'serial_number' => $post->serial_number,
            'notes' => $post->notes,
            'date' => $post->date
        );
        print_r(json_encode($post_arr));
    } else {
        http_response_code(404); // Not Found
        $error_arr = array('error' => $post->errors);
        echo json_encode($error_arr);
        exit;
    }

} catch (PDOException $e) {
    http_response_code(404); // Not Found status code
    print_r(json_encode(array('message' => 'Product not found.')));
}



