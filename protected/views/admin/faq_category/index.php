<?php
$this->sectionTitle = 'Manage Faq Categories';

$this->contextMenuItems = array(
    array('label'=>'Create Faq Category', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('//common/advanced_search', array('model'=>$model) ); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'faq-category-grid',
	'dataProvider'=>$model->dataProviderAdmin(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'class'=>'CButtonColumn',
        ),
        'id',
		array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'CHtml::link($data->name, Yii::app()->createUrl( "faq/index", array("category_id"=>$data->id) ) );',
        ),
		'description',
        array(
            'name' => 'position',
            'type' => 'raw',
            'htmlOptions' => array(
                'align'=>'center',
                'style'=>'text-align:center',
            ),
            'value' => '
                CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/admin/first.gif", "first"), Yii::app()->createUrl(Yii::app()->controller->id."/move/to/first", array("id"=>$data->id)) )."&nbsp;".
                CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/admin/up.gif", "prev"), Yii::app()->createUrl(Yii::app()->controller->id."/move/to/prev", array("id"=>$data->id)) )."&nbsp;".
                "&nbsp;".$data->position."&nbsp;".
                CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/admin/down.gif", "next"), Yii::app()->createUrl(Yii::app()->controller->id."/move/to/next", array("id"=>$data->id)) )."&nbsp;".
                CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/admin/last.gif", "last"), Yii::app()->createUrl(Yii::app()->controller->id."/move/to/last", array("id"=>$data->id)) );
            '
        ),
	),
)); ?>
