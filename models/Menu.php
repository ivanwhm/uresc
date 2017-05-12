<?php
/**
 * This is the model class for table "menu".
 *
 * @property integer $id Menu's ID.
 * @property string $name Menu's name.
 * @property string $icon Menu's icon.
 * @property string $visible True if menu is visible.
 * @property integer $order Menu's order.
 * @property string $type Menu's type.
 * @property integer $page_id Menu's page ID.
 * @property datetime $date_created Menu's date of creation.
 * @property datetime $date_updated Menu's date of updated.
 * @property integer $user_created Menu's user created.
 * @property integer $user_updated Menu's user updated.
 *
 * @property Page $page Page related to the menu.
 * @property User $userCreated User that created the menu.
 * @property User $userUpdated User that updated the menu.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */

namespace app\models;

//Imports
use Yii;
use yii\db\ActiveRecord;

class Menu extends ActiveRecord
{

    const VISIBLE_YES = 'Y';
    const VISIBLE_NO = 'N';

    const TYPE_MENU = 'M';
    const TYPE_PAGE = 'P';
    const TYPE_DEPARTMENT = 'D';
    const TYPE_GALLERY = 'G';
    const TYPE_FILE = 'F';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'order', 'icon'], 'required'],
            [['order', 'page_id', 'user_created', 'user_updated'], 'integer'],
            [['date_created', 'date_updated', 'user_created', 'user_updated'], 'safe'],
            [['name', 'icon'], 'string', 'max' => 50],
            [['visible', 'type'], 'string', 'max' => 1],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
        ];
    }

    /**
     * Returns the page related to the menu.
     *
     * @return Page
     */
    public function getPage()
    {
        return Page::findOne(['id' => $this->page_id]);
    }

    /**
     * Return all the visible menus.
     *
     * @return Menu[]
     */
    public static function getMenu()
    {
        return self::find(['visible' => self::VISIBLE_YES])->orderBy('order')->all();
    }

}

