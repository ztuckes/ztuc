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
 * UserToken: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\model\admin;
use app\controller\common\Common;

use app\model\core\InitModel;


class UserToken extends InitModel
{
    // 定义表
    protected $name = 'user_token';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';


    // 可用字段
    protected static $available = [
        'token',
        'user_id',
        'createtime',
        'expiretime',
    ];   

    // 列表
   public static function lists()
    {
        return UserToken::select();
   
    }
     // 新增
    public static function add($post)
    {
        try {
            $model = new UserToken();
            foreach ($post as $key => $val) {
                if (in_array($key, self::$available)) {
                    $model->$key = $val;
                }
            }
            return $model->save();
        } catch (\Exception $e) {
            return false;
        }
    }
 
    // 删除检查
    public static function del($user_id)
    { 
        cookie('userToken',null);
        session('userToken',null);
        session('state',null);
        $model = UserToken::where('user_id' , $user_id)->find();
        if (!$model) return false;
        $model->delete();
        // 结果 true , 不管删除成功与否
        return true;
    }

}