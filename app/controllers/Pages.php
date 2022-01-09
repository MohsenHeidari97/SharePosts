<?php

class Pages extends Controller {
    public function __construct()
    {

    }

    public function index() {
        if (isLoggedIn()){
            redirect('posts');
        }

        $data = [
            'title' => 'SharePost' ,
            'description' => 'Simple Social network built on MVC PHP framework'
        ];
        $this->view('/pages/index' , $data);
    }

    public function about() {
        $data = [
            'title' => 'About us' ,
            'description' => 'App to share posts with other users'
        ];
        $this->view('/pages/about' , $data);
    }
}

?>