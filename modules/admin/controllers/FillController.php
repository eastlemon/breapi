<?php

namespace app\modules\admin\controllers;

use app\models\File;
use app\modules\admin\models\forms\FillForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class FillController extends Controller
{
    public function actionIndex(): Response|string
    {
        $form = new FillForm();
        $form->format = 'Surname,Name,Patronymic,INN,@,Phone';

        if ($form->load(Yii::$app->request->post())) {
            $form->sheedFile = UploadedFile::getInstance($form, 'sheedFile');

            if ($form->upload()) return $this->redirect(['index']);
        }

        $query = File::find()->where(['id_user' => Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('index', [
            'model' => $form,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCheck(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

//        if (!$count = Yii::$app->redis->executeCommand('PUBSUB', ['filler.messages'])) {
//            $count = '0';
//        }

        if (!$count = Yii::$app->redis->lrange('filler.waiting', 0, 0)) {
            $count = '0';
        }

        return ['result' => $count];
    }
}
