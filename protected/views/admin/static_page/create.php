<?php
/* @var $this Static_pageController */
/* @var $model StaticPage */

$this->sectionTitle = 'Create Static Page';
$this->breadcrumbs[]='Create';

$this->contextMenuItems=array(
	array('label'=>'Back to list', 'url'=>array('index')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>