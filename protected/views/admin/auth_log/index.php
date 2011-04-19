<?php
$this->sectionTitle = 'Manage Auth Logs';
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
        'date:strdate',
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
