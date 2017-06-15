<?php
/**
* Displays the content regarding a page.
*
* @var $this View
* @var $data Page
*
* @author Ivan Wilhelm <ivan.whm@icloud.com>
*/

use app\models\Page;
use yii\web\View;

?>
<h1><?= $data->name ?></h1>
<div class="ure-page-text">
    <?= $data->text ?>
</div>