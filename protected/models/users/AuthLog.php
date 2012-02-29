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
 * @property integer $error_code
 * @property string $error_message
 */
class AuthLog extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
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

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('user_id, error_code', 'numerical', 'integerOnly'=>true),
            array('ip', 'length', 'max'=>50),
            array('host, url, script_name, username, error_message', 'length', 'max'=>255),
            array('date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date, ip, host, url, script_name, user_id, username, error_code, error_message', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'date' => 'Date',
            'ip' => 'Ip',
            'host' => 'Host',
            'url' => 'Url',
            'script_name' => 'Script Name',
            'user_id' => 'User Id',
            'username' => 'Username',
            'error_code' => 'Error Code',
            'error_message' => 'Error Message',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function dataProviderAdmin() {
        $criteria=new CDbCriteria;

        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.date',$this->date,true);
        $criteria->compare('t.ip',$this->ip,true);
        $criteria->compare('t.host',$this->host,true);
        $criteria->compare('t.url',$this->url,true);
        $criteria->compare('t.script_name',$this->script_name,true);
        $criteria->compare('t.user_id',$this->user_id);
        $criteria->compare('t.username',$this->username,true);
        $criteria->compare('t.error_code',$this->error_code,true);
        $criteria->compare('t.error_message',$this->error_message,true);
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20
            ),
            'sort'=>array(
                'defaultOrder' => 'date DESC'
            ),
        ));
    }
    
    /**
     * Retrieves a successful authentication date of the specified user.
     * @param integer $userId user id value
     * @param integer $offset zero based date offset.
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