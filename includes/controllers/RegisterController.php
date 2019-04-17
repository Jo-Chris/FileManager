<?php

class RegisterController extends Controller {
    protected $viewFileName = "register";

    public function run(){
        $this->view->title = "Register";
    }

    public function register() {
        if(!empty($_POST) && isset($_POST['action']) && $_POST['action'] == 'register') {

            echo 'Checked';

            $first = $_POST['firstname'];
            $last  = $_POST['lastname'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            //need to check if user exists..

            //creat User
            User::createUser(array('firstname' => $first, 'lastname' => $last, 'email' => $email, 'password' => $password));


            //JSON
        }
    }
}