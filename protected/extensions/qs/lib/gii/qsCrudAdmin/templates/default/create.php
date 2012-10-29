<?php
/**
 * The following variables are available in this template:
 * - $this: the QSCrudAdminCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$labelSingular = $this->class2name($this->modelClass);
$labelPlural = $this->pluralize($labelSingular);
?>
$this->sectionTitle = 'Create <?php echo $labelSingular; ?>';
$this->breadcrumbs[] = 'Create';

$this->contextMenuItems = array(
	array('label'=>'Back to list', 'url'=>array('index')),
);
?>
<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
