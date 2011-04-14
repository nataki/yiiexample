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
		array(
            'class'=>'CButtonColumn',
        ),
        'id',
		'name',
		//'password',
        'email',
        'create_date:strdate',
        /*array(
            'name'=>'create_date',
            'value'=>'Yii::app()->format->formatDate( strtotime($data->create_date) )'
        ),*/
		'status.name:text:Status',		        
	),
)); ?>
