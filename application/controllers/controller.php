<?php
namespace InsertFancyNameHere\Application\Controllers;

abstract class Controller {
	/**
	 * The Application Core, injected
	 * @var InsertFancyNameHere\Application\Core
	 */
	protected $core = null;

	/**
	 * Class Constructor, gets Dependencies Injection Style
	 * @param InsertFancyNameHere\Application\Core\Core
	 */
	public function __construct(\InsertFancyNameHere\Application\Core\Core $core) {
		$this->core = $core;
	}


}
?>