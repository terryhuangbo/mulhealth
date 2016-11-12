<?php

namespace common\models;

use common\base\BaseModel;
use Yii;
use common\lib\Category;
use yii\caching\Cache;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $name
 */
class City extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'name'], 'required'],
            [['pid'], 'integer'],
            [['name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'name' => 'Name',
        ];
    }

    /**
     * 获取信息
     * @param $where array
     * @return array|boolean
     **/
    public function _get_info($where = []) {
        if (empty($where)) {
            return false;
        }

        $obj = self::findOne($where);
        if (!empty($obj)) {
            return $obj->toArray();
        }
        return false;
    }

    /**
     * 获取列表
     * @param $where array
     * @param $order string
     * @return array|boolean
     */
    public function _get_list($where = [], $order = '', $page = 1, $limit = 0) {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else if (is_array($where)) {
            $_obj->where($where);
        }

        if(!empty($order)){
            $_obj->orderBy($order);
        }

        if (!empty($limit)) {
            $offset = max(($page - 1), 0) * $limit;
            $_obj->offset($offset)->limit($limit);
        }
        return $_obj->asArray(true)->all();
    }

    /**
     * 获取总条数
     * @param $where array
     * @return int
     */
    public function _get_count($where = []) {
        $_obj = self::find();
        if (isset($where['sql']) || isset($where['params'])) {
            $_obj->where($where['sql'], $where['params']);
        } else {
            $_obj->where($where);
        }
        return intval($_obj->count());
    }

    /**
     * 获取所有列表
     * @param $pid int 父id
     * @return int
     */
    public static function _get_cities($pid = 0){
        return self::find()
            ->where(['pid' => $pid])
            ->indexBy('id')
            ->asArray(true)
            ->all();
    }

    /**
     * 获取所有省
     * @return array
     */
    public function getProvinces(){
        $cache = Yii::$app->cache;
        if ($cache instanceof Cache && ($provinces = $cache->get(['all_province'])) != false)
        {
            return $provinces;
        }
        $provinces = (new static)->_get_list(['pid' => 0]);
        if ($cache instanceof Cache )
        {
            $cache->set(['all_province'], $provinces, 30*24*24*3600);
        }
        return $provinces;
    }


}
