<?php
/**
 * This is the model class for table "user".
 *
 * @property integer $id User unique code
 * @property string $name User full name
 * @property string $email User email address
 * @property string $password Password of the user
 * @property string $can_access_settings Indicate if the user can configure the application
 * @property string $language System language of the user
 * @property string $salt Password SALT of the user
 * @property string $status Status of the record
 * @property datetime $date_created Date of the user was created
 * @property datetime $date_updated Date of the last updated
 * @property integer $user_created User that created the record
 * @property integer $user_updated User of the last updated of the record
 *
 * @property UserAccess[] $userAccess Access of the user through the system
 * @property User $user_created_data User object
 * @property User $user_updated_data User object
 * @property Department[] $departmentUserCreated Departments objects that user has created
 * @property Department[] $departmentUserUpdated Departments objects that user has updated
 *
 * @author Ivan Wilhelm <ivan.whm@icloud.com>
 */

namespace app\models;

//Imports
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_ACTIVE = "A";
    const STATUS_INACTIVE = "I";

    const SETTINGS_YES = "Y";
    const SETTINGS_NO = "N";

    const LANGUAGE_PT_BR = 'pt-BR';
    const LANGUAGE_EN_US = 'en-US';

    /**
     * Attribute used to compare passwords.
     *
     * @var string
     */
    public $new_password;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'can_access_settings', 'language', 'status'], 'required'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['password', 'new_password'], 'required', 'on' => 'create'],
            [['new_password'], 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('password', 'The entered passwords are differents.')],
            [['password', 'date_created', 'date_updated', 'user_created', 'user_updated', 'salt'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['password'], 'string', 'min' => 6],
            [['language'], 'string', 'max' => 5],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * Return the access of the user through the system.
     *
     * @return ActiveQuery
     */
    public function getUserAccess()
    {
        return $this->hasMany(UserAccess::className(), ['user_id' => 'id']);
    }

    /**
     * Do the password cryptography.
     *
     * @param $password Password
     * @param $key Password Key
     * @return string
     */
    private function passwordCrypt($password, $key)
    {
        return sha1($key . $password);
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return User
     */
    public static function findIdentity($id)
    {
        return User::findOne(['status' => User::STATUS_ACTIVE, 'id' => $id]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->password;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        $key = $this->passwordCrypt($authKey, $this->salt);
        return  $key === $this->getAuthKey();
    }

    /**
     * Returns the full name of the user.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            return ($this->id !== 1);
        }
    }

}

