<?php
/* @var $this EmailpatternController */
/* @var $model EmailPattern */

$this->sectionTitle = 'Manage Email Patterns';

$this->contextMenuItems = array(
	array('label'=>'Create Email Pattern', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('//common/advanced_search', array('model'=>$model) ); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'record-grid',
	'ajaxUrl' => array($this->getRoute()),
	'dataProvider' => $model->dataProviderAdmin(),
	'filter' => $model,
	'columns' => array(
		array(
			'class' => 'CButtonColumn',
		),
		'id',
		'name',
		array(
			'name' => 'from_email',
			'header' => 'From',
			'value' => "\$data->from_name.' <'.\$data->from_email.'>'"
		),
		'subject',
	),
)); ?>
