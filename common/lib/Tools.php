<?php
/**
 * Created by PhpStorm.
 * User: Bo Huang
 * Date: 2016/2/29
 * Time: 19:13
 */

namespace common\lib;

use yii;

class Tools extends yii\base\Component {

    /**
     * 获取客户端IP地址
     * @return string
     */
    public static function getIP() {
        $ip_address = '0.0.0.0';
        if (!empty($_SERVER['HTTP_CDN_SRC_IP'])) {
            $ip_address = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) AND isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if ($ip_address === 'Unknown') {
            $ip_address = '0.0.0.0';
            return $ip_address;
        }
        if (strpos($ip_address, ',') !== 'Unknown') {
            $x = explode(',', $ip_address);
            $ip_address = trim(end($x));
        }
        return $ip_address;
    }

    /**
     * 下载文件
     * @return string
     */
    public static function downloadFile($file_url) {
        $file_url = iconv('utf-8', 'gb2312', $file_url);
        //将编码转为支持中英文的gb2312编码
        if (!isset($file_url) || trim($file_url) == '') {
            return '500';
        }
        $file_size = strlen(file_get_contents($file_url));
        $file_name = basename($file_url);
        //输入文件标签
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: " . $file_size);
        header("Content-Disposition: attachment; filename=" . $file_name);
        $file_type = fopen($file_url, 'r'); //打开文件
        //输出文件内容
        $buffer = 1024;   //定义1KB的缓存空间
        $file_count = 0;  //计数器,计算发送了多少数据
        while (!feof($file_type) && ($file_size > $file_count)) {
            //如果文件还没读到结尾，且还有数据没有发送
            $senddata = fread($file_type, $buffer);
            //读取文件内容到缓存区
            $file_count += $senddata;
            echo $senddata;
        }
        fclose($file_type);
    }

    /**
     * 生成由大写字母数字组成的随机字符串
     * @param int $len 随机字符串的长度
     * @param string $chars 产生随机串的母字符串
     * @return string
     */
    public static function genUpcharNum($len = 1,  $chars = null){
        if (is_null($chars)){
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }
        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }

    /**
     * 获取时间删选项
     * @return string
     */
    public static function getTimeFilter(){
        return [
            0 => [
                'text' => '今天',
                'from' => 'today',
                'to' => 'now',
            ],
            1 => [
                'text' => '昨天',
                'from' => 'today -1 day',
                'to' => 'today',
            ],
            3 => [
                'text' => '三天内',
                'from' => '-3 day',
                'to' => 'now',
            ],
            4 => [
                'text' => '一周内',
                'from' => '-1 week',
                'to' => 'now',
            ],
            5 => [
                'text' => '一月内',
                'from' => '-1 month',
                'to' => 'now',
            ],

        ];
    }

    /**
     * 从身份证中获取年龄
     * @return string
     */
    public static function getAgeByID($id)
    {
        //过了这年的生日才算多了1周岁
        if (empty($id))
        {
            return '';
        }
        $date = strtotime(substr($id, 6, 8));
        //获得出生年月日的时间戳
        $today = strtotime('today');
        //获得今日的时间戳
        $diff = floor(($today - $date) / 86400 / 365);
        //得到两个日期相差的大体年数

        //strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
        $age = strtotime(substr($id, 6, 8) . ' +' . $diff . 'years') > $today ? ($diff + 1) : $diff;

        return $age;
    }

    /**
     * 将数组转化为json字符串
     * @param string $data
     * @return string
     */
    public static function toJson($data)
    {
        return json_encode((array) $data);
    }

    /**
     * 将json字符串转化为数组
     * @param string $data
     * @param $first bool 是否返回第一个元素
     * @return string
     */
    public static function toArray($data, $first = false)
    {
        $array = json_decode($data, true);
        if ($first) {
            $firstEle = reset($array);
            return $firstEle ? $firstEle : '';
        }
        return $array;
    }

}
