<?php
/**
 * This is the model class for table "settings".
 *
 * @property integer $id Settings' ID.
 * @property string $phrase Phrase that will be presented in header page.
 * @property string $phrase_author Author of the phrase that will be presented in header page.
 * @property string $page_title Title of the main page.
 * @property datetime $date_updated Settings' date of updated.
 * @property integer $user_updated Settings' user updated.
 * @property string $login_logo_image Imagem to be used on the login page.
 * @property string $default_business_hours The default business hours to new spiritist centres records.
 *
 * @property User $userUpdated User that updated the calendar.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */
namespace app\models;

//Imports
use Yii;
use yii\db\ActiveRecord;

class Settings extends ActiveRecord
{

    const LANGUAGE_PT_BR = 'pt-BR';
    const LANGUAGE_EN_US = 'en-US';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_updated', 'user_updated', 'login_logo_image', 'logo', 'default_business_hours'], 'safe'],
            [['phrase', 'phrase_author', 'page_title', 'phone_mask'], 'required'],
            [['user_updated'], 'integer'],
            [['phrase'], 'string', 'max' => 255],
            [['default_business_hours'], 'string', 'max' => 100],
            [['phrase_author', 'page_title'], 'string', 'max' => 150],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
        ];
    }

    /**
     * Returns the logo image directory.
     *
     * @return string
     */
    public static function getLogoDirectory()
    {
        return Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'web';
    }

    /**
     * Returns the default settings.
     *
     * @return Settings
     */
    public static function getSettings()
    {
        return Settings::findOne(1);
    }

}
