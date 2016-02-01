<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 11/22/15
 * Time: 7:01 PM
 */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

NavBar::begin([
    'brandLabel' => (YII_ENV_DEMO ? 'DEMO: ' : '') . $this->title,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
],
    'innerContainerOptions' => [
        'class' => 'container-fluid'
        ]
        ]);

        if (Yii::$app->user->isGuest) {

        	//$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        	$menuItems[] = ['label' => \Yii::t('app', 'Login'), 'url' => ['/site/login']];
        	$menuItems[] = ['label' => \Yii::t('app', 'Contact'), 'url' => ['/site/contact']];
        	$menuItems[] = ['label' => \Yii::t('app', 'About'), 'url' => ['/site/about']];

        } else {

        	$menuItems = [
        	['label' => 'Data',
            'items' => [
        	['label' => \Yii::t('app', 'Tickets'), 'url' => ['/ticket']],
        	['label' => \Yii::t('app', 'Tags'), 'url' => ['/tags']],
        	],
        	],
        	];

        	$menuItems[] = ['label' => \Yii::t('app', 'Ban The Can'), 'items' => [
        	['label' => \Yii::t('app', 'Select Board'), 'url' => ['/board/select']],
        	['label' => \Yii::t('app', 'Logout'), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
        	['label' => \Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
        	['label' => \Yii::t('app', 'About'), 'url' => ['/site/about']],
        	],
        	];

        	$menuItems[] = html::tag('li',
        	$this->render('@frontend/views/site/partials/_userIcon',['userId' => Yii::$app->getUser()->id]),
        	['class' => 'menu-avatar-li']);

        }

        echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
        ]);

        echo $this->renderFile('@frontend/views/layouts/partials/_header-buttons.php');

        NavBar::end();