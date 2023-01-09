<?php

namespace app\modules\admin\controllers;

use app\models\Fio;
use app\models\Inn;
use app\models\Phone;
use Yii;
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;

class SearchController extends Controller
{
    public function actionIndex(): Response|string
    {
        $model = new DynamicModel(['search']);
        $model->addRule('search', 'required');
        $model->addRule('search', 'string');

        if ($model->load(Yii::$app->request->post())) {
            $innsProvider = new ActiveDataProvider([
                'query' => Inn::find()->where(['like', 'inn', $model->search]),
                'pagination' => [
                    'pageSize' => 10
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC,
                    ]
                ],
            ]);

            $phonesProvider = new ActiveDataProvider([
                'query' => Phone::find()->where(['like', 'phone', $model->search]),
                'pagination' => [
                    'pageSize' => 10
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC,
                    ]
                ],
            ]);

            $fiosProvider = new ActiveDataProvider([
                'query' => Fio::find()->where(['like', 'fio', $model->search]),
                'pagination' => [
                    'pageSize' => 10
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC,
                    ]
                ],
            ]);

            return $this->render('search-result', [
                'inns' => $innsProvider,
                'phones' => $phonesProvider,
                'fios' => $fiosProvider,
            ]);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
