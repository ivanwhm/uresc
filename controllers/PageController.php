<?php
/**
 * This class is responsible to manager the site page   s.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */

namespace app\controllers;

//Imports
use app\components\UreController;
use app\models\Page;
use Yii;
use yii\web\NotFoundHttpException;

class PageController extends UreController
{

    /**
     * Render a specific page.
     *
     * @param int $id Page ID.
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($id)
    {
        if (null !== ($data = Page::findOne($id))) {
            return $this->render('index', [
                'data' => $data
            ]);
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
