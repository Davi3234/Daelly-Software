<?php

class ResultException extends Exception {
	private $title;
	
	function __construct($title = '', $message = '', $code = 400) {
		parent::__construct($message, $code);

		$this->title = $title;
		$this->message = $message;
	}
	
	function getTitle() {
		return $this->title;
	}
}
