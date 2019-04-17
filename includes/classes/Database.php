<?php

	/**
		* Class: Database
		* @function: __construct, __destruct, query, fetchObject, fetchArray, fetchAssoc, fetchSingleResult, escapeString, numRows, insertId, getConnection
	*/

	class Database {

		private $conn = null;

		/**
			* Database connection 
		*/
		function __construct(){

			// Define database variables from includes/dbconfig.php
			$host = DB_HOST;
			$dbname = DB_NAME;
			$user = DB_USER;
			$pass = DB_PASS;

			// DB connection
			$conn = mysqli_connect($host, $user, $pass);

			// Error, if database connection failed
			if (!$conn){
				die("Connection to the database failed!");
			};

			$this->conn = $conn;

			// Select database
			$db_sel = mysqli_select_db($this->conn, $dbname);

			// Error, if database couldn't selected
			if(!$db_sel){
				die("Can't select database with name " .  $dbname . " !");
			};

			// UTF-8 encoding
			$this->query("SET NAMES 'utf8'");

		}

		/**
			* Close database connection
		*/
		function __destruct(){
			@mysqli_close($this->conn);
		}

		/**
			* Performs an SQL statement and returns the resultset - if the resultset is not false - if the resultset is false - the error will be returned
			* @param $sql String (SQL Statement)
			* @return boolean|mysqli_result (Resultset or an error and stop execution)
		*/
		public function query($sql){

			$result = mysqli_query($this->conn, $sql);

			// Error, if no results
			if ($result == false){
				echo "<b>Fatal Error!</b> MySQL-Error (".mysqli_errno($this->conn)."): ".mysqli_error($this->conn);
				echo "<br><br>Query:<br>\n";
				echo $sql."\n<br>";
				die();
			};

			return $result;

		}

		/**
			* Fetches one row of the resultset as object (if there is still a row)
			* @param $result
			* @return null|object
		*/
		public function fetchObject($result){
			return mysqli_fetch_object($result);
		}

		/**
			* Fetches one row of the resultset as array (if there is still a row)
			* @param $result
			* @return array|null
		*/
		public function fetchArray($result){
			return mysqli_fetch_array($result);
		}

		/**
			* Fetches one row of the resultset as associative array (if there is still a row)
			* @param $result
			* @return array|null
		*/
		public function fetchAssoc($result){
			return mysqli_fetch_assoc($result);
		}

		/**
			* Fetches the first result
			* @param $result
			* @return bool
		*/
		public function fetchSingleResult($result){
			if (!mysql_num_rows($result)){
				return false;
			} else {
				return mysqli_data_seek($result, 0);
			};
		}

		/**
			* Escapes a string so that an SQL injection can be prevented
			* @param $string
			* @return string
		*/
		public function escapeString($string){
			return mysqli_real_escape_string($this->conn, $string);
		}

		/**
			* Returns the number of results in the resultset
			* @param $result
			* @return int
		*/
		public function numRows($result){

			if ($result == false){
				return 0;
			};

			return mysqli_num_rows($result);

		}

		/**
			* Returns the last id that was given after an insert with "auto_increment"
			* @return int|string
		*/
		public function insertId(){
			return mysqli_insert_id($this->conn);
		}

		/**
			* Returns the current connection ressource
			* @return mysqli
		*/
		public function getConnection(){
			return $this->conn;
		}
	}
?>