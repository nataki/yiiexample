<?php
$this->layout = 'single';

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
    'Error',
);
?>

<h1>Unauthorized</h1>
<h2><?php echo nl2br(CHtml::encode($data['message'])); ?></h2>
<p>
You do not have the proper credential to access this page.
</p>