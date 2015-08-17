<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\LoginForm;
use common\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class UserController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\User';    

}