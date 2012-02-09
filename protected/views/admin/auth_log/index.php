<?php
$this->sectionTitle = 'Manage Auth Logs';
?>

<?php $this->renderPartial('//common/advanced_search', array('model'=>$model) ); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'record-grid',
	'dataProvider'=>$model->dataProviderAdmin(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'class'=>'CButtonColumn',
            'template'=>'{view} {delete}'
        ),
        'id',
        'date:strdatetime',
        'username',
        'ip',
        'host',
		array(
            'name'=>'url',
            'type'=>'raw',
            'value'=>"CHtml::link('http://'.\$data->url, 'http://'.\$data->url, array('target'=>'blank')) ",
        ),        
		'error_code',
	),
)); ?>
