<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ContextKey;

/**
 * ContextKeySearch represents the model behind the search form of `common\models\ContextKey`.
 */
class ContextKeySearch extends ContextKey
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['context_id'], 'integer'],
            [['namespace', 'title', 'description', 'key', 'value'], 'safe'],
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
        $query = ContextKey::find();

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
            'context_id' => $this->context_id,
        ]);

        $query->andFilterWhere(['ilike', 'namespace', $this->namespace])
            ->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'key', $this->key])
            ->andFilterWhere(['ilike', 'value', $this->value]);

        return $dataProvider;
    }
}
