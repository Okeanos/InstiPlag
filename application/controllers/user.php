<?php
namespace InsertFancyNameHere\Application\Controllers;

class User extends Controller {

	public function login() {
		if(isset($_POST['login']) && !isset($_SESSION[SNAME])) {
			$user = \InsertFancyNameHere\Application\Models\User::getByName($_POST['login']['username']);
			if(!$user->isNew()) {
				if(\password_verify($_POST['login']['password'], $user->getPassword())) {
					$_SESSION[SNAME] = $user;
					return $user;
				}
				throw new \Exception('Access Denied: Wrong password',531);
			}
			throw new \Exception('Access Denied: User doesn\'t exist',531);
		}
		return null;
	}

	public function logout() {
		$_SESSION = array(); 								// destroy all $_SESSION data
		setcookie(session_name(), "", time() - 3600, "/");	// destroy PHP session cookie
		session_unset();									// unset variables
		session_destroy();
		session_start();									// Restart Session
		return null;
	}

}
?>