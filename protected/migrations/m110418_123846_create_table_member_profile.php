<?php

class m110418_123846_create_table_member_profile extends CDbMigration {
	public function up() {
        $columns = array(
            'id' => 'pk',
            'user_id' => 'integer NOT NULL',
            'first_name' => 'string',
            'last_name' => 'string',
            'address1' => 'string',
            'address2' => 'string',
            'city' => 'string',
            'postal_code' => 'string',
            'phone_home' => 'string',
            'phone_mobile' => 'string',
        );
        $this->createTable('member_profile', $columns, 'engine=INNODB');
        
        $this->addForeignKey('fk_member_profile_user_id', 'member_profile', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }
    
    public function down() {
        $this->dropTable('member_profile');
    }
}