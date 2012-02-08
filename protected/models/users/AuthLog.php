<?php

/**
 * This is the model class for table "_auth_log".
 *
 * The followings are the available columns in table '_auth_log':
 * @property integer $id
 * @property string $date
 * @property string $ip
 * @property string $host
 * @property string $url
 * @property string $script_name
 * @property integer $user_id
 * @property string $username
 * @property string $error_code
 */
class AuthLog extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @return AuthLog the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '_auth_log';
    }
    
    public function init() {
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $this->script_name = $_SERVER['SCRIPT_NAME'];
        $this->url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $this->error_code = 0;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'numerical', 'integerOnly'=>true),
            array('ip', 'length', 'max'=>50),
            array('host, url, script_name, username, error_code', 'length', 'max'=>255),
            array('date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date, ip, host, url, script_name, user_id, username, error_code', 'safe', 'on'=>'search'),
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
            'date' => 'Date',
            'ip' => 'IP Address',
            'host' => 'Host',
            'url' => 'Url',
            'script_name' => 'Script Name',
            'user_id' => 'User',
            'username' => 'Login Name',
            'error_code' => 'Error Code',
        );
    }

    public function behaviors() {
         return array(
             'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'date',
                'updateAttribute' => null,
         ));
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function dataProviderAdmin() {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('date',$this->date,true);
        $criteria->compare('ip',$this->ip,true);
        $criteria->compare('host',$this->host,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('script_name',$this->script_name,true);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('error_code',$this->error_code,true);

        //$criteria->order = 'date DESC';
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder' => 'date DESC'
            ),
        ));
    }
    
    /**
     * Retrieves a successful authentication date of the specified user.
     * @param integer $userId user id value
     * @param integer $offset date offset.
     * @return string date of last login in SQL format.
     */
    protected function getSuccessfulAuthDate($userId, $offset=0) {
        $successErrorCode = CBaseUserIdentity::ERROR_NONE;
        $criteriaConfig = array(
            'condition'=>'t.error_code=:successErrorCode AND t.user_id=:user_id',
            'params'=>array(
                'user_id'=>$userId,
                'successErrorCode'=>$successErrorCode
            ),
            'order'=>'date DESC',
            'offset'=>$offset,
            'limit'=>1,
        );
        $criteria = new CDbCriteria($criteriaConfig);

        $authRecord = $this->find($criteria);

        if (!empty($authRecord)) {
            return $authRecord->date;
        }
        return null;
    }

    /**
     * Retrieves a last login date of the specified user.
     * @param integer $userId user id value
     * @return string date of last login in SQL format.
     */
    public function getLastLoginDate($userId) {
        return $this->getSuccessfulAuthDate($userId,0);
    }

    /**
     * Retrieves a pre last login date of the specified user.
     * @param integer $userId user id value
     * @return string date of last login in SQL format.
     */
    public function getPreLastLoginDate($userId) {
        return $this->getSuccessfulAuthDate($userId,1);
    }
} 