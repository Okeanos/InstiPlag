<!DOCTYPE html>
<html lang="<?php echo $this->getLanguage() ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $this->getTitle() ?></title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css"/>
		<link rel="stylesheet" type="text/css" href="css/instiplag.css"/>
		<link rel="stylesheet" type="text/css" media="print" href="css/print.css"/>
		<link rel="stylesheet" type="text/css" href="css/bootstrap-wysihtml5.css"/>
	</head>
	<body>
		<section class="container">
			<header class="row-fluid">
				<h1 class="label"><?php echo $this->t('Welcome to the Institute for plagiarism research') ?></h1>
			</header>
			<div class="row-fluid">
				<?php if(!empty($this->getFlash()['type'])) { ?>
				<div class="alert alert-<?php echo $this->getFlash()['type'] ?>">
	  				<button type="button" class="close" data-dismiss="alert">&times;</button>
	  				<?php echo $this->getFlash()['text'] ?>
				</div>
				<?php } ?>
				<hr />
				<div class="tabbable tabs-left">
					<?php echo $this->getMenu() ?>
					<div class="tab-content">
						<div class="tab-pane active">
							<?php echo $this->getContent() ?>
						</div>
					</div>
				</div>
			</div>
			<hr />
			<footer class="row-fluid">
				<p class="muted pull-left">&copy; <time>2012</time> InsertFancyNamehere :: Christopher Getschmann, Nikolas Grottendieck, Katrin Hofer</p>
				<p class="muted pull-right"><?php if(isset($_SESSION[SNAME])) { ?><a href="?m=user&amp;a=logout"><?php echo $this->t('Logout') ?></a><?php } else { ?><a href="?m=user&amp;a=login"><?php echo $this->t('Login') ?></a><?php } ?></p>
			</footer>
		</section>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script src="js/wysihtml5.js"></script>
		<script src="js/bootstrap-wysihtml5.js"></script>
		<script type="text/javascript">
			$('.ttip').tooltip()
			$('textarea').wysihtml5();
		</script>
	</body>
</html>