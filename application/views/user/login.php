<article>
	<?php if(isset($_SESSION[SNAME])) { ?>
	<h1><?php echo $this->t('Logged in') ?></h1>
	<?php } else { ?>
	<h1><?php echo $this->t('Login') ?></h1>
	<form class="form-inline" action="?m=<?php echo $this->request['model'] ?>&amp;a=<?php echo $this->request['action'] ?>" method="post">
		<input type="text" class="input-large" placeholder="<?php echo $this->t('Username') ?>" name="login[username]" />
		<input type="password" class="input-large" placeholder="<?php echo $this->t('Password') ?>" name="login[password]" />
		<input type="submit" class="btn" value="<?php echo $this->t('Login') ?>">
	</form>
	<?php } ?>
</article>