<?php

class m110420_130610_create_tables_faq extends CDbMigration {
	public function up() {
        $columns = array(
            'id'=>'pk',
            'name'=>'string NOT NULL',            
            'description'=>'text',
            'position'=>'integer',
        );
        $this->createTable('faq_category', $columns, 'engine=INNODB');
        $this->createIndex('idx_faq_category_position', 'faq_category', 'position');
        
        $columns = array(
            'id'=>'pk',
            'category_id'=>'integer NOT NULL',
            'question'=>'string NOT NULL',            
            'answer'=>'text',
            'position'=>'integer',
        );
        $this->createTable('faq', $columns, 'engine=INNODB');
        $this->addForeignKey('fk_faq_category_id', 'faq', 'category_id', 'faq_category', 'id');
        $this->createIndex('idx_faq_position', 'faq', 'position');
        
        $this->insertDefaultData();
    }
    
    protected function insertDefaultData() {
        // FAQ Category:
        $tableName = 'faq_category';
        
        $data = array(
            'name'=>'General',            
            'description'=>'General questions',
            'position'=>'1',
        );
        $this->insert($tableName, $data);
        $data = array(
            'name'=>'Signup',            
            'description'=>'Questions related to signup process',
            'position'=>'2',
        );
        $this->insert($tableName, $data);
        
        // FAQ:
        $tableName = 'faq';
        
        $data = array(
            'category_id'=>'1',
            'question'=>'What is this site essence?',
            'answer'=>'This is an example application, with the most common functionaly.',
            'position'=>'1',
        );
        $this->insert($tableName, $data);
        $data = array(
            'category_id'=>'1',
            'question'=>'What service do you offer?',
            'answer'=>'This is an example application, so do not expect too much...',
            'position'=>'2',
        );
        $this->insert($tableName, $data);
        $data = array(
            'category_id'=>'2',
            'question'=>'What do I need to signup?',
            'answer'=>'Following our signup process, you should specify your username, email and password.',
            'position'=>'1',
        );
        $this->insert($tableName, $data);
        $data = array(
            'category_id'=>'2',
            'question'=>'Is my email safe?',
            'answer'=>'Your email is safe. We do not share our members\'s emails.',
            'position'=>'2',
        );
        $this->insert($tableName, $data);
    }
    
    public function down() {
        $this->dropTable('faq');
        $this->dropTable('faq_category');
    }
}