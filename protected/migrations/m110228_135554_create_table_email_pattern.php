<?php

class m110228_135554_create_table_email_pattern extends CDbMigration {
    public function up() {
        $tableName = 'email_pattern';
        
        $columns = array(
            'id' => 'pk',
            'timestamp' => 'integer',
            'name' => 'string',
            'from_email' => 'string',
            'from_name' => 'string',
            'subject' => 'string',
            'body' => 'text',
        );
        $this->createTable($tableName, $columns, 'engine=INNODB');
        $this->createIndex("idx_{$tableName}_name", $tableName, 'name', true);
        $this->createIndex("idx_{$tableName}_timestamp", $tableName, 'timestamp');
                
        $data = array(
            'timestamp' => time(),
            'name' => 'contact',
            'from_email' => '{form->email}',
            'from_name' => '{form->name}',
            'subject' => '{site_name} contact: {form->subject}',
            'body' => '<b>New contact message at <a href="<? echo \'http://\'.$_SERVER[\'HTTP_HOST\'].Yii::app()->baseUrl; ?>">{site_name}</a>:</b><br /><br />
                <b>From:</b> {form->name} on <a href="mailto:{form->email}">{form->email}</a><br />
                <b>Subject:</b> {form->subject}<br />
                <b>Message:</b><br />
                {form->body}',
        );
        $this->insert($tableName, $data);
    }
    
    public function down() {
        $this->dropTable('email_pattern');
    }
}