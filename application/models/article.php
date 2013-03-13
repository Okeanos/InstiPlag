<?php
namespace InsertFancyNameHere\Application\Models;

class Article extends Model {
	// Object Properties from DB
	protected $id = null;
	protected $pageId = null;
	protected $display = 1;
	protected $h1 = null;
	protected $h2 = null;
	protected $content = null;
	protected $authorId = null;
	protected $creationDate = null;
	protected $updateDate = null;

	// Object Properties loaded after the fact
	protected $author = null;

	protected static $table = '`InsertFancyNameHere_article`';

	/**
     * List of sanitation details to check against & list of columns
     * @return array
	 */
	protected static function getRequirements() {
		return array (
			'`id`' => array ('type' => 'int', 'boundary' => '>0'),
			'`pageId`' => array ('type' => 'int', 'boundary' => '>0'),
			'`display`' => array('type' => 'bool'),
			'`h1`' => array ('type' => 'plain', 'length'=> 128),
			'`h2`' => array ('type' => 'plain', 'length'=> 128),
			'`content`' => array ('type' => 'html'),
			'`authorId`' => array ('type' => 'int','>=0'),
			'`creationDate`' => array ('type' => 'datetime'),
			'`updateDate`' => array ('type' => 'datetime'),
		);
	}

	/**
	 * Fills the Article Object with the supplied data:
	 * array (
	 *  'id' => int
	 *  'display' => bool
	 *  'h1' => string
	 *  'h2' => string
	 *  'content' => string
	 *  'authorId' => int
	 *  'creationDate' => \DateTime|MySQL DateTime
	 *  'updateDate  => \DateTime|MySQL DateTime
	 *  'isNew => bool
 	 * )
	 * @param array
	 */
	public function __construct($objectDetails = array()) {
		if(!empty($objectDetails)) {
			$this->setId($objectDetails['id']);
			$this->setPageId($objectDetails['pageId']);
			$this->setDisplay($objectDetails['display']);
			$this->setH1($objectDetails['h1']);
			$this->setH2($objectDetails['h2']);
			$this->setContent($objectDetails['content']);
			$this->setAuthorId($objectDetails['authorId']);
			$this->setCreationDate($objectDetails['creationDate']);
			$this->setUpdateDate($objectDetails['creationDate']);
			$this->setIsNew($objectDetails['isNew']);
		}
	}

	/**
	 * Returns the current article's ID
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Returns the current article's associated page's ID
	 * @return int
	 */
	public function getPageId() {
		return $this->pageId;
	}

	/**
	 * Says whether the article is to be publicly displayed
	 * @return bool
	 */
	public function isDisplayed() {
		return $this->display;
	}

	/**
	 * Returns the current article's heading
	 * @return string
	 */
	public function getH1() {
		return $this->h1;
	}

	/**
	 * Returns the current article's subheading
	 * @return string
	 */
	public function getH2() {
		return $this->h2;
	}

	/**
	 * Returns the current article's content
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Returns the associated author object
	 * @return InsertFancyNameHere\Application\Models\User
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Returns the Author ID for this object
	 * @return int
	 */
	public function getAuthorId() {
		return $this->authorId;
	}

	/**
	 * Returns the current article's creation date
	 * @return \DateTime
	 */
	public function getCreationDate() {
		return $this->creationDate;
	}

	/**
	 * Returns the current article's latest update date
	 * @return \DateTime
	 */
	public function getUpdateDate() {
		return $this->updateDate;
	}

	/**
	 * Set the ID for this object
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * Set the parent page ID for this object
	 * @param int $pageId
	 */
	public function setPageId($pageId) {
		$this->pageId = $pageId;
	}

	/**
	 * Set the display status for this object
	 * @param boolean $display
	 */
	public function setDisplay($display) {
		$this->display = (bool) $display;
	}

	/**
	 * Set the heading for this object
	 * @param string $h1
	 */
	public function setH1($h1) {
		$this->h1 = $h1;
	}

	/**
	 * Set the subheading for this object
	 * @param string $h2
	 */
	public function setH2($h2) {
		$this->h2 = $h2;
	}

	/**
	 * Set the content for this object
	 * @param string $content
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Set the author/user object for this object
	 * @param InsertFancyNameHere\Application\Models\User $author
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * Sets the Author ID for this object
	 * @param int $authorId
	 */
	public function setAuthorId($authorId) {
		$this->authorId = $authorId;
	}

	/**
	 * Set the creation date of this object
	 * @param string $creationDate Y-m-d G:i:s
	 */
	public function setCreationDate($creationDate) {
		$this->creationDate = $creationDate instanceof \DateTime ? $creationDate : \DateTime::createFromFormat('Y-m-d G:i:s', $creationDate);
	}

	/**
	 * Set the update date of this object
	 * @param \DateTime $updateDate
	 */
	public function setUpdateDate($updateDate) {
		$this->updateDate = $updateDate instanceof \DateTime ? $updateDate : \DateTime::createFromFormat('Y-m-d G:i:s', $updateDate);
	}

	/**
	 * Returns an array of all articles belonging to the supplied pageId
	 * @param int $pageId
	 * @param \PDO $pdo
	 * @return array Array of Articles or empty array if no matches available
	 */
	public static function getAllByPageId($pageId, \PDO $pdo) {
		$rs = array();
		$stmt = $pdo->prepare('SELECT '.implode(',',array_keys(Article::getRequirements())).' FROM '.Article::$table.' WHERE '.Article::$table.'.`pageId` = ?');
		if($stmt->execute(array($pageId))) {
			while($fetchArticle = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$article = new Article();
				$article->setId($fetchArticle['id']);
				$article->setPageId($fetchArticle['pageId']);
				$article->setDisplay($fetchArticle['display']);
				$article->setH1($fetchArticle['h1']);
				$article->setH2($fetchArticle['h2']);
				$article->setContent($fetchArticle['content']);
				$article->setAuthorId($fetchArticle['authorId']);
				$article->setAuthor(User::get($fetchArticle['authorId']));
				$article->setCreationDate($fetchArticle['creationDate']);
				$article->setUpdateDate($fetchArticle['updateDate']);
				$article->setIsNew(false);
				$article->setDb($pdo);
				$rs[$fetchArticle['id']] = $article;
			}
		}
		return (empty($rs)) ? array() : $rs;
	}
}
?>