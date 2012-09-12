<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->sectionTitle = 'Create Faq';
$this->breadcrumbs[] = 'Create';

$contextAttributes = $this->getActiveContextModelAttributes();

$this->contextMenuItems = array(
	array('label'=>'Back to list', 'url'=>array_merge( array('index'), $contextAttributes ) ),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>