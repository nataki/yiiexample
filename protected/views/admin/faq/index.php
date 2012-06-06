<?php
$this->sectionTitle = 'Manage FAQ';

$contextAttributes = $this->getActiveContextModelAttributes();

$this->contextMenuItems = array(
    //array('label'=>'Create Faq', 'url'=>array('create')),
    array('label'=>'Create Faq', 'url'=>array_merge( array('create'), $contextAttributes )),
);
?>

<?php $this->renderPartial('//common/advanced_search', array('model'=>$model) ); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'faq-grid',
    'ajaxUrl'=>array_merge( array($this->getRoute()), $contextAttributes ),
	'dataProvider'=>$model->dataProviderAdmin(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'class'=>'CButtonColumn',
            'viewButtonUrl'=>'Yii::app()->controller->createUrl("view",array_merge( array("id"=>$data->primaryKey), $this->grid->owner->getActiveContextModelAttributes() ))',
            'updateButtonUrl'=>'Yii::app()->controller->createUrl("update",array_merge( array("id"=>$data->primaryKey), $this->grid->owner->getActiveContextModelAttributes() ))',
            'deleteButtonUrl'=>'Yii::app()->controller->createUrl("delete",array_merge( array("id"=>$data->primaryKey), $this->grid->owner->getActiveContextModelAttributes() ))'
        ),
        'id',
		array(
            'header'=>'Category',
            'name'=>'category_id',
            'filter'=>CHtml::listData(FaqCategory::model()->findAll(), 'id', 'name'),
            'value'=>'$data->category->name',
        ),
		'question',
		'answer',
        array(
            'class'=>'ext.qs.web.widgets.grid.QsGridColumnSwitchPosition',
            'name'=>'position'
        ),
	),
)); ?>
