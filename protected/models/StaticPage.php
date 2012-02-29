<?php

/**
 * This is the model class for table "static_page".
 *
 * The followings are the available columns in table 'static_page':
 * @property integer $id
 * @property string $url_keyword
 * @property string $title
 * @property string $meta_description
 * @property string $content
 * @property integer $position
 */
class StaticPage extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return StaticPage the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'static_page';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('url_keyword, title, meta_description, content', 'required'),
            array('position', 'numerical', 'integerOnly'=>true),
            array('url_keyword, title', 'length', 'max'=>255),                                                
            array('url_keyword','unique','className'=>get_class($this),'caseSensitive'=>false),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, url_keyword, title, meta_description, content, position', 'safe', 'on'=>'search'),
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
            'url_keyword' => 'URL Keyword',
            'title' => 'Title',
            'meta_description' => 'Meta Description',
            'content' => 'Content',
            'position' => 'Position',
        );
    }
    
    /**
     * @return array the behavior configurations (behavior name=>behavior configuration)
     */
    public function behaviors() {
        return array(
            'positionBehavior' => array(
                'class'=>'ext.qs.db.QsActiveRecordBehaviorPosition'
            ),
            'cacheClearBehavior' => array(
                'class'=>'ext.qs.db.QsActiveRecordBehaviorClearCache',
                'dependingCacheIds'=>array(
                    'Yii.COutputCache.secondaryMenuHtml......',
                    'QsUrlRuleModelPageStaticPage',
                    //'QsUrlRuleModelPage'.get_class($this),
                )
            ),
        );
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function dataProviderAdmin() {
        $criteria=new CDbCriteria;

        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.url_keyword',$this->url_keyword,true);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.meta_description',$this->meta_description,true);
        $criteria->compare('t.content',$this->content,true);
        $criteria->compare('t.position',$this->position);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
}
