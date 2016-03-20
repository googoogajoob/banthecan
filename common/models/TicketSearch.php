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
    const TICKET_SEARCH = 'TicketSearch';

    private $_sessionKey;

    /* Combined search value for searching in description and title */
    public $text_search;
    public $from_date;
    public $to_date;
    public $user_search = [];
    public $tag_search;
    public $vote_priority_filter;

    /**
     * @inheritdoc
     */
    public function rules() {

        return [
            [['from_date', 'to_date'], 'default', 'value' => null],
            [['from_date'], 'date', 'timestampAttribute' => 'from_date'],
            [['to_date'], 'date', 'timestampAttribute' => 'to_date'],
            [['text_search', 'user_search', 'tag_search', 'vote_priority_filter'], 'safe'],
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

        if (array_key_exists(self::TICKET_SEARCH, $params)) {
            $this->load($params);
            $this->saveToSession();
        } else {
            $this->getFromSession();
        }

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

        if ($this->vote_priority_filter) {
            $query->andFilterWhere([
                    'or',
                    ['>', 'vote_priority', 0],
                    ['<', 'vote_priority', 0],
                ]
            );
        }

        return $dataProvider;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text_search' => \Yii::t('app', 'Text Search'),
            'from_date' => \Yii::t('app', 'From Date'),
            'to_date' => \Yii::t('app', 'To Date'),
            'user_search' => \Yii::t('app', 'User Search'),
            'tag_search' => \Yii::t('app', 'Tag Search'),
            'vote_priority_filter' => \Yii::t('app', 'Voted'),
        ];
    }

    public function setSessionKey($key)
    {
        $this->_sessionKey = $key;
    }

    public function saveToSession()
    {
        $value = serialize([
            'text_search' => $this->text_search,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'user_search' => $this->user_search,
            'tag_search' => $this->tag_search,
            'vote_priority_filter' => $this->vote_priority_filter,
        ]);

        Yii::$app->getSession()->set(self::TICKET_SEARCH . '_' . $this->_sessionKey, $value);
    }

    public function getFromSession()
    {
        $value = unserialize(Yii::$app->getSession()->get(self::TICKET_SEARCH . '_' . $this->_sessionKey));

        $this->text_search = isset($value['text_search']) ? $value['text_search'] : '';
        $this->from_date = isset($value['from_date']) ? $value['from_date'] : '';
        $this->to_date = isset($value['to_date']) ? $value['to_date'] : '';
        $this->user_search = isset($value['user_search']) ? $value['user_search'] : '';
        $this->tag_search = isset($value['tag_search']) ? $value['tag_search'] : '';
        $this->vote_priority_filter = isset($value['vote_priority_filter']) ? $value['vote_priority_filter'] : 0;
    }
}
