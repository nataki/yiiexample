<?php

class TestRoleMasterSlave extends TestRoleMaster {
    
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    
    public function behaviors() {
        return array_merge(
            parent::behaviors(),
            array(
                'role' => array(
                    'class'=>'ext.qs.db.QsActiveRecordBehaviorRole',
                    'relationName'=>'slave',
                    'relationConfig'=>array(
                        'TestRoleSlave', 'master_id'
                    )
                )
            )
        );        
    }
}