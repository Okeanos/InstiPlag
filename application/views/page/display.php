<?php
	$page = $this->result;
	$this->title .= ' :: '.$page->getName();
	foreach ($page->getArticles() as $id => $article) {
		$this->result = $article;
		echo $article->isDisplayed() ? $this->loadView('article' . DIRECTORY_SEPARATOR . 'display.php') : '';
	}
?>
<?php if(isset($_SESSION[SNAME])) { ?>
	<hr class="clear" />
	<p>
		<a href="?m=article&amp;a=create&amp;id=<?php echo $page->getId() ?>" class="btn btn-mini btn-success"><span class="icon-plus"></span><?php echo $this->t('Add Article') ?></a>
		<a href="?m=page&amp;a=update&amp;id=<?php echo $page->getId() ?>" class="btn btn-mini"><span class="icon-pencil"></span><?php echo $this->t('Edit Page') ?></a>
		<a href="?m=page&amp;a=remove&amp;id=<?php echo $page->getId() ?>" class="btn btn-mini btn-danger ttip" rel="tooltip" title="<?php echo $this->t('Deleting a page will also delete all attached articles!') ?>"><span class="icon-minus"></span><?php echo $this->t('Remove Page') ?></a>
	</p>
<?php } ?>