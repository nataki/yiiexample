<?php
/* @var $this AdminBaseController */
/* @var $model CModel */

if (!isset($listId)) {
	$listId = 'record-grid';
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function() {
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function() {
	$('#{$listId}').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php echo CHtml::link('Advanced Search', '#', array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->