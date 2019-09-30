<?php

namespace common\modules\pet\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\pet\models\Pet;

/**
 * PetSearch represents the model behind the search form of `common\modules\pet\models\Pet`.
 */
class PetSearch extends Pet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'ties_id', 'birth_date', 'status'], 'integer'],
            [['name', 'description'], 'safe'],
            [['sex'], 'boolean'],
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
        $query = Pet::find();

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
            'category_id' => $this->category_id,
            'ties_id' => $this->ties_id,
            'sex' => $this->sex,
            'birth_date' => $this->birth_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }
}
