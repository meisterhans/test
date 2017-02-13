<?php

namespace app\controllers;

use app\models\Companies;
use app\models\Data;
use app\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $companiesModel = new Companies();
        $comapniesDataProvider = new ActiveDataProvider([
            'query' => Companies::find()->orderBy(["id" => SORT_DESC]),
            'sort' => false
        ]);

        $usersModel = new Users();
        $usersDataProvider = new ActiveDataProvider([
            'query' => Users::find()
                ->select('users.*, companies.name as company_name')
                ->innerJoinWith('company')
                ->orderBy(["id" => SORT_DESC]),
            'sort' => false
        ]);

        $dataModel = new Users();
        $dataDataProvider = new ActiveDataProvider([
            'query' => Data::find()
                ->select("companies.id as company_id, companies.name as company_name, companies.quota as company_quota, sum(amount) as total")
                ->innerJoinWith("user")
                ->having("sum(amount) > companies.quota")
                ->groupBy("users.company_id")
                ->orderBy(["companies.id" => SORT_DESC]),
            'sort' => false
        ]);

        return $this->render('index', [
            'companies_model' => $companiesModel,
            'companies' => $comapniesDataProvider,
            'users_model' => $usersModel,
            'users' => $usersDataProvider,
            'data_model' => $dataModel,
            'data' => $dataDataProvider
        ]);
    }

    public function actionCompany($id)
    {
        $dataModel = new Users();
        $dataDataProvider = new ActiveDataProvider([
            'query' => Data::find()
                ->select('data.*, users.name as user_name')
                ->innerJoinWith("user")
                ->where("companies.id = :id", [
                    'id' => $id
                ])
                ->orderBy(["created_at" => SORT_DESC]),
            'sort' => false
        ]);

        return $this->render('company', [
            'data_model' => $dataModel,
            'data' => $dataDataProvider
        ]);
    }

    public function actionGenerate()
    {
        Data::generateData();

        return true;
    }
}
