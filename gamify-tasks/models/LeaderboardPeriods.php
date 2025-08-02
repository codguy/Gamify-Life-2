<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%leaderboard_periods}}".
 *
 * @property int $id
 * @property string $period_type
 * @property string $period_start
 * @property string $period_end
 * @property int|null $is_current
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property LeaderboardEntries[] $leaderboardEntries
 * @property Users[] $users
 */
class LeaderboardPeriods extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const PERIOD_TYPE_DAILY = 'daily';
    const PERIOD_TYPE_WEEKLY = 'weekly';
    const PERIOD_TYPE_MONTHLY = 'monthly';
    const PERIOD_TYPE_YEARLY = 'yearly';
    const PERIOD_TYPE_ALL_TIME = 'all_time';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%leaderboard_periods}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_current'], 'default', 'value' => 0],
            [['period_type', 'period_start', 'period_end', 'created_by'], 'required'],
            [['period_type'], 'string'],
            [['period_start', 'period_end', 'created_at', 'updated_at'], 'safe'],
            [['is_current', 'created_by'], 'integer'],
            ['period_type', 'in', 'range' => array_keys(self::optsPeriodType())],
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
            'period_type' => 'Period Type',
            'period_start' => 'Period Start',
            'period_end' => 'Period End',
            'is_current' => 'Is Current',
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
     * Gets query for [[LeaderboardEntries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeaderboardEntries()
    {
        return $this->hasMany(LeaderboardEntries::class, ['period_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['id' => 'user_id'])->viaTable('{{%leaderboard_entries}}', ['period_id' => 'id']);
    }


    /**
     * column period_type ENUM value labels
     * @return string[]
     */
    public static function optsPeriodType()
    {
        return [
            self::PERIOD_TYPE_DAILY => 'daily',
            self::PERIOD_TYPE_WEEKLY => 'weekly',
            self::PERIOD_TYPE_MONTHLY => 'monthly',
            self::PERIOD_TYPE_YEARLY => 'yearly',
            self::PERIOD_TYPE_ALL_TIME => 'all_time',
        ];
    }

    /**
     * @return string
     */
    public function displayPeriodType()
    {
        return self::optsPeriodType()[$this->period_type];
    }

    /**
     * @return bool
     */
    public function isPeriodTypeDaily()
    {
        return $this->period_type === self::PERIOD_TYPE_DAILY;
    }

    public function setPeriodTypeToDaily()
    {
        $this->period_type = self::PERIOD_TYPE_DAILY;
    }

    /**
     * @return bool
     */
    public function isPeriodTypeWeekly()
    {
        return $this->period_type === self::PERIOD_TYPE_WEEKLY;
    }

    public function setPeriodTypeToWeekly()
    {
        $this->period_type = self::PERIOD_TYPE_WEEKLY;
    }

    /**
     * @return bool
     */
    public function isPeriodTypeMonthly()
    {
        return $this->period_type === self::PERIOD_TYPE_MONTHLY;
    }

    public function setPeriodTypeToMonthly()
    {
        $this->period_type = self::PERIOD_TYPE_MONTHLY;
    }

    /**
     * @return bool
     */
    public function isPeriodTypeYearly()
    {
        return $this->period_type === self::PERIOD_TYPE_YEARLY;
    }

    public function setPeriodTypeToYearly()
    {
        $this->period_type = self::PERIOD_TYPE_YEARLY;
    }

    /**
     * @return bool
     */
    public function isPeriodTypeAlltime()
    {
        return $this->period_type === self::PERIOD_TYPE_ALL_TIME;
    }

    public function setPeriodTypeToAlltime()
    {
        $this->period_type = self::PERIOD_TYPE_ALL_TIME;
    }
}
