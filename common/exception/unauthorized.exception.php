<?php

class UnauthorizedException extends ResultException {
	function __construct($message = '') {
		$err = new ErrorModel();

		$err->setTitle('Unauthorized Request');
		$err->setMessage($message);
		$err->setCode(403);

		return parent::__construct($err);
	}
}