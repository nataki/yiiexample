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
}