<?php

class m110228_133744_create_table_site_setting extends CDbMigration {
    public function up() {
        $tableName = 'site_setting';
        
        $columns = array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'value' => 'text',
            'is_required' => 'integer',
            'title' => 'string NOT NULL',
            'description' => 'text',
        );
        $this->createTable($tableName, $columns, 'engine=INNODB');
        $this->createIndex("idx_{$tableName}_name", $tableName, 'name', true);
        
        $data = array(
            'name' => 'name',
            'value' => 'YiiExample',
            'is_required' => '1',
            'title' => 'Site name',
            'description' => 'The name of the site.'
        );
        $this->insert($tableName, $data);        
        $data = array(
            'name' => 'title',
            'value' => 'Yii Example',
            'is_required' => '0',
            'title' => 'Site title',
            'description' => 'The default site title, if set it will always appear as the part of page title.'
        );
        $this->insert($tableName, $data);
        $data = array(
            'name' => 'email',
            'value' => 'someuser@somedomain.com',
            'is_required' => '1',
            'title' => 'Site email address',
            'description' => 'The email address of the site, it will be passed as sender of the emails from the site.'
        );
        $this->insert($tableName, $data);
    }
    
    public function down() {
        $this->dropTable('site_setting');
    }    
}