<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $date
 * @property integer $ref_status
 * @property integer $ref_group
 *
 * The followings are the available model relations:
 */
class User extends CActiveRecord {
    const StatusPending = 1;
    const StatusActive = 2;
    const StatusCanceled = 3;
    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function init() {
        $this->ref_status = self::StatusPending;
        $this->date = new CDbExpression('NOW()');
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
            array('name, email, password, date, ref_status, ref_group', 'required'),
            array('ref_status, ref_group', 'numerical', 'integerOnly'=>true),
            array('name, email, password', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, email, date, ref_status, ref_group', 'safe', 'on'=>'search'),
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
                self::BELONGS_TO, 'UserStatus', 'ref_status',
                'select' => 'name',
                'joinType' => 'INNER JOIN',
            )
        );
        
    }

    public function scopes() {
        return array(
            'active'=>array(
                'condition'=>'ref_status='.self::StatusActive,
            ),
            'recently'=>array(
                'order'=>'date DESC',
                'limit'=>5,
            ),
        );
    }    
    
    public function defaultScope() {
        return array(
            'with' => array('status')
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
            'date' => 'Date',
            'ref_status' => 'Status',
            'ref_group' => 'Group',
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
        $criteria->compare('t.date',$this->date,true);
        $criteria->compare('t.ref_status',$this->ref_status);
        $criteria->compare('t.ref_group',$this->ref_group);        

        
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