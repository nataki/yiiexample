<?php $this->beginContent('//layouts/overall'); ?>
<div id="main">
	<?php if (!Yii::app()->user->isGuest) { ?>
		<?php $this->renderPartial('//common/main_menu'); ?>
	<?php } ?>
	<div id="entry">
		<?php echo $content; ?>
	</div>
</div>

<?php $this->endContent(); ?>