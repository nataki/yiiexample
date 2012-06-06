<?php
$this->sectionTitle = 'Manage Static Pages';

$this->contextMenuItems = array(
    array('label'=>'Create Static Page', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('//common/advanced_search', array('model'=>$model) ); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'record-grid',
    'ajaxUrl'=>array($this->getRoute()),
	'dataProvider'=>$model->dataProviderAdmin(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'class'=>'CButtonColumn',
        ),
        'id',
		array(
            'name' => 'url_keyword',
            'type' => 'raw',
            'value' => 'CHtml::link($data->url_keyword, Yii::app()->baseUrl."/".$data->url_keyword, array("target"=>"blank") );'
        ),
        'title',
		array(
            'class'=>'ext.qs.web.widgets.grid.QsGridColumnSwitchPosition',
            'name'=>'position'
        ),
	),
)); ?>
