<?php

class m110228_133744_create_table_setting extends CDbMigration {
    public function up() {
        $columns = array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'value' => 'text',
            'description' => 'text',
        );
        $this->createTable('setting', $columns, 'engine=INNODB');
        $this->createIndex('idx_setting_name', 'setting', 'name', true);
        
        $data = array(
            'name' => 'site_name',
            'value' => 'YiiExample',
            'description' => 'The name of the site.'
        );
        $this->insert('setting', $data);        
        $data = array(
            'name' => 'site_email',
            'value' => 'someuser@somedomain.com',
            'description' => 'The email of the site, it will be passed as sender of the emails from the site.'
        );
        $this->insert('setting', $data);
    }
    
    public function down() {
        $this->dropTable('setting');
    }    
}