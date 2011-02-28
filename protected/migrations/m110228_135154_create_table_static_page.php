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
    }
    
    public function down() {
        $this->dropTable('static_page');
    }
}