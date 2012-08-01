<?php
/* @var $this IndexController */

$this->pageTitle = 'Error At '.Yii::app()->name;
Yii::app()->clientScript->registerMetaTag('Sorry, an error has occurred while resolving your request.', 'description');
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>