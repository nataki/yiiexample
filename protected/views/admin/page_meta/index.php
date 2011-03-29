<?php
$this->sectionTitle = 'Manage Page Metas';

$this->contextMenuItems = array(
    array('label'=>'Create Page Meta', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('//base/advanced_search', array('model'=>$model) ); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'class'=>'CButtonColumn',
        ),
        'id',
		array(
            'name'=>'url',
            'type'=>'raw',
            'value'=>"CHtml::link(\$url=Yii::app()->getRequest()->getHostInfo('http').Yii::app()->baseUrl.'/'.\$data->url, \$url, array('target'=>'blank')) ",
        ),        
		'title',		
	),
)); ?>
