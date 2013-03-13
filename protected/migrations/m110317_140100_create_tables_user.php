<?php

class m110317_140100_create_tables_user extends CDbMigration {
	public function up() {
		$this->upUserStatus();
		$this->upUserGroup();
		$this->upUser();
	}

	protected function upUserStatus() {
		$tableName = 'user_status';

		$columns = array(
			'id' => 'integer',
			'name' => 'string NOT NULL',
			'PRIMARY KEY(id)', // no auto-increment!
		);
		$this->createTable($tableName, $columns, 'engine=INNODB');

		$columns = array(
			'id' => '1',
			'name' => 'pending',
		);
		$this->insert($tableName, $columns);
		$columns = array(
			'id' => '2',
			'name' => 'active',
		);
		$this->insert($tableName, $columns);
		$columns = array(
			'id' => '3',
			'name' => 'canceled',
		);
		$this->insert($tableName, $columns);
	}

	protected function upUserGroup() {
		$tableName = 'user_group';

		$columns = array(
			'id' => 'integer',
			'name' => 'string NOT NULL',
			'PRIMARY KEY(id)', // no auto-increment!
		);
		$this->createTable($tableName, $columns, 'engine=INNODB');

		$columns = array(
			'id' => '1',
			'name' => 'admin',
		);
		$this->insert($tableName, $columns);
		$columns = array(
			'id' => '2',
			'name' => 'member',
		);
		$this->insert($tableName, $columns);
	}

	protected function upUser() {
		$tableName = 'user';

		$columns = array(
			'id' => 'pk',
			'name' => 'string NOT NULL',
			'email' => 'string',
			'password' => 'string',
			'create_date' => 'datetime',
			'status_id' => 'integer',
			'group_id' => 'integer',
		);
		$this->createTable($tableName, $columns, 'engine=INNODB');
		$this->addForeignKey('fk_user_status_id', 'user', 'status_id', 'user_status', 'id');
		$this->addForeignKey('fk_user_group_id', 'user', 'group_id', 'user_group', 'id');

		$columns = array(
			'name' => 'admin',
			'email' => 'develqs@quartsoft.com',
			'password' => sha1('admin'),
			'create_date' => date('Y-m-d H:i:s', strtotime('NOW')),
			'status_id' => '2',
			'group_id' => '1',
		);
		$this->insert($tableName, $columns);
	}

	public function down() {
		$this->dropTable('user');
		$this->dropTable('user_group');
		$this->dropTable('user_status');
	}

}