<?php

/**
 * This is the model class for table "test_attach_file".
 *
 * The followings are the available columns in table 'test_attach_file':
 * @property integer $id
 * @property string $name
 * @property string $file_extension
 * @property integer $file_version
 */
class TestAttachFile extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return TestAttachFile the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'test_attach_file';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('file_version', 'numerical', 'integerOnly'=>true),
            array('name, file_extension', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, file_extension, file_version', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'file_extension' => 'File Extension',
            'file_version' => 'File Version',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('file_extension',$this->file_extension,true);
        $criteria->compare('file_version',$this->file_version);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
    
    public function behaviors() {
        return array(
            'fileBehavior' => array(
                'class'=>'ext.qs.db.QsActiveRecordBehaviorFile',
                'fileStoragePath' => Yii::getPathOfAlias('application').'/runtime',
                //'fileWebPath' => '',
                'subDirTemplate' => '{__model__}/{__file__}/{^id}/{id}',
            )
        );
    }
} 