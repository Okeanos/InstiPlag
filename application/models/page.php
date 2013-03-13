<?php
namespace InsertFancyNameHere\Application\Models;

class Page extends Model {
	// Object Properties from DB
	protected $id = null;
	protected $parentId = 0;
	protected $name = null;

	// Object Properties loaded after the fact
	protected $articles = array();

	protected static $table = '`InsertFancyNameHere_page`';

	/**
     * List of sanitation details to check against & list of columns
     * @return array
	 */
	protected static function getRequirements() {
		return array (
				'`id`' => array ('type' => 'int', 'boundary' => '>0'),
				'`parentId`' => array ('type' => 'int', 'boundary' => '>0'),
				'`name`' => array('type' => 'plain', 'length' => 128),
		);
	}

	/**
	 * Fills the Page Object with the supplied data
	 * array (
	 *  'id' => int
	 *  'parentId' => int
	 *  'name' => string
	 *  'h2' => string
	 *  'isNew' => bool
	 * )
	 * @param array $objectDetails
	 */
	public function __construct($objectDetails = array()) {
		if(!empty($objectDetails)) {
			$this->id = $objectDetails['id'];
			$this->parentId = $objectDetails['parentId'];
			$this->name = $objectDetails['name'];
			$this->isNew = $objectDetails['isNew'];
		}
	}

	/**
	 * Returns current Page's ID
	 * @return int pageId
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Returns current Page's Parent's ID
	 * @return int parentId
	 */
	public function getParentId() {
		return $this->parentId;
	}

	/**
	 * Returns current Page's Name
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns the array of all attached articles or an empty one if none exist
	 * @param bool $forceNew
	 * @return array
	 */
	public function getArticles($forceNew = false) {
		if(empty($this->articles) || $forceNew) {
			$this->articles = Article::getAllByPageId($this->id, $this->pdo);
		}
		return $this->articles;
	}

	/**
	 * Set this object's id
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * Set this object's parent Id
	 * @param int $parentId
	 */
	public function setParentId($parentId) {
		$this->parentId = $parentId;
	}

	/**
	 * Set this object's name
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns all pages in the database as array
	 * @param \PDO $pdo
	 * @return array Array of Pages or empty array if no matches available
	 */
	public static function getAll(\PDO $pdo) {
		$rs = array();
		$stmt = $pdo->prepare('SELECT '.implode(',',array_keys(Page::getRequirements())).' FROM '.Page::$table);
		if($stmt->execute()) {
			while($fetchPage = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$page = new Page();
				$page->setId($fetchPage['id']);
				$page->setParentId($fetchPage['parentId']);
				$page->setName($fetchPage['name']);
				$page->setIsNew(false);
				$page->setDb($pdo);
				$rs[$fetchPage['id']] = $page;
			}
		}
		return (empty($rs)) ? array() : $rs;
	}
}
?>