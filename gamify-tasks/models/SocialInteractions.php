<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%social_interactions}}".
 *
 * @property int $id
 * @property int $activity_id
 * @property int $user_id
 * @property string $interaction_type
 * @property string|null $comment_text
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SocialActivities $activity
 * @property Users $createdBy
 * @property Users $user
 */
class SocialInteractions extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const INTERACTION_TYPE_LIKE = 'like';
    const INTERACTION_TYPE_COMMENT = 'comment';
    const INTERACTION_TYPE_SHARE = 'share';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%social_interactions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_text'], 'default', 'value' => null],
            [['activity_id', 'user_id', 'interaction_type', 'created_by'], 'required'],
            [['activity_id', 'user_id', 'created_by'], 'integer'],
            [['interaction_type', 'comment_text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            ['interaction_type', 'in', 'range' => array_keys(self::optsInteractionType())],
            [['activity_id', 'user_id', 'interaction_type'], 'unique', 'targetAttribute' => ['activity_id', 'user_id', 'interaction_type']],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => SocialActivities::class, 'targetAttribute' => ['activity_id' => 'id']],
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
            'activity_id' => 'Activity ID',
            'user_id' => 'User ID',
            'interaction_type' => 'Interaction Type',
            'comment_text' => 'Comment Text',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Activity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(SocialActivities::class, ['id' => 'activity_id']);
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
     * column interaction_type ENUM value labels
     * @return string[]
     */
    public static function optsInteractionType()
    {
        return [
            self::INTERACTION_TYPE_LIKE => 'like',
            self::INTERACTION_TYPE_COMMENT => 'comment',
            self::INTERACTION_TYPE_SHARE => 'share',
        ];
    }

    /**
     * @return string
     */
    public function displayInteractionType()
    {
        return self::optsInteractionType()[$this->interaction_type];
    }

    /**
     * @return bool
     */
    public function isInteractionTypeLike()
    {
        return $this->interaction_type === self::INTERACTION_TYPE_LIKE;
    }

    public function setInteractionTypeToLike()
    {
        $this->interaction_type = self::INTERACTION_TYPE_LIKE;
    }

    /**
     * @return bool
     */
    public function isInteractionTypeComment()
    {
        return $this->interaction_type === self::INTERACTION_TYPE_COMMENT;
    }

    public function setInteractionTypeToComment()
    {
        $this->interaction_type = self::INTERACTION_TYPE_COMMENT;
    }

    /**
     * @return bool
     */
    public function isInteractionTypeShare()
    {
        return $this->interaction_type === self::INTERACTION_TYPE_SHARE;
    }

    public function setInteractionTypeToShare()
    {
        $this->interaction_type = self::INTERACTION_TYPE_SHARE;
    }
}
