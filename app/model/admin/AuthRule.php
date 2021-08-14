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
 * AuthRule: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\model\admin;

use app\controller\common\Common;

use app\model\core\InitModel;


class AuthRule extends InitModel
{
    // 定义表
    protected $name = 'auth_rule';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    // 可用字段
    protected static $available = [
        'id',
        'type',
        'pid',
        'url',
        'name',
        'icon',
        'condition',
        'remark',
        'ismenu',
        'createtime',
        'updatetime',
        'weigh',
        'status',
    ];

   
    // 列表
    public static function lists($get)
    {
        $data = AuthRule::order('weigh desc')
            ->page($get['page'], $get['limit'])
            ->select()
            ->toArray();
        $count = AuthRule::count();
        return [
            'data' => $data,
            'count' => $count,
        ];
    }

    public static function tree($data, $pid = 0, $lev = 0)
    {
        static $tree = [];
        foreach ($data as $value) {
            if ($value['pid'] == $pid) {
                $value['title'] = str_repeat('└- ', $lev) . $value['title'];
                $tree[] = $value;
                self::tree($data, $value['id'], $lev + 1);
            }
        }
        return $tree;
    }

    // 新增
    public static function add($post)
    {
        try {
            $model = new AuthRule();
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

    // 删除
    public static function del($id)
    {
        $data = AuthRule::whereIn('id', $id)->select();
        if (!$data) return false;
        AuthRule::destroy($id);
        return true;
    }

    // 编辑
    public static function edit($post)
    {
        if (!$post['id']) return false;
        $model = AuthRule::where(['id' => $post['id']])->find();
        if (!$model) return false;
        return AuthRule::update($post);
    }

    /**
     * 分类
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/11 15:35
     */
    public static function getRule()
    {
        $data = AuthRule::where(['status' => 1])
            ->field(['id', 'name', 'pid'])
            ->order('weigh','desc')
            ->select()
            ->toArray();
        return $data;
    }

    /**
     * 树
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/8 20:33
     */
    public static function ruleTree()
    {
        $data = AuthRule::where(['status' => 1])
            ->field(['id', 'name as title', 'pid','remark as children','weigh','status'])
            ->order('weigh','desc')
            ->select()
            ->toArray();
        return $data;
    }

    /**
     * 左侧菜单栏
     * @param $ids
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/11 15:34
     */
    public static function leftTree($ids)
    {
        $data = AuthRule::where(['type'=>'nav','status'=>1])
            ->force('rules')
            ->whereIn('id',$ids)
            ->field(['id','pid','name as title','url','icon','weigh','status','ismenu','remark as child'])
            ->order('weigh','asc')
            ->select()
            ->toArray();
        return $data;
    }
}