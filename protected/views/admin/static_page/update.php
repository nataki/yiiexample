<?php
$this->breadcrumbs[$model->id]=array('view','id'=>$model->id);
$this->breadcrumbs[]='Update';
?>

<h1>Update Static Page #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>