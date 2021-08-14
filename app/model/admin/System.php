<?php
/**
 * Created by PhpStorm.
 * SmsMoban: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\model\admin;
use app\controller\common\Common;

use app\controller\common\Upload;
use app\model\core\InitModel;


class System extends InitModel
{ 
    // 定义表
    protected $name = 'system';
    protected $json = ['jdata'];
    protected $jsonAssoc = true;
    
    /**
     * 写入cert证书文件
     * @param string $cert_pem
     * @param string $key_pem
     * @return bool
     */
    static function writeCertPemFiles($cert_pem = '', $key_pem = '')
    {
        if (empty($cert_pem) || empty($key_pem)) {
            return false;
        }
        // 证书目录
        $filePath = base_path().'/common/library/wechat/cert/';
        // 目录不存在则自动创建
        if (!is_dir($filePath)) {
            mkdir($filePath, 0777, true);
        }
        // 写入cert.pem文件
        if (!empty($cert_pem)) {
            file_put_contents($filePath . 'cert.pem', $cert_pem);
        }
        // 写入key.pem文件
        if (!empty($key_pem)) {
            file_put_contents($filePath . 'key.pem', $key_pem);
        }
        return true;
    }
    
}