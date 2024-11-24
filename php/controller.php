<?php
    require "wordpress_conn.php";
    require "WP_Post.php";
    require "post_types.php";
    function return_response($status, $statusMessage, $data) {
        header("HTTP/1.1 $status $statusMessage");
        header("Content-Type: application/json; charset=UTF-8");
        //echo json_encode($data);
        echo json_encode($_SERVER);
    }

    $bodyRequest = file_get_contents("php://input");
    $method = $_SERVER['REQUEST_METHOD'];
    $post_type = $_SERVER['HTTP_X_POST_TYPE'];

    switch ($method) {
        case 'GET':
            handleGET();
            break;
        case 'POST':
            handlePOST($bodyRequest, $post_type);
            break;
        case 'PUT':
            handlePUT($bodyRequest);
            break;
        case 'DELETE':
            handleDELETE($bodyRequest);
            break;
        default:
            echo json_encode(['message' => 'Invalid request method']);
            break;
    }

    function handlePOST($bodyRequest, $post_type) {
        switch ($post_type) {
            case 'temperature':
                tempPost();
                break;
            case 'post':
                publishPost($bodyRequest);
                break;
            default:
                echo json_encode(['message' => 'Invalid request method']);
                break;
        }
    }
?>