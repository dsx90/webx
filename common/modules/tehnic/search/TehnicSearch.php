<?php

namespace common\modules\tehnic\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\tehnic\models\Tehnic;

/**
 * TehnicSearch represents the model behind the search form about `common\modules\tehnic\models\Tehnic`.
 */
class TehnicSearch extends Tehnic
{
    public $price_min;
    public $price_max;

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['launch.parent.title', 'launch.title']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['launch_id', 'status', 'views', 'price', 'price_min', 'price_max'], 'integer'],
            [['launch.title', 'launch.parent.title'], 'safe'],
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
        $query = Tehnic::find();
        $query->joinWith([
            'launch',
            'launch.parent as parent'
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['price'] = [
            'asc' => ['price' => SORT_ASC],
            'desc' => ['price' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['launch.title'] = [
            'asc' => ['launch.title' => SORT_ASC],
            'desc' => ['launch.title' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['launch.parent.title'] = [
            'asc' => ['parent.title' => SORT_ASC],
            'desc' => ['parent.title' => SORT_DESC],
        ];

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
            'status' => $this->status,
            'views' => $this->views,
        ]);

        $query  ->andFilterWhere(['LIKE', 'parent.title', $this->getAttribute('launch.parent.title')])
                ->andFilterWhere(['LIKE', 'launch.title', $this->getAttribute('launch.title')])
                ->andFilterWhere(['>=', 'price', $this->price_min])
                ->andFilterWhere(['<=', 'price', $this->price_max])
        ;

        return $dataProvider;
    }
}
