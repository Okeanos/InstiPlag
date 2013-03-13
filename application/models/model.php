<?php
namespace InsertFancyNameHere\Application\Models;

abstract class Model {
	use \InsertFancyNameHere\Application\Core\modelTraits;
	/**
	 * PDO Database Object
	 * @var \PDO
	 */
	protected $pdo = null;

	/*
	 * Data to be implemented in the inheriting models
	 */
	protected static $table;

	/**
	 * Inject PDO Database Access Object into Model
	 * @param \PDO $pdo
	 */
	public function setDb(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	/**
	 * Insert Model Data into the appropriate table
	 * @return boolean
	 */
	public function create() {
		$c = get_called_class();

		$stmt = $this->pdo->prepare('INSERT INTO '.$c::$table.' ('.implode(',', $c::getColumnNames()).') VALUES ('.$this->columnsToTokens().');');
		if($stmt->execute($this->values(false))) {
			$this->isNew = false;
			return true;
		}
		return false;
	}

	/**
	 * Removes the current model data from the database
	 * @return boolean
	 */
	public function remove() {
		$c = get_called_class();

		// can't delete data not in the DB
		if($this->isNew) { return false; }
		$stmt = $this->pdo->prepare('DELETE FROM '.$c::$table.' WHERE '.$c::$table.'.'.$c::$primaryKey.' = ?;');
		if($stmt->execute(array($this->{substr($c::$primaryKey, 1, strlen($c::$primaryKey)-2)}))) {
			return true;
		}
		return false;
	}

	/**
	 * Updates the database with current model data
	 * @return boolean
	 */
	public function update() {
		$c = get_called_class();

		// can't update if not in DB (well, REPLACE INTO but I don't feel like it)
		if($this->isNew) { return false; }
 		$stmt = $this->pdo->prepare('UPDATE '.$c::$table.' SET '.$this->columnsToTokens(false,true).' WHERE '.$c::$table.'.'.$c::$primaryKey.' = ?;');
		if($stmt->execute($this->values())) {
			$this->isNew = false;
			return true;
		}
		return false;
	}

	/**
     * Retrieve model data from database as object of the same class
     * @param int $id the object's ID to retrieve
     * @param \PDO the Database object to work on
     * @return object
	 */
	public static function get($id, \PDO $pdo) {
		$c = get_called_class();

		$stmt = $pdo->prepare('SELECT '.implode(',', $c::getColumnNames(true)).' FROM '.$c::$table.' WHERE '.$c::$table.'.'.$c::$primaryKey.' = ?;');
		if($stmt->execute(array($id))) {
			$rs = $stmt->fetch(\PDO::FETCH_ASSOC);
			if(!empty($rs)) {
				$rs['isNew'] = false;
				$return = new $c($rs);
				$return->setDb($pdo);
				return $return;
			}
		}
		$return = new $c();
		$return->setDb($pdo);
		return $return;
	}

	/**
	 * Counts the columns for data to be inserted into the database and returns the appropriate number of ?
	 * @param bool $appendPrimaryKey append a token for the primary key or not
	 * @return string
	 */
	private function columnsToTokens($appendPrimaryKey = false, $addColumnNames = false) {
		$c = get_called_class();

		$return = '';
		foreach ($c::getRequirements() as $key => $value) {
			if($c::$primaryKey != $key) {
				$return .= ($addColumnNames ? $key.' = ': '').'?,';
			}
		}
		if($appendPrimaryKey) {
			$return .= ($addColumnNames ? $c::$primaryKey.' = ': '').'?,';
		}
		return substr($return,0,-1);
	}

	/**
     * Returns the Column Names as 1-dimesional array optionally with the primary key included
     * @return array
	 */
	private static function getColumnNames($includePrimaryKey = false) {
		$c = get_called_class();
		return array_slice(array_keys($c::getRequirements()), $includePrimaryKey ? 0 : 1);
	}

	/**
     * Sanitizes input and assigns it to the current object
     * @param array $dirty
	 */
	public function sanitizeAndAssign($dirty = array()) {
		$c = get_called_class();

		foreach ($c::getRequirements() as $column => $details) {
			$property = substr($column,1,strlen($column)-2);
			if(isset($dirty[$property])) {
				switch($details['type']) {
					case 'int':
						$this->$property = \InsertFancyNameHere\Application\Core\Validator::toInt($dirty[$property], $details['boundary']);
						break;
					case 'bool':
						$this->$property = \InsertFancyNameHere\Application\Core\Validator::toBool($dirty[$property]);
						break;
					case 'html':
						$this->$property = \InsertFancyNameHere\Application\Core\Validator::toCleanHtml($dirty[$property]);
						break;
					case 'datetime':
						$this->$property = $dirty[$property];
						break;
					case 'plain':
					default:
						$this->$property = \InsertFancyNameHere\Application\Core\Validator::toPlainText($dirty[$property], isset($details['length']) ? $details['length'] : 0);
				}
			}
		}
	}

	/**
	 * Returns false if any property is null
     * @return bool
	 */
	public function isValid($checkPrimaryKey = true) {
		$c = get_called_class();

		foreach ($c::getRequirements() as $column => $details) {
			$property = substr($column,1,strlen($column)-2);
			if($c::$primaryKey == $column && $checkPrimaryKey && null === $this->$property) {
				return false;
			} elseif($c::$primaryKey != $column && null === $this->$property) {
				return false;
			}
		}
		return true;
	}
}
?>