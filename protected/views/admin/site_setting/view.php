<?php
$this->sectionTitle = 'View Site Setting #'.$model->id;
$this->breadcrumbs[]=$model->id;

$this->contextMenuItems=array(
	array('label'=>'Update Values', 'url'=>array('index')),
    array('label'=>'Back To List', 'url'=>array('admin')),
	array('label'=>'Create Site Setting', 'url'=>array('create')),
	array('label'=>'Update Site Setting', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Site Setting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),	
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        'name',        
        'value',
        'is_required:boolean',
		'title',
        'description',		
	),
)); ?>
