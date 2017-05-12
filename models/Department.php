<?php
/**
 * This is the model class for table "department".
 *
 * @property integer $id Department' unique ID.
 * @property string $name Department's name
 * @property string $status Department's status.
 * @property string $info Department's text.
 * @property datetime $date_created Department's date of creation.
 * @property datetime $date_updated Department's date of updated.
 * @property integer $user_created Department's user created.
 * @property integer $user_updated Department's user updated.
 *
 * @property User $userCreated User that created the department.
 * @property User $userUpdated User that updated the department.
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */

namespace app\models;

//Imports
use yii\db\ActiveRecord;
use yii\helpers\Url;

class Department extends ActiveRecord
{

    const STATUS_ACTIVE = "A";
    const STATUS_INACTIVE = "I";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['info'], 'string'],
            [['id', 'date_created', 'date_updated', 'user_created', 'user_updated'], 'safe'],
            [['user_created', 'user_updated'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 1],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
        ];
    }

    /**
     * @return Department[]
     */
    public static function getDepartments()
    {
        return self::find(['status' => self::STATUS_ACTIVE])->orderBy('name')->all();
    }

    /**
     * Returns the link to department info.
     *
     * @return string
     */
    public function getLink()
    {
        return Url::to(['department/info', 'id' => $this->id]);
    }

}
