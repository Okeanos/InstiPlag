<?php
namespace InsertFancyNameHere\Application\Controllers;

class Page extends Controller {
	use \InsertFancyNameHere\Application\Core\controllerTraits;
	/**
	 * Displays the overview over all pages
	 */
	public function index() {
		$page = \InsertFancyNameHere\Application\Models\Page::get($this->core->request['id'], $this->core->getDb());

		$pages = array();

		if(empty($pages)) {
			throw new \Exception('Not Found', 404);
		}

		return $pages;
	}

	/**
	 * Creates a new page
	 */
	public function create() {
		if(!isset($_SESSION[SNAME])) {
			throw new \Exception('Forbidden: You don\'t have the necessary privileges to access this resource',403);
		}
		$page = new \InsertFancyNameHere\Application\Models\Page();
		$page->setDb($this->core->getDb());

		if(isset($_POST['page'])) {
			$core = \InsertFancyNameHere\Application\Core\Core::getInstance();

			$page->sanitizeAndAssign($_POST['page']);

			if(!$page->isValid(false)) {
				$core->setFlash('error',$core->t('<strong>Error!</strong> Page not created. Please fill in everything'));
				return $page;
			}

			if($page->create()) {
				$core->setFlash('success',$core->t('<strong>Success!</strong> Page Created.'));
			} else {
				$core->setFlash('error',$core->t('<strong>Error!</strong> Page not created.'));
			}
		}

		return $page;
	}

	/**
	 * Removes an existing article
	 */
	public function remove() {
		if(!isset($_SESSION[SNAME])) {
			throw new \Exception('Forbidden: You don\'t have the necessary privileges to access this resource',403);
		}

		$page = \InsertFancyNameHere\Application\Models\Page::get($this->core->request['id'], $this->core->getDb());

		if($page->isNew()) {
			throw new \Exception('Not Found',404);
		}

		$core = \InsertFancyNameHere\Application\Core\Core::getInstance();
		if($page->remove()) {
			$core->setFlash('success',$core->t('<strong>Success!</strong> Page Removed.'));
		} else {
			$core->setFlash('error',$core->t('<strong>Error!</strong> Page not removed.'));
		}

		return $page;
	}

	/**
	 * Updates an existing page
	 */
	public function update() {
		if(!isset($_SESSION[SNAME])) {
			throw new \Exception('Forbidden: You don\'t have the necessary privileges to access this resource',403);
		}

		$page = \InsertFancyNameHere\Application\Models\Page::get($this->core->request['id'], $this->core->getDb());

		if($page->isNew()) {
			throw new \Exception('Not Found',404);
		}

		if(isset($_POST['page'])) {
			$core = \InsertFancyNameHere\Application\Core\Core::getInstance();

			$page->sanitizeAndAssign($_POST['page']);

			if(!$page->isValid()) {
				$core->setFlash('error',$core->t('<strong>Error!</strong> Page not updated. Please fill in everything'));
				return $page;
			}

			if($page->update()) {
				$core->setFlash('success',$core->t('<strong>Success!</strong> Page Updated.'));
			} else {
				$core->setFlash('error',$core->t('<strong>Error!</strong> Page not updated.'));
			}
		}

		$core = \InsertFancyNameHere\Application\Core\Core::getInstance();

		return $page;
	}

	/**
	 * Displays a single existing page
	 */
	public function display() {
		$page = \InsertFancyNameHere\Application\Models\Page::get($this->core->request['id'], $this->core->getDb());

		if($page->isNew()) {
			throw new \Exception('Not Found',404);
		}

		return $page;
	}
}
?>