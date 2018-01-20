<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 11/22/15
 * Time: 7:01 PM
 */

use yii\bootstrap\Nav;
use yii\bootstrap\Dropdown;
use apc\rewrite\bootstrap\NavBar;
use yii\helpers\Html;
use common\models\Task;
use common\models\Board;

// Determine $brandLabel and $boardSelector for the options left in the main nav header
$userBoardIds = array(); // default case, no boards (e.g. user not logged in)

if ($userIdentity = Yii::$app->user->getIdentity()) {

    if ($boardId = $userIdentity->board_id) {
        $userBoardIds = explode(',', $boardId);
    }
}

if (count($userBoardIds) > 1) {

    $brandLabel = '<span class="glyphicon glyphicon-home"></span>';
    $selectLabel = (YII_ENV_DEMO ? 'DEMO: ' : '') . $this->title;
    $userBoards = Board::find($userBoardIds)->orderBy('title');
    $userBoards = $userBoards->all();

    $boardSwitchItems = null;
    foreach ($userBoards as $userBoard) {
        $boardSwitchItems[] = [
            'label' => $userBoard->title,
            'url' => ['/board/activate/' . $userBoard->id],
        ];
    }

    $boardSelector[] =
          Html::beginTag('div', ['id' => "apc-board-selector", 'class' => "dropdown navbar-brand"])
        . Html::a($selectLabel . ' <span class="caret"></span>', '#',
              ['data-toggle' => "dropdown", 'class' =>"dropdown-toggle  apc-navbar-brand"])
        . Dropdown::widget(['items' => $boardSwitchItems])
        . Html::endTag('div');

} else {

    $brandLabel = (YII_ENV_DEMO ? 'DEMO: ' : '') . $this->title;
    $boardSelector = null;
}

NavBar::begin([
    'brandLabel'            => $brandLabel,
    'options'               => ['class' => 'navbar-inverse navbar-fixed-top'],
    'innerContainerOptions' => ['class' => 'container-fluid'],
    'additionalHeaders'     => $boardSelector
    ]
);

if (Yii::$app->user->isGuest) {

	$menuItems[] = ['label' => \Yii::t('app', 'Login'), 'url' => ['/site/login']];
	$menuItems[] = ['label' => \Yii::t('app', 'Contact'), 'url' => ['/site/contact']];
	$menuItems[] = ['label' => \Yii::t('app', 'About'), 'url' => ['/site/about']];

} else {

    $dropDownMenuItems = [
        ['label' => \Yii::t('app', 'Tickets'),
            'url' => ['/ticket'],
        ],
		['label' => \Yii::t('app', 'Tags'),
            'url' => ['/tags'],
        ],
		['label' => \Yii::t('app', 'Tasks'),
            'url' => ['/task'],
        ],
		['label' => \Yii::t('app', 'Resolutions'),
            'url' => ['/resolution'],
        ],
		['label' => \Yii::t('app', 'Select Board'),
            'url' => ['/board/select'],
        ],
		['label' => \Yii::t('app', 'Logout'),
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post'],
        ],
		['label' => \Yii::t('app', 'User Settings'),
            'url' => ['/user/view'],
        ],
		['label' => \Yii::t('app', 'Contact'),
            'url' => ['/site/contact'],
        ],
		['label' => \Yii::t('app', 'About'),
            'url' => ['/site/about'],
        ],
		['label' => \Yii::t('app', 'Admin'),
            'url' => ['/admin'],
            //'visible' => Yii::$app->getUser()->isAdmin(),
        ],
    ];

    $menuItems[] = html::tag('li',
        $this->render('@frontend/views/site/partials/_userIcon',
        ['userId' => Yii::$app->getUser()->id]),
        ['class' => 'menu-avatar-li pull-right hidden-xs']);

	$menuItems[] = [
        'label' => \Yii::t('app', 'Menu'),
        'options' => ['class' => 'pull-right hidden-xs'],
        'items' => $dropDownMenuItems,
	];

    // Buttons for convenience Options

    $menuItems[] = Html::a(
        \Yii::t('app', 'New Ticket'),
        '/ticket/create', [
        'class' => 'btn btn-success apc-header-button',
        'id' => 'header-create-button',
        'data-toggle' => 'modal',
        'data-target' => '#global-modal-container'
    ]);

    $menuItems[] = Html::a(
        Board::getBoardSectionName('backlog'),
        '/board/backlog', [
        'class' => 'btn btn-primary apc-header-button',
        'id' => 'header-backlog-button',
    ]);

    $menuItems[] = Html::a(
        Board::getBoardSectionName('kanban'),
        '/board', [
        'class' => 'btn btn-primary apc-header-button',
        'id' => 'header-kanban-button',
    ]);

    $menuItems[] = Html::a(
        Board::getBoardSectionName('completed'),
        '/board/completed', [
        'class' => 'btn btn-primary apc-header-button',
        'id' => 'header-completed-button',
    ]);

    $openTaskCount = Task::getOpenTaskCount();
    $openTaskCountDisplay = $openTaskCount ? '<strong class="text-danger">&nbsp;(' . $openTaskCount . ')</strong>' : '';

    $menuItems[] = Html::a(
        \Yii::t('app', 'Tasks') . $openTaskCountDisplay,
        '/task',
        [
            'class' => 'btn btn-success apc-header-button',
            'id' => 'header-create-button',
        ]
    );

    $dropDownMenuItemsOptions = ['class' => 'hidden-sm hidden-md hidden-lg'];
    $dropDownMenuItemsXs = [];
    foreach($dropDownMenuItems as $key => $value) {
        $value['options'] = $dropDownMenuItemsOptions;
        $dropDownMenuItemsXs[] = $value;
    }

    $menuItems = array_merge($menuItems, $dropDownMenuItemsXs);
}

echo Nav::widget([
	'options' => ['class' => 'navbar-nav navbar-right'],
	'items' => $menuItems,
]);

NavBar::end();