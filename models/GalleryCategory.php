<?php
/**
 * This is the model class for table "gallery_category".
 *
 * @property integer $id Gallery category's unique ID.
 * @property string $name Gallery category's name
 * @property string $status Gallery category's status.
 * @property datetime $date_created Gallery category's date of creation.
 * @property datetime $date_updated Gallery category's date of updated.
 * @property integer $user_created Gallery category's user created.
 * @property integer $user_updated Gallery category's user updated.
 *
 * @property User $userCreated User that created the gallery category.
 * @property User $userUpdated User that updated the gallery category.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */
namespace app\models;

//Imports
use yii\db\ActiveRecord;
use yii\helpers\Url;

class GalleryCategory extends ActiveRecord
{

    const STATUS_ACTIVE = "A";
    const STATUS_INACTIVE = "I";
    const ONLY_PICTURE_YES = 'Y';
    const ONLY_PICTURE_NO = 'N';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_created', 'user_updated', 'date_created', 'date_updated'], 'safe'],
            [['name', 'status'], 'required'],
            [['user_created', 'user_updated'], 'integer'],
            [['name'], 'string', 'max' => 59],
            [['status'], 'string', 'max' => 1],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
        ];
    }

    /**
     * Returns all the gallery categories.
     *
     * @return GalleryCategory[]
     */
    public static function getGalleryCategories()
    {
        return self::find(['status' => self::STATUS_ACTIVE])->orderBy('name')->all();
    }

    /**
     * Returns the link to gallery's category visualization info.
     *
     * @return string
     */
    public function getLink()
    {
        return Url::to(['gallery/info', 'id' => $this->id]);
    }

}
