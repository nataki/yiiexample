<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->composePageMetaTag('description', 'Sorry, an error has occured while resolving your request');
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>