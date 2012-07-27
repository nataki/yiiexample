<?php
$this->sectionTitle = 'Update Email Pattern #'.$model->id;
$this->breadcrumbs[$model->id]=array('view','id'=>$model->id);
$this->breadcrumbs[]='Update';

$this->contextMenuItems=array(
	array('label'=>'Back To List', 'url'=>array('index')),
	array('label'=>'Create Email Pattern', 'url'=>array('create')),
	array('label'=>'View Email Pattern', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Delete Email Pattern', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>