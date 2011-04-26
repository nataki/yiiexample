<?php
$this->sectionTitle = 'View Administrator #'.$model->id;
$this->breadcrumbs[]=$model->id;

$this->contextMenuItems=array(
    array('label'=>'Back To List', 'url'=>array('index')),
    array('label'=>'Create Administrator', 'url'=>array('create')),
    array('label'=>'Update Administrator', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete Administrator', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),    
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        'group.name:html:Group',
        'status.name:html:Status',
		'name',
		//'password',
        'email:email',
		'create_date:strdate',        
	),
)); ?>