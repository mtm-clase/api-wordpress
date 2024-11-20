<?php
class Wordpress_conn {
    public $curl;
    public function __construct() {
        $wp_user = 'moises';
        $wp_app_pass = 'F5OURk4gc0d5GslwPybUC3Qk';
        $wp_api_key = base64_encode($wp_user.':'.$wp_app_pass); // Base64
        $url = 'http://www.ingeniero.cierva/wp-json/wp/v2/posts/';
        $this -> curl = curl_init($url);
        curl_setopt($this -> curl, CURLOPT_HTTPHEADER, [
            'Authorization: Basic '.$wp_api_key,
            'Content-Type: application/json'
        ]);
    }

    public function __destruct() {
        curl_close($this-> curl);
    }
}
$pepe = new Wordpress_conn();
?>