<?php
$this->sectionTitle = 'Manage Site Settings';

$this->contextMenuItems = array(
    array('label'=>'Update Values', 'url'=>array('index')),
    array('label'=>'Create Site Setting', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('//base/advanced_search', array('model'=>$model) ); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->dataProviderAdmin(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'class'=>'CButtonColumn',
        ),
        'id',
        'name',
		'value',
        array(
            'name'=>'is_required',
            'value'=>'$data->is_required ? Yes: no;',
        ),
		'title',
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
