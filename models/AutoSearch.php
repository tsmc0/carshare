<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Auto;

/**
 * AutoSearch represents the model behind the search form of `app\models\Auto`.
 */
class AutoSearch extends Auto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date_create', 'owner', 'color', 'is_visible'], 'integer'],
            [['public_id', 'preview', 'num_plate', 'mark', 'model', 'coast_per_hour'], 'safe'],
        ];
    }

    public static function tableName()
    {
        return 'auto';
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
        $query = Auto::find();

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
            'date_create' => $this->date_create,
            'owner' => $this->owner,
            'color' => $this->color,
            'is_visible' => $this->is_visible,
        ]);

        $query->andFilterWhere(['like', 'public_id', $this->public_id])
            ->andFilterWhere(['like', 'preview', $this->preview])
            ->andFilterWhere(['like', 'num_plate', $this->num_plate])
            ->andFilterWhere(['like', 'mark', $this->mark])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'coast_per_hour', $this->coast_per_hour]);

        return $dataProvider;
    }
}
