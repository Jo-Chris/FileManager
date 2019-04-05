<?php

class RegisterController extends Controller {
    protected $viewFileName = "register";

    public function run(){
        $this->view->title = "Register";
    }

    public function register() {

    }

}