<?php
namespace InsertFancyNameHere\Application\Core;

/**
 *
 * Model Trait for Models that don't necessarily need DB access to work but related functionality
 *
 */
trait modelTraits {
	protected static $primaryKey = '`id`';
	protected $isNew = true;

	/**
     * List of sanitation details to check against & list of columns
     * @return array
	 */
	protected static function getRequirements() {
		return array('`id`' => array ('type' => 'int', 'boundary' => '>0'));
	}

	/**
	 * returns the model's data as neat array for DB functions (create, update)
	 * @param bool $appendPrimaryKey Should the Model's primary Key be appended to the array?
	 * @return array
	 */
	private function values($appendPrimaryKey = true) {
		$c = get_called_class();

		$return = array();
		foreach ($c::getRequirements() as $column => $details) {
			if($c::$primaryKey != $column) {
				$property = substr($column,1,strlen($column)-2);
				if(in_array($property, array('creationDate','updateDate'))) {
					$return[] = $this->$property->format('Y-m-d H:i:s');
				} else {
					$return[] = $this->$property;
				}
			}
		}
		if($appendPrimaryKey) {
			$return[] = $this->{substr($c::$primaryKey,1,strlen($c::$primaryKey)-2)}; }
		return $return;
	}

	/**
	 * Says whether this is a newly created or database retrieved object
	 * @return boolean
	 */
	public function isNew() {
		return $this->isNew;
	}

	/**
     * Sets the object's is new status
     * @param boolean $isNew
	 */
	public function setIsNew($isNew) {
		$this->isNew = (bool) $isNew;
	}
}

/**
 *
 * CRUD Actions, have to be implemented in the inheriting controllers that offer fully featured functionality
 *
 */
trait controllerTraits {
	abstract public function index();
	abstract public function create();
	abstract public function remove();
	abstract public function update();
	abstract public function display();
}
?>