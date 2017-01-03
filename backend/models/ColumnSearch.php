<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Column;

/**
 * TagsSearch represents the model behind the search form about `common\models\Tags`.
 */
class ColumnSearch extends Column
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		[['id', 'board_id'], 'integer'],
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
		$query = Column::find();

		$dataProvider = new ActiveDataProvider([
            'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		$query->andFilterWhere([
            'board_id' => $this->board_id,
		]);

		return $dataProvider;
	}
}
