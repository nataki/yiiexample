<?php
/* @var $this Faq_categoryController */
/* @var $model FaqCategory */

$this->sectionTitle = 'Update Faq Category #'.$model->id;
$this->breadcrumbs[$model->id]=array('view','id'=>$model->id);
$this->breadcrumbs[]='Update';

$this->contextMenuItems=array(
	array('label'=>'Back To List', 'url'=>array('index')),
	array('label'=>'Create Faq Category', 'url'=>array('create')),
	array('label'=>'View Faq Category', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Delete Faq Category', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>