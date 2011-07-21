<?php
$this->composePageTitle( array('Account', 'Overview') );
$this->composePageMetaTag('description', 'Your account on '.Yii::app()->name.' overview');
$this->sectionTitle = 'Account Overview';
$this->breadcrumbs[] = 'Overview';
?>
<p>
Welcome, <?php echo $this->user->first_name.' '.$this->user->last_name ?>!<br />
This is your account.<br />
Use the side bar menu to navigate different sections of your account.
</p>