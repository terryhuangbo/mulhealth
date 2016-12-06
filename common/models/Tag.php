<?php

namespace common\models;

use common\base\BaseModel;
use Yii;
use yii\caching\Cache;
use yii\caching\DbDependency;

/**
 * This is the model class for table "{{%tags}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property integer $create_at
 * @property integer $update_at
 */
class Tag extends BaseModel
{

    /**
     * 类型
     */
    const TYPE_ALL       = 0;//不限
    const TYPE_PROJECT   = 1;//项目
    const TYPE_CASE      = 2;//案例
    const TYPE_KNOWLEDGE = 3;//知识

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'create_at', 'update_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
            //name必须唯一
            [['name'], 'unique', 'message' => '你已经添加过该标签了'],
            //type类型限制
            [['type'], 'in', 'range' => array_keys(self::getTypes()), 'message' => '标签类型不正确'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '标签类型（1-项目；2-案例；3-知识）',
            'name' => '标签',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }

    /**
     * 状态
     * @param $type int
     * @return array|boolean
     */
    public static function getTypes($type = null){
        $typeArr = [
            self::TYPE_ALL        => '不限',
            self::TYPE_PROJECT    => '项目',
            self::TYPE_CASE       => '案例',
            self::TYPE_KNOWLEDGE  => '知识',
        ];
        return is_null($type) ? $typeArr : (isset($typeArr[$type]) ? $typeArr[$type] : '');
    }

    /**
     * 获取标签列表
     * @param $type array|string  标签类型，
     * @param $handler callable 对标签处理的回调
     * @return array|boolean
     */
    public static function getTags($type = [], $handler = null){
        $cache = Yii::$app->cache;
        if (($tags = $cache->get([__METHOD__, 'tags', $handler])) !== false) {
            return $tags;
        }

        //获取标签列表
        $tags = static::find()
            ->select(['name'])
            ->where(['type' => $type])
            ->asArray()
            ->column();

        //缓存标签列表
        $dependency = new DbDependency([
            'sql' => 'SELECT MAX(update_at) FROM {{%tags}}',
        ]);
        if (!empty($tags) && is_callable($handler)) {
            $tags =  call_user_func($handler, $tags);
        }
        $cache->set([__METHOD__, 'tags', $handler], $tags, 3600, $dependency);

        return $tags;
    }

}
