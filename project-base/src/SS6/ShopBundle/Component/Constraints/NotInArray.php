<?php

namespace SS6\ShopBundle\Component\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotInArray extends Constraint {

	public $message = 'Value must not be contained in specified array';
	public $array = [];

	public function getRequiredOptions() {
		return [
			'array',
		];
	}

}
