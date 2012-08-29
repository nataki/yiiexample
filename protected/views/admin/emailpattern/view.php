<?php
/* @var $this EmailpatternController */
/* @var $model EmailPattern */

$this->sectionTitle = 'View Email Pattern #'.$model->id;
$this->breadcrumbs[]=$model->id;

$this->contextMenuItems=array(
	array('label'=>'Back To List', 'url'=>array('index')),
	array('label'=>'Create Email Pattern', 'url'=>array('create')),
	array('label'=>'Update Email Pattern', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Email Pattern', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),	
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		array(
			'label'=>'From',
			'type'=>'text',
			'value'=>$model->from_name.' <'.$model->from_email.'>'
		),
		'subject',
		'body:html',
	),
)); ?>
