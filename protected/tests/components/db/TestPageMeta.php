<?php

/**
 * This is the model class for table "test_page_meta".
 *
 * The followings are the available columns in table 'test_page_meta':
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $description
 * @property string $keywords
 */
class TestPageMeta extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @return TestPageMeta the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'test_page_meta';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('url, title', 'length', 'max'=>255),
            array('description, keywords', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, url, title, description, keywords', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'url' => 'Url',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
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
        $criteria->compare('t.url',$this->url,true);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.description',$this->description,true);
        $criteria->compare('t.keywords',$this->keywords,true);

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

        $criteria->compare('t.url',$this->url,true);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.description',$this->description,true);
        $criteria->compare('t.keywords',$this->keywords,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize'=>20
            )
        ));
    }*/
} 