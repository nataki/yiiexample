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
    }
    
    public function down() {
        $this->dropTable('faq');
        $this->dropTable('faq_category');
    }
}