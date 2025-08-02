<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_audit_logs".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $table_name
 * @property int $record_id
 * @property string $action
 * @property string|null $old_values
 * @property string|null $new_values
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property Users $user
 */
class AuditLogs extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ACTION_CREATE = 'CREATE';
    const ACTION_UPDATE = 'UPDATE';
    const ACTION_DELETE = 'DELETE';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_audit_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'old_values', 'new_values', 'ip_address', 'user_agent'], 'default', 'value' => null],
            [['user_id', 'record_id', 'created_by'], 'integer'],
            [['table_name', 'record_id', 'action', 'created_by'], 'required'],
            [['action', 'user_agent'], 'string'],
            [['old_values', 'new_values', 'created_at', 'updated_at'], 'safe'],
            [['table_name'], 'string', 'max' => 100],
            [['ip_address'], 'string', 'max' => 45],
            ['action', 'in', 'range' => array_keys(self::optsAction())],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'table_name' => 'Table Name',
            'record_id' => 'Record ID',
            'action' => 'Action',
            'old_values' => 'Old Values',
            'new_values' => 'New Values',
            'ip_address' => 'Ip Address',
            'user_agent' => 'User Agent',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }


    /**
     * column action ENUM value labels
     * @return string[]
     */
    public static function optsAction()
    {
        return [
            self::ACTION_CREATE => 'CREATE',
            self::ACTION_UPDATE => 'UPDATE',
            self::ACTION_DELETE => 'DELETE',
        ];
    }

    /**
     * @return string
     */
    public function displayAction()
    {
        return self::optsAction()[$this->action];
    }

    /**
     * @return bool
     */
    public function isActionCreate()
    {
        return $this->action === self::ACTION_CREATE;
    }

    public function setActionToCreate()
    {
        $this->action = self::ACTION_CREATE;
    }

    /**
     * @return bool
     */
    public function isActionUpdate()
    {
        return $this->action === self::ACTION_UPDATE;
    }

    public function setActionToUpdate()
    {
        $this->action = self::ACTION_UPDATE;
    }

    /**
     * @return bool
     */
    public function isActionDelete()
    {
        return $this->action === self::ACTION_DELETE;
    }

    public function setActionToDelete()
    {
        $this->action = self::ACTION_DELETE;
    }
}
