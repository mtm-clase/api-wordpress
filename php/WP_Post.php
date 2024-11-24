<?php
class WP_Post implements \JsonSerializable {
    private string $title;
    private string $content;
    public string $respuesta;

    public function parametersConstruct(int $title, string $content){
        $this->title = $title;
        $this->content = $content;
    }

    public function jsonConstruct($json) {
        foreach (json_decode($json, true) as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

    public function insertPost($wpconn) {
        $title=$this->title;
        $content=$this->content;
        // Lo bueno de descomponer el JSON para volver a componerlo es que en el servidor podemos
        // manipular los elementos por si quisieramos darles otro formato y/o añadir algo más.
        $data = json_encode(array('title'=> $title, 'content'=> $content, 'status'=> 'publish'));
        curl_setopt($wpconn, CURLOPT_POSTFIELDS, $data);
        curl_setopt($wpconn, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($wpconn);
        if ($response === false) {
            die('Error occurred while fetching the data: ' 
                . curl_error($wpconn));
        }
        $this->respuesta = $response;
    }
    public function getTemperatures() {
        
    }
}
?>
