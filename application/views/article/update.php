<article>
	<h1><?php echo $this->t('Update'); ?>: <?php echo $this->t('Article') ?>/<?php echo $this->result->getH1() ?>/<?php echo $this->result->getH2() ?></h1>
	<?php echo $this->loadView('article' . DIRECTORY_SEPARATOR . '_form.php') ?>
</article>