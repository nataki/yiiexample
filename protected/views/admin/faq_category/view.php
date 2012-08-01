<?php
/* @var $this Faq_categoryController */
/* @var $model FaqCategory */

$this->sectionTitle = 'View Faq Category #'.$model->id;
$this->breadcrumbs[]=$model->id;

$this->contextMenuItems=array(
	array('label'=>'Back To List', 'url'=>array('index')),
	array('label'=>'Create Faq Category', 'url'=>array('create')),
	array('label'=>'Update Faq Category', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Faq Category', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description:html',
		array(
			'label'=>'FAQ',
			'type'=>'raw',
			'value'=>CHtml::link('see questions', array('faq/index/category_id/'.$model->id) )
		),
	),
)); ?>
