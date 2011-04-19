<?php

class m110419_093531_create_table_auth_log extends CDbMigration {
	public function up() {
        $columns = array(
            'id' => 'pk',
            'date' => 'datetime',
            'ip' => 'varchar(50)',
            'host' => 'string',
            'url' => 'string',
            'script_name' => 'string',
            'user_id' => 'integer',
            'username' => 'string',
            'error_code' => 'string'            
        );
        $this->createTable('_auth_log', $columns, 'engine=INNODB');
    }
    
    public function down() {
        $this->dropTable('_auth_log');
    }
}