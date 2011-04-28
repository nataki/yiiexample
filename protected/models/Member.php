<?php

/**
 * This is the model class for site member users.
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $create_date
 * @property integer $status_id
 * @property integer $group_id
 * 
 */
class Member extends User {
    public $verifyCode;
    
    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function init() {
        parent::init();
        $this->group_id = self::GROUP_MEMBER;
    }
    
    public function rules() {
        $rules = parent::rules();
        $rules = array_merge(
            $rules,
            array(
                array('verifyCode', 'safe', 'on'=>'insert'),
                array('verifyCode', 'captcha', 'on'=>'insert', 'allowEmpty'=>( !Yii::app()->user->getIsGuest() || !CCaptcha::checkRequirements() ) ),
            )
        );
        return $rules;
    }
    
    public function defaultScope() {
        $defaultScope = parent::defaultScope();
        
        $additionalScope = array(
            'condition'=>'group_id=:groupId',
            'params'=>array(
                'groupId'=>self::GROUP_MEMBER
            ),
        );
        $defaultScope = array_merge($defaultScope, $additionalScope);
        return $defaultScope;        
    }
    
    public function behaviors() {
        return array(
            'memberRoleBehavior' => array(
                'class'=>'ext.qs.db.QsActiveRecordBehaviorRole',
                'relationName'=>'profile',
                'relationConfig'=>array('MemberProfile', 'user_id'),
            )
        );
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function dataProviderAdmin() {
        $activeDataProvider = parent::dataProviderAdmin();        
        $sort = $activeDataProvider->sort;
        
        $sortAttributes = $sort->attributes;
        
        $sortAttributes['profile.first_name'] = array(
            'asc'=>'profile.first_name asc',
            'desc'=>'profile.first_name desc'
        );
        
        $sort->attributes = $sortAttributes;
        
        return $activeDataProvider;
    }
}