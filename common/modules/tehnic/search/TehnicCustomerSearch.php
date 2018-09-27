<?php

namespace common\modules\tehnic\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\tehnic\models\TehnicCustomer;

/**
 * TehnicCustomerSearch represents the model behind the search form about `common\modules\tehnic\models\TehnicCustomer`.
 */
class TehnicCustomerSearch extends TehnicCustomer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'order_id', 'work_time', 'order_time', 'order_on_time', 'value_work', 'percent'], 'integer'],
            [['address'], 'safe'],
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
        $query = TehnicCustomer::find();

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
            'customer_id' => $this->customer_id,
            'order_id' => $this->order_id,
            'work_time' => $this->work_time,
            'order_time' => $this->order_time,
            'order_on_time' => $this->order_on_time,
            'value_work' => $this->value_work,
            'percent' => $this->percent,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
