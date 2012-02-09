<?php
$this->sectionTitle = 'View Auth Log #'.$model->id;
$this->breadcrumbs[]=$model->id;

$this->contextMenuItems=array(
	array('label'=>'Back To List', 'url'=>array('index')),	
	array('label'=>'Delete Auth Log', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),	
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        'date:strdatetime',
        'username',
        'user_id',
		array(
            'name'=>'url',
            'type'=>'raw',
            'value' => CHtml::link('http://'.$model->url, 'http://'.$model->url, array('target'=>'blank')) 
        ),        
		'script_name',
        'error_code',
        'error_message',
        'ip',
		'host',
	),
)); ?>
