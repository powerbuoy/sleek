<?php
# Description: Add employees to the page.

namespace Sleek\Modules;

require_once __DIR__ . '/../posts/module.php';

class Employees extends Posts {
	public function __construct () {
		parent::__construct();

		$this->postTypes = [
			'employee' => __('Employees', 'sleek_admin')
		];
	}
}
