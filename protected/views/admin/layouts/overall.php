<?php /* @var $this AdminBaseController */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $languageHtmlCode = str_replace('_','-',Yii::app()->language); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $languageHtmlCode; ?>" lang="<?php echo $languageHtmlCode; ?>">
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset; ?>" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta name="language" content="<?php echo $languageHtmlCode; ?>" />

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
		<?php $this->renderPartial('//common/header_menu'); ?>
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