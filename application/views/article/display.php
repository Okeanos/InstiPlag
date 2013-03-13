<article class="clear">
	<h1><?php echo $this->getResult()->getH1(); ?></h1>
	<h2><?php echo $this->getResult()->getH2(); ?></h2>
	<?php echo $this->getResult()->getContent(); ?>
	<hr />
<?php if(isset($_SESSION[SNAME])) { ?>
	<p class="muted pull-left">
		<a href="?m=article&amp;a=update&amp;id=<?php echo $this->getResult()->getId() ?>" class="btn btn-mini"><span class="icon-pencil"></span><?php echo $this->t('Edit Article') ?></a>
		<a href="?m=article&amp;a=remove&amp;id=<?php echo $this->getResult()->getId() ?>" class="btn btn-mini btn-danger"><span class="icon-minus"></span><?php echo $this->t('Remove Article') ?></a>
	</p>
<?php } ?>
	<p class="muted pull-right">
		<time datetime="<?php echo $this->getResult()->getUpdateDate()->format('Y-m-d') ?>"><?php echo $this->getResult()->getUpdateDate()->format('jS F Y') ?></time>, <?php echo $this->getResult()->getAuthor()->getUsername() ?>
	</p>
</article>