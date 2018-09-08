<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TaskSearch represents the model behind the search form about `common\models\Task`.
 */
class TaskSearch extends Task
{

    public $boardFilter = [
        'show_backlog' => 0,
        'show_kanban' => 0,
        'show_completed' => 0
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'ticket_id', 'user_id', 'completed', 'due_date'], 'integer'],
            [['title', 'description'], 'safe'],
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


    protected function setBoardFilterValue($params)
    {
        foreach ($this->boardFilter as $boardSectionName => $value) {
            if (isset($params['boardFilter'][$boardSectionName]) && (int)$params['boardFilter'][$boardSectionName] > 0) {
                $this->boardFilter[$boardSectionName] = 1;
            } else {
                $this->boardFilter[$boardSectionName] = 0;
            }
        }
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

        $this->setBoardFilterValue($params);

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

        $allTicketIds = $this->getAllBoardSectionTicketIds();
        if (count($allTicketIds)) {
            $query->andfilterWhere(['ticket_id' => $allTicketIds]);
        } else {
            $currentActiveBoard = Board::getCurrentActiveBoard();
            $query->andFilterWhere(['board_id' => $currentActiveBoard->id]);
        }

        return $dataProvider;
    }

    protected function getAllBoardSectionTicketIds()
    {
        $ticketsIdArray = [];
        foreach ($this->boardFilter as $boardSectionName => $value) {
            if ($value) {
                $ticketsInSection = $this->getBoardSectionTicketIds($boardSectionName);
                if ($ticketsInSection) {
                    foreach ($ticketsInSection as $sectionTicket) {
                        $ticketsIdArray[] = $sectionTicket->id;
                    }
                }
            }
        }

        return $ticketsIdArray;
    }

    protected function getBoardSectionTicketIds($boardSection)
    {
        $returnValue = null;
        switch ($boardSection) {
            case 'show_backlog':
                $returnValue = Ticket::findTicketsInBacklog()->all();
                break;
            case 'show_kanban':
                $returnValue = Ticket::findTicketsInKanBan()->all();
                break;
            case 'show_completed':
                $returnValue = Ticket::findTicketsInCompleted()->all();
                break;
        }

        return $returnValue;
    }
}
