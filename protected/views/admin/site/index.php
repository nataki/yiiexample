<?php 
/* @var $this SiteController */
$this->sectionTitle = 'Welcome to '.CHtml::encode(Yii::app()->name).' Administration Area';
?>
<p>This panel allows you to manage your site content and maintain the business logic.</p>

<p>You may start working from the following sections:</p>
<ul>
	<li><?php echo CHtml::link('General Site Settings', Yii::app()->createUrl('sitesetting')) ?></li>
	<li><?php echo CHtml::link('Set Up Administrator Accounts', Yii::app()->createUrl('administrator')) ?></li>
	<li><?php echo CHtml::link('Manage static pages', Yii::app()->createUrl('staticpage')) ?></li>
	<li><?php echo CHtml::link('Manage email patterns', Yii::app()->createUrl('emailpattern')) ?></li>
</ul>

<p>Use the left side menu to access to the other administration sections.</p>