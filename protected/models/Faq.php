<?php

/**
 * This is the model class for table "faq".
 *
 * The followings are the available columns in table 'faq':
 * @property integer $id
 * @property integer $category_id
 * @property string $question
 * @property string $answer
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property FaqCategory $category
 */
class Faq extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Faq the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'faq';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('category_id, question', 'required'),
			array('category_id, position', 'numerical', 'integerOnly'=>true),
			array('question', 'length', 'max'=>255),
			array('answer', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_id, question, answer, position', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'category' => array(self::BELONGS_TO, 'FaqCategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'category_id' => 'Category',
			'question' => 'Question',
			'answer' => 'Answer',
			'position' => 'Position',
		);
	}

	/**
	 * @return array the default query criteria.
	 */
	public function defaultScope() {
		return array(
			'with' => array('category')
		);
	}

	/**
	 * @return array the behavior configurations (behavior name=>behavior configuration)
	 */
	public function behaviors() {
		return array(
			'positionBehavior' => array(
				'class'=>'ext.qs.lib.db.ar.QsActiveRecordBehaviorPosition',
				'defaultOrdering'=>true,
				'groupAttributes'=>array(
					'category_id'
				)
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
		$criteria->compare('t.category_id',$this->category_id);
		$criteria->compare('t.question',$this->question,true);
		$criteria->compare('t.answer',$this->answer,true);
		$criteria->compare('t.position',$this->position);

		$attributeNames = array_keys( $this->getAttributes() );
		$sortAttributes = array();
		foreach ($attributeNames as $attributeName) {
			$sortAttributes[$attributeName] = array(
				'asc'=>"t.{$attributeName} asc",
				'desc'=>"t.{$attributeName} desc",
			);
		}
		$sortAttributes['status_id'] = array(
			'asc'=>'category.name asc',
			'desc'=>'category.name desc'
		);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'sort'=>array(
				'attributes'=>$sortAttributes
			),
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