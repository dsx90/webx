<?php

namespace common\modules\tehnic\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\tehnic\models\TehnicCat;

/**
 * TehnicCatSearch represents the model behind the search form about `common\modules\tehnic\models\TehnicCat`.
 */
class TehnicCatSearch extends TehnicCat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['launch_id'], 'integer'],
            [['content', 'thumbnail', 'thumbnail_base_url', 'thumbnail_path'], 'safe'],
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
        $query = TehnicCat::find();

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
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'thumbnail', $this->thumbnail])
            ->andFilterWhere(['like', 'thumbnail_base_url', $this->thumbnail_base_url])
            ->andFilterWhere(['like', 'thumbnail_path', $this->thumbnail_path]);

        return $dataProvider;
    }
}
