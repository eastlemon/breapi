<?php

namespace app\modules\admin\controllers;

use app\models\Inn;
use app\modules\admin\models\search\FioSearch;
use app\modules\admin\models\search\InnSearch;
use app\modules\admin\models\search\PhoneSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InnController implements the CRUD actions for Inn model.
 */
class InnController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Inn models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new InnSearch();
        $searchModel->id_user = Yii::$app->user->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Phone model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $fioSearch = new FioSearch();
        $fioProvider = $fioSearch->search($this->request->queryParams);

        $phoneSearch = new PhoneSearch();
        $phoneProvider = $phoneSearch->search($this->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'fioSearch' => $fioSearch,
            'fioProvider' => $fioProvider,
            'phoneSearch' => $phoneSearch,
            'phoneProvider' => $phoneProvider,
        ]);
    }

    /**
     * Updates an existing Inn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Inn model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Inn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Inn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inn::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
