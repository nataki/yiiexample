<?php
/* @var $this AccountController */

$this->pageTitle = 'Overview Account At '.Yii::app()->name;
Yii::app()->getComponent('clientScript')->registerMetaTagUnique('Overview Your account on '.Yii::app()->name.' ', 'description');
$this->sectionTitle = 'Account Overview';
$this->breadcrumbs[] = 'Overview';
?>
<p>
Welcome, <?php echo $this->user->first_name.' '.$this->user->last_name ?>!<br />
This is your account.<br />
Use the side bar menu to navigate different sections of your account.
</p>
<?php if ($preLastLoginDate=$this->user->getPreLastLoginDate()): ?>
<p>
Last login date:<br />
<?php echo Yii::app()->getComponent('format')->formatDateTime($preLastLoginDate); ?>
</p>
<?php endif; ?>