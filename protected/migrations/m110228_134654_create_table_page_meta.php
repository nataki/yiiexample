<?php

class m110228_134654_create_table_page_meta extends CDbMigration {
    public function up() {
        $tableName = 'page_meta';
        
        $columns = array(
            'id' => 'pk',
            'url' => 'string',
            'title' => 'string',
            'description' => 'text',
            'keywords' => 'text'
        );
        $this->createTable($tableName, $columns, 'engine=INNODB');
        $this->createIndex("idx_{$tableName}_url", $tableName, 'url', true);
        
        $data = array(
            'url' => '',
            'title' => 'Example Application',
            'description' => 'Yii Example description',
            'keywords' => 'Yii Example keywords'
        );
        $this->insert($tableName, $data);
        $data = array(
            'url' => 'help/contact',
            'title' => 'Contact',
            'description' => 'Contact Yii Example',
            'keywords' => 'Yii Example, contact'
        );
        $this->insert($tableName, $data);
        $data = array(
            'url' => 'signup',
            'title' => 'Signup',
            'description' => 'Sign up for Yii Example',
            'keywords' => 'Yii Example, signup, register'
        );
        $this->insert($tableName, $data);
        $data = array(
            'url' => 'about',
            'title' => 'About',
            'description' => 'About Yii Example',
            'keywords' => 'Yii Example, about'
        );
        $this->insert($tableName, $data);
        $data = array(
            'url' => 'howitworks',
            'title' => 'How It Works',
            'description' => 'How Yii Example Works',
            'keywords' => 'Yii Example, how it works'
        );
        $this->insert($tableName, $data);
    }
    
    public function down() {
        $this->dropTable('page_meta');
    }    
}