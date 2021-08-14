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
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\model\admin;
use app\controller\common\Common;

use app\model\core\InitModel;


class AdminLog extends InitModel
{
    // 定义表
    protected $name = 'admin_log';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段
    protected static $available = [
        'id',
        'admin_id',
        'username',
        'url',
        'title',
        'content',
        'ip',
        'useragent',
        'createtime',
    ];   

    // 列表
  
   public static function lists($page,$limit)
    {  
        $data = AdminLog::order('id', 'desc')->page($page,$limit)->select();
        $count = AdminLog::count();
        return [
            'data'=>$data,
            'count'=>$count,
        ];
      
    }
    // 删除
    public static function del($id)
    {
        $data = AdminLog::whereIn('id', $id)->find();
        if (!$data) return false;
        AdminLog::destroy($id);
        return true;
    }

    // 写入行为日志
    public static function write($post)
    {
        $list = ['add','edit','del','import','backup','downFile','optimize','repair'];
        if (in_array(request()->action(),$list)){
            $data = [
                'title' => request()->action(),
                'content' => json_encode(request()->param(),true),
                'url' => substr(request()->url(), 0, 1500),
                'admin_id' => $post['id'],
                'username' => $post['username'],
                'useragent' => substr(request()->server('HTTP_USER_AGENT'), 0, 255),
                'ip' => request()->ip(),
                'createtime'=>time()
            ];
            return self::insert($data);
        }
       return true;
    }
}