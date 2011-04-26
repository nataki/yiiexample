<?php
$this->sectionTitle = 'Create Site Setting';
$this->breadcrumbs[]='Create';

$this->contextMenuItems=array(
    array('label'=>'Update Values', 'url'=>array('index')),
    array('label'=>'Back to list', 'url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>