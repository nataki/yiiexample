<?php
$this->sectionTitle = 'Manage Users';

$this->contextMenuItems = array(
    array('label'=>'Create User', 'url'=>array('create')),
);
?>

<?php $this->renderPartial('//base/advanced_search', array('model'=>$model) ); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
    'filter'=>$model,
    //'ajaxUpdate'=>false,
    //'selectableRows'=>1,
    //'filterPosition'=>'body',
	//'summaryText'=>'{start}-{end} of {count}',
    'pager' => array(
        'class'=>'CLinkPager',        
        'pages' => array(
            'pageSize' => 2
        ),        
    ),
	'columns'=>array(
		'id',
		'name',
		//'password',
        'email',
		'status.name:text:Status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
