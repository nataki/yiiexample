<?php

/**
 * This is the model class for table "site_setting".
 *
 * The followings are the available columns in table 'site_setting':
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property integer $is_required
 * @property string $title
 * @property string $description
 * @property integer $position
 */
class SiteSetting extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Setting the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'site_setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		if ($this->is_required) {
			$requiredAddon = ', value';
		} else {
			$requiredAddon = '';
		}
		return array(
			array('name, title'.$requiredAddon, 'required'),
			array('is_required, position', 'numerical', 'integerOnly'=>true),
			array('name, title', 'length', 'max'=>255),
			array('value, title, description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, value, is_required, title, description, position', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'value' => 'Value',
			'is_required' => 'Is Required',
			'title' => 'Title',
			'description' => 'Description',
			'position' => 'Position',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function dataProviderAdmin() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.value', $this->value, true);
		$criteria->compare('t.is_required', $this->is_required);
		$criteria->compare('t.title', $this->title, true);
		$criteria->compare('t.description', $this->description, true);
		$criteria->compare('t.position', $this->position, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	/**
	 * @return array the behavior configurations (behavior name=>behavior configuration)
	 */
	public function behaviors() {
		return array(
			'settingBehavior' => array(
				'class' => 'ext.qs.lib.db.ar.QsActiveRecordBehaviorNameValue',
				'autoNamePrefix' => 'site_'
			),
			'positionBehavior' => array(
				'class' => 'ext.qs.lib.db.ar.QsActiveRecordBehaviorPosition',
				'defaultOrdering' => true,
			)
		);
	}
}
