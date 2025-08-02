<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_file_uploads".
 *
 * @property int $id
 * @property int $user_id
 * @property string $original_filename
 * @property string $stored_filename
 * @property string $file_path
 * @property int $file_size
 * @property string $mime_type
 * @property string|null $file_hash SHA256 hash for deduplication
 * @property string|null $related_table Table this file belongs to
 * @property int|null $related_id ID of the related record
 * @property int|null $is_public
 * @property int|null $is_temporary
 * @property string|null $expires_at
 * @property int|null $download_count
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property Users $user
 */
class FileUploads extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_file_uploads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_hash', 'related_table', 'related_id', 'expires_at'], 'default', 'value' => null],
            [['download_count'], 'default', 'value' => 0],
            [['user_id', 'original_filename', 'stored_filename', 'file_path', 'file_size', 'mime_type', 'created_by'], 'required'],
            [['user_id', 'file_size', 'related_id', 'is_public', 'is_temporary', 'download_count', 'created_by'], 'integer'],
            [['expires_at', 'created_at', 'updated_at'], 'safe'],
            [['original_filename', 'stored_filename'], 'string', 'max' => 255],
            [['file_path'], 'string', 'max' => 500],
            [['mime_type', 'related_table'], 'string', 'max' => 100],
            [['file_hash'], 'string', 'max' => 64],
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
            'original_filename' => 'Original Filename',
            'stored_filename' => 'Stored Filename',
            'file_path' => 'File Path',
            'file_size' => 'File Size',
            'mime_type' => 'Mime Type',
            'file_hash' => 'File Hash',
            'related_table' => 'Related Table',
            'related_id' => 'Related ID',
            'is_public' => 'Is Public',
            'is_temporary' => 'Is Temporary',
            'expires_at' => 'Expires At',
            'download_count' => 'Download Count',
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

}
