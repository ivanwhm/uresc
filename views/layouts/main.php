<?php

/* @var $this View */
/* @var $content string */

//Imports
use app\models\Department;
use app\models\DownloadCategory;
use app\models\GalleryCategory;
use app\models\Menu;
use app\models\Settings;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$set = Settings::getSettings();
$this->title = $set->page_title;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?= Icon::map($this, Icon::FA) ?>
    <?= Icon::map($this, Icon::WHHG) ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="ure-blue-theme">

    <div id="ure-menu">
        <div class="ure-icon">
            <div class="ure-icon-hamburguer">
                <?= Icon::show("bars", ['class' => 'fa-1x'], Icon::FA) ?>
            </div>
        </div>
        <div class="ure-menu-title">MENU</div>
        <ul id="ure-menu-item">
            <li>
                <?php $homeClass = (Yii::$app->controller->id == "site" && Yii::$app->controller->action->id == "index") ? "ure-icon-selected" : ""; ?>
                <?= Icon::show("home", ['class' => 'fa-1x' . $homeClass], Icon::FA) ?>
                <a href="<?= Url::home() ?>"
                   class="<?= (Yii::$app->controller->id == "site" && Yii::$app->controller->action->id == "index") ? "selected" : "" ?>">
                    <?= Yii::t('app', 'HOME') ?>
                </a>
            </li>
            <?php
            foreach (Menu::getMenu() as $menu) {
                echo Html::beginTag('li');

                echo Icon::show($menu->icon, [], $menu->icon_library);

                if ($menu->type == Menu::TYPE_MENU) {
                    echo Html::a($menu->name, Url::toRoute(['menu', ['id' => $menu->id]]));
                } else if ($menu->type == Menu::TYPE_PAGE) {
                        echo Html::a($menu->name, $menu->getPage()->getLink());
                } else {

                    echo Html::tag('span', $menu->name, ['class' => 'ure-menu-item-drop']);

                    if ($menu->type == Menu::TYPE_DEPARTMENT) {
                        echo Html::beginTag('ul', ['id' => 'department', 'class' => 'ure-sub']);
                        foreach (Department::getDepartments() as $department) {
                            echo Html::beginTag('li');
                            echo Html::a(' - ' . $department->name, $department->getLink());
                            echo Html::endTag('li');
                        }
                        echo Html::endTag('ul');
                    } else if ($menu->type == Menu::TYPE_GALLERY) {
                        echo Html::beginTag('ul', ['id' => 'gallery', 'class' => 'ure-sub']);
                        foreach (GalleryCategory::getGalleryCategories() as $gallery) {
                            echo Html::beginTag('li');
                            echo Html::a(' - ' . $gallery->name, $gallery->getLink());
                            echo Html::endTag('li');
                        }
                        echo Html::endTag('ul');
                    } else if ($menu->type == Menu::TYPE_FILE) {
                        echo Html::beginTag('ul', ['id' => 'file', 'class' => 'ure-sub']);
                        foreach (DownloadCategory::getDownloadCategories() as $download) {
                            echo Html::beginTag('li');
                            echo Html::a(' - ' . $download->name, $download->getLink());
                            echo Html::endTag('li');
                        }
                        echo Html::endTag('ul');
                    }
                }

                echo Html::endTag('li');
            }
            ?>
        </ul>
    </div>

    <div id="ure-top">
        <ul>
            <li>
                <a href="<?= Url::to('site/contact') ?>">
                    <?= Yii::t('app', 'CONTACT') ?>
                </a>
            </li>
        </ul>
    </div>

    <div id="ure-header">
        <div id="ure-logo"
             onclick="window.location='<?= Yii::$app->getHomeUrl() ?>';"
             title="<?= $this->title; ?>">
        </div>
        <div id="ure-phrases">
            <div id="ure-phrase">
                <?= $set->phrase ?>
            </div>
            <div id="ure-author">
                <?= $set->phrase_author ?>
            </div>
        </div>
    </div>

    <div id="ure-content">
        <?= $content; ?>
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
