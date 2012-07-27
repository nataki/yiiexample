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

		$this->insertDefaultData();
	}

	public function down() {
		$this->dropTable('email_pattern');
	}

	protected function insertDefaultData() {
		$tableName = 'email_pattern';

		$data = array(
			'timestamp' => time(),
			'name' => 'contact',
			'from_email' => '{form->email}',
			'from_name' => '{form->name}',
			'subject' => '{site_name} contact: {form->subject}',
			'body' => '<b>New contact message at <a href="{homeUrl}">{site_name}</a>:</b><br /><br />
				<b>From:</b> {form->name} on <a href="mailto:{form->email}">{form->email}</a><br />
				<b>Subject:</b> {form->subject}<br />
				<b>Message:</b><br />
				{form->body}',
		);
		$this->insert($tableName, $data);

		$data = array(
			'timestamp' => time(),
			'name' => 'forgot_password',
			'from_email' => '{site_email}',
			'from_name' => '{site_name}',
			'subject' => 'Your password at {site_name}',
			'body' => 'Your password at {site_name} has been resetted.<br />
				Your new password is <b>{user->new_password}</b><br />
				You may set up new password at your account.<br />
				<br />
				You may log in here:<br />
				<a href="{homeUrl}/site/login">{homeUrl}/site/login</a>',
		);
		$this->insert($tableName, $data);

		$data = array(
			'timestamp' => time(),
			'name' => 'signup',
			'from_email' => '{site_email}',
			'from_name' => '{site_name}',
			'subject' => 'Your account at {site_name}',
			'body' => 'Dear {member->first_name} {member->last_name},<br />
				your account at {site_name} has been created successfully.<br />
				You may log in here:<br />
				<a href="{homeUrl}/site/login">{homeUrl}/site/login</a>',
		);
		$this->insert($tableName, $data);
	}
}