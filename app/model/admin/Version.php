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
 * Version: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\model\admin;

use app\model\core\InitModel;

/**
 * 版本管理
 * Class Version
 * @package app\model\admin
 */
class Version extends InitModel
{
    // 定义表
    protected $name = 'version';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    // 可用字段
    protected static $available = [
        'id',
        'oldversion',
        'newversion',
        'packagesize',
        'content',
        'downloadurl',
        'enforce',
        'createtime',
        'updatetime',
        'weigh',
        'status',
    ];

    /**
     * 列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/6 19:00
     */
    public static function lists()
    {
        $data = Version::order('weigh desc')->select();
        $count = Version::count();
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
     * @Time: 2020/4/6 19:00
     */
    public static function add($post)
    {
        if (!$post) return false;
        $model = new Version();
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
     * @Time: 2020/4/6 20:27
     */

    public static function edit($post)
    {
        $model = Version::where(['id'=>$post['id']])->find();
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
     * @Time: 2020/4/6 19:00
     */
    public static function del($ids)
    {
        $data = Version::whereIn('id', $ids)->select();
        if (!$data) return false;
        return Version::destroy($ids);
    }
}