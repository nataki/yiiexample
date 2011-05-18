<?php

class m110228_135154_create_table_static_page extends CDbMigration {
    public function up() {
        $tableName = 'static_page';
        
        $columns = array(
            'id' => 'pk',
            'action' => 'string NOT NULL',
            'title' => 'text',
            'meta_description' => 'text',
            'content' => 'text',
            'position' => 'integer'
        );
        $this->createTable($tableName, $columns, 'engine=INNODB');
        $this->createIndex("idx_{$tableName}_action", $tableName, 'action', true);
        $this->createIndex("idx_{$tableName}_position", $tableName, 'position');
        
        $columns = array(
            'action' => 'howitworks',
            'title' => 'How It Works',
            'meta_description' => 'How the service works',
            'content' => 'The manual about how your service works',
            'position' => '1'
        );        
        $this->insert($tableName, $columns);
        $columns = array(
            'action' => 'about',
            'title' => 'About',
            'meta_description' => 'About the service',
            'content' => 'A brief information about your site',
            'position' => '2'
        );        
        $this->insert($tableName, $columns);
    }
    
    public function down() {
        $this->dropTable('static_page');
    }
}