<form class="form-horizontal" action="?m=<?php echo $this->request['model'] ?>&amp;a=<?php echo $this->request['action'] ?>&amp;id=<?php echo $this->request['id'] ?>" method="post">
	<div class="control-group">
		<label class="control-label" for="page-h1"><?php echo $this->t('Name') ?></label>
		<div class="controls">
			<input type="text" id="page-h1" placeholder="<?php echo $this->t('Name') ?>" name="page[name]" value="<?php echo $this->result->getName() ?>" />
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<input type="submit" class="btn" value="<?php echo $this->t('Submit') ?>">
		</div>
	</div>
</form>