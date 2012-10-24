<?php
/* @var $this SitesettingController */
/* @var $model SiteSetting */

$this->sectionTitle = 'Manage Site Settings';

$this->contextMenuItems = array(
	array('label'=>'Update Values', 'url'=>array('index')),
	array('label'=>'Create Site Setting', 'url'=>array('create')),
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
		'value',
		'is_required:boolean',
		'title',
		array(
			'class' => 'ext.qs.lib.web.widgets.grid.QsGridColumnSwitchPosition',
			'name' => 'position'
		),
	),
)); ?>
