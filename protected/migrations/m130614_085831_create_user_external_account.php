<?php

class m130614_085831_create_user_external_account extends CDbMigration {
	public function up() {
		$tableName = 'user_external_account';
		$columns = array(
			'external_user_id' => 'string NOT NULL',
			'external_service_name' => 'string NOT NULL',
			'user_id' => 'integer',
			'PRIMARY KEY(external_user_id, external_service_name)',
		);
		$this->createTable('user_external_account', $columns, 'engine=INNODB');
		$this->addForeignKey("fk_{$tableName}_user_id", $tableName, 'user_id', 'user', 'id');
	}

	public function down() {
		$this->dropTable('user_external_account');
	}
}