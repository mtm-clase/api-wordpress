<?php
    require "wordpress_conn.php";
    require "WP_Post.php";
    function return_response($status, $statusMessage, $data) {
        header("HTTP/1.1 $status $statusMessage");
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
    }

    $bodyRequest = file_get_contents("php://input");
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            handleGET();
            break;
        case 'POST':
            handlePOST($bodyRequest);
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

    function handlePOST($bodyRequest) {
        $wpconn = new Wordpress_conn();
        $new_post = new WP_Post;
        $new_post -> jsonConstruct($bodyRequest);
        $new_post -> insertPost($wpconn->curl);
        return_response(200, "OK", $new_post -> respuesta);
    }
?>