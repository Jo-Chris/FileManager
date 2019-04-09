<?php

    /**
		* Class: User
		* @function: __construct
	*/

    class User extends Database {

        public $username = "";
        public $id = "";
        public $isLoggedIn = false;

        public function __construct(){

            parent::__construct();

            if ($_SESSION[get_class($this) . "Ship"] != ""){
                $ship = $_SESSION[get_class($this) . "Ship"];
                $this->fillIt($ship);
            };

        }

        public function __destruct(){
            parent::__destruct();
            $_SESSION[get_class($this) . "Ship"] = $this->shipIt();
        }

        public function authenticate(){

            if (!$this->isLoggedIn){
                define("LOGGED_IN", false);
                $this->redirectToLogin();
            };

            define("LOGGED_IN", true);

            return true;

        }

        public function redirectToLogin(){

            if (API_CALL === true){
                header("Location: ../" . LOGIN_URL);
            } else {
                header("Location: " . LOGIN_URL);
            };

            header("Status: 303");
            exit();

        }

        public function redirectToIndex(){
            header("Location: " . INDEX_URL);
            header("Status: 303");
            exit();
        }

        public function login($username, $password){

            $sql = "SELECT `id`, `password` FROM `user` WHERE `name`='" . $this->escapeString($username) . "'";
            $result = $this->query($sql);

            if ($this->numRows($result) == 0){
                $this->isLoggedIn = false;
                return false;
            };

            $row = $this->fetchObject($result);

            if (password_verify($password, $row->password)){
                $this->username = $username;
                $this->id = $row->id;
                $this->isLoggedIn = true;
                return true;
            };

            $this->isLoggedIn = false;
            return false;

        }

        public static function getById($id){

            $id = intval($id);
            $sql = "SELECT * FROM `user` WHERE `id`= ". $id;
            $db = new Database();
            $result = $db->query($sql);

            if ($db->numRows($result) > 0){

                $data = $db->fetchObject($result);
                $user = new User();
                $user->username = $data["username"];
                $user->id = $id;

                return $user;

            };

            return null;

        }

        public function logout(){

            $this->username = null;
            $this->id = null;
            $this->isLoggedIn = false;
            $this->shipIt();

            //$this->redirectToLogin();

            return true;

        }

        protected function shipIt(){

            $ship = serialize($this);
            $ship = addslashes($ship);

            return $ship;

        }

        protected function fillIt($ship){

            $ship = stripslashes($ship);
            $thiz = unserialize($ship);
            $ro = new reflectionObject($thiz);

            foreach ($ro->getProperties() as $propObj){
                $this->{$propObj->name} = $thiz->{$propObj->name};
            };

        }

        public static function existsWithUsername($username){

            $db = new Database();
            //check if user exists...
            $sql = "SELECT COUNT(`id`) AS num FROM `user` WHERE `name` = '" . $db->escapeString($username) . "'";
            $result = $db->query($sql);
            $row = $db->fetchObject($result);

            if ($row->num == 0){
                return false;
            };

            return true;

        }

        public static function createUser($data){
            $db = new Database();
            $username = $db->escapeString($data["username"]);
            $password = password_hash($db->escapeString($data["password"]), PASSWORD_BCRYPT);
            $sql = "INSERT INTO `user`(`name`, `password`) VALUES('" . $username . "','" . $password . "')";
            $db->query($sql);
        }

        public static function deleteUser($id){
            //@TODO
        }

        public static function updateUser($data){
            //@TODO
        }

        public function delete(){
            self::deleteUser($this->id);
        }

        public function update($data){
            self::updateUser($this->id, $data);
        }
        
    }

?>