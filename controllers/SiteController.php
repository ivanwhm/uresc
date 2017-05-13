<?php
/**
 * This class is responsible to manager the site pages.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */

namespace app\controllers;

//Imports
use app\components\UreController;

class SiteController extends UreController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
