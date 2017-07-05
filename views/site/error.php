<?php
/**
 * Displays the content regarding a page.
 *
 * @var $this View
 * @var $data Page
 * @var $exception Exception
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */

use app\models\Page;
use Exception;
use yii\helpers\Html;
use yii\web\View;

?>
<h1><?= Yii::t('app', 'Ups! There is a problem.' ) ?></h1>
<div class="ure-page-text">

    <?php if ($exception !== null && $exception->statusCode == 404) : ?>
        <?= Yii::t('app', 'The requested page does not exist.') ?>
    <?php else : ?>
        <?= Yii::t('app', 'There is an internal error. Please try again later.') ?>
    <?php endif; ?>

    <?php if (YII_ENV_DEV) : ?>
        <?= Html::tag('br') ?>
        <?= Html::tag('p', '<strong>' . Yii::t('app', 'Error code'). ' </strong>: ' . $exception->statusCode); ?>
        <?= Html::tag('p', '<strong>' . Yii::t('app', 'Error line'). ' </strong>: ' . $exception->getLine()); ?>
        <?= Html::tag('p', '<strong>' . Yii::t('app', 'Error trace'). ' </strong>: ' . $exception->getTraceAsString()); ?>
    <?php endif; ?>

</div>