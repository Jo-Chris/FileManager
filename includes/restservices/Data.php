<?php

	/**
		* Class: Data
		* @function: __construc, __destruct, getData
	*/

	class Data extends RESTClass {

		protected function getData($directory){

			$data = DataModel::getDataFromDirectory($directory);

			$jsonResponse = new JSON();
			$jsonResponse->result = true;
			$jsonResponse->setData($data);
			$jsonResponse->send();

		}

	}

?>