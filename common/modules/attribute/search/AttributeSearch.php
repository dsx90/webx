<?php

namespace common\modules\attribute\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\attribute\models\Attribute;

/**
 * AttributeSearch represents the model behind the search form of `common\modules\attribute\models\Attribute`.
 */
class AttributeSearch extends Attribute
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'max', 'sort'], 'integer'],
            [['name', 'description', 'scale'], 'safe'],
            [['required'], 'boolean'],
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
        $query = Attribute::find();

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
            'required' => $this->required,
            'type' => $this->type,
            'max' => $this->max,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'scale', $this->scale]);

        return $dataProvider;
    }
}
