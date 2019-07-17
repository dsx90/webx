<?php

namespace common\modules\order\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\order\models\Order;

/**
 * OrderSearch represents the model behind the search form of `common\modules\order\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'link_id', 'user_ip_id', 'manager_id', 'comment_id', 'manager_comment_id', 'status', 'created_at', 'update_at'], 'integer'],
            [['table'], 'safe'],
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
        $query = Order::find();

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
            'link_id' => $this->link_id,
            'user_ip_id' => $this->user_ip_id,
            'manager_id' => $this->manager_id,
            'comment_id' => $this->comment_id,
            'manager_comment_id' => $this->manager_comment_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['ilike', 'table', $this->table]);

        return $dataProvider;
    }
}
