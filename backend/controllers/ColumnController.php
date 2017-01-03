<?php

namespace backend\controllers;

use Yii;
use common\models\Column;
use backend\models\ColumnSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\filters\VerbFilter;

/**
 * BoardColumnController implements the CRUD actions for BoardColumn model.
 */
class ColumnController extends Controller
{
	public function behaviors()
	{
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
	 * Reorder the columns display order per ajax
	 * @return mixed
	 * @throws MethodNotAllowedHttpException (405) when not called via ajax
	 */
	public function actionReorder()
	{
		$request = Yii::$app->request;
		if ($request->isAjax) {
			$displayOrder = $request->post('displayOrder');
			$newColumnOrder = 1;
			foreach ($displayOrder as $displayOrderKey => $columnId) {
				$column = Column::findOne($columnId);
				$column->display_order = $newColumnOrder;
				//$junk = $column->name;
				//$column->name = $junk;
				if ($column->update() === false) {
					yii::error("Ticket Reordering Error: Column:$columnId, Ticket:$ticketId, Order:$ticketOrderKey");
				}
				$newColumnOrder++;
			}
		} else {
			throw new MethodNotAllowedHttpException;
		}
	}

	/**
	 * Lists all BoardColumn models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new ColumnSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//		$dataProvider = new ActiveDataProvider([
//            'query' => Column::find()->orderBy('display_order'),
//            'sort' => false,
//		]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single BoardColumn model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
            'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new BoardColumn model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Column();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
                'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing BoardColumn model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
                'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing BoardColumn model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Column model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return BoardColumn the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Column::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
