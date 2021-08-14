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
 * AuthGroup: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\AuthGroup as AuthGroupModel;
use app\model\admin\AuthRule;

/**
 * 角色组
 * Class AuthGroup
 * @package app\controller\admin
 */
class AuthGroup extends InitController
{

    /**
     * 列表
     * @return string
     * @throws \Exception
     * @author: MK
     * @Time: 2020/4/8 20:07
     */
    public function lists()
    {
        return View::fetch('list');
    }


    /**
     * 权限狗模式
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/8 20:41
     */
    public function rule()
    {
        $data = AuthRule::ruleTree();
        $tree = $this->rules($data, 0, 0);
        return $tree;
    }

    /**
     * 权限狗模式
     * @param $data
     * @param int $pid
     * @param int $lev
     * @return array
     * @author: MK
     * @Time: 2020/4/8 20:41
     */
    public function rules($data, $pid = 0, $lev = 0)
    {
        $tree = [];
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['children'] = $this->rules($data, $v['id'], $lev + 1);
                unset($v['status']);    // 为什么这样写，因为匹配layui树组件
                unset($v['weigh']);
                unset($v['pid']);
                if (empty($v['children'])) {
                    unset($v['children']);
                }
                $tree[] = $v;
            }
        }
        return $tree;
    }

    // 数据
    public function info()
    {
        $data = AuthGroupModel::lists();
        return $this->success($data['data'], $data['count']);
    }

    // 新增
    public function add()
    {
        $post = $this->request->post();

        if (!$post['posts'] || !$post['groups']) return $this->error();

        // 组装数据
        $newData = [
            'group_name' => $post['posts']['group_name'],
            'status' => $post['posts']['status'],
        ];

        $groupId = [];
        foreach ($post['groups'] as $k=>$v){
            $groupId[] = $v['id'];
            if (!empty($v['children'])){
                foreach ($v['children'] as $k2=>$v2){
                    $groupId[] = $v2['id'];
                }
            }
        }
        // 数组转字符串
        $newData['rules'] = implode(',',$groupId);

        $res = AuthGroupModel::add($newData);
        return $res ? $this->saveSuccess() : $this->error();
    }

    // 编辑
    public function edit()
    {
        $post = $this->request->post();

        if (!$post['posts'] || !$post['groups']) return $this->error();

        // 组装数据
        $newData = [
            'id' => $post['posts']['id'],
            'group_name' => $post['posts']['group_name'],
            'status' => $post['posts']['status'],
        ];

        $groupId = [];
        foreach ($post['groups'] as $k=>$v){
            $groupId[] = $v['id'];
            if (!empty($v['children'])){
                foreach ($v['children'] as $k2=>$v2){
                    $groupId[] = $v2['id'];
                }
            }
        }
        // 数组转字符串
        $newData['rules'] = implode(',',$groupId);


        $edit = AuthGroupModel::edit($newData);
        return $edit ? $this->saveSuccess() : $this->error();
    }

    // 删除
    public function del()
    {
        $id = $this->request->post('id');
        $del = AuthGroupModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
    }

    /**
     * 编辑树
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/11 13:59
     */
    public function editTree()
    {
        $get = $this->request->get('rule');
        $rule = explode(',',$get);
        $data = $this->rule();
        foreach ($data as $k=>$v){
            $temp = [];
            foreach ($v['children'] as $k2=>$v2){

                if (in_array($v2['id'],$rule)){
                    $data[$k]['spread'] = true;
                    $v2['checked'] = true;
                    $temp[] = $v2;
                }else{
                    $temp[] = $v2;
                }
            }
            $data[$k]['children'] = $temp;
        }
        return $data;
    }
}