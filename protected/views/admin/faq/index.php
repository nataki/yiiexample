<?php
$this->sectionTitle = 'Manage FAQ';

$contextAttributes = $this->getActiveContextModelAttributes();

$this->contextMenuItems = array(
    //array('label'=>'Create Faq', 'url'=>array('create')),
    array('label'=>'Create Faq', 'url'=>array_merge( array('create'), $contextAttributes )),
);
?>

<?php $this->renderPartial('//base/advanced_search', array('model'=>$model) ); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'faq-grid',
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
            'name' => 'position',
            'type' => 'raw',
            'htmlOptions' => array(
                'align'=>'center',
                'style'=>'text-align:center',
            ),
            'value' => '
                CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/admin/first.gif", "first"), Yii::app()->createUrl(Yii::app()->controller->id."/move/to/first", array_merge( array("id"=>$data->id), $this->grid->owner->getActiveContextModelAttributes() ) ) )."&nbsp;".
                CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/admin/up.gif", "prev"), Yii::app()->createUrl(Yii::app()->controller->id."/move/to/prev", array_merge( array("id"=>$data->id), $this->grid->owner->getActiveContextModelAttributes() ) ) )."&nbsp;".
                "&nbsp;".$data->position."&nbsp;".
                CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/admin/down.gif", "next"), Yii::app()->createUrl(Yii::app()->controller->id."/move/to/next", array_merge( array("id"=>$data->id), $this->grid->owner->getActiveContextModelAttributes() ) ) )."&nbsp;".
                CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/admin/last.gif", "last"), Yii::app()->createUrl(Yii::app()->controller->id."/move/to/last", array_merge( array("id"=>$data->id), $this->grid->owner->getActiveContextModelAttributes() ) ) );
            '
        ),
	),
)); ?>
