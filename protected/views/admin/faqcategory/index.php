<?php
/* @var $this FaqcategoryController */
/* @var $model FaqCategory */

$this->sectionTitle = 'Manage Faq Categories';

$this->contextMenuItems = array(
	array('label'=>'Create Faq Category', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('//common/advanced_search', array('model'=>$model) ); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'faq-category-grid',
	'ajaxUrl' => array($this->getRoute()),
	'dataProvider' => $model->dataProviderAdmin(),
	'filter' => $model,
	'columns' => array(
		array(
			'class' => 'CButtonColumn',
		),
		'id',
		array(
			'name' => 'name',
			'type' => 'raw',
			'value' => 'CHtml::link($data->name, Yii::app()->createUrl( "faq/index", array("category_id"=>$data->id) ) );',
		),
		'description',
		array(
			'class' => 'ext.qs.web.widgets.grid.QsGridColumnSwitchPosition',
			'name' => 'position'
		),
	),
)); ?>
