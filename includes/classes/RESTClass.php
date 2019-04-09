<?php

	/**
		* Class: RESTClass
		* @function: getData, createData, saveData, deleteData, processData, returnJSON
	*/

	abstract class RESTClass {

		abstract protected function getData($data);
		/*abstract protected function createData($data);
		abstract protected function saveData($data);
		abstract protected function deleteData($data);*/

		/**
			* Process data
			* @param $method
			* @param $data
		*/
		public function processData($method, $data){
			switch($method){
				/*case "post":
					$this->createData($data);
					break;
				case "put":
					$this->saveData($data);
					break;
				case "delete":
					$this->deleteData($data);
					break;
				case "get":*/
				default:
					$this->getData($data);
					break;
			};
		}

		/**
			* Return json
			* @param $result
			* @param $setMessage
			* @param $data
			* @param $sendToken
		*/
		public static function returnJSON($result = False, $setMessage = "API call failed!", $data = array(), $sendToken = False){

			$jsonResponse = new JSON();
			$jsonResponse->result = $result;
			$jsonResponse->setMessage($setMessage);
			$jsonResponse->setData($data);

			if ($sendToken){
				$jsonResponse->setRequestToken();
			};

			$jsonResponse->send();

		}

	}

?>