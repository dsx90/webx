<?php

namespace common\modules\tehnic\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\tehnic\models\TehnicOption;

/**
 * TehnicCustomerOption represents the model behind the search form about `common\modules\tehnic\models\TehnicOption`.
 */
class TehnicCustomerOptionSearch extends TehnicOption
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_id'], 'integer'],
            [['option', 'scale'], 'safe'],
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
        $query = TehnicOption::find();

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
            'option_id' => $this->option_id,
        ]);

        $query->andFilterWhere(['like', 'option', $this->option])
            ->andFilterWhere(['like', 'scale', $this->scale]);

        return $dataProvider;
    }
}
