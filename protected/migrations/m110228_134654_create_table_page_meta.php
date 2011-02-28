<?php

class m110228_134654_create_table_page_meta extends CDbMigration {
    public function up() {
        $columns = array(
            'id' => 'pk',
            'url' => 'string',
            'title' => 'string',
            'description' => 'text',
            'keywords' => 'text'
        );
        $this->createTable('page_meta', $columns, 'engine=INNODB');
        
        $data = array(
            'url' => '',
            'title' => 'Yii Example Title',
            'description' => 'Yii Example description',
            'keywords' => 'Yii Example keywords'
        );
        $this->insert('page_meta', $data);
    }
    
    public function down() {
        $this->dropTable('page_meta');
    }    
}