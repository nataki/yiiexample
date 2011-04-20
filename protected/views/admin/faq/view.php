<?php
$this->sectionTitle = 'View Faq #'.$model->id;
$this->breadcrumbs[]=$model->id;

$this->contextMenuItems=array(
    array('label'=>'Back To List', 'url'=>array('index')),
    array('label'=>'Create Faq', 'url'=>array('create')),
    array('label'=>'Update Faq', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete Faq', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),    
);
?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
            'label'=>'Category',
            'type'=>'raw',
            'value'=>CHtml::link($model->category->name, array('faq_category/view/'.$model->category_id))
        ),
		'question:html',
		'answer:html',		
	),
)); ?>
