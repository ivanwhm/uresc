<?php
/**
 * @inheritdoc
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */
namespace app\components;

//Imports
use app\models\Settings;
use Yii;
use yii\web\Controller;

class UreController extends Controller
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        $language = Yii::$app->language;
        if (Yii::$app->getSession()->has('language') &&
            in_array(Yii::$app->getSession()->get('language'), [
                Settings::LANGUAGE_EN_US,
                Settings::LANGUAGE_PT_BR
            ]))
        {
            $language = Yii::$app->getSession()->get('language');
        } else
        {
            $settings = Settings::findOne(1);
            $language = $settings->language;
        }

        //Adjust the system language
        Yii::$app->language = $language;
    }

}