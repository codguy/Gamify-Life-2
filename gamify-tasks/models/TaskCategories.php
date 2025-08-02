<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task_categories}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $color_code
 * @property string|null $icon
 * @property int|null $is_system_default
 * @property int $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $createdBy
 * @property TaskMetadata[] $taskMetadatas
 */
class TaskCategories extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task_categories}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['color_code'], 'default', 'value' => '#3b82f6'],
            [['icon'], 'default', 'value' => 'fas fa-tasks'],
            [['is_system_default'], 'default', 'value' => 0],
            [['name', 'created_by'], 'required'],
            [['description'], 'string'],
            [['is_system_default', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['color_code'], 'string', 'max' => 7],
            [['icon'], 'string', 'max' => 50],
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
            'name' => 'Name',
            'description' => 'Description',
            'color_code' => 'Color Code',
            'icon' => 'Icon',
            'is_system_default' => 'Is System Default',
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
     * Gets query for [[TaskMetadatas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskMetadatas()
    {
        return $this->hasMany(TaskMetadata::class, ['category_id' => 'id']);
    }

}
