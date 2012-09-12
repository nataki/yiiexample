<?php
/* @var $this AuthlogController */
/* @var $model AuthLog */

$this->sectionTitle = 'Manage Auth Logs';
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
			'template' => '{view} {delete}'
		),
		'id',
		'date:strdatetime',
		'username',
		'ip',
		'host',
		array(
			'name' => 'url',
			'type' => 'raw',
			'value' => "CHtml::link('http://'.\$data->url, 'http://'.\$data->url, array('target'=>'blank')) ",
		),
		'error_code',
	),
)); ?>
