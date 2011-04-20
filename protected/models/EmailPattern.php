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
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
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
            'timestamp' => 'Timestamp',
            'name' => 'Name',
            'from_email' => 'From Email',
            'from_name' => 'From Name',
            'subject' => 'Subject',
            'body' => 'Body',
        );
    }
    
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
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('timestamp',$this->timestamp);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('from_email',$this->from_email,true);
        $criteria->compare('from_name',$this->from_name,true);
        $criteria->compare('subject',$this->subject,true);
        $criteria->compare('body',$this->body,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
} 