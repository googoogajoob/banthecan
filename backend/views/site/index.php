<?php
/* @var $this yii\web\View */
/* @var $activity array */
/* @var $news ActiveRecord */

$this->title = 'Ban the Can Backend';
?>
<div class="site-index">

<div class="jumbotron">
<h1><?php echo \Yii::t('app', 'Ban The Can Administration'); ?></h1>
<p class="lead"><?php echo \Yii::t('app', 'Here you can edit all DB Tables used in the Front End'); ?></p>
</div>

<div class="body-content">

<div class="row">
<div class="col-lg-6">
<h2><?php echo \Yii::t('app', 'Site News'); ?></h2>
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th><?php echo \Yii::t('app', 'Date'); ?></th>
			<th><?php echo \Yii::t('app', 'Event'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach($news as $k => $v) {
		echo '<tr><td>' . Yii::$app->formatter->asDate($v->updated_at, 'long') . '</td><td>' . $v->title . '</td></tr>';
	}
	?>
	</tbody>
</table>
</div>

<div class="col-lg-6">
<h2><?php echo \Yii::t('app', 'Activity - In the previous 7 days'); ?></h2>
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th><?php echo \Yii::t('app', 'Table'); ?></th>
			<th><?php echo \Yii::t('app', 'Updates'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach($activity as $k => $v) {
		echo '<tr><td>' . $k . '</td><td>' . $v . '</td></tr>';
	}
	?>
	</tbody>
</table>
</div>
</div>

</div>
</div>
