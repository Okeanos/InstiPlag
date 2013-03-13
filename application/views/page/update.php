<article>
	<h1><?php echo $this->t('Update'); ?>: <?php echo $this->t('Page') ?>/<?php echo $this->result->getName() ?></h1>
	<?php echo $this->loadView('page' . DIRECTORY_SEPARATOR . '_form.php') ?>
</article>