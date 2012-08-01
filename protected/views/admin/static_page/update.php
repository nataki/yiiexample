<?php
/* @var $this Static_pageController */
/* @var $model StaticPage */

$this->sectionTitle = 'Update Static Page #'.$model->id;
$this->breadcrumbs[$model->id]=array('view','id'=>$model->id);
$this->breadcrumbs[]='Update';

$this->contextMenuItems=array(
	array('label'=>'Back To List', 'url'=>array('index')),
	array('label'=>'Create Static Page', 'url'=>array('create')),
	array('label'=>'View Static Page', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Delete Static Page', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>