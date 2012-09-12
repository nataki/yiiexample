<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->sectionTitle = 'Update FAQ #'.$model->id;
$this->breadcrumbs[$model->id] = array('view','id'=>$model->id);
$this->breadcrumbs[] = 'Update';

$contextAttributes = $this->getActiveContextModelAttributes();

$this->contextMenuItems = array(
	array('label'=>'Back To List', 'url'=>array_merge( array('index'), $contextAttributes ) ),
	array('label'=>'Create FAQ', 'url'=>array_merge( array('create'), $contextAttributes ) ),
	array('label'=>'View FAQ', 'url'=>array_merge( array('view', 'id'=>$model->id), $contextAttributes ) ),
	array('label'=>'Delete FAQ', 'url'=>'#', 'linkOptions'=>array('submit'=>array_merge( array('delete','id'=>$model->id), $contextAttributes ),'confirm'=>'Are you sure you want to delete this item?')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>