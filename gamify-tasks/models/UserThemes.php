<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_user_themes".
 *
 * @property int $id
 * @property int $user_id
 * @property int $theme_id
 * @property int|null $is_active
 * @property int|null $dark_mode_enabled
 * @property string|null $custom_settings User customizations
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property Themes $theme
 * @property Users $user
 */
class UserThemes extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user_themes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['custom_settings'], 'default', 'value' => null],
            [['dark_mode_enabled'], 'default', 'value' => 0],
            [['user_id', 'theme_id', 'created_by'], 'required'],
            [['user_id', 'theme_id', 'is_active', 'dark_mode_enabled', 'created_by'], 'integer'],
            [['custom_settings', 'created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Themes::class, 'targetAttribute' => ['theme_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'theme_id' => 'Theme ID',
            'is_active' => 'Is Active',
            'dark_mode_enabled' => 'Dark Mode Enabled',
            'custom_settings' => 'Custom Settings',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Theme]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Themes::class, ['id' => 'theme_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

}
