<?php

namespace common\models;

use common\base\BaseModel;
use common\lib\RegexValidator;
use common\lib\Tools;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $oid
 * @property integer $order_id
 * @property integer $gid
 * @property integer $uid
 * @property string $goods_id
 * @property string $goods_name
 * @property string $receiver_name
 * @property string $receiver_mobile
 * @property integer $receiver_province
 * @property integer $receiver_service
 * @property string $points_cost
 * @property integer $order_status
 * @property integer $count
 * @property integer $add_id
 * @property integer $express_type
 * @property integer $express_num
 * @property integer $is_deleted
 * @property integer $update_at
 * @property integer $create_at
 */
class Order extends BaseModel
{
    /**
     * 商品状态
     */
    const STATUS_PAY        = 1;//待付款
    const STATUS_SEND       = 2;//待发货
    const STATUS_RECEIVE    = 3;//待收货
    const STATUS_DONE       = 4;//已完成
    const STATUS_UNDO       = 5;//已撤销
    const STATUS_COMMENT    = 6;//待评论

    /**
     * 是否删除
     */
    const NO_DELETE = 1;//未删除、正常
    const IS_DELETE = 2;//删除


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
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
    public function rules()
    {
        return [
            [['gid', 'uid', 'order_status', 'points_cost', 'count', 'is_deleted', 'update_at', 'create_at'], 'integer'],
            [['uid', 'gid', 'receiver_name', 'receiver_mobile'], 'required'],
            //用户必须存在
            ['uid', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'uid', 'message' => '用户必须存在'],
            //商品必须存在
            ['gid', 'exist', 'targetClass' => Goods::className(), 'targetAttribute' => 'gid', 'message' => '商品必须存在'],
            //接收人姓名
            ['receiver_name', 'string', 'max' => 50, 'min' => 1, 'tooShort' => '接收人姓名不能为空', 'tooLong' => '接收人姓名太长'],
            //接收人手机号
            ['receiver_mobile', RegexValidator::className(), 'method' => 'mobile', 'message' => '接收人手机号不正确'],
            //接收人省份
            ['receiver_province', 'required', 'message' => '接收人地区不能为空'],
            //手机号码服务商
            ['receiver_service', 'in', 'range' => array_keys(yiiParams('mobileService')), 'message' => '手机号码服务商不正确'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oid' => '订单ID',
            'order_id' => '订单编号',
            'gid' => '商品ID',
            'uid' => '用户ID',
            'goods_id' => '商品编号',
            'goods_name' => '商品名称',
            'receiver_name' => '收货人姓名',
            'receiver_mobile' => '收货人联系方式',
            'receiver_province' => '收货人所在地区',
            'receiver_service' => '手机号码服务商',
            'points_cost' => '所需积分',
            'order_status' => '订单状态（1-待付款；2-待发货；3-待收货；4-已完成；5-已撤销；6-待评论）',
            'count' => '商品数量',
            'add_id' => '地址ID',
            'express_type' => '物流公司类型',
            'express_name' => '物流编号',
            'is_deleted' => '是否删除(1-未删除；2-已删除)',
            'update_at' => '更新时间',
            'create_at' => '创建时间',
        ];
    }

    /**
     * 关联表-hasMany
     **/
    public function getAddress() {
        return $this->hasOne(Address::className(), ['add_id' => 'add_id']);
    }

    /**
     * 关联表-hasMany
     **/
    public function getGoods() {
        return $this->hasOne(Goods::className(), ['gid' => 'gid']);
    }

    /**
     * 关联表-hasMany
     **/
    public function getUser() {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
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

        $obj = self::find();
        return $obj->where($where)
            ->joinWith('address')
            ->asArray(true)
            ->one();
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

        $_obj->andWhere([self::tableName() . '.is_deleted' => self::NO_DELETE]);
        if(!empty($order)){
            $_obj->orderBy($order);
        }

        if (!empty($limit)) {
            $offset = max(($page - 1), 0) * $limit;
            $_obj->offset($offset)->limit($limit);
        }

        return $_obj->joinWith('address')->joinWith('goods')->asArray(true)->all();
    }

    /**
     * 获取列表
     * @param $where array
     * @param $order string
     * @return array|boolean
     */
    public function _get_list_all($where = [], $order = '', $page = 1, $limit = 0) {
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

        return $_obj->joinWith('address')->joinWith('goods')->asArray(true)->all();
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
     * 添加记录-返回新插入的自增id
     **/
    public static function _add($data) {
        if (!empty($data) && !empty($data['username'])) {
            try {
                $_mdl = new self;

                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
                }
                if(!$_mdl->validate()) {//校验数据
                    return false;
                }
                $ret = $_mdl->insert();
                if ($ret !== false) {
                    return self::getDb()->getLastInsertID();
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * 保存记录
     * @param $data array
     * @return array|boolean
     */
    public function _save($data) {
        if (!empty($data)) {
            $_mdl = new self();

            try {
                foreach ($data as $k => $v) {
                    $_mdl->$k = $v;
                }

                if (!empty($data['oid'])) {//修改
                    $id = $data['oid'];
                    $ret = $_mdl->updateAll($data, ['oid' => $id]);
                } else {//增加
                    $ret = $_mdl->insert();
                }

                if ($ret !== false) {
                    return true;
                }
                return false;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * 删除记录
     * @param $where array
     * @return array|boolean
     */
    public function _delete($where) {
        if (!empty($where)) {
            try {
                return (new self)->deleteAll($where);
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * 订单状态
     * @param $status int
     * @return array|boolean
     */
    public static function _get_order_status($status = 1){
        switch(intval($status)){
            case self::STATUS_PAY:
                $_name = '待付款';
                break;
            case self::STATUS_SEND:
                $_name = '待发货';
                break;
            case self::STATUS_RECEIVE:
                $_name = '待收货';
                break;
            case self::STATUS_DONE:
                $_name = '已完成';
                break;
            case self::STATUS_UNDO:
                $_name = '已撤销';
                break;
            case self::STATUS_COMMENT:
                $_name = '待评论';
                break;

            default:
                $_name = '';
                break;
        }
        return $_name;
    }

    /**
     * 订单状态列表
     * @return array|boolean
     */
    public static function _get_status_list(){
        $statusArr = [];
        $statusArr[self::STATUS_PAY]     = '待付款';
        $statusArr[self::STATUS_SEND]    = '待发货';
        $statusArr[self::STATUS_RECEIVE] = '待收货';
        $statusArr[self::STATUS_DONE]    = '已完成';
        $statusArr[self::STATUS_UNDO]    = '已撤销';
        $statusArr[self::STATUS_COMMENT] = '待评论';

        return $statusArr;
    }

    /**
     * 生成财务数据
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)){
            if($insert){
                //订单编号
                $this->order_id = $this->genOrderBn();
                //用户扣积分
                if ($this->goods->redeem_pionts > $this->user->points)
                {
                    throw new Exception('用户积分不足');
                }
                //商品已经下架
                if ($this->goods->goods_status !== Goods::STATUS_UPSHELF)
                {
//                    throw new Exception('商品已经下架');
                }

            }else{//更新操作

            }
            return true;
        }
        return false;
    }

    /**
     * 生成财务数据
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        if($insert)//新增记录
        {
            //用户
            $user = $this->user;
            //商品
            $goods = $this->goods;
            //用户扣积分
            if ($goods->redeem_pionts > $user->points)
            {
                throw new Exception('用户积分不足');
            }
            $user->points -= $goods->redeem_pionts;
            if ($user->save()['code'] < 0)
            {
                throw new Exception('用户扣积分失败');
            }
            //商品下架
            $goods->goods_status = Goods::STATUS_OFFSHELF;
            if ($goods->save()['code'] < 0)
            {
                throw new Exception('商品状态更新失败');
            }

        }else{//更新订单

        }
    }

    /**
     * 生成唯一订单编号，格式为BD-V-XXXXX  XXXXX为大写字母和数字的组合
     * @return string
     */
    protected function genOrderBn() {
        $len = 8;
        $rand_bn = date('YmdHis', time()) . Tools::genUpcharNum($len);
        $exist = static::find()->where(['order_id' => $rand_bn])->exists();
        if($exist){
            $this->genOrderBn();
        }
        return $rand_bn;
    }


}
