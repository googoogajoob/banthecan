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
    public function actionReorder() {

        $changedColumnTicketId = -1; // Starting value indicates no ticket has changed columns

        $request = Yii::$app->request;
        if ($request->isAjax) {
            session_write_close(); // !!! Important, otherwise there is blocking among server sessions
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
                $ticketDecorationHtml = $this->renderFile('@frontend/views/ticket/partials/_ticketDecorations.php',
                    ['ticket' => $ticket, 'showDiv' => false]);
            } else {
                $ticketHtmlId = 0; //indicates no column change to the client
                $ticketDecorationHtml = '';
            }

            Yii::$app->response->format = 'json';

            return ['ticketId' => $ticketHtmlId, 'decorationHtml' => $ticketDecorationHtml];

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
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            return $this->renderAjax('view', ['model' => $this->findModel($id),'modalFlag' => true]);
        } else {
            return $this->render('view', ['model' => $this->findModel($id),'modalFlag' => false]);
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
        $originalModel = $this->findModel($id);
        if ($originalModel) {
            $originalModel->setIsNewRecord(true);
            $originalModel->title = 'Copy - ' . $originalModel->title;
            $originalModel->id = 0;
            $originalModel->moveToBacklog();
            if ($originalModel->save(false)) {
                Yii::$app->getSession()->setFlash('success', 'A copy of the ticket is in the backlog');
                return $this->redirect(['view', 'id' => $originalModel->id]);
            } else {
                Yii::$app->getSession()->setFlash('error', 'A problem occurred when copying the ticket.');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Creates a new Ticket model.Normal and Ajax/Modal requests
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate() {

        $model = new Ticket();
        $model->board_id = Board::getActiveBoard()->id; //A new ticket belongs to the current active board
        $model->moveToBacklog(); //A new ticket always starts in the backlog
        $request = Yii::$app->request;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($request->getBodyParam('modalFlag')) {
                return $this->redirect(Url::previous());
            } else {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
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
    public function actionUpdate($id) {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                //                'returnUrl' => Yii::$app->request->getReferrer(),
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
            Yii::$app->getSession()->setFlash('error',
                $model->getErrors('vote_priority')
            );
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
    public function actionDelete($id) {

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
}
