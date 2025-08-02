<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_user_friendships".
 *
 * @property int $id
 * @property int $requester_id
 * @property int $addressee_id
 * @property string|null $status
 * @property string|null $accepted_at
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $addressee
 * @property Users $createdBy
 * @property Users $requester
 */
class UserFriendships extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DECLINED = 'declined';
    const STATUS_BLOCKED = 'blocked';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user_friendships';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accepted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'pending'],
            [['requester_id', 'addressee_id', 'created_by'], 'required'],
            [['requester_id', 'addressee_id', 'created_by'], 'integer'],
            [['status'], 'string'],
            [['accepted_at', 'created_at', 'updated_at'], 'safe'],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['requester_id', 'addressee_id'], 'unique', 'targetAttribute' => ['requester_id', 'addressee_id']],
            [['requester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['requester_id' => 'id']],
            [['addressee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['addressee_id' => 'id']],
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
            'requester_id' => 'Requester ID',
            'addressee_id' => 'Addressee ID',
            'status' => 'Status',
            'accepted_at' => 'Accepted At',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Addressee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddressee()
    {
        return $this->hasOne(Users::class, ['id' => 'addressee_id']);
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
     * Gets query for [[Requester]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequester()
    {
        return $this->hasOne(Users::class, ['id' => 'requester_id']);
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_PENDING => 'pending',
            self::STATUS_ACCEPTED => 'accepted',
            self::STATUS_DECLINED => 'declined',
            self::STATUS_BLOCKED => 'blocked',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function setStatusToPending()
    {
        $this->status = self::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isStatusAccepted()
    {
        return $this->status === self::STATUS_ACCEPTED;
    }

    public function setStatusToAccepted()
    {
        $this->status = self::STATUS_ACCEPTED;
    }

    /**
     * @return bool
     */
    public function isStatusDeclined()
    {
        return $this->status === self::STATUS_DECLINED;
    }

    public function setStatusToDeclined()
    {
        $this->status = self::STATUS_DECLINED;
    }

    /**
     * @return bool
     */
    public function isStatusBlocked()
    {
        return $this->status === self::STATUS_BLOCKED;
    }

    public function setStatusToBlocked()
    {
        $this->status = self::STATUS_BLOCKED;
    }
}
