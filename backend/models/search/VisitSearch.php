<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Visit;

/**
 * VisitSearch represents the model behind the search form of `common\models\Visit`.
 */
class VisitSearch extends Visit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'launch_id', 'user_id'], 'integer'],
            [['ip', 'user_agent'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
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
    public function search($params)
    {
        $query = Visit::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'launch_id' => $this->launch_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['ilike', 'ip', $this->ip])
            ->andFilterWhere(['ilike', 'user_agent', $this->user_agent]);

        return $dataProvider;
    }
}
