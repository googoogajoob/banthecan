<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;

/**
 * Upload a CSV File into the Tickets table
 *
 * Class CsvController
 * @package console\controllers
 */
class CsvController extends \yii\console\Controller
{
	/**
	 * @var string controller default action ID.
	 */
	public $defaultAction = 'dry';

	protected $inputFileHandle = null;
	public $tableName = null;
	public $userId = null;
	protected $columns = null;

	/**
	 * @inheritdoc
	 */
	public function options($actionID)
	{
		return array_merge(
		parent::options($actionID),
		['tableName', 'userId'] // global for all actions
		);
	}

	/**
	 * Perform a Dry Run of the Upload
	 *
	 * @return string
	 */
	public function actionDry($inputFile)
	{
		$this->stdout("Dry Run ...\n\n");
		$this->getInputFileHandle($inputFile);

		if (!$this->validateInputParameters()) {
			return static::EXIT_CODE_ERROR;
		}

		$this->showParameters();

		$this->stdout("CSV Records ...\n");
		while ($csvLine = $this->getInputLine()) {
			$this->showInputLine($csvLine);
		}

		return static::EXIT_CODE_NORMAL;
	}

	protected function showInputLine($csvLine)
	{
		$this->stdout(implode(',', $csvLine) . "\n");
	}

	/**
	 *
	 */
	protected function showParameters()
	{
		$this->stdout("Upload Parameters\n");
		$this->stdout("SQL Table: $this->tableName\n");
		$this->stdout("User ID  : $this->userId\n");
		$columns = implode(',', $this->columns);
		$this->stdout("Columns  : $columns\n\n");
	}

	/**
	 * Perform the Upload
	 *
	 * @return string
	 */
	public function actionUpload($inputFile)
	{
		$this->stdout("Uploading ...\n\n");
		$this->getInputFileHandle($inputFile);

		if (!$this->validateInputParameters()) {
			return static::EXIT_CODE_ERROR;
		}

		$this->showParameters();

		while ($csvLine = $this->getInputLine()) {
			$this->saveInputLine($csvLine);
		}

		return static::EXIT_CODE_NORMAL;
	}

	protected function saveInputLine($csvLine)
	{
		$sqlCommand = Yii::$app->db->createCommand()
		->insert(
		$this->tableName,
		$this->mergeInputFields($csvLine));

		//$this->stdout($sqlCommand->getSql() . "\n");
		$sqlCommand->execute();
	}

	protected function mergeInputFields($csvLine)
	{
		$inputFields = array_combine($this->columns, $csvLine);
		$secondaryParameters = [
            'created_by' => $this->userId,
            'updated_by' => $this->userId,
            'created_at' => time(),
            'updated_at' => time(),
		];

		return array_merge($inputFields, $secondaryParameters);
	}

	protected function validateInputParameters()
	{
		if (!$this->inputFileHandle) {
			$this->stdout("Cannot open input file\n");
			return false;
		}
		if (!$this->tableName) {
			$this->stdout("SQL Table not specified\n");
			return false;
		}
		if (!$this->columns) {
			$this->stdout("Table columns not specified\n");
			return false;
		}
		if (!$this->userId) {
			$this->stdout("User-Id not specified\n");
			return false;
		}

		return true;
	}

	protected function getInputFileHandle($fileName) {

		if (file_exists($fileName)) {
			$this->inputFileHandle = fopen($fileName, 'r');
			$this->columns = $this->getInputLine();
			$this->columns = array_map('trim', $this->columns);
		}

		return $this->inputFileHandle;
	}

	protected function getInputLine()
	{
		return fgetcsv($this->inputFileHandle);
	}
}
