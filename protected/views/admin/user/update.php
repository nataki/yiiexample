<?php
//$this->breadcrumbs['Users']=array('index');
$this->breadcrumbs[$model->id]=array($model->id);
$this->breadcrumbs[]='Update';	
?>

<h1>Update User #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>