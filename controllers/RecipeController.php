<?php

namespace app\controllers;

use app\components\CustomModel;
use app\models\Ingridient;
use app\models\RecIng;
use http\Exception;
use Yii;
use app\models\Recipe;
use app\models\ResipeSearchModel;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecipeController implements the CRUD actions for Recipe model.
 */
class RecipeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        $this->redirect(['/user/login']);
                    } else {
                        throw new ForbiddenHttpException('You are not allowed to access this page');
                    }
                }
            ],
        ];
    }

    /**
     * Lists all Recipe models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new ResipeSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Recipe model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\db\Exception
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $resIngOlds = $model->recIngs;
        foreach ($resIngOlds as $index => $resIngOld) {
            $resIng [] = $resIngOld;
        }
        if (!empty(Yii::$app->request->post('RecIng'))) {
            $resIngs = CustomModel::createMultiple(RecIng::class, $resIng);
            Model::loadMultiple($resIngs, Yii::$app->request->post());
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                foreach ($resIngs as $resIng) {
                    $new = $resIng->save();
                    if (!$new) {
                        throw new \DomainException('New recipe don\'t save');
                    }
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Игридиент успешно обновлен');
                return $this->goHome();
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'An error has occurred. Contact your administrator' . $e->getMessage());
                return $this->goHome();
            }
        }
        return $this->render('view', [
            'model' => $model,
            'resIng' => (empty($resIng)) ? [new RecIng()] : $resIng
        ]);
    }

    /**
     * Creates a new Recipe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new Recipe();
        $ingridient = new Ingridient();
        $resIngrs = [new RecIng()];
        if ($model->load(Yii::$app->request->post())) {
            $resIngrs = CustomModel::createMultiple(RecIng::class, []);
            Model::loadMultiple($resIngrs, Yii::$app->request->post());
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    foreach ($resIngrs as $ingr) {
                        $ingr->res_id = $model->id;
                        $flag = $ingr->save();
                        if (!$flag) {
                            throw new \DomainException('Ingridient don\'t save');
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['index']);
                }
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', 'Error.' . $e->getMessage());
                $transaction->rollBack();
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'ingridient' => $ingridient,
            'resIngrs' => $resIngrs,
        ]);
    }

    /**
     * Updates an existing Recipe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $ingridient = new Ingridient();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'ingridient' => $ingridient,
        ]);
    }

    /**
     * Deletes an existing Recipe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Recipe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recipe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recipe::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
