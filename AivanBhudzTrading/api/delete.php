<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
    // initializing api
    include_once('../core/initialize.php');

    // instantiate post
    $post = new Post($db);

    // get raw posted data
    $data = json_decode(file_get_contents("php://input"));
    $post -> serial_number  = $data -> serial_number;

    // create post
    if($post->delete()) {
        echo json_encode(
            array('message' => 'Product deleted.')
        );
    } else {
        echo json_encode(array('message' => 'Product delete error.'));
    }