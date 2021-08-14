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


use app\model\core\InitModel;

/**
 * 角色组
 * Class AuthGroup
 * @package app\model\admin
 */
class AuthGroup extends InitModel
{
    // 定义表
    protected $name = 'auth_group';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    // 可用字段
    protected static $available = [
        'id',
        'group_name',
        'rules',
        'createtime',
        'description',
        'updatetime',
        'status',
    ];

    /**
     * 列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/6 20:50
     */
    public static function lists()
    {
        $data = AuthGroup::select();
        $count = AuthGroup::count();
        return [
            'data' => $data,
            'count' => $count,
        ];
    }

    /**
     * 新增
     * @param $post
     * @return bool
     * @author: MK
     * @Time: 2020/4/6 20:50
     */
    public static function add($post)
    {
        if (!$post) return false;
        $model = new AuthGroup();
        return $model->allowField(self::$available)->save($post);
    }

    /**
     * 编辑
     * @param $post
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/6 20:51
     */
    public static function edit($post)
    {
        $model = AuthGroup::where(['id' => $post['id']])->find();
        if (!$model) return false;
        return $model->allowField(self::$available)->save($post);
    }

    /**
     * 删除
     * @param $ids
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/6 20:52
     */
    public static function del($id)
    {
        if ($id == 1) return false;
        $model = AuthGroup::whereIn('id', $id)->select();
        if (!$model) return false;
        return AuthGroup::destroy($id);
    }

    // 权限组
    public static function groupName()
    {
        return AuthGroup::where(['status'=>1])->field(['id','group_name'])->select()->toArray();
    }

    // 单条数据
    public static function findGroup($id)
    {
        $uid = AuthGroupAccess::findAccess($id);
        $name = AuthGroup::where('id',$uid['group_id'])->find();
        return $name;
    }
}