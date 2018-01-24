<?php

class Routes
{
    private $uri = [];

    public function __construct()
    {
        $uri_param = strtolower(filter_input(INPUT_GET, "uri", FILTER_SANITIZE_STRING));

        $this->uri = isset($_GET['uri']) ? explode("/", $uri_param) : null;
        
        if (sizeof($this->uri) == 0) {
            require 'app/principal.html';
            exit();
        }

        if($this->uri[0] == "admin"){
            require 'app/admin/admin_main.html';
            exit();
        }

        http_response_code(404);
        #require 'custom404.php';
        exit();
    }


}
