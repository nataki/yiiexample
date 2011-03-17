<?php

class m110228_135154_create_table_static_page extends CDbMigration {
    public function up() {
        $columns = array(
            'id' => 'pk',
            'action' => 'string NOT NULL',
            'title' => 'text',
            'content' => 'text'
        );
        $this->createTable('static_page', $columns, 'engine=INNODB');
        $this->createIndex('idx_static_page_action', 'setting', 'name', true);
        
        $columns = array(
            'action' => 'about',
            'title' => 'About',
            'content' => 'A brief information about your site'
        );        
        $this->insert('static_page', $columns);
        $columns = array(
            'action' => 'howitworks',
            'title' => 'How It Works',
            'content' => 'The manual about how your service works'
        );        
        $this->insert('static_page', $columns);
    }
    
    public function down() {
        $this->dropTable('static_page');
    }
}