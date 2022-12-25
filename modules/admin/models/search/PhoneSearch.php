<?php

namespace app\modules\admin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Phone;

/**
 * PhoneSearch represents the model behind the search form of `app\models\Phone`.
 */
class PhoneSearch extends Phone
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id_inn', 'year'], 'integer'],
            [['phone'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(int $inn, array $params): ActiveDataProvider
    {
        $query = Phone::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_inn' => $inn,
            'year' => $this->year,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
