<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

//use common\models\Ticket;

/**
 * TicketSearch represents the model behind the search form about `common\models\Ticket`.
 */
class TicketSearch extends Ticket {

    /* Combined search value for searching in description and title */
    public $text_search;
    public $from_date;
    public $to_date;
    public $user_search = [];
    public $tag_search;

    /**
     * @inheritdoc
     */
    public function rules() {

        return [
            [['from_date', 'to_date'], 'default', 'value' => null],
            [['from_date'], 'date', 'timestampAttribute' => 'from_date'],
            [['to_date'], 'date', 'timestampAttribute' => 'to_date'],
            [['text_search', 'user_search', 'tag_search'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {

        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param boolean $searchPool (-1 Completed, 0 Backlog, otherwise all)
     *
     * @return ActiveDataProvider
     */
    public function search($params, $searchPool = null) {

        switch ($searchPool) {
            case -1:
                $query = self::findCompleted();
                break;
            case 0:
                $query = self::findBacklog();
                break;
            default:
                $query = self::find();
                break;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            $query->where('0=1');

            return $dataProvider;
        }

        // If Create From Date given add to query
        $query->andFilterWhere(['>=', 'created_at', $this->from_date]);
        // If Created To Date given add to query
        $query->andFilterWhere(['<=', 'created_at', $this->to_date]);
        // If Text search given, search for text in title and description
        $query->andFilterWhere([
                'or',
                ['like', 'title', $this->text_search],
                ['like', 'description', $this->text_search],
                ['like', 'protocol', $this->text_search],
            ]
        );
        // If Users selected, restrict ticket search to the selected users (as created by)
        $query->andFilterWhere(['created_by' => $this->user_search]);

        if (trim($this->tag_search) <> '') {
            $query->andFilterWhere(['id' => Tags::getTicketId($this->tag_search)]);
        }

        return $dataProvider;
    }
}
