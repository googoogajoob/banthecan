<?php

namespace frontend\controllers;

use Yii;
use common\models\Board;
use common\models\Ticket;
use common\models\TicketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * TicketController implements the CRUD actions (and other actions) for the Ticket model.
 */
class TicketController extends Controller {

    /* This is needed in the views and in the controller,
     it is placed here in the controller as a central reference point */
    const TICKET_HTML_PREFIX = 'ticketwidget_';
    const MOVE_VIEW_ACTION_MESSAGE = 'This is only allowed per Ajax';

    public function behaviors() {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Reorder the tickets of one column per ajax
     * @return mixed
     * @throws MethodNotAllowedHttpException (405) when not called via ajax
     */
    public function actionReorder()
    {
        $changedColumnTicketId = -1; // Starting value indicates no ticket has changed columns
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $columnId = $request->post('columnId');
            $ticketOrder = $request->post('ticketOrder');
            foreach ($ticketOrder as $ticketOrderKey => $ticketId) {
                $ticket = Ticket::findOne($ticketId);
                $ticket->ticket_order = $ticketOrderKey;
                $ticket->column_id = intval($columnId);

                if (array_key_exists('column_id', $ticket->getDirtyAttributes())) {
                    $changedColumnTicketId = $ticketId;
                }

                if ($ticket->update() === false) {
                    yii::error("Ticket Reordering Error: Column:$columnId, Ticket:$ticketId, Order:$ticketOrderKey");
                }
            }

            if ($changedColumnTicketId > 0) {
                $ticket = Ticket::findOne($changedColumnTicketId);
                $ticketHtmlId = '#' . static::TICKET_HTML_PREFIX . $changedColumnTicketId;
                $ticketHtml = $this->renderFile('@frontend/views/ticket/partials/single/_ticketSingle.php',
                    [
                        'model' => $ticket,
                        'showKanBanAvatar' => isset(Yii::$app->params['showKanBanAvatar']) ? Yii::$app->params['showKanBanAvatar'] : true,
                        'fixedHeightTicketView' => false,
                    ]);
            } else {
                $ticketHtmlId = 0; //indicates no column change to the client
                $ticketHtml = '';
            }

            Yii::$app->response->format = 'json';

            return ['ticketId' => $ticketHtmlId, 'ticketHtml' => $ticketHtml];

        } else {
            throw new MethodNotAllowedHttpException;
        }
    }

    /**
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setPagination(['pageSize' => 10]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ticket model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        Yii::$app->getUser()->setReturnUrl(Yii::$app->request->getReferrer());
        $request = Yii::$app->request;
        if ($request->isAjax) {
            return $this->renderAjax('view', ['model' => $this->findModel($id),'modalFlag' => true]);
        } else {
            return $this->render('view', ['model' => $this->findModel($id),'modalFlag' => false]);
        }
    }

    /**
     * Displays the movement options of a single Ticket.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionMove($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            return $this->renderAjax('move', ['model' => $this->findModel($id),'modalFlag' => true]);
        } else {
            return $this->render('move', ['model' => $this->findModel($id),'modalFlag' => false]);
        }
    }

    /**
     * Duplicates an existing Ticket model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id id of the ticket to be duplicated
     * @return mixed
     */
    public function actionCopy($id)
    {
        Yii::$app->getUser()->setReturnUrl(Yii::$app->request->getReferrer());
        $originalModel = $this->findModel($id);
        if ($originalModel) {
            $originalModel->setIsNewRecord(true);
            $originalModel->title = 'Copy: ' . $originalModel->title;
            $originalModel->id = 0;
            $originalModel->moveToBacklog();
            if ($originalModel->save(false)) {
                Yii::$app->getSession()->setFlash('success', 'A copy of the ticket has been created in the backlog: <em>' . $originalModel->title . '</em>');
            } else {
                Yii::$app->getSession()->setFlash('error', 'A problem occurred when copying the ticket.');
            }
        }

        return $this->goBack();
    }

