<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%system_settings}}".
 *
 * @property int $id
 * @property string $setting_key
 * @property string|null $setting_value
 * @property string|null $setting_type
 * @property string|null $description
 * @property int|null $is_public
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 */
class SystemSettings extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const SETTING_TYPE_STRING = 'string';
    const SETTING_TYPE_INTEGER = 'integer';
    const SETTING_TYPE_BOOLEAN = 'boolean';
    const SETTING_TYPE_JSON = 'json';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%system_settings}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['setting_value', 'description'], 'default', 'value' => null],
            [['setting_type'], 'default', 'value' => 'string'],
            [['is_public'], 'default', 'value' => 0],
            [['setting_key', 'created_by'], 'required'],
            [['setting_value', 'setting_type', 'description'], 'string'],
            [['is_public', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['setting_key'], 'string', 'max' => 100],
            ['setting_type', 'in', 'range' => array_keys(self::optsSettingType())],
            [['setting_key'], 'unique'],
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
            'setting_key' => 'Setting Key',
            'setting_value' => 'Setting Value',
            'setting_type' => 'Setting Type',
            'description' => 'Description',
            'is_public' => 'Is Public',
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
     * column setting_type ENUM value labels
     * @return string[]
     */
    public static function optsSettingType()
    {
        return [
            self::SETTING_TYPE_STRING => 'string',
            self::SETTING_TYPE_INTEGER => 'integer',
            self::SETTING_TYPE_BOOLEAN => 'boolean',
            self::SETTING_TYPE_JSON => 'json',
        ];
    }

    /**
     * @return string
     */
    public function displaySettingType()
    {
        return self::optsSettingType()[$this->setting_type];
    }

    /**
     * @return bool
     */
    public function isSettingTypeString()
    {
        return $this->setting_type === self::SETTING_TYPE_STRING;
    }

    public function setSettingTypeToString()
    {
        $this->setting_type = self::SETTING_TYPE_STRING;
    }

    /**
     * @return bool
     */
    public function isSettingTypeInteger()
    {
        return $this->setting_type === self::SETTING_TYPE_INTEGER;
    }

    public function setSettingTypeToInteger()
    {
        $this->setting_type = self::SETTING_TYPE_INTEGER;
    }

    /**
     * @return bool
     */
    public function isSettingTypeBoolean()
    {
        return $this->setting_type === self::SETTING_TYPE_BOOLEAN;
    }

    public function setSettingTypeToBoolean()
    {
        $this->setting_type = self::SETTING_TYPE_BOOLEAN;
    }

    /**
     * @return bool
     */
    public function isSettingTypeJson()
    {
        return $this->setting_type === self::SETTING_TYPE_JSON;
    }

    public function setSettingTypeToJson()
    {
        $this->setting_type = self::SETTING_TYPE_JSON;
    }
}
