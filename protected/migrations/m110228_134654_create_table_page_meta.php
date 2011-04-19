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
            'title' => 'Example Application',
            'description' => 'Yii Example description',
            'keywords' => 'Yii Example keywords'
        );
        $this->insert('page_meta', $data);
        $data = array(
            'url' => 'help/contact',
            'title' => 'Contact',
            'description' => 'Contact Yii Example',
            'keywords' => 'Yii Example, contact'
        );
        $this->insert('page_meta', $data);
        $data = array(
            'url' => 'about',
            'title' => 'About',
            'description' => 'About Yii Example',
            'keywords' => 'Yii Example, about'
        );
        $this->insert('page_meta', $data);
        $data = array(
            'url' => 'howitworks',
            'title' => 'How It Works',
            'description' => 'How Yii Example Works',
            'keywords' => 'Yii Example, how it works'
        );
        $this->insert('page_meta', $data);
    }
    
    public function down() {
        $this->dropTable('page_meta');
    }    
}