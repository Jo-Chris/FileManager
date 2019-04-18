<?php

    /**
        * Class: LogoutController
        * @function: run
    */

    class LogoutController extends Controller {

        protected $viewFileName = "logout";
        protected $loginRequired = false;

        public function run(){

            $this->view->title = "Logout";

            $this->user->logout();
            $this->user = null;

        }

    }

?>