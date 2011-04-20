<?php

/**
 * This is the model class for table "static_page".
 *
 * The followings are the available columns in table 'static_page':
 * @property integer $id
 * @property string $action
 * @property string $title
 * @property string $content
 * @property integer $position
 */
class StaticPage extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class.
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
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('action, title, content, position', 'required'),
            array('position', 'numerical', 'integerOnly'=>true),
            array('action, title', 'length', 'max'=>255),
            array('action','unique','className'=>get_class($this),'caseSensitive'=>false),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, action, title, content, position', 'safe', 'on'=>'search'),
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
            'action' => 'Action',
            'title' => 'Title',
            'content' => 'Content',
            'position' => 'Position',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function dataProviderAdmin() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('action',$this->action,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('position',$this->position);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
    
    public function behaviors() {
        return array(
            'positionBehavior' => array(
                'class'=>'ext.qs.db.QsActiveRecordBehaviorPosition'
            )
        );
    }
}
