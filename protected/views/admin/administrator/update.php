<?php
$this->sectionTitle = 'Update Administrator #'.$model->id;
$this->breadcrumbs[$model->id]=array('view','id'=>$model->id);
$this->breadcrumbs[]='Update';

$this->contextMenuItems=array(
    array('label'=>'Back To List', 'url'=>array('index')),    
    array('label'=>'Create Administrator', 'url'=>array('create')),
    array('label'=>'View Administrator', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Delete Administrator', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),    
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>