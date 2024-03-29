<?php

namespace app\modules\admin\controllers;

use app\models\Tag;
use app\modules\admin\models\forms\UploadForm;
use Yii;
use yii\base\Exception;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class LoadController extends Controller
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception|\Throwable
     */
    public function actionIndex(): Response|string
    {
        $form = new UploadForm();
        $form->format = 'Surname,Name,Patronymic,INN,@,Phone';

        if ($form->load(Yii::$app->request->post())) {
            $form->sheedFiles = UploadedFile::getInstances($form, 'sheedFiles');

            if ($form->upload()) return $this->redirect(['index']);
        }

        $start_year = Yii::$app->settings->get('common', 'start_year') ?? '2017';

        $years = array_combine(range(date('Y'), $start_year), range(date('Y'), $start_year));

        return $this->render('index', [
            'model' => $form,
            'tags' => ArrayHelper::map(Tag::find()->all(), 'id', 'name'),
            'years' => $years,
        ]);
    }

    public function actionCheck(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$count = (new Query())->from('queue')->count()) {
            $count = '0';
        }

        return ['result' => $count];
    }
}
