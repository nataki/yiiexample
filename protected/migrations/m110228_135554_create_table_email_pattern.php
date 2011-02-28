<?php

class m110228_135554_create_table_email_pattern extends CDbMigration {
    public function up() {
        $columns = array(
            'id' => 'pk',
            'timestamp' => 'integer',
            'name' => 'string',
            'from_email' => 'string',
            'from_name' => 'string',
            'subject' => 'string',
            'body' => 'text',
        );
        $this->createTable('email_pattern', $columns, 'engine=INNODB');
    }
    
    public function down() {
        $this->dropTable('email_pattern');
    }
}