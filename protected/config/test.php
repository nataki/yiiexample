<?php
/**
 * This is the test application configuration. Any writable
 * CWebApplication properties can be configured here.
 */

return CMap::mergeArray(
    //require(dirname(__FILE__).'/main.php'),
	require(dirname(__FILE__).'/index.php'),
	array(
		'import'=>array(
            'ext.qs.test.*',
            'ext.qs.test.exceptions.*',
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
