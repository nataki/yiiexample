<?php
$this->sectionTitle = 'View Page Meta #'.$model->id;
$this->breadcrumbs[]=$model->id;

$this->contextMenuItems=array(
	array('label'=>'Back To List', 'url'=>array('index')),
	array('label'=>'Create Page Meta', 'url'=>array('create')),
	array('label'=>'Update Page Meta', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Page Meta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),	
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'url',
		'title',
        'description',
		'keywords',
	),
)); ?>
