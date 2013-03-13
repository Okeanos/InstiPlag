<?php

/**
 * Set the session name to prevent conflicts with other concurrently running programs
 * @var string
 */
define('SNAME', 'InsertFancyNameHere\Session');
/**
 * root path of the application
 * @var string
*/
define('ROOT', dirname(__FILE__));

$config		= ROOT . DIRECTORY_SEPARATOR . 'config.php';
$app		= ROOT . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR .'core'. DIRECTORY_SEPARATOR . 'core.php';
$password	= ROOT . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR .'core'. DIRECTORY_SEPARATOR . 'password.php';
$traits		= ROOT . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR .'core'. DIRECTORY_SEPARATOR . 'traits.php';

require_once $app;
require_once $password;
require_once $traits;

InsertFancyNameHere\Application\Core\Core::getInstance(require_once $config)->run();
?>