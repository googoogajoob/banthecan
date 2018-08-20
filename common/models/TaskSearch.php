<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TaskSearch represents the model behind the search form about `common\models\Task`.
 */
class TaskSearch extends Task
{

    public $show_backlog = 0;
    public $show_kanban = 1;
    public $show_completed = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'ticket_id', 'user_id', 'completed', 'due_date'], 'integer'],
            [['title', 'description', 'show_backlog', 'show_kanban', 'show_completed'], 'safe'],
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
        $query = Task::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!isset($params['TaskSearch']['completed'])) {
            $params['TaskSearch']['completed'] = "0";
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ticket_id' => $this->ticket_id,
            'user_id' => $this->user_id,
            'completed' => $this->completed,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
              ->andFilterWhere(['like', 'description', $this->description]);

        $kanBanFilterActive = false;
        if ($kanBanFilterActive) {
            $ticketsInKanBan = Ticket::findTicketsInKanBan();
            $ticketsInKanBanIdArray = [];
            foreach ($ticketsInKanBan as $kanBanTicket) {
                $ticketsKanBanIdArray[] = $kanBanTicket->id;
            }

            if (count($ticketsKanBanIdArray)) {
                $query->andFilterWhere(['ticket_id' => $ticketsKanBanIdArray]);
            }
        }

        return $dataProvider;
    }
}
