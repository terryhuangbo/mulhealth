<?php
namespace frontend\modules\common\controllers;

use Yii;
use common\lib\Upload;
use yii\filters\Cors;
use yii\web\Controller;

/**
 * Upload controller
 */
class FileController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * Cors Filter
     * 允许跨域上传文件
     * @return array
     */
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => Cors::className(),
                'cors'  => [
                    'Origin' => [Yii::getAlias('@back'), '127.0.0.1', 'localhost'],
                    'Access-Control-Request-Method' => ['PUT'],
                ],
            ],
        ];
    }

    /**
     * 上传文件
     * @return array
     */
    public function actionUpload() {
        $objtype = trim(Yii::$app->request->post('objtype', 'pictures'));
        $up_mdl = new Upload();

        $ret = $up_mdl->upload(yiiParams('img_save_dir'), $objtype);
        if ($ret['code'] > 0) {
            return json_encode(['code' => 20000,'msg' => $ret['msg'], 'data' => $ret['data']]);
        } else {
            return json_encode(['code' => -20000,'msg' => $ret['msg']]);
        }
    }

    /**
     * 删除文件
     * @return array
     */
    public function actionDelete() {
        $file_path = trim(Yii::$app->request->post('filepath'));
        if(empty($file_path)){
            return json_encode(['code' => -20001,'msg' => '文件路径不能为空']);
        }
        $file_dir = $_SERVER['DOCUMENT_ROOT'] . $file_path;
        $file_dir = str_replace('/', '\\', $file_dir);
        if(!file_exists($file_dir)){
            return json_encode(['code' => 20001,'msg' => '文件不存在']);
        }
        //删除文件
        $result = @unlink($file_dir);
        if($result == false){
            return json_encode(['code' => -20002,'msg' => '文件删除失败！']);
        }
        return json_encode(['code' => 20000,'msg' => '删除成功！']);
    }

}
