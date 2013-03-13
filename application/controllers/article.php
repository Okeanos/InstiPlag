<?php
namespace InsertFancyNameHere\Application\Controllers;

class Article extends Controller {
	use \InsertFancyNameHere\Application\Core\controllerTraits;
	/**
	 * Displays the overview over all articles
	 */
	public function index() {
		$articles = \InsertFancyNameHere\Application\Models\Article::get($this->core->request['id'], $this->core->getDb());
		if(empty($articles)) {
			throw new \Exception('Not Found', 404);
		}

		return $articles;
	}

	/**
	 * Creates a new article
	 */
	public function create() {
		if(!isset($_SESSION[SNAME])) {
			throw new \Exception('Forbidden: You don\'t have the necessary privileges to access this resource',403);
		}
		$article = new \InsertFancyNameHere\Application\Models\Article();
		$article->setDb($this->core->getDb());


		$core = \InsertFancyNameHere\Application\Core\Core::getInstance();
		$article->setPageId($core->request['id']);

		if(isset($_POST['article'])) {

			$article->sanitizeAndAssign($_POST['article']);
			$article->setAuthorId($_SESSION[SNAME]->getId());
			$article->setCreationDate(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
			$article->setUpdateDate($article->getCreationDate());
			// TODO Check whether everything is in order!

			if(!$article->isValid(false)) {
				$core->setFlash('error',$core->t('<strong>Error!</strong> Article not created. Please fill in everything'));
				return $article;
			}

			if($article->create()) {
				$core->setFlash('success',$core->t('<strong>Success!</strong> Article Created.'));
			} else {
				$core->setFlash('error',$core->t('<strong>Error!</strong> Article not created.'));
			}
		}

		return $article;
	}

	/**
	 * Removes an existing article
	 */
	public function remove() {
		if(!isset($_SESSION[SNAME])) {
			throw new \Exception('Forbidden: You don\'t have the necessary privileges to access this resource',403);
		}

		$article = \InsertFancyNameHere\Application\Models\Article::get($this->core->request['id'], $this->core->getDb());

		if($article->isNew()) {
			throw new \Exception('Not Found',404);
		}

		$core = \InsertFancyNameHere\Application\Core\Core::getInstance();
		if($article->remove()) {
			$core->setFlash('success',$core->t('<strong>Success!</strong> Article Deleted.'));
		} else {
			$core->setFlash('error',$core->t('<strong>Error!</strong> Article not deleted.'));
		}

		return $article;
	}

	/**
	 * Updates an existing article
	 */
	public function update() {
		if(!isset($_SESSION[SNAME])) {
			throw new \Exception('Forbidden: You don\'t have the necessary privileges to access this resource',403);
		}

		$article = \InsertFancyNameHere\Application\Models\Article::get($this->core->request['id'], $this->core->getDb());

		if($article->isNew()) {
			throw new \Exception('Not Found',404);
		}

		if(isset($_POST['article'])) {
			$core = \InsertFancyNameHere\Application\Core\Core::getInstance();

			$article->sanitizeAndAssign($_POST['article']);
			$article->setAuthorId($_SESSION[SNAME]->getId());
			$article->setUpdateDate(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));

			if(!$article->isValid()) {
				$core->setFlash('error',$core->t('<strong>Error!</strong> Article not updated. Please fill in everything'));
				return $article;
			}

			if($article->update()) {
				$core->setFlash('success',$core->t('<strong>Success!</strong> Article Updated.'));
			} else {
				$core->setFlash('error',$core->t('<strong>Error!</strong> Article not updated.'));
			}
		}

		return $article;
	}

	/**
	 * Displays a single existing article
	 */
	public function display() {
		$article = \InsertFancyNameHere\Application\Models\Article::get($this->core->request['id'], $this->core->getDb());

		if($article->isNew()) {
			throw new \Exception('Not Found',404);
		}

		return $article;
	}
}
?>