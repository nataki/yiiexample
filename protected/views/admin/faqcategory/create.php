<?php
/* @var $this FaqcategoryController */
/* @var $model FaqCategory */

$this->sectionTitle = 'Create Faq Category';
$this->breadcrumbs[] = 'Create';

$this->contextMenuItems = array(
	array('label'=>'Back to list', 'url'=>array('index')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>