<?php
/**
 * Created by PhpStorm.
 * User: and
 * Date: 11/22/15
 * Time: 7:01 PM
 */

use yii\helpers\Html;

/*NavBar::begin([
    'brandLabel' => (YII_ENV_DEMO ? 'DEMO: ' : '') . $this->title,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
	],
    'innerContainerOptions' => [
        'class' => 'container-fluid'
        ]
    ]
);*/

if (Yii::$app->user->isGuest) {

	//$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
	$menuItems[] = ['label' => \Yii::t('app', 'Login'), 'url' => ['/site/login']];
	$menuItems[] = ['label' => \Yii::t('app', 'Contact'), 'url' => ['/site/contact']];
	$menuItems[] = ['label' => \Yii::t('app', 'About'), 'url' => ['/site/about']];

} else {

	$menuItems[] = ['label' => \Yii::t('app', 'Ban The Can'), 'items' => [
			['label' => \Yii::t('app', 'Tickets'), 'url' => ['/ticket']],
			['label' => \Yii::t('app', 'Tags'), 'url' => ['/tags']],
			['label' => \Yii::t('app', 'Tasks'), 'url' => ['/task']],
			['label' => \Yii::t('app', 'Resolutions'), 'url' => ['/resolution']],
			['label' => \Yii::t('app', 'Select Board'), 'url' => ['/board/select']],
			['label' => \Yii::t('app', 'Logout'), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
			['label' => \Yii::t('app', 'User Settings'), 'url' => ['/user/view']],
			['label' => \Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
			['label' => \Yii::t('app', 'About'), 'url' => ['/site/about']],
		]
	];

	$menuItems[] = html::tag('li',
		$this->render('@frontend/views/site/partials/_userIcon',['userId' => Yii::$app->getUser()->id]),
		['class' => 'menu-avatar-li']);

}
?>

<!-- div class="top-bar">
<div class="top-bar-right" -->
<!-- ul class="menu dropdown" data-dropdown-menu -->

    <ul class="dropdown menu" data-dropdown-menu>
        <li>
            <a href="#">Item 1</a>
            <ul class="menu">
                <li><a href="#">Item 1A</a></li>
                <!-- ... -->
            </ul>
        </li>
        <li><a href="#">Item 2</a></li>
        <li><a href="#">Item 3</a></li>
        <li><a href="#">Item 4</a></li>
    </ul>
<!-- ?php
    foreach ($menuItems as $v) {

        if (!is_array($v)) {

            echo $v;

        } elseif (array_key_exists('url', $v)) {

            echo '<li><a href ="' . array_shift($v['url']) . '">' . $v['label'] . '</a ></li>';

        } elseif (array_key_exists('items', $v)) {

            echo '<li>';
            echo '<a href ="#">' . $v['label'] . '</a >';
            echo '<ul class="menu">';

            foreach ($v['items'] as $sv) {
                echo '<li><a href ="' . array_shift($sv['url']) . '">' . $sv['label'] . '</a ></li>';
            }

            echo '</ul>';
            echo '</li>';
        }
    }
? -->

<!-- /ul -->
<!-- /div>
</div -->

<?php
/*echo Nav::widget([
	'options' => ['class' => 'navbar-nav navbar-right'],
	'items' => $menuItems,
]);*/

echo $this->renderFile('@frontend/views/layouts/partials/_header-buttons.php');

//NavBar::end();