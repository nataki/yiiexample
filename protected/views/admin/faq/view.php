<?php
$this->sectionTitle = 'View FAQ #'.$model->id;
$this->breadcrumbs[]=$model->id;

$contextAttributes = $this->getActiveContextModelAttributes();

$this->contextMenuItems=array(
    array('label'=>'Back To List', 'url'=>array_merge( array('index'), $contextAttributes ) ),
    array('label'=>'Create FAQ', 'url'=>array_merge( array('create'), $contextAttributes ) ),
    array('label'=>'Update FAQ', 'url'=>array_merge( array('update', 'id'=>$model->id), $contextAttributes ) ),
    array('label'=>'Delete FAQ', 'url'=>'#', 'linkOptions'=>array('submit'=>array_merge( array('delete','id'=>$model->id), $contextAttributes ),'confirm'=>'Are you sure you want to delete this item?')),    
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
