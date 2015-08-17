<?php
namespace api\modules\v1\controllers;
use Yii;
use yii\rest\ActiveController;
use api\modules\v1\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;

class CountryController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Country';    
/*
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            //'class' => HttpBasicAuth::className(),
            'class' => CompositeAuth::className(),
             'authMethods' => [
                 HttpBasicAuth::className(),
                 HttpBearerAuth::className(),
                 QueryParamAuth::className(),
             ],
        ];
        return $behaviors;
    }*/
     public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => function ($username, $password) {
        // Return Identity object or null
            
                return User::findByUsernameAndPassword( $username, $password);
                
            },
        ];
        return $behaviors;
    }
    
      public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}

