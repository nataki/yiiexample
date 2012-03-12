<?php

class m110419_093531_create_table_auth_log extends CDbMigration {
	public function up() {
        $tableName = '_auth_log';
        $columns = array(
            'id' => 'pk',
            'date' => 'datetime',
            'ip' => 'varchar(50)',
            'host' => 'string',
            'url' => 'string',
            'script_name' => 'string',
            'user_id' => 'integer',
            'username' => 'string',
            'error_code' => 'integer',
            'error_message' => 'string'
        );
        $this->createTable($tableName, $columns, 'engine=INNODB');
        $this->createIndex("idx_{$tableName}_user_id", $tableName, 'user_id');
        $this->createIndex("idx_{$tableName}_error_code", $tableName, 'error_code');
        $this->createIndex("idx_{$tableName}_date", $tableName, 'date');
    }
    
    public function down() {
        $this->dropTable('_auth_log');
    }
}