<?php

return CMap::mergeArray(
    //require(dirname(__FILE__).'/main.php'),
	require(dirname(__FILE__).'/index.php'),
	array(
		'import'=>array(
            'ext.qs.test.*'
        ),
        'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			/* uncomment the following to provide test database connection
			'db'=>array(
				'connectionString'=>'DSN for test database',
			),
			*/
            'urlManager'=>array(
                'showScriptName'=>true,                
            ),
            'email'=> array(                
                'testMode' => 'silence',
            ),
		),
	)
);
