<?php
$this->composePageTitle( array('Account', 'Overview') );
$this->composePageMetaTag('description', 'Your account on '.Yii::app()->name.' overview');
$this->sectionTitle = 'Account Overview';
$this->breadcrumbs[] = 'Overview';
?>
<p>Welcome ,<?php echo $this->user->first_name.' '.$this->user->last_name ?>!</p>
<p>This is your account. Use side bar menu to navigate.</p>