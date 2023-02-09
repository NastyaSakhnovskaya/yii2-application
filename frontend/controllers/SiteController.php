<?php

namespace frontend\controllers;

use yii\helpers\Html;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Routes;
use frontend\models\Driver;
use frontend\models\Order;
use frontend\models\SearchForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->identity->status == 10 || Yii::$app->user->isGuest) {
            $routes=Routes::find()->limit(3)->all();
    
            return $this->render('index',[
                'routes'=>$routes
            ]);
        } else {
            $driver = Driver::find()->where(['driver_login' => Yii::$app->user->identity->username])->one();

            if(Yii::$app->request->get()['type'] == 'complete') {
                $order= Routes::find()->andWhere(['driver_id'=> $driver->driver_id])->andWhere(['route_status'=> 'complete'])->all();
            } else{
                $order= Routes::find()->andWhere(['driver_id'=> $driver->driver_id])->andWhere(['route_status'=> 'active'])->all();
            }
    

            return $this->render('index',[
                'driver'=>$driver,
                'route'=>$order,
            ]);
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        /* if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        } */

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались.');
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionRoute(){

        if( Yii::$app->request->get()['date']) {
            $route_id = (new \yii\db\Query())
            ->select('route_id')
            ->from('routes')
            ->andWhere(['direction_from' => Yii::$app->request->get()['from']])
            ->andWhere(['direction_to' => Yii::$app->request->get()['to']])
            ->andWhere(['date' => Yii::$app->request->get()['date']])
            ->orderBy('time ASC')
            ->all();
        } else {
            $route_id = (new \yii\db\Query())
            ->select('route_id')
            ->from('routes')
            ->andWhere(['direction_from' => Yii::$app->request->get()['from']])
            ->andWhere(['direction_to' => Yii::$app->request->get()['to']])
            ->orderBy('time ASC')
            ->all();
        }

        if(Yii::$app->request->get()['time']) {
            if(Yii::$app->request->get()['time'] == 'morning') {
                $route = (new \yii\db\Query())
                ->from('routes')
                ->where(['between','time', '05:00:01', '12:00:00'])
                ->andWhere(['route_id' => $route_id])
                ->orderBy('time ASC')
                ->all();
                $route_time = (new \yii\db\Query())->select('route_id')->from('routes')->where(['between','time', '05:00:01', '12:00:00'])->andWhere(['route_id' => $route_id])->all();
            } else if(Yii::$app->request->get()['time'] == 'day') {
                $route = (new \yii\db\Query())
                ->from('routes')
                ->where(['between','time', '12:00:01', '18:00:00'])
                ->andWhere(['route_id' => $route_id])
                ->orderBy('time ASC')
                ->all();
                $route_time = (new \yii\db\Query())->select('route_id')->from('routes')->where(['between','time', '12:00:01', '18:00:00'])->andWhere(['route_id' => $route_id])->all();
            } else {
                $route = (new \yii\db\Query())
                ->from('routes')
                ->where(['between','time', '18:00:01', '24:00:00'])
                ->andWhere(['route_id' => $route_id])
                ->orderBy('time ASC')
                ->all();
                $route_time = (new \yii\db\Query())->select('route_id')->from('routes')->where(['between','time', '18:00:01', '24:00:00'])->andWhere(['route_id' => $route_id])->all();
            }
        }
        
        if(Yii::$app->request->get()['order']) {
            if(Yii::$app->request->get()['order'] == 'asc') {
                $route = (new \yii\db\Query())
                ->from('routes')
                ->andWhere(['route_id' => $route_id])
                ->orderBy('number_of_free_seats ASC')
                ->orderBy('time ASC')
                ->all();
            } else {
                $route = (new \yii\db\Query())
                ->from('routes')
                ->andWhere(['route_id' => $route_id])
                ->orderBy('number_of_free_seats DESC')
                ->orderBy('time ASC')
                ->all();
            }
        }

        if(Yii::$app->request->get()['order'] && Yii::$app->request->get()['time']) {
            if(Yii::$app->request->get()['order'] == 'asc') {
                $route = (new \yii\db\Query())
                ->from('routes')
                ->andWhere(['route_id' => $route_time])
                ->orderBy('number_of_free_seats ASC')
                ->all();
            } else {
                $route = (new \yii\db\Query())
                ->from('routes')
                ->andWhere(['route_id' => $route_time])
                ->orderBy('number_of_free_seats DESC')
                ->all();
            }
        }

        if(!Yii::$app->request->get()['order'] && !Yii::$app->request->get()['time']) {
            $route = (new \yii\db\Query())
            ->from('routes')
            ->andWhere(['route_id' => $route_id])
            ->orderBy('time ASC')
            ->all();
        }
        
        return $this->render('route', [
            'route' => $route,
        ]);
    }

     public function actionSearch(){

        $model=new SearchForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            
            $from = Html::encode($model->from);
            $to = Html::encode($model->to);
            $date = Html::encode($model->date);
            $person = Html::encode($model->person);

            $route = (new \yii\db\Query())
            ->from('routes')
            ->andWhere(['direction_from' => $from])
            ->andWhere(['direction_to' => $to])
            ->andWhere(['>','number_of_free_seats', $person])
            ->andWhere(['date' => $date])
            ->orderBy('time ASC')
            ->all();

            return $this->render('route', [
                'route' => $route,
            ]);
        }else{
            return $this->render('search', [
                'model' => $model,
            ]);
        }

     }
}
