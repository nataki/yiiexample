<?php
/* @var $this PageController */
/* @var $model StaticPage */

$this->pageTitle = Yii::app()->name.' - '.$model->title;
Yii::app()->getComponent('clientScript')->registerMetaTagUnique($model->meta_description, 'description');
$this->breadcrumbs = array(
	$model->title,
);
?>
<h1><?php echo $model->title; ?></h1>
<p><?php echo Yii::app()->getComponent('format')->formatEvalView($model->content); ?></p>