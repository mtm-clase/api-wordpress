<?php
function publishPost($post) {
    $wpconn = new Wordpress_conn();
    $new_post = new WP_Post;
    $new_post -> jsonConstruct($post);
    $new_post -> insertPost($wpconn->curl);
    return_response(200, "OK", $new_post -> respuesta);
}

function tempPost() {
    $temps=fetch_temperature();
    $minTemp=$temps["min"];
    $maxTemp=$temps["max"];
    $date=date("Y/m/d");
    $post=json_encode(array("title"=> "Temperature of $date", "content" =>"<p>La temperatura mínima hoy es de $minTemp ºC.</p><br><p>La temperatura máxima es de $maxTemp ºC.</p>"));
    publishPost($post);
}

function fetch_temperature() {
    $url = "https://www.el-tiempo.net/api/json/v2/provincias/30";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        return false;
    }

    $data = json_decode($response, true);

    if (isset($data['ciudades'])) {
        foreach ($data['ciudades'] as $city) {
            if ($city['id'] === '30030') {
                $temperatureMax = $city['temperatures']['max'];
                $temperatureMin = $city['temperatures']['min'];
                break;
            }
        }
        return array("max"=>$temperatureMax, "min"=>$temperatureMin);
    } else {
        return false;
    }
}