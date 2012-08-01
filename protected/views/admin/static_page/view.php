<?php
/* @var $this Static_pageController */
/* @var $model StaticPage */

$this->sectionTitle = 'View Static Page #'.$model->id;
$this->breadcrumbs[]=$model->id;

$this->contextMenuItems=array(
	array('label'=>'Back To List', 'url'=>array('index')),
	array('label'=>'Create Static Page', 'url'=>array('create')),
	array('label'=>'Update Static Page', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Static Page', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'url_keyword',
			'type'=>'raw',
			'value'=> CHtml::link($model->url_keyword, Yii::app()->baseUrl.'/'.$model->url_keyword, array('target'=>'blank') )
		),
		'title',
		'meta_description',
		'content',
	),
)); ?>
