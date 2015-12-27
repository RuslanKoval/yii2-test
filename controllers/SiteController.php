<?php
namespace app\controllers;
use app\models\LoginForm;
use app\models\RegistrationForm;
use Yii;
use yii\db\mssql\PDO;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\User;
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['registration', 'login', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['registration'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->actionLogin();
        } else {
            return $this->render('index');
        }
    }

    public function actionCategories()
    {
        return $this->render('categories');
    }

    public function actionPosts()
    {
        return $this->render('posts');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->actionIndex();
    }

    public function actionRegistration()
    {
        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password_hash = password_hash($model->password_hash, 1);
            if ($model->save(false)) {
                return $this->render('congratulations');
            }
        }
        return $this->render('registration', [
            'model' => $model
        ]);
    }
}