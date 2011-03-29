<?php

class m110228_133744_create_table_setting extends CDbMigration {
    public function up() {
        $columns = array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'value' => 'text',
            'is_required' => 'integer',
            'title' => 'string NOT NULL',
            'description' => 'text',
        );
        $this->createTable('setting', $columns, 'engine=INNODB');
        $this->createIndex('idx_setting_name', 'setting', 'name', true);
        
        $data = array(
            'name' => 'site_name',
            'value' => 'YiiExample',
            'is_required' => '1',
            'title' => 'Site name',
            'description' => 'The name of the site.'
        );
        $this->insert('setting', $data);        
        $data = array(
            'name' => 'site_email',
            'value' => 'someuser@somedomain.com',
            'is_required' => '1',
            'title' => 'Site email address',
            'description' => 'The email address of the site, it will be passed as sender of the emails from the site.'
        );
        $this->insert('setting', $data);
    }
    
    public function down() {
        $this->dropTable('setting');
    }    
}