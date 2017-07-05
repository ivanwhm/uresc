<?php
/**
 * This class is responsible to manager the site pages.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */

namespace app\controllers;

//Imports
use app\components\UreController;
use Yii;

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

    /**
     * Displays a page to show error in the system.
     *
     * @return string
     */
    public function actionError()
    {
        $exception = Yii::$app->getErrorHandler()->exception;
        return $this->render('error', [
            'exception' => $exception
        ]);
    }

}
