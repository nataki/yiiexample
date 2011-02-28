<?php

/**
 * This is the model class for table "test_tree".
 *
 * The followings are the available columns in table 'test_tree':
 * @property integer $id
 * @property string $name
 * @property integer $left_index
 * @property integer $right_index
 * @property integer $level
 */
class TestTree extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return TestTree the static model class
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
        return 'test_tree';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('left_index, right_index, level', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, left_index, right_index, level', 'safe', 'on'=>'search'),
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
            'left_index' => 'Left Index',
            'right_index' => 'Right Index',
            'level' => 'Level',
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
        $criteria->compare('left_index',$this->left_index);
        $criteria->compare('right_index',$this->right_index);
        $criteria->compare('level',$this->level);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
    
    public function behaviors() {
        return array(
            'fileBehavior' => array(
                'class'=>'ext.qs.db.QsActiveRecordBehaviorTree',
            )
        );
    }
} 