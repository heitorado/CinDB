<?php

class Routes
{
    private $uri = [];
    #private $admuri = [];

    public function __construct()
    {
        $uri_param = strtolower(filter_input(INPUT_GET, "uri", FILTER_SANITIZE_STRING));

        $this->uri = isset($_GET['uri']) ? explode("/", $uri_param) : null;
        #$this->admuri = isset($_GET['uri'] ? explode("_"), $uri_param) : null;

        if (sizeof($this->uri) == 0) {
            require 'app/principal.html';
            exit();
        }

        if($this->uri[0] == "admin"){ //if($this->uri[0] == "admin" && sizeof($this->uri) > 1){
            require 'app/admin/admin_main.html';
            exit();
        }

        if($this->uri[0] == "login"){
            require 'app/admin/login_page.html';
            exit();
        }

        http_response_code(404);
        #require 'custom404.php';
        exit();
    }


}
