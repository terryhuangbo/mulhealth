<?php
/**
 * Created by PhpStorm.
 * User: Huangbo
 * Date: 2016/5/30
 * Time: 11:49
 */

if (!function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param string $instance
     *
     * @return mixed|\yii\di\Container
     */
    function app($instance = null)
    {
        if (is_null($instance)) {
            return Yii::$container;
        }

        if (Yii::$app->has($instance)) {
            return Yii::$app->get($instance);
        }

        return Yii::$container->get($instance);
    }
}
/**
 * 获取Yii配置
 * @param string $key
 * @return mix
 */
function yiiParams($key) {
    return Yii::$app->params[$key];
}

/**
 * 创建url
 * @param array $params
 * @return string
 */
function yiiUrl($params) {
    return Yii::$app->urlManager->createUrl($params);
}

/**
 * 记录日志的当前用户
 * @return string
 */
function logUser() {
    if (Yii::$app->user->isGuest)
    {
        return '游客 ';
    }
    return Yii::$app->user->identity->nick . '(' . Yii::$app->user->identity->uid . ') ';
}

/**
 * 从对象，数组中获取获取数据
 * @param $array mixed 数组或者对象
 * @param $key array|string 对象的属性，或者数组的键值/索引，以'.'链接或者放入一个数组
 * @param $default string 如果对象或者属性中不存在该值事返回的值
 * @return mixed mix
 **/
function getValue($array, $key, $default = '')
{
    if ($key instanceof \Closure) {
        return $key($array, $default);
    }

    if (is_array($key)) {
        $lastKey = array_pop($key);
        foreach ($key as $keyPart) {
            $array = getValue($array, $keyPart);
        }
        $key = $lastKey;
    }

    if (is_array($array) && array_key_exists($key, $array)) {
        return $array[$key];
    }

    if (($pos = strrpos($key, '.')) !== false) {
        $array = getValue($array, substr($key, 0, $pos), $default);
        $key = substr($key, $pos + 1);
    }

    if (is_object($array)) {
        return $array->$key;
    } elseif (is_array($array)) {
        return array_key_exists($key, $array) ? $array[$key] : $default;
    } else {
        return $default;
    }
}

/**
 * 判断客户端是否为移动端
 * @param nothing
 * @return boolean
 */
function isMobile() {
    $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $useragent_commentsblock = preg_match('|\(.*?\)|', $useragent, $matches) > 0 ? $matches[0] : '';
    $mobile_os_list = array('Google Wireless Transcoder', 'Windows CE', 'WindowsCE', 'Symbian', 'Android', 'armv6l', 'armv5', 'Mobile', 'CentOS', 'mowser', 'AvantGo', 'Opera Mobi', 'J2ME/MIDP', 'Smartphone', 'Go.Web', 'Palm', 'iPAQ');
    $mobile_token_list = array('Profile/MIDP', 'Configuration/CLDC-', '160×160', '176×220', '240×240', '240×320', '320×240', 'UP.Browser', 'UP.Link', 'SymbianOS', 'PalmOS', 'PocketPC', 'SonyEricsson', 'Nokia', 'BlackBerry', 'Vodafone', 'BenQ', 'Novarra-Vision', 'Iris', 'NetFront', 'HTC_', 'Xda_', 'SAMSUNG-SGH', 'Wapaka', 'DoCoMo', 'iPhone', 'iPod');
    $found_mobile = checkSubstrs($mobile_os_list, $useragent_commentsblock) ||
        checkSubstrs($mobile_token_list, $useragent);
    if ($found_mobile) {
        return true;
    } else {
        return false;
    }
}

/**
 * 判断是否为子字符串
 * @param $substrs string
 * @param $text string
 * @return boolean
 */
function checkSubstrs($substrs, $text) {
    foreach ($substrs as $substr)
        if (false !== strpos($text, $substr)) {
            return true;
        }
    return false;
}

/**
 * 对象转数组,使用get_object_vars返回对象属性组成的数组
 * @param $obj object
 * @return array
 */
function objectToArray($obj) {
    $arr = is_object($obj) ? get_object_vars($obj) : $obj;
    if (is_array($arr)) {
        return array_map(__FUNCTION__, $arr);
    } else {
        return $arr;
    }
}

/**
 * 获取差异时间
 * @param int $time 输入的时间戳
 * @return string 差异时间 如‘2分钟以前，3天以前等等’
 */
function getDiffDate($time) {
    $now = time();
    $diff = $now > $time ? $now - $time : $time - $now;
    $d = floor($diff / 3600 / 24);
    $h = floor($diff / 3600);
    $m = floor($diff / 60);
    if ($d > 0) {
        return $d . '天前';
    } else if ($h > 0) {
        return $h . '小时前';
    } else if ($m > 0) {
        return $m . '分钟前';
    } else {
        return '1分钟前';
    }
}

/**
 * 数组转对象
 * @param array $arr
 * @return array|object
 */
function arrayToObject($arr) {
    if (is_array($arr)) {
        return (object)array_map(__FUNCTION__, $arr);
    } else {
        return $arr;
    }
}

/**
 * 用于Debug记录日志，路径为根目录下
 * *@param string|array|int $content
 * *@param int $type 1-清空重新输入；0-换行追加追加
 * @return boolean
 */
function lg($content, $type = 1){
    $path = dirname(dirname(__DIR__));
    if($type){
        file_put_contents($path . "/1.txt", print_r($content ,true));
    }else{
        file_put_contents($path . "/1.txt", "\r\n" . print_r($content ,true), FILE_APPEND);
    }
}

if (!function_exists('dd')) {
    function dd(...$param)
    {
        if (empty($param)) {
            var_dump(app());
            exit(1);
        }
        var_dump(...$param);
        exit(1);
    }
}