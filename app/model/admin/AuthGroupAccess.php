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
 * Date: 2020/4/11
 * Time: 14:30
 */

namespace app\model\admin;

use app\model\core\InitModel;

/**
 * 权限中间表
 * Class AuthGroupAccess
 * @package app\model\admin
 */
class AuthGroupAccess extends InitModel
{
    // 定义表
    protected $name = 'auth_group_access';

    // 可用字段
    protected static $available = [
        'uid',
        'group_id',
    ];

    // 查找uid
    public static function findAccess($uid)
    {
        return self::where('uid', $uid)->find();
    }

    /**
     * 新增
     * @param $groupId
     * @param $uid
     * @return bool
     * @author: MK
     * @Time: 2020/4/11 15:42
     */
    public static function add($groupId, $uid)
    {

        $model = AuthGroupAccess::where(['uid' => $uid])->find();

        if ($model) {
            return $model->save(['group_id' => $groupId]);
        } else {
           $access = new AuthGroupAccess();
           return $access->save(['uid'=>$uid,'group_id'=>$groupId]);
        }

    }

    // 删除检查
    public static function del($uid)
    {
        $model = AuthGroupAccess::where(['uid' => $uid])->find();
        if (!$model) return false;
        return $model->delete();
    }
}