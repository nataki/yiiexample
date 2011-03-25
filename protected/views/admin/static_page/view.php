<?php
$this->breadcrumbs[]=$model->id;

$this->menu=array(
	/*array('label'=>'List Page Meta', 'url'=>array('index')),
	array('label'=>'Create Page Meta', 'url'=>array('create')),*/
	array('label'=>'Update Static Page', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Static Page', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage Page Meta', 'url'=>array('admin')),
);
?>

<h1>View Page Meta #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'action',
		'title',
        'content',
	),
)); ?>
