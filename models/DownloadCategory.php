<?php
/**
 * This is the model class for table "download_category".
 *
 * @property integer $id Download category's unique ID.
 * @property string $name Download category's name
 * @property string $status Download category's status.
 * @property datetime $date_created Download category's date of creation.
 * @property datetime $date_updated Download category's date of updated.
 * @property integer $user_created Download category's user created.
 * @property integer $user_updated Download category's user updated.
 *
 * @property User $userCreated User that created the download category.
 * @property User $userUpdated User that updated the download category.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */

namespace app\models;

//Imports
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class DownloadCategory extends ActiveRecord
{

    const STATUS_ACTIVE = "A";
    const STATUS_INACTIVE = "I";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'download_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['date_created', 'date_updated', 'user_created', 'user_updated'], 'safe'],
            [['user_created', 'user_updated'], 'integer'],
            [['name'], 'string', 'max' => 59],
            [['status'], 'string', 'max' => 1],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('download_category', 'ID'),
            'name' => Yii::t('download_category', 'Name'),
            'status' => Yii::t('general', 'Status'),
            'date_created' => Yii::t('general', 'Date of creation'),
            'date_updated' => Yii::t('general', 'Date of the update'),
            'user_created' => Yii::t('general', 'User who created'),
            'user_updated' => Yii::t('general', 'User who do last update'),
        ];
    }

    /**
     * Returns all the download categories.
     *
     * @return DownloadCategory[]
     */
    public static function getDownloadCategories()
    {
        return self::find(['status' => self::STATUS_ACTIVE])->orderBy('name')->all();
    }

    /**
     * Returns the link to download's category visualization info.
     *
     * @return string
     */
    public function getLink()
    {
        return Url::to(['file/info', 'id' => $this->id]);
    }
}
