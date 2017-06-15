<?php
/**
 * This class is responsible to manager the site department pages.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */

namespace app\controllers;

//Imports
use app\components\UreController;
use app\models\Department;
use Yii;
use yii\web\NotFoundHttpException;

class DepartmentController extends UreController
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
        if (null !== ($data = Department::findOne($id))) {
            return $this->render('index', [
                'data' => $data
            ]);
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
