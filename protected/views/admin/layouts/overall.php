<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>	
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/form.css" />
    
    <title><?php echo CHtml::encode($this->pageTitle); ?> | Administration</title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?>&nbsp;|&nbsp;Administration Area</div>
        <div class="header_actions">
            <?php if (!Yii::app()->user->isGuest) { ?>
            Welcome <b><?php echo Yii::app()->user->name?></b>&nbsp;&nbsp;<br />
            <?php echo CHtml::link('Administration', array('site/index'));?>&nbsp;&nbsp;
            <?php echo CHtml::link('Home', Yii::app()->baseUrl);?>&nbsp;&nbsp;
            <?php echo CHtml::link('Logout', array('site/logout'));?>&nbsp;&nbsp;
            <?php } ?>
        </div>        
	</div><!-- header -->

    <?php echo $content; ?>
            	
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::encode(Yii::app()->name); ?>.<br />
		All Rights Reserved.<br />
        Powered by <?php echo CHtml::link('QuartSoft', 'http://www.quartsoft.com') ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>