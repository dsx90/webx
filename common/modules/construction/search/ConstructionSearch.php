<?php

namespace common\modules\construction\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\construction\models\Construction;

/**
 * ConstructionSearch represents the model behind the search form about `common\modules\construction\models\Construction`.
 */
class ConstructionSearch extends Construction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['launch_id', 'price'], 'integer'],
            [['content'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Construction::find();

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
            'launch_id' => $this->launch_id,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
