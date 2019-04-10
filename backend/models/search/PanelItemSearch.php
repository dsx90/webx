<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PanelItem;

/**
 * PanelItemSearch represents the model behind the search form of `common\models\PanelItem`.
 */
class PanelItemSearch extends PanelItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'panel_id', 'sort', 'status'], 'integer'],
            [['visible', 'title', 'description', 'icon', 'url', 'options', 'key', 'slug', 'richtext'], 'safe'],
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
        $query = PanelItem::find();

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
            'parent_id' => $this->parent_id,
            'panel_id' => $this->panel_id,
            'sort' => $this->sort,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'visible', $this->visible])
            ->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'icon', $this->icon])
            ->andFilterWhere(['ilike', 'url', $this->url])
            ->andFilterWhere(['ilike', 'options', $this->options])
            ->andFilterWhere(['ilike', 'key', $this->key])
            ->andFilterWhere(['ilike', 'slug', $this->slug])
            ->andFilterWhere(['ilike', 'richtext', $this->richtext]);

        return $dataProvider;
    }
}
