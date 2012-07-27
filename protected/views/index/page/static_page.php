<?php
$this->pageTitle = Yii::app()->name.' - '.$model->title;
Yii::app()->clientScript->registerMetaTag($model->meta_description, 'description');
$this->breadcrumbs=array(
	$model->title,
);
?>
<h1><?php echo $model->title; ?></h1>
<p><?php echo Yii::app()->format->formatEvalView($model->content); ?></p>