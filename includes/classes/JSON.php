<?php

	/**
		* Class: JSON
		* @function: __construct, __set, setData, setMessage, getData, send
	*/

	class JSON {

		private $arrData = array();
		private $result = false;
		private $message = '';

		public function __construct(){}

		/**
		 	* Set data
			* @param string $name
			* @param mixed $value
		*/
		public function __set($name, $value){
			if ($name == "result"){
				$this->result = ($value);
			} else if ($name != "message"){
				$this->arrData[$name] = $value;
			};
		}

		/**
			* Set an associative array as data
			* @param $assocArrayWithData
		*/
		public function setData($assocArrayWithData){
			foreach ($assocArrayWithData as $key => $value){
				$this->arrData[$key] = $value;
			};
		}

		/**
			* Set message
			* @param $string
		*/
		public function setMessage($string){
			$this->message = $string;
		}

		/**
			* Get data as an object
			* @return object
		*/
		public function getData(){

			$dataToReturn = array();
			$dataToReturn["result"] = $this->result;

			if ($this->message != ""){
				$dataToReturn["message"] = $this->message;
			};

			if (!empty($this->arrData)){
				foreach ($this->arrData as $key => $value){
					$dataToReturn["data"][$key] = $value;
				};
			};

			return (object) $dataToReturn;

		}

		/**
			* Send json
		*/
		public function send($valuesToSend = false, $exit = true){

			header("HTTP/1.1 200 OK");
			header("Content-type: application/json");
			header("X-UA-Compatible: IE=edge, chrome=1");

			if ($valuesToSend){
				echo json_encode($valuesToSend);
			} else {
				echo json_encode($this->getData());
			};

			if ($exit){
				exit;
			};

		}

	}

?>