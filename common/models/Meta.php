<?php

namespace common\models;

use Yii;
use common\base\BaseModel;

/**
 * This is the model class for table "{{%meta}}".
 *
 * @property string $id
 * @property string $key
 * @property string $value
 * @property string $create_at
 * @property string $update_at
 */
class Meta extends BaseModel
{
    /**
     * 配置数组
     */
    private $_config = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%meta}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string'],
            [['create_at', 'update_at'], 'integer'],
            [['key'], 'string', 'max' => 100],
            [['key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '公司介绍ID',
            'key' => '扩展字段key',
            'value' => '扩展字段值',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }

    /**
     * 获取所有的Meta配置
     * @return array
     */
    public function getAllConfig(){

        if(!$this->_config){
            $this->_config = static::find()->where('1=1')->indexBy('key')->all();
        }
        return $this->_config;
    }

    /**
     * 获取Meta配置
     * @param $key string Meta key
     * @return array
     */
    public function getConfig($key = ''){
        if(!$this->_config){
            $this->getAllConfig();
        }
        return empty($key) || !isset($this->_config[$key]) ? '' : $this->_config[$key]->value;
    }

    /**
     * 设置Meta配置
     * @param $key string Meta key
     * @param $value string Meta value
     * @return bool 是否保存成功
     */
    public function setConfig($key = '', $value){
        if(!$this->_config){
            $this->getAllConfig();
        }

        if(empty($key) || !isset($this->_config[$key])){
            return false;
        }

        $this->_config[$key]->value = trim($value);
        return getValue($this->_config[$key]->save(), 'code') > 0;
    }

    /**
     * 获取数组
     * @return array
     */
    public function asArray(){
        $this->getAllConfig();
        $_array = [];
        foreach($this->_config as $key => $val){
            $_array[$key] = $val->value;
        }
        return $_array;
    }
}
