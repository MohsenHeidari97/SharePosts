<?php
/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */
class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        $url = $this->getUrl();

        //   Look in controllers for first value
        if (!empty($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // if exists set a controller
            $this->currentController = ucwords($url[0]);
            // unset 0 Index
            unset($url[0]);
        }

        //    Require the controller
        require_once '../app/controllers/'. $this->currentController . '.php';

        // Instantiate controller class
        $this->currentController = new $this->currentController;

        // check for second part of url
        if (isset($url[1])) {
            // check to see if method exists in controller
            if (method_exists($this->currentController , $url[1])) {
                $this->currentMethod = $url[1];

                // unset 1 index
                unset($url[1]);
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // call a callback with array of params
        call_user_func_array([$this->currentController , $this->currentMethod] , $this->params);

    }

    public function getUrl(){
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/' , $url);
            return $url;
        }
    }
}