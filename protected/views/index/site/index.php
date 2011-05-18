<?php 
$this->composePageTitle('Example Yii Application');
$this->composePageMetaTag('description', Yii::app()->name.' is an example Yii application');
?>
<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>This is an example application, which provides only the basic functionality.</p>

<p>You may try to do the following actions:</p>
<ul>
    <li>Create new account <?php echo CHtml::link('here', Yii::app()->createUrl('signup/')) ?></li>
	<li>View our <?php echo CHtml::link('F.A.Q.', Yii::app()->createUrl('help/faq')) ?></li>
    <li>Contact site administrators using <?php echo CHtml::link('Contact form', Yii::app()->createUrl('help/contact')) ?></li>
</ul>

<p>Use menus to navigate the site.</p>