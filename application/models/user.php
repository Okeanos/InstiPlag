<?php
namespace InsertFancyNameHere\Application\Models;

class User {
	use \InsertFancyNameHere\Application\Core\modelTraits;

	protected $id 		= null;
	protected $username = null;
	protected $password = null;

	/**
     * List of sanitation details to check against & list of columns
     * @return array
	 */
	protected static function getRequirements() {
		return array (
				'`id`' => array ('type' => 'int', 'boundary' => '>0'),
				'`username`' => array ('type' => 'plain', 'length' => 0),
				'`password`' => array('type' => 'plain', 'length' => 0),
		);
	}

	/**
	 * Fills the Page Object with the supplied data
	 * @param int $id
	 * @param string $username
	 * @param string $password
	 * @param boolean $isNew
	 */
	public function __construct($objectDetails = array()) {
		if(!empty($objectDetails)) {
			$this->id = $objectDetails['id'];
			$this->username = $objectDetails['username'];
			$this->password = $objectDetails['password'];
			$this->isNew = $objectDetails['isNew'];
		}
	}

	/**
	 * Returns the object's ID
     * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Returns the object's username
     * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * Set this object's id
     * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * Set this object's username
	 * @param string $username
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
     * Returns the hashed password string
     * @return string
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * Retrieves the requested account object if found or an empty one
	 * @param int $id the object's ID to retrieve
     * @return InsertFancyNameHere\Application\Models\User
	 */
	public static function get($id) {
		// Load all existing accounts
		$accounts = require_once(ROOT . DIRECTORY_SEPARATOR . 'accounts.php');

		if(isset($accounts[$id])) {
			$accounts[$id]['isNew'] = false;
			return new User($accounts[$id]);
		}

		return new User();
	}

	/**
	 * Retrieves the requested account object if found or an empty one
	 * @param string $name the object's name to retrieve
	 * @return InsertFancyNameHere\Application\Models\User
	 */
	public static function getByName($name) {
		// Load all existing accounts
		$accounts = require_once(ROOT . DIRECTORY_SEPARATOR . 'accounts.php');

		foreach ($accounts as $id => $account) {
			if ($account['username'] == $name) {
				return new User($account);
			}
		}

		return new User();
	}
}
?>