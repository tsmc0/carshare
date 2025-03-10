<?php

namespace app\controllers;

use app\models\AddCarForm;
use app\models\AddCarGroupForm;
use app\models\Auto;
use app\models\AutoBrand;
use app\models\ProfileForm;
use app\models\Rent;
use app\models\SignupForm;
use app\models\Team;
use app\models\TeamCar;
use app\models\TeamForm;
use app\models\TeamUser;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        if (!file_exists('data-check/auto-brands.txt')) {
            if (AutoBrand::find()->count() == 0) {
                include_once '../assets/Utils.php';

                extractBrands();

                file_put_contents('data-check/auto-brands.txt', 1);
            } else {
                file_put_contents('data-check/auto-brands.txt', 1);
            }
        }

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
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
        if (Yii::$app->user->isGuest) {
            return $this->redirect('login');
        }

        return $this->render('index', ['rent' => Rent::find()->where(['user' => Yii::$app->user->identity->getId()])->all()]);
    }

    public function actionGarage()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('login');
        }

        return $this->render('garage', [
            'brands' => AutoBrand::find()->all(),
            'all' => Auto::find()->where(['owner' => Yii::$app->user->identity->getId()])->all(),
        ]);
    }

    public function actionCars()
    {
        return $this->render('cars-catalog', [
            'brands' => AutoBrand::find()->all(),
            'all' => Auto::find()->limit(50)->all(),
        ]);
    }

    public function actionGroupInvitation($pubID)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!Team::find()->where(['public_id' => $pubID])->exists()) {
            return $this->goHome();
        }

        $invite = Team::find()->where(['public_id' => $pubID])->one();
        $users = TeamUser::find()->where(['team' => $invite->id])->count();

        return $this->render('group-invite', [
            'invite' => $invite,
            'users' => $users
        ]);
    }

    public function actionAcceptInvite()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isPost) {
            $group = Yii::$app->request->post('publicID');

            if (Team::find()->where(['public_id' => $group])->exists()) {
                $teamID = Team::find()->where(['public_id' => $group])->one()->id;

                if (!TeamUser::find()->where(['team' => $teamID, 'user' => Yii::$app->user->identity->getId()])->exists()) {
                    $tu = new TeamUser();
                    $tu->user = Yii::$app->user->identity->getId();
                    $tu->team = $teamID;

                    return $this->asJson(['message' => $tu->save()]);
                } else {
                    return $this->asJson(['message' => 'Вы уже состоите в этой группе']);
                }
            } else {
                return $this->asJson(['message' => 'Такого приглашения не существует']);
            }
        }
    }

    public function actionCreateGroup()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new TeamForm();
        if (Yii::$app->request->isPost) {
            $t = new Team;
            $t->title = Yii::$app->request->post('title');
            $t->public_id = Yii::$app->getSecurity()->generateRandomString();
            $t->owner = Yii::$app->user->identity->getId();
            $writeGroup = $t->save();

            $ug = new TeamUser;
            $ug->user = Yii::$app->user->identity->getId();
            $ug->team = $t->id;
            $ug->save();

            return $this->asJson($writeGroup);
        }

        return $this->render('create-group', ['model' => $model]);
    }

    public function actionAddCarToGroup($teamID)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new AddCarGroupForm();
        if (Yii::$app->request->isPost) {
            $t = new TeamCar();
            $t->auto = Yii::$app->request->post('selectedCar');
            $t->team = Yii::$app->request->post('team');
            $t->user = Yii::$app->user->identity->getId();

            return $this->asJson($t->save());
        }

        $rentCarsAll = Auto::find()->select(['mark', 'model', 'id'])->indexBy('id')->all();
        $rentCars = [];

        foreach ($rentCarsAll as $rentCar) {
            $rentCars[$rentCar['id']] = $rentCar['mark'] . ' ' . $rentCar['model'];
        }

        return $this->render('add-auto-group', ['model' => $model, 'rentCars' => $rentCars, 'teamID' => $teamID]);
    }

    public function actionGroup()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $g = TeamUser::find()->where(['user' => Yii::$app->user->identity->getId()])->all();
        $groups = [];
        $users = [];

        foreach ($g as $item) {
            $u = TeamUser::find()->where(['team' => $item->team])->limit(3)->all();

            foreach ($u as $user) {
                $users[] = User::findOne($user->user);
            }

            $groups[] = [
                'info' => Team::find()->where(['id' => $item->team])->one(),
                'users' => $users,
            ];

            $users = [];
        }

        return $this->render('group', [
            'groups' => $groups,
        ]);
    }

    public function actionAddCar()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new AddCarForm();

        if (Yii::$app->request->isPost) {
            $model = new Auto;
            $model->mark = Yii::$app->request->post('brand');
            $model->date_create = time();
            $model->model = Yii::$app->request->post('model');
            $model->preview = Yii::$app->request->post('preview');
            $model->coast_per_hour = Yii::$app->request->post('cph');
            $model->owner = Yii::$app->user->identity->getId();
            $model->public_id = Yii::$app->getSecurity()->generateRandomString(24);

            return $this->asJson($model->save());
        }

        $autoBrands = AutoBrand::find()
            ->select(['title'])
            ->indexBy('id')
            ->column();

        return $this->render('add-car', [
            'model' => $model,
            'brands' => $autoBrands,
        ]);

    }

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new ProfileForm;

        if (Yii::$app->request->isPost) {
            $phone_number = Yii::$app->request->post('phone_number');
            $drive_license = Yii::$app->request->post('drive_license');
            $passport = Yii::$app->request->post('passport');

            $u = User::findOne(Yii::$app->user->identity->getId());
            $u->phone_number = $phone_number;
            $u->drive_license = $drive_license;
            $u->passport = $passport;

            if (!is_null($drive_license) && !is_null($passport)) {
                $u->is_verified = true;
            }

            return $this->asJson($u->save());
        }

        return $this->render('profile', [
            'model' => $model,
            'user' => Yii::$app->user->identity,
        ]);

    }

    public function actionGetModels()
    {
        if (Yii::$app->user->isGuest) {
            return $this->response->setStatusCode(403);
        }

        if (Yii::$app->request->isPost) {
            $brand = Yii::$app->request->post('brand');

            include_once '../assets/Utils.php';

            extractModels($brand, function ($models) {
                return $this->asJson($models);
            });
        }
    }

    public function actionGetCar()
    {
        if (Yii::$app->user->isGuest) {
            return $this->response->setStatusCode(403);
        }

        if (Yii::$app->request->isPost) {
            $pubID = Yii::$app->request->post('publicID');

            return $this->asJson(Auto::find()->where(['public_id' => $pubID])->one());
        }
    }

    public function actionGetGroup()
    {
        if (Yii::$app->user->isGuest) {
            return $this->response->setStatusCode(403);
        }

        if (Yii::$app->request->isPost) {
            $pubID = Yii::$app->request->post('publicID');

            $full_info = [
                'data' => Team::find()->where(['id' => $pubID])->one(),
                'users' => [],
                'cars' => [],
            ];

            $tu = TeamUser::find()->where(['team' => $pubID])->limit(3)->all();
            $tc = TeamCar::find()->where(['team' => $pubID])->all();

            foreach ($tu as $item) {
                $full_info['users'][] = User::find()->where(['id' => $item->user])->one();
            }

            foreach ($tc as $item) {
                $full_info['cars'][] = Auto::find()->where(['id' => $item->auto])->one();
            }

            return $this->asJson($full_info);
        }
    }

    public function actionWriteRent()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isPost) {
            $dt = Yii::$app->request->post('date_take');
            $auto = Yii::$app->request->post('auto');
            $lih = Yii::$app->request->post('long_in_hours');

            $r = new Rent();
            $r->user = Yii::$app->user->identity->getId();
            $r->auto = $auto;
            $r->date_take = $dt;
            $r->long_in_hours = $lih;

            return $r->save();
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->response->setStatusCode(403);
        }

        $model = new LoginForm();

        if (Yii::$app->request->isPost) {
            $model->credential = Yii::$app->request->post('credential');

            return $this->asJson($model->login());
        }

        return $this->render('login', [
            'model' => $model,
        ]);

    }

    public function actionLoginPassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->response->setStatusCode(403);
        }

        if (Yii::$app->request->isPost) {
            $model = new LoginForm();
            $model->credential = Yii::$app->request->post('credential');
            $model->password = Yii::$app->request->post('password');

            return $this->asJson($model->checkPassword());
        }
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->response->setStatusCode(204);
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            return $this->asJson($model->write());
        }

        return $this->render('signup', [
            'model' => $model,
        ]);

    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('login');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
