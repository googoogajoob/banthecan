<?php

use yii\helpers\Html;
use yii\bootstrap\Carousel;

//Ticket Decoration Bar displays the Ticket decorations
/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */
/* @var $showTags boolean switch for tags display*/

if ($taglist = $ticket->tagNames) {

	echo Html::beginTag('div',
		[
			'class' => 'ticket-single-tags',
			'data-toggle' => 'tooltip',
            'data-placement' => 'top',
            'title' => str_replace(',', ', ', $taglist),
		]
	);

	$tagArray = explode(',', $taglist);
	$tagCount = count($tagArray);
	$i = 1;
	foreach ($tagArray as $tag) {
		$carouselItems[] = [
            'content' => '',
            'caption' => "$tag&nbsp;&ndash;&nbsp;<small>($i/$tagCount)</small>",
		];
		$i++;
	}

	echo Carousel::widget([
        'items' => $carouselItems,
        'controls' => false,
        'showIndicators' => false,
	]);

	echo Html::endTag('div');

}

?>