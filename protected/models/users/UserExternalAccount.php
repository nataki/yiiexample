<?php

/**
 * This is the model class for table "user_external_account".
 *
 * The followings are the available columns in table 'user_external_account':
 * @property string $external_user_id
 * @property string $external_service_name
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserExternalAccount extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserExternalAccount the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'user_external_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('external_user_id, external_service_name', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('external_user_id, external_service_name', 'length', 'max'=>255),
			array('external_user_id, external_service_name, user_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'external_user_id' => 'External User',
			'external_service_name' => 'External Service Name',
			'user_id' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * This method should be called only in admin panel.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function dataProviderAdmin() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.external_user_id', $this->external_user_id, true);
		$criteria->compare('t.external_service_name', $this->external_service_name, true);
		$criteria->compare('t.user_id', $this->user_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Creates the data provider, using current model criteria.
	 * @param array $config data provider config.
	 * @return CActiveDataProvider the data provider instance.
	 */
	public function dataProvider(array $config=array()) {
		$criteria = $this->getDbCriteria();
		if (array_key_exists('criteria', $config)) {
			$criteria->mergeWith($config['criteria']);
		}
		$config['criteria'] = $criteria;
		return new CActiveDataProvider(get_class($this), $config);
	}
}