<?php
$this->pageTitle = Yii::app()->name . ' - '.$staticPage->title;
$this->breadcrumbs=array(
    $staticPage->title,
);
?>
<h1><?php echo $staticPage->title ?></h1>
<p><?php echo $staticPage->content ?></p>