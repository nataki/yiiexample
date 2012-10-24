<?php

/**
 * This is the model class for table "faq_category".
 *
 * The followings are the available columns in table 'faq_category':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property Faq[] $faqs
 */
class FaqCategory extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FaqCategory the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'faq_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('name', 'required'),
			array('position', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, position', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'faqs' => array(self::HAS_MANY, 'Faq', 'category_id', 'order'=>'faqs.position ASC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'position' => 'Position',
		);
	}

	/**
	 * @return array the behavior configurations (behavior name=>behavior configuration)
	 */
	public function behaviors() {
		return array(
			'positionBehavior' => array(
				'class'=>'ext.qs.lib.db.ar.QsActiveRecordBehaviorPosition',
				'defaultOrdering'=>true
			),
			'cacheClearBehavior' => array(
				'class'=>'ext.qs.lib.db.ar.QsActiveRecordBehaviorClearCache',
				'dependingCacheIds'=>array(
					'Yii.COutputCache.faqListHtml..help/faq....'
				)
			),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * This method should be called only in admin panel.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function dataProviderAdmin() {
		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.description',$this->description,true);
		$criteria->compare('t.position',$this->position);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Creates the data provider, using current model criteria.
	 * @param array $config data provider config.
	 * @return CActiveDataProvider the data provider instance.
	 */
	public function dataProvider(array $config=array()) {
		$criteria = $this->getDbCriteria();
		if (array_key_exists('criteria',$config)) {
			$criteria->mergeWith($config['criteria']);
		}
		$config['criteria'] = $criteria;
		return new CActiveDataProvider(get_class($this),$config);
	}
}