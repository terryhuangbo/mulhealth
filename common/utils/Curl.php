<?php
namespace common\utils;

use yii;
use yii\base\Component;

/**
 * Curl 请求类
 * @package common\utils
 */
class Curl extends Component
{
    /**
     * post 请求
     * @param string $url
     * @param array $post_data
     * @param array $header
     * @return mixed
     */
    public function post($url, $post_data = [], $header = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        if (!empty($header))
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * get 请求
     * @param $url
     * @param array $get_data
     * @return mixed
     */
    public function get($url, $get_data = [])
    {
        $url = $url . '?' . http_build_query($get_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * delete 请求
     * @param $url
     * @param null $data
     * @param array $header
     * @return mixed
     */
    public function delete($url, $data = null, $header = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($header))
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $i = 0;
        //无响应重试三次
        while (!$output = curl_exec($ch))
        {
            $i++;
            if ($i > 3)
            {
                break;
            }
            usleep(200000);
        }
        curl_close($ch);
        return $output;
    }

    /**
     * 生成curl需要参数
     * @return mixed
     */
    function buildCurlRequest($ch, $boundary, $fields, $files, $filesName)
    {
        $delimiter = '-------------' . $boundary;
        $data = '';

        foreach ($fields as $name => $content)
        {
            $data .= "--" . $delimiter . "\r\n"
                . 'Content-Disposition: form-data; name="' . $name . "\"\r\n\r\n"
                . $content . "\r\n";
        }

        foreach ($files as $name => $content)
        {
            $data .= "--" . $delimiter . "\r\n"
                . 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $filesName . '"' . "\r\n\r\n"
                . $content . "\r\n";
        }

        $data .= "--" . $delimiter . "--\r\n";

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: multipart/form-data; boundary=' . $delimiter,
                'Content-Length: ' . strlen($data)
            ],
            CURLOPT_POSTFIELDS => $data
        ]);
        return $ch;
    }
}
