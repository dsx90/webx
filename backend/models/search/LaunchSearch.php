<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\Launch;

/**
 * LaunchSearch represents the model behind the search form about `common\models\Launch`.
 */
class LaunchSearch extends Launch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'status', 'author_id', 'updater_id', 'published_at', 'created_at', 'updated_at', 'content_type_id'], 'integer'],
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
        $query = Launch::find();

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
            'status' => $this->status,
            'author_id' => $this->author_id,
            'updater_id' => $this->updater_id,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'content_type_id' => $this->content_type_id
        ]);

//        $query
//            ->andFilterWhere(['like', 'meta.title', $this->meta->title])
//            ->andFilterWhere(['like', 'meta.long_title', $this->meta->long_title])
//            ->andFilterWhere(['like', 'meta.description', $this->meta->description])
//            ->andFilterWhere(['like', 'meta.keywords', $this->meta->keywords])
//            ->andFilterWhere(['like', 'meta.menutitle', $this->meta->menutitle])
//            ->andFilterWhere(['like', 'meta.slug', $this->meta->slug]);

        return $dataProvider;
    }
}