    /**
     * Creates a new Ticket model.Normal and Ajax/Modal requests
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate() {

        $model = new Ticket();
        $model->board_id = Board::getCurrentActiveBoard()->id; //A new ticket belongs to the current active board
        $model->moveToBacklog(); //A new ticket always starts in the backlog
        $request = Yii::$app->request;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack();
        } else {
            Yii::$app->getUser()->setReturnUrl($request->getReferrer());
            if ($request->isAjax) {
                Url::remember($request->getReferrer());
                return $this->renderAjax('create', ['model' => $model, 'modalFlag' => true]);
            } else {
                return $this->render('create', ['model' => $model, 'modalFlag' => false]);
            }
        }
    }

    /**
     * Updates an existing Ticket model.
     * The browser will be redirected to the 'backlog' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack();
        } else {
            Yii::$app->getUser()->setReturnUrl(Yii::$app->request->getReferrer());
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Increases the vote_priority of an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionPlus($id)
    {
        $model = $this->findModel($id);
        $model->incrementVotePriority()->save();

        if ($model->hasErrors('vote_priority')) {
            Yii::$app->getSession()->setFlash('error', $model->getErrors('vote_priority'));
        }

        return $this->goBack();
    }

    /**
     * Increases the vote_priority of an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionMinus($id)
    {
        $model = $this->findModel($id);
        $model->decrementVotePriority()->save();

        if ($model->hasErrors('vote_priority')) {
            Yii::$app->getSession()->setFlash('error',
                $model->getErrors('vote_priority')
            );
        }

        return $this->goBack();
    }

    /**
     * Deletes an existing Ticket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->getUser()->setReturnUrl(Yii::$app->request->getReferrer());
        $this->findModel($id)->delete();

        return $this->goBack();
    }

    /**
     * Moves a Ticket to the KanBanBoard
     * The browser will be returned to the calling page.
     * @param integer $id
     * @return mixed
     */
    public function actionBoard($id) {

        $this->findModel($id)->moveToKanBanBoard()->save();

        return $this->goBack();
    }

    /**
     * Moves a Ticket to Completed 'Backlog'
     * The browser will be returned to the calling page.
     * @param integer $id
     * @return mixed
     */
    public function actionCompleted($id) {

        $this->findModel($id)->moveToCompleted()->save();

        return $this->goBack();
    }

    /**
     * Moves a Ticket to the Backlog
     * The browser will be returned to the calling page.
     * @param integer $id
     * @return mixed
     */
    public function actionBacklog($id) {

        $this->findModel($id)->moveToBacklog()->save();

        return $this->goBack();
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {

        if (($model = Ticket::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionMerge()
    {
        $mergeCandidateId  = Yii::$app->request->post('mergeCandidateId');
        $mergeCandidates = Ticket::findAll(['id' => $mergeCandidateId]);

        $model = new Ticket();
        $model->board_id = Board::getCurrentActiveBoard()->id; //A new ticket belongs to the current active board
        $model->moveToBacklog(); //A new ticket always starts in the backlog

        $firstLoop = true;
        $newTitle = '';
        $newDescription = '';
        $newTagNames = '';
        foreach ($mergeCandidates as $mergeCandidate) {
            $newTitle .= ($firstLoop ? '' : ' ') . $mergeCandidate->title;
            $newDescription .= ($firstLoop ? '' : ' ') . $mergeCandidate->description;
            $newTagNames .= ($firstLoop ? '' : ', ') . $mergeCandidate->tagNames;
            $firstLoop = false;
        }

        $model->title = 'Merge: ' . $newTitle;
        $model->description = $newDescription;
        $model->tagNames = $newTagNames;

        if ($model->save()) {
            foreach ($mergeCandidates as $mergeCandidate) {
                $mergeCandidate->delete();
            }
        }

        return $this->redirect(['board/backlog']);
    }
}
