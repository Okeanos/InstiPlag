<form class="form-horizontal" action="?m=<?php echo $this->request['model'] ?>&amp;a=<?php echo $this->request['action'] ?>&amp;id=<?php echo $this->request['id'] ?>" method="post">
	<div class="control-group">
		<label class="control-label" for="article-h1"><?php echo $this->t('Heading') ?></label>
		<div class="controls">
			<input type="text" id="article-h1" placeholder="<?php echo $this->t('Heading') ?>" name="article[h1]" value="<?php echo $this->result->getH1() ?>" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="article-h2"><?php echo $this->t('Subheading') ?></label>
		<div class="controls">
			<input type="text" id="article-h2" placeholder="<?php echo $this->t('Subheading') ?>" name="article[h2]" value="<?php echo $this->result->getH2() ?>" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="article-page"><?php echo $this->t('Page') ?></label>
		<div class="controls">
			<select id="article-page" name="article[pageId]">
				<option value="0" <?php if(0 == $this->result->getPageId()) { ?>selected="selected"<?php } ?>><?php echo $this->t('Select a page') ?></option>
				<?php foreach (\InsertFancyNameHere\Application\Models\Page::getAll($this->db) as $id => $page) { ?>
				<option value="<?php echo $id ?>" <?php if($id == $this->result->getPageId()) { ?>selected="selected"<?php } ?>><?php echo $page->getName() ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="article-display"><?php echo $this->t('Display') ?></label>
		<div class="controls">
			<select id="article-display" name="article[display]">
				<option value="0" <?php if(!$this->result->isDisplayed()) { ?>selected="selected"<?php } ?>><?php echo $this->t('No') ?></option>
				<option value="1" <?php if($this->result->isDisplayed()) { ?>selected="selected"<?php } ?>><?php echo $this->t('Yes') ?></option>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="article-content"><?php echo $this->t('Content') ?></label>
		<div class="controls">
			<textarea rows="10" cols="10" id="article-content" name="article[content]">
			<?php echo $this->result->getContent() ?>
			</textarea>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<input type="submit" class="btn" value="<?php echo $this->t('Submit') ?>">
		</div>
	</div>
</form>