<?php

/**
 * This is the model class for table "setting".
 *
 * The followings are the available columns in table 'setting':
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property integer $is_required
 * @property string $title
 * @property string $description
 */
class Setting extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Setting the static model class
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
        return 'setting';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        if ($this->is_required) {
            $requiredAddon = ', value';
        } else {
            $requiredAddon = '';
        }        
        return array(
            array('name, title'.$requiredAddon, 'required'),
            array('is_required', 'numerical', 'integerOnly'=>true),
            array('name, title', 'length', 'max'=>255),
            array('value, title, description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, value, is_required, title, description', 'safe', 'on'=>'search'),
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
            'value' => 'Value',
            'is_required' => 'Is Required',
            'title' => 'Title',
            'description' => 'Description',
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
        $criteria->compare('value',$this->value,true);
        $criteria->compare('is_required',$this->is_required);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('description',$this->description,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
    
    public function getValues() {
        $records = self::model()->findAll();
        $result = array();
        if (empty($records)) return $result;
        
        foreach($records as $record) {
            $result[$record->name] = $record->value;
        }
        return $result;
    }
}
