<?php

    /**
<<<<<<< HEAD
        * Class: User
        * @function: __construct, __destruct, authenticate, redirectToLogin, redirectToIndex, login, getById, logout, shipIt, fillIt, existsWithEMail
        * createUser, deleteUser, delete, update
    */

    class User extends Database {

        public $email = "";
        public $id = "";
        public $isLoggedIn = false;

        /**
            * User constructor.
            * This is a little crazy - especailly the "fillIt" and "shipIt" part.
            * Instead of just saving a normal value like an integer or a string
            * one is able to save complex structures by serializing them and store them as a string
            * with that method - we are able to save public attributes in the session
            * if there are values in the session we fill our object with those values
            * not magic - but a little complex on the first sight
        */
=======
		* Class: User
		* @function: __construct
	*/

    class User extends Database {

        public $username = "";
        public $id = "";
        public $isLoggedIn = false;

>>>>>>> feature-rest
        public function __construct(){

            parent::__construct();

            if ($_SESSION[get_class($this) . "Ship"] != ""){
                $ship = $_SESSION[get_class($this) . "Ship"];
                $this->fillIt($ship);
            };

        }

<<<<<<< HEAD
        /**
            * save our values in the session
        */
        public function __destruct(){

            parent::__destruct();

            $_SESSION[get_class($this) . "Ship"] = $this->shipIt();

        }

        /**
            * Checks if the User is logged in - if not redirect him to the login page
            * @return bool
        */
        public function authenticate(){

            if (!$this->isLoggedIn){

                define("LOGGED_IN", false);
                $this->redirectToLogin();

                //return false;
=======
        public function __destruct(){
            parent::__destruct();
            $_SESSION[get_class($this) . "Ship"] = $this->shipIt();
        }

        public function authenticate(){

            if (!$this->isLoggedIn){
                define("LOGGED_IN", false);
                $this->redirectToLogin();
>>>>>>> feature-rest
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

<<<<<<< HEAD
        public function login($email, $password){

            $sql = "SELECT `id`,`password`, `active` FROM `user` WHERE `email` = '" . $this->escapeString($email) . "'";
=======
        public function login($username, $password){

            $sql = "SELECT `id`, `password` FROM `user` WHERE `name`='" . $this->escapeString($username) . "'";
>>>>>>> feature-rest
            $result = $this->query($sql);

            if ($this->numRows($result) == 0){
                $this->isLoggedIn = false;
                return false;
            };

            $row = $this->fetchObject($result);

<<<<<<< HEAD
            if (password_verify($password, $row->password) && $row->active){

                $this->email = $email;
                $this->id = $row->id;
                $this->isLoggedIn = true;

                return true;

=======
            if (password_verify($password, $row->password)){
                $this->username = $username;
                $this->id = $row->id;
                $this->isLoggedIn = true;
                return true;
>>>>>>> feature-rest
            };

            $this->isLoggedIn = false;
            return false;

        }

        public static function getById($id){

            $id = intval($id);
<<<<<<< HEAD
            $sql = "SELECT * FROM `user` WHERE `id`= " . $id;

=======
            $sql = "SELECT * FROM `user` WHERE `id`= ". $id;
>>>>>>> feature-rest
            $db = new Database();
            $result = $db->query($sql);

            if ($db->numRows($result) > 0){

                $data = $db->fetchObject($result);
                $user = new User();
<<<<<<< HEAD

                $user->email = $data["email"];
=======
                $user->username = $data["username"];
>>>>>>> feature-rest
                $user->id = $id;

                return $user;

            };

            return null;

        }

        public function logout(){

<<<<<<< HEAD
            $this->email = null;
=======
            $this->username = null;
>>>>>>> feature-rest
            $this->id = null;
            $this->isLoggedIn = false;
            $this->shipIt();

<<<<<<< HEAD
            $this->redirectToLogin();
=======
            //$this->redirectToLogin();
>>>>>>> feature-rest

            return true;

        }

<<<<<<< HEAD
        /**
            * Gets all attributes from this class, serializes it adds slahes to save this string in the session
            * @return string
        */
        protected function shipIt(){
            $ship = serialize($this);
            $ship = addslashes($ship);
            return $ship;
        }

        /**
            * Fills this class with the data from the session which was previously saved
            * @param $ship
        */
=======
        protected function shipIt(){

            $ship = serialize($this);
            $ship = addslashes($ship);

            return $ship;

        }

>>>>>>> feature-rest
        protected function fillIt($ship){

            $ship = stripslashes($ship);
            $thiz = unserialize($ship);
            $ro = new reflectionObject($thiz);

            foreach ($ro->getProperties() as $propObj){
                $this->{$propObj->name} = $thiz->{$propObj->name};
            };

        }

<<<<<<< HEAD
        public static function existsWithEMail($email){

            $db = new Database();

            $sql = "SELECT COUNT(`id`) AS num FROM `user` WHERE `email` = '" . $db->escapeString($email) . "'";
            $result = $db->query($sql);

=======
        public static function existsWithUsername($username){

            $db = new Database();
            //check if user exists...
            $sql = "SELECT COUNT(`id`) AS num FROM `user` WHERE `name` = '" . $db->escapeString($username) . "'";
            $result = $db->query($sql);
>>>>>>> feature-rest
            $row = $db->fetchObject($result);

            if ($row->num == 0){
                return false;
            };

            return true;

        }

        public static function createUser($data){
<<<<<<< HEAD

            $db = new Database();

            $gender = $db->escapeString($data["gender"]);
            $firstname = $db->escapeString($data["firstname"]);
            $lastname = $db->escapeString($data["lastname"]);
            $email = $db->escapeString($data["email"]);
            $password = password_hash($db->escapeString($data["password"]), PASSWORD_DEFAULT);
            $activationKey = password_hash($db->escapeString($data["email"]), PASSWORD_DEFAULT);

            $sql = "INSERT INTO `user`(`gender`, `firstname`, `lastname`, `email`, `password`, `active`, `activationKey`, `roleID`) VALUES('" . $gender . "', '" . $firstname . "', '" . $lastname . "', '" . $email . "', '" . $password . "', 0, '" . $activationKey . "', 1)";
            $db->query($sql);

=======
            $db = new Database();
            $username = $db->escapeString($data["username"]);
            $password = password_hash($db->escapeString($data["password"]), PASSWORD_BCRYPT);
            $sql = "INSERT INTO `user`(`name`, `password`) VALUES('" . $username . "','" . $password . "')";
            $db->query($sql);
>>>>>>> feature-rest
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
<<<<<<< HEAD

=======
        
>>>>>>> feature-rest
    }

?>