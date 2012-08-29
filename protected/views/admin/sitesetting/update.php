<?php
/* @var $this SitesettingController */
/* @var $model SiteSetting */

$this->sectionTitle = 'Update Site Setting #'.$model->id;
$this->breadcrumbs[$model->id]=array('view','id'=>$model->id);
$this->breadcrumbs[]='Update';

$this->contextMenuItems=array(
	array('label'=>'Update Values', 'url'=>array('index')),
	array('label'=>'Back To List', 'url'=>array('admin')),
	array('label'=>'Create Site Setting', 'url'=>array('create')),
	array('label'=>'View Site Setting', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Delete Site Setting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>