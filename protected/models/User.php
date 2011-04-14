<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $create_date
 * @property integer $status_id
 * @property integer $group_id
 *
 * The followings are the available model relations:
 */
class User extends CActiveRecord {
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_CANCELED = 3;
    
    const GROUP_ADMIN = 1;
    const GROUP_MEMBER = 2;
    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function init() {
        $this->status_id = self::STATUS_PENDING;
        $this->group_id = self::GROUP_MEMBER;
        $this->create_date = new CDbExpression('NOW()');
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, email, password, create_date, status_id, group_id', 'required'),
            array('status_id, group_id', 'numerical', 'integerOnly'=>true),
            array('name, email, password', 'length', 'max'=>255),
            array('email','email'),
            array('name,email','unique','className'=>'User','caseSensitive'=>false, 'on'=>'insert'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, email, create_date, status_id, group_id', 'safe', 'on'=>'search'),
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
            'status'=>array(
                self::BELONGS_TO, 'UserStatus', 'status_id',                
                'joinType' => 'INNER JOIN',
            ),
            'group'=>array(
                self::BELONGS_TO, 'UserGroup', 'group_id',
                'joinType' => 'INNER JOIN',
            )
        );
        
    }

    public function scopes() {
        return array(
            'active'=>array(
                'condition'=>'status_id='.self::STATUS_ACTIVE,
            ),
            'recently'=>array(
                'order'=>'create_date DESC',
                'limit'=>5,
            ),
        );
    }    
    
    public function defaultScope() {
        return array(
            'with' => array('status', 'group')
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
            'email' => 'Email',
            'password' => 'Password',
            'create_date' => 'Creation Date',
            'status_id' => 'Status',
            'group_id' => 'Group',
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

        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.name',$this->name,true);
        $criteria->compare('t.email',$this->email,true);
        $criteria->compare('t.password',$this->email,true);
        $criteria->compare('t.create_date',$this->create_date,true);
        $criteria->compare('t.status_id',$this->status_id);
        $criteria->compare('t.group_id',$this->group_id);        

        
        $sortAttributes = array_keys( $this->getAttributes() );        
        $sortAttributes[] = 'status.name';
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>$sortAttributes
            ),
            /*'pagination' => array(
                'pageSize'=>2
            )*/
        ));
    }
} 