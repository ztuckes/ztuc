<?php
/**
 * +----------------------------------------------------------------------
 * | 九月科技-ztuc.cn
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: ztucke@ztuc.cn
 *                 ..:::::::::::'           | DATETIME: 2020/01/31
 *             '::::::::::::'
 *                .::::::::::
 *           '::::::::::::::..
 *                ..::::::::::::.
 *              ``::::::::::::::::
 *               ::::``:::::::::'        .:::.
 *              ::::'   ':::::'       .::::::::.
 *            .::::'      ::::     .:::::::'::::.
 *           .:::'       :::::  .:::::::::' ':::::.
 *          .::'        :::::.:::::::::'      ':::::.
 *         .::'         ::::::::::::::'         ``::::.
 *     ...:::           ::::::::::::'              ``::.
 *   ```` ':.          ':::::::::'                  ::::..
 *                      '.:::::'                    ':'````..
 * +----------------------------------------------------------------------
 */
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/4/4
 * Time: 12:13
 */

namespace app\controller\common;

use think\facade\Filesystem;

/**
 * 图片上传
 * Class Upload
 * @package app\controller\common
 */
class Upload
{

    const TYPE_BANNER = 1;                      // 轮播图片
    const BANNER_PATH = 'banner';               // 路径

    const TYPE_ADMIN = 2;                       //管理员头像图片
    const ADMIN_PATH = 'admin';                 // 路径

    const TYPE_USER = 3;                        //会员头像图片
    const USER_PATH = 'user';                   // 路径

    const TYPE_ARTICLE = 4;                     //文章图片
    const ARTICLE_PATH = 'article';             // 路径


    const TYPE_SYSTEM = 5;                     //logo图片
    const SYSTEM_PATH = 'system';             // 路径

    /**
     * 创建文件目录
     * @param string $path
     * @author: MK
     * @Time: 2020/4/5 12:33
     */
    public static function makeDir(string $path)
    {
        $list = explode('/', $path);

        if (!empty($list)) {
            $temp = '';
            foreach ($list as $k => $v) {
                $temp .= $v . '/';
                if (!file_exists($temp)) {
                    @mkdir($temp, 0777);
                    chmod($temp, 0777);
                }
            }
        }
    }

    /**
     * 图片上传
     * @param $path
     * @return array
     * @author: MK
     * @Time: 2020/4/5 12:33
     */
    public static function upload($path)
    {
        $result = [
            'code' => -1,
            'msg' => __('Upload failed'),
        ];

        // 上传图片 public/upload目录
        $file = request()->file('file');
        $saveName = Filesystem::disk('public')->putFile($path, $file);

        if ($saveName) {
            $result['code'] = 0;
            $result['msg'] = __('Upload success');
            $result['file'] = '/upload/'.str_replace('\\','/',$saveName);
        }
        return $result;
    }

    /**
     * 获取图片路径
     * @param $url
     * @return string
     * @author: MK
     * @Time: 2020/4/5 12:33
     */
    public static function image($url)
    {
        $url = isset($url) ? $url : '/upload/404.png'; // 默认图片
        return request()->domain() . $url;
    }
}
