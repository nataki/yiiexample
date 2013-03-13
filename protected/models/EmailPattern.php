<?php

/**
 * This is the model class for table "email_pattern".
 *
 * The followings are the available columns in table 'email_pattern':
 * @property integer $id
 * @property integer $timestamp
 * @property string $name
 * @property string $from_email
 * @property string $from_name
 * @property string $subject
 * @property string $body
 */
class EmailPattern extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailPattern the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'email_pattern';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('name, from_email, from_name, subject, body', 'required'),
			array('timestamp', 'numerical', 'integerOnly'=>true),
			array('name, from_email, from_name, subject', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, timestamp, name, from_email, from_name, subject, body', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'timestamp' => 'Timestamp',
			'name' => 'Name',
			'from_email' => 'From Email',
			'from_name' => 'From Name',
			'subject' => 'Subject',
			'body' => 'Body',
		);
	}

	/**
	 * @return array the behavior configurations (behavior name=>behavior configuration)
	 */
	public function behaviors() {
		 return array(
			 'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'timestamp',
				'updateAttribute' => 'timestamp',
		 ));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function dataProviderAdmin() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.timestamp', $this->timestamp);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.from_email', $this->from_email, true);
		$criteria->compare('t.from_name', $this->from_name, true);
		$criteria->compare('t.subject', $this->subject, true);
		$criteria->compare('t.body', $this->body, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}
} 