<?php

/**
 * This is the model class for table "member_profile".
 *
 * The followings are the available columns in table 'member_profile':
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $postal_code
 * @property string $phone_home
 * @property string $phone_mobile
 *
 * The followings are the available model relations:
 * @property User $user
 */
class MemberProfile extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return MemberProfile the static model class
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
        return 'member_profile';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('user_id', 'required'),
            array('first_name, last_name', 'required'),
            array('user_id', 'numerical', 'integerOnly'=>true),
            array('first_name, last_name, address1, address2, city, postal_code, phone_home, phone_mobile', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, first_name, last_name, address1, address2, city, postal_code, phone_home, phone_mobile', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'city' => 'City',
            'postal_code' => 'Postal Code',
            'phone_home' => 'Phone Home',
            'phone_mobile' => 'Phone Mobile',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function dataProviderAdmin()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('first_name',$this->first_name,true);
        $criteria->compare('last_name',$this->last_name,true);
        $criteria->compare('address1',$this->address1,true);
        $criteria->compare('address2',$this->address2,true);
        $criteria->compare('city',$this->city,true);
        $criteria->compare('postal_code',$this->postal_code,true);
        $criteria->compare('phone_home',$this->phone_home,true);
        $criteria->compare('phone_mobile',$this->phone_mobile,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
} 