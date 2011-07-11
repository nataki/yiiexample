<?php

/**
 * This is the model class for table "test_role_slave".
 *
 * The followings are the available columns in table 'test_role_slave':
 * @property integer $id
 * @property integer $master_id
 * @property string $slave_name
 */
class TestRoleSlave extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return TestRoleSlave the static model class
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
        return 'test_role_slave';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('master_id', 'numerical', 'integerOnly'=>true),
            array('slave_name', 'required'),
            array('slave_name', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, master_id, slave_name', 'safe', 'on'=>'search'),
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
            'master_id' => 'Master',
            'slave_name' => 'Slave Name',
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
        $criteria->compare('master_id',$this->master_id);
        $criteria->compare('slave_name',$this->slave_name,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
} 