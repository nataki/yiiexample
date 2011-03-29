<?php 
    $this->sectionTitle = 'Welcome to '.CHtml::encode(Yii::app()->name).' Administration Area';
?>
<p>This panel allows you to manage your site content and maintain the bisuness logic.</p>

<p>You may start working from the following sections:</p>
<ul>
    <li><?php echo CHtml::link('General Settings', Yii::app()->createUrl('setting')) ?></li>
    <li><?php echo CHtml::link('Set Up Administrator Accounts', Yii::app()->createUrl('administrator')) ?></li>
	<li><?php echo CHtml::link('Manage SEO Parameters', Yii::app()->createUrl('page_meta')) ?></li>
</ul>

<p>Use the left side menu to access to the other administration sections.</p>