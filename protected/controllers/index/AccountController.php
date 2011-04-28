<?php

class AccountController extends IndexController {        
    /**
     * @var string title of the section, varies by action.
     */
    public $sectionTitle = 'Account';
    /**
     * @var CActiveRecord stores user model. 
     */
    protected $_user = null;
    
    public function setUser(CActiveRecord $user) {
        $this->_user = $user;
        return true;
    }
    
    public function getUser() {
        $this->initUser();
        return $this->_user;
    }
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        $rules = parent::accessRules();
        // deny anonymous:
        $rules[] = array(
            'deny',            
            'users' => array('?'),
        );        
        return $rules;
    }
    
    /**
     * Initializes the controller.
     */
    public function init() {
        parent::init();
        $this->layout = "//{$this->id}/layout";
        
        $this->breadcrumbs = array(
            'Account'=>array($this->getId().'/'),
        );
    }
    
    /**
     * Inits user data based on the session user. 
     */
    protected function initUser() {
        if (!is_object($this->_user)) {
            $this->_user = Member::model()->findByPk( Yii::app()->user->id );
        }
        return true;
    }
    
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionProfile() {
        $model = $this->user;
        
        if ( isset($_POST['Member']) || isset($_POST['MemberProfile'])) {
            $model->attributes = $_POST['Member'];
            $model->profile->attributes = $_POST['MemberProfile'];
            if ($model->validate()) {
                $model->save(false);
                                
                Yii::app()->user->setFlash( 'account_profile' ,'Your profile data has been updated.');
                $this->refresh();                
            }
        }
        
        $this->render('profile',array('model'=>$model));
    }
}