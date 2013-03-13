<?php

class m110228_132242_create_tables_auth extends CDbMigration {
	public function up() {
		$tableEngine = 'engine=INNODB';

		// _auth_item
		$columns = array(
			'name' => 'string',
			'type' => 'integer NOT NULL',
			'description' => 'text',
			'bizrule' => 'text',
			'data' => 'text',
			'PRIMARY KEY(name)'
		);
		$this->createTable('_auth_item', $columns, $tableEngine);
		
		// _auth_item_child
		$columns = array(
			'parent' => 'string',
			'child' => 'string',
			'PRIMARY KEY(parent,child)'
		);
		$this->createTable('_auth_item_child', $columns, $tableEngine);
		$this->addForeignKey('fk_auth_item_child_parent', '_auth_item_child', 'parent', '_auth_item', 'name', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_auth_item_child_child', '_auth_item_child', 'child', '_auth_item', 'name', 'CASCADE', 'CASCADE');

		// _auth_assignment
		$columns = array(
			'itemname' => 'string',
			'userid' => 'string',
			'bizrule' => 'text',
			'data' => 'text',
			'PRIMARY KEY(itemname, userid)'
		);
		$this->createTable('_auth_assignment', $columns, $tableEngine);
		$this->addForeignKey('fk_auth_assignment_itemname', '_auth_assignment', 'itemname', '_auth_item', 'name', 'CASCADE', 'CASCADE');

		// Initial data
		$data = array(
			'name' => 'admin',
			'type' => 2,
			'description' => 'Auto detect admin by group_id param',
			'bizrule' => 'return ( !Yii::app()->user->getIsGuest() && Yii::app()->user->getState(\'group_id\')==1 );',
			'data' => 'N;'
		);
		$this->insert('_auth_item', $data);
		$data = array(
			'name' => 'member',
			'type' => 2,
			'description' => 'Auto detect member by group_id param',
			'bizrule' => 'return ( !Yii::app()->user->getIsGuest() && Yii::app()->user->getState(\'group_id\')==2 );',
			'data' => 'N;'
		);
		$this->insert('_auth_item', $data);
	}

	public function down() {
		$this->dropTable('_auth_assignment');
		$this->dropTable('_auth_item_child');
		$this->dropTable('_auth_item');
	}
}