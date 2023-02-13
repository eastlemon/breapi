<?php

namespace app\modules\admin\controllers;

use app\models\File;
use app\modules\admin\models\forms\FillForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii2tech\spreadsheet\Spreadsheet;

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

        if (!$count = Yii::$app->redis->hlen('filler.messages')) {
            $count = '0';
        }

        return ['result' => $count];
    }

    public function actionDownload(int $id)
    {
        $to_return = null;

        if ($file = File::findOne($id)) {


            $exporter = new Spreadsheet([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => $file->fillers,
                ]),
                'columns' => [
                    'fio',
                    'inn',
                    'phone',
                ],
                'showHeader' => false,
            ]);

            $to_return = $exporter->send($file->name);
        }

        return $to_return;
    }

    public function actionDelete(int $id)
    {
        File::find()->where(['id' => $id])->one()->delete();

        return $this->redirect(['index']);
    }
}
