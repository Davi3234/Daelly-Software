<?php

class UnauthorizedException extends ResultException {
	function __construct($args = null) {
		if (!isset($args)) {
			return parent::__construct('Unauthorized Request', '', 403);
		}
		
		if (isString($args)) {
			return parent::__construct('Unauthorized Request', $args, 403);
		}

		if (isArray($args)) {
			if (!isset($args['title'])) {
				$args['title'] = 'Unauthorized Request';
			}
			
			if (!isset($args['message'])) {
				$args['message'] = '';
			}
			return parent::__construct($args['title'], $args['message'], 403);
		}

		if (isObject($args)) {
			if (!isset($args->title)) {
				$args->title = 'Unauthorized Request';
			}
			
			if (!isset($args->message)) {
				$args->message = '';
			}
			parent::__construct($args->title, $args->message, 403);
		}

		parent::__construct('Unauthorized Request', '', 403);
	}
}