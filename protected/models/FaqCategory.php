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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
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
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
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
    
    public function behaviors() {
        return array(
            'positionBehavior' => array(
                'class'=>'ext.qs.db.QsActiveRecordBehaviorPosition',
                'defaultOrdering'=>true
            ),
            'cacheClearBehavior' => array(
                'class'=>'ext.qs.db.QsActiveRecordBehaviorClearCache',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('position',$this->position);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
    
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	/*public function dataProvider() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize'=>20
            )
		));
	}*/
}