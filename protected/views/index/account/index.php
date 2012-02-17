<?php
$this->pageTitle = 'Overview Account At '.Yii::app()->name;
Yii::app()->clientScript->registerMetaTag('Overview Your account on '.Yii::app()->name.' ', 'description');
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
<?php echo Yii::app()->format->formatStrDateTime( $preLastLoginDate ); ?>
</p>
<?php endif; ?>