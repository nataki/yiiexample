<?php
/* @var $this EmailpatternController */
/* @var $model EmailPattern */

$this->sectionTitle = 'Create Email Pattern';
$this->breadcrumbs[] = 'Create';

$this->contextMenuItems = array(
	array('label'=>'Back to list', 'url'=>array('index')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>