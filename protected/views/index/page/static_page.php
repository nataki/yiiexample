<?php
$this->composePageTitle($model->title);
$this->composePageMetaTag('description', $model->meta_description);
$this->breadcrumbs=array(
    $model->title,
);
?>
<h1><?php echo $model->title; ?></h1>
<p><?php echo Yii::app()->format->formatEvalView($model->content); ?></p>