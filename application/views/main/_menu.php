<?php
	$pages = \InsertFancyNameHere\Application\Models\Page::getAll($this->db);
	if(!empty($pages) || isset($_SESSION[SNAME])) {
?>
<ul class="nav nav-tabs">
<?php foreach ($pages as $id => $page) { ?>
	<li<?php if($id == $this->request['id'] && 'page' == strtolower($this->request['model'])) { ?> class="active"<?php }?>><a href="?m=page&amp;a=display&amp;id=<?php echo $id ?>"><?php echo $page->getName() ?></a></li>
<?php } ?>
<?php if(isset($_SESSION[SNAME])) { ?>
	<li<?php if(0 == $this->request['id'] && 'page' == strtolower($this->request['model'])) { ?> class="active"<?php }?>><a href="?m=page&amp;a=create"><span class="icon-plus"></span> <?php echo $this->t('Add Page') ?></a></li>
<?php } ?>
</ul>
<?php } ?>