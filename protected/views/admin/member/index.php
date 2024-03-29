<?php
/* @var $this MemberController */
/* @var $model Member */

$this->sectionTitle = 'Manage Members';

$this->contextMenuItems = array(
	array('label'=>'Create Member', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('//common/advanced_search', array('model'=>$model) ); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'record-grid',
	'ajaxUrl' => array($this->getRoute()),
	'dataProvider' => $model->dataProviderAdmin(),
	'filter' => $model,
	'pager' => array(
		'class' => 'CLinkPager',
	),
	'columns' => array(
		array(
			'class' => 'CButtonColumn',
		),
		'id',
		'name',
		/*array(
			'header' => 'Full name',
			'name' => 'profile.first_name',
			'value' => '$data->profile->first_name." ".$data->profile->first_name',
		),*/
		'email',
		'create_date:date',
		array(
			'header' => 'Status',
			'name' => 'status_id',
			'filter' => CHtml::listData(UserStatus::model()->findAll(), 'id', 'name'),
			'value' => '$data->status->name',
		),
	),
)); ?>
