<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
    // initializing api
    include_once('../core/initialize.php');

    // instantiate post
    $post = new Post($db);

    // get raw posted data
    $data = json_decode(file_get_contents("php://input"));
    $post -> id             = $data -> id;
    $post -> product_name   = $data -> product_name;
    $post -> storage        = $data -> storage;
    $post -> memory         = $data -> memory;
    $post -> color          = $data -> color;
    $post -> price          = $data -> price;
    $post -> serial_number  = $data -> serial_number;
    $post -> notes          = $data -> notes;
    $post -> brand_id       = $data -> brand_id;

    // create post
    if($post->update()) {
        echo json_encode(
            array('message' => 'Product Updated.')
        );
    } else {
        echo json_encode(array('message' => 'Product update error.'));
    }