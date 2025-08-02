<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%journal_entries}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $entry_date
 * @property string|null $mood
 * @property string|null $mood_emoji
 * @property string|null $title
 * @property string|null $content_positive What went well
 * @property string|null $content_negative What could be improved
 * @property string|null $content_tomorrow Tomorrows focus
 * @property string|null $content_general General thoughts
 * @property int|null $is_private
 * @property string|null $tags Array of tags for categorization
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property Users $user
 */
class JournalEntries extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const MOOD_VERY_HAPPY = 'very_happy';
    const MOOD_HAPPY = 'happy';
    const MOOD_NEUTRAL = 'neutral';
    const MOOD_SAD = 'sad';
    const MOOD_VERY_SAD = 'very_sad';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%journal_entries}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mood_emoji', 'title', 'content_positive', 'content_negative', 'content_tomorrow', 'content_general', 'tags'], 'default', 'value' => null],
            [['mood'], 'default', 'value' => 'neutral'],
            [['is_private'], 'default', 'value' => 1],
            [['user_id', 'entry_date', 'created_by'], 'required'],
            [['user_id', 'is_private', 'created_by'], 'integer'],
            [['entry_date', 'tags', 'created_at', 'updated_at'], 'safe'],
            [['mood', 'content_positive', 'content_negative', 'content_tomorrow', 'content_general'], 'string'],
            [['mood_emoji'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 255],
            ['mood', 'in', 'range' => array_keys(self::optsMood())],
            [['user_id', 'entry_date'], 'unique', 'targetAttribute' => ['user_id', 'entry_date']],
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
            'entry_date' => 'Entry Date',
            'mood' => 'Mood',
            'mood_emoji' => 'Mood Emoji',
            'title' => 'Title',
            'content_positive' => 'Content Positive',
            'content_negative' => 'Content Negative',
            'content_tomorrow' => 'Content Tomorrow',
            'content_general' => 'Content General',
            'is_private' => 'Is Private',
            'tags' => 'Tags',
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
     * column mood ENUM value labels
     * @return string[]
     */
    public static function optsMood()
    {
        return [
            self::MOOD_VERY_HAPPY => 'very_happy',
            self::MOOD_HAPPY => 'happy',
            self::MOOD_NEUTRAL => 'neutral',
            self::MOOD_SAD => 'sad',
            self::MOOD_VERY_SAD => 'very_sad',
        ];
    }

    /**
     * @return string
     */
    public function displayMood()
    {
        return self::optsMood()[$this->mood];
    }

    /**
     * @return bool
     */
    public function isMoodVeryhappy()
    {
        return $this->mood === self::MOOD_VERY_HAPPY;
    }

    public function setMoodToVeryhappy()
    {
        $this->mood = self::MOOD_VERY_HAPPY;
    }

    /**
     * @return bool
     */
    public function isMoodHappy()
    {
        return $this->mood === self::MOOD_HAPPY;
    }

    public function setMoodToHappy()
    {
        $this->mood = self::MOOD_HAPPY;
    }

    /**
     * @return bool
     */
    public function isMoodNeutral()
    {
        return $this->mood === self::MOOD_NEUTRAL;
    }

    public function setMoodToNeutral()
    {
        $this->mood = self::MOOD_NEUTRAL;
    }

    /**
     * @return bool
     */
    public function isMoodSad()
    {
        return $this->mood === self::MOOD_SAD;
    }

    public function setMoodToSad()
    {
        $this->mood = self::MOOD_SAD;
    }

    /**
     * @return bool
     */
    public function isMoodVerysad()
    {
        return $this->mood === self::MOOD_VERY_SAD;
    }

    public function setMoodToVerysad()
    {
        $this->mood = self::MOOD_VERY_SAD;
    }
}
