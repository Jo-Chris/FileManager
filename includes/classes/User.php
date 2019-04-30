<?php

    /**
        * Class: User
        * @function: __construct, __destruct, authenticate, redirectToLogin, redirectToIndex, login, getById, logout, shipIt, fillIt, existsWithEMail
        * createUser, deleteUser, delete, update
    */

    class User extends Database {

        public $username = "";
        public $id = "";
        public $isLoggedIn = false;

        public function __construct(){

            parent::__construct();

            if ($_SESSION[get_class($this) . "Ship"] != "") {
                $ship = $_SESSION[get_class($this) . "Ship"];
                $this->fillIt($ship);
            };

        }

        public function __destruct(){
            parent::__destruct();
            $_SESSION[get_class($this) . "Ship"] = $this->shipIt();
        }

        public function authenticate(){

            if (!$this->isLoggedIn) {
                define("LOGGED_IN", false);
                $this->redirectToLogin();
            };

            define("LOGGED_IN", true);

            return true;

        }

        public function redirectToLogin(){

            if (API_CALL === true) {
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


        public function login($email, $password){

            $sql = "SELECT `id`,`password`, `active` FROM `user` WHERE `email` = '" . $this->escapeString($email) . "'";

            $result = $this->query($sql);

            if ($this->numRows($result) == 0) {
                $this->isLoggedIn = false;
                return false;
            };

            $row = $this->fetchObject($result);

            if (password_verify($password, $row->password) && $row->active) {

                $this->email = $email;
                $this->id = $row->id;
                $this->isLoggedIn = true;

                return true;

            };

            $this->isLoggedIn = false;
            return false;

        }

        public static function getById($id){

            $id = intval($id);
            $sql = "SELECT * FROM `user` WHERE `id`= " . $id;

            $db = new Database();
            $result = $db->query($sql);

            if ($db->numRows($result) > 0) {

                $data = $db->fetchObject($result);
                $user = new User();
                $user->email = $data["email"];
                $user->id = $id;

                return $user;

            };

            return null;

        }

        public function logout(){

            $this->email = null;
            $this->id = null;
            $this->isLoggedIn = false;
            $this->shipIt();

            $this->redirectToLogin();

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

            foreach ($ro->getProperties() as $propObj) {
                $this->{$propObj->name} = $thiz->{$propObj->name};
            };

        }

        public static function existsWithEMail($email){

            $db = new Database();

            $sql = "SELECT COUNT(`id`) AS num FROM `user` WHERE `email` = '" . $db->escapeString($email) . "'";
            $result = $db->query($sql);

            $row = $db->fetchObject($result);

            if ($row->num == 0) {
                return false;
            };

            return true;

        }

        public static function createUser($data){

            $db = new Database();

            $gender = $db->escapeString($data["gender"]);
            $firstname = $db->escapeString($data["firstname"]);
            $lastname = $db->escapeString($data["lastname"]);
            $email = $db->escapeString($data["email"]);
            $password = password_hash($db->escapeString($data["password"]), PASSWORD_DEFAULT);
            $activationKey = password_hash($db->escapeString($data["email"]), PASSWORD_DEFAULT);

            $sql = "INSERT INTO `user`(`gender`, `firstname`, `lastname`, `email`, `password`, `active`, `activationKey`, `roleID`) VALUES('" . $gender . "', '" . $firstname . "', '" . $lastname . "', '" . $email . "', '" . $password . "', 0, '" . $activationKey . "', 1)";
            $db->query($sql);

            // Send activation mail

            if ($sql) {
                self::sendActivationMail($firstname, $lastname, $email, $activationKey);
            };

        }

        public static function deleteUser($id){}

        public static function updateUser($data){}

        public function delete(){
            self::deleteUser($this->id);
        }

        public function update($data){
            self::updateUser($this->id, $data);
        }

        private static function sendActivationMail($firstname, $lastname, $email, $activationKey){

            $activationKey = urlencode($activationKey);

            $body = "<html>
                <head>
                    <title>Registrierung - Filemanager</title>
                </head>
                <body>
                    <h1>Vielen Dank für deine Registrierung!</h1>
                    <p>Hallo {$firstname},<br> vielen Dank für deine Registrierung. Damit du dich einloggen kannst, musst du bitte deine Registrierung unten bestätigen.</p>
                    <a href='http://localhost/filemanager/api/account/?activationKey={$activationKey}&email={$email}'  target='_blank'>Registrierung bestätigen</a>
                </body>
            </html>";

            $mail = new Mail($body, "register@filemanager.at", "reply@filemanager.at", "Registrierung - Filemanager", $email);
            $mail->send();

        }

    }

?>