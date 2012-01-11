<?php

/**
 * This is the model class for table "test_language".
 *
 * The followings are the available columns in table 'test_language':
 * @property integer $id
 * @property string $name
 * @property string $native_name
 * @property string $code
 * @property string $locale_code
 * @property string $html_code
 * @property integer $status_id
 */
class TestLanguage extends CActiveRecord {
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return Language the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'test_language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, native_name, code, locale_code, html_code, status_id', 'required'),
            array('status_id', 'numerical', 'integerOnly'=>true),
			array('name, native_name', 'length', 'max'=>255),
			array('code, locale_code, html_code', 'length', 'max'=>5),
            array('name,code, locale_code, html_code','unique','className'=>'Language','caseSensitive'=>false),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, native_name, code, locale_code, html_code, status_id', 'safe', 'on'=>'search'),
		);
	}

	/**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'status' => array(self::BELONGS_TO, 'LanguageStatus', 'status_id'),
            'faqCategoryTranslations' => array(self::HAS_MANY, 'FaqCategoryTranslation', 'language_id'),
            'faqTranslations' => array(self::HAS_MANY, 'FaqTranslation', 'language_id'),
            'staticPageTranslations' => array(self::HAS_MANY, 'StaticPageTranslation', 'language_id'),
        );
    }

    public function scopes() {
        return array(
            'active'=>array(
                'condition'=>'status_id='.self::STATUS_ACTIVE,
            ),
        );
    }
    
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'native_name' => 'Native Name',
			'code' => 'Code',
			'locale_code' => 'Locale Code',
            'html_code' => 'Html Code',
			'status_id' => 'Status',
		);
	}            
}