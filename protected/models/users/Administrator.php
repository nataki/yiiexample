<?php

/**
 * This is the model class for administrator users.
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
class Administrator extends User {
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * Initializes this model.
     */
    public function init() {
        parent::init();
        $this->group_id = self::GROUP_ADMIN;
    }
    
    /**
     * @return array the default query criteria.
     */
    public function defaultScope() {
        $defaultScope = parent::defaultScope();

        $mainTableAlias = $this->getTableAlias(false,false);

        $additionalScope = array(
            'condition'=>$mainTableAlias.'.group_id=:groupId',
            'params'=>array(
                'groupId'=>self::GROUP_ADMIN
            ),
        );
        $defaultScope = array_merge($defaultScope, $additionalScope);
        return $defaultScope;        
    }
}