<?php
/* @var $this MemberController */
/* @var $model Member */

$this->sectionTitle = 'Create Member';
$this->breadcrumbs[]='Create';

$this->contextMenuItems=array(
	array('label'=>'Back to list', 'url'=>array('index')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>