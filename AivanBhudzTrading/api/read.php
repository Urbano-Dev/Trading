<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// initializing api
include_once ('../core/initialize.php');

// instantiate post
$post = new Post($db);

$result = $post->read();


if ($result) {
    $num = $result->rowCount();
    if ($num > 0) {
        $post_arr = array();
        $post_arr['data'] = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $post_item = array(
                'id' => $id,
                'brand' => $brand,
                'product_name' => $name,
                'storage' => $storage,
                'memory' => $memory,
                'color' => $color,
                'price' => $price,
                'serial_number' => $serial_number,
                'notes' => $notes,
                'date' => $date
            );
            array_push($post_arr['data'], $post_item);
        }
        echo json_encode($post_arr);
    } else {
        echo json_encode(array('message' => 'No item found.'));
    }
} else {
    echo json_encode(array('message' => 'Error'));
}

