<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div class="span-5">
        <?php $this->renderPartial('//menus/left_menu'); ?>
    </div>
    <div class="span-19 last">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	
</div>
<?php $this->endContent(); ?>