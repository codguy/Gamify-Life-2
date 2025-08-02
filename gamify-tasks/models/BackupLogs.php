<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_backup_logs".
 *
 * @property int $id
 * @property string $backup_type
 * @property string $backup_status
 * @property string|null $file_path
 * @property int|null $file_size
 * @property int|null $backup_duration_seconds
 * @property string|null $error_message
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 */
class BackupLogs extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const BACKUP_TYPE_FULL = 'full';
    const BACKUP_TYPE_INCREMENTAL = 'incremental';
    const BACKUP_TYPE_DIFFERENTIAL = 'differential';
    const BACKUP_STATUS_STARTED = 'started';
    const BACKUP_STATUS_COMPLETED = 'completed';
    const BACKUP_STATUS_FAILED = 'failed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_backup_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_path', 'file_size', 'backup_duration_seconds', 'error_message'], 'default', 'value' => null],
            [['backup_type', 'backup_status', 'created_by'], 'required'],
            [['backup_type', 'backup_status', 'error_message'], 'string'],
            [['file_size', 'backup_duration_seconds', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_path'], 'string', 'max' => 500],
            ['backup_type', 'in', 'range' => array_keys(self::optsBackupType())],
            ['backup_status', 'in', 'range' => array_keys(self::optsBackupStatus())],
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
            'backup_type' => 'Backup Type',
            'backup_status' => 'Backup Status',
            'file_path' => 'File Path',
            'file_size' => 'File Size',
            'backup_duration_seconds' => 'Backup Duration Seconds',
            'error_message' => 'Error Message',
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
     * column backup_type ENUM value labels
     * @return string[]
     */
    public static function optsBackupType()
    {
        return [
            self::BACKUP_TYPE_FULL => 'full',
            self::BACKUP_TYPE_INCREMENTAL => 'incremental',
            self::BACKUP_TYPE_DIFFERENTIAL => 'differential',
        ];
    }

    /**
     * column backup_status ENUM value labels
     * @return string[]
     */
    public static function optsBackupStatus()
    {
        return [
            self::BACKUP_STATUS_STARTED => 'started',
            self::BACKUP_STATUS_COMPLETED => 'completed',
            self::BACKUP_STATUS_FAILED => 'failed',
        ];
    }

    /**
     * @return string
     */
    public function displayBackupType()
    {
        return self::optsBackupType()[$this->backup_type];
    }

    /**
     * @return bool
     */
    public function isBackupTypeFull()
    {
        return $this->backup_type === self::BACKUP_TYPE_FULL;
    }

    public function setBackupTypeToFull()
    {
        $this->backup_type = self::BACKUP_TYPE_FULL;
    }

    /**
     * @return bool
     */
    public function isBackupTypeIncremental()
    {
        return $this->backup_type === self::BACKUP_TYPE_INCREMENTAL;
    }

    public function setBackupTypeToIncremental()
    {
        $this->backup_type = self::BACKUP_TYPE_INCREMENTAL;
    }

    /**
     * @return bool
     */
    public function isBackupTypeDifferential()
    {
        return $this->backup_type === self::BACKUP_TYPE_DIFFERENTIAL;
    }

    public function setBackupTypeToDifferential()
    {
        $this->backup_type = self::BACKUP_TYPE_DIFFERENTIAL;
    }

    /**
     * @return string
     */
    public function displayBackupStatus()
    {
        return self::optsBackupStatus()[$this->backup_status];
    }

    /**
     * @return bool
     */
    public function isBackupStatusStarted()
    {
        return $this->backup_status === self::BACKUP_STATUS_STARTED;
    }

    public function setBackupStatusToStarted()
    {
        $this->backup_status = self::BACKUP_STATUS_STARTED;
    }

    /**
     * @return bool
     */
    public function isBackupStatusCompleted()
    {
        return $this->backup_status === self::BACKUP_STATUS_COMPLETED;
    }

    public function setBackupStatusToCompleted()
    {
        $this->backup_status = self::BACKUP_STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isBackupStatusFailed()
    {
        return $this->backup_status === self::BACKUP_STATUS_FAILED;
    }

    public function setBackupStatusToFailed()
    {
        $this->backup_status = self::BACKUP_STATUS_FAILED;
    }
}
