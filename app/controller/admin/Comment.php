<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/10
 * Time: 20:36
 */

namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Comment as CommentModel;
use think\facade\Session;

/**
 * 登录
 * Class Login
 * @package app\controller\admin
 */
class Comment extends InitController
{
    // 列表
    public function lists()
    {
        return View::fetch('admin/comment/list');
    }

    // 数据
    public function info()
    {
        $get = $this->request->get();
        $data = CommentModel::lists($get);
        return $this->success($data['data'], $data['count']);
    }
    // 新增
    public function add()
    {
        $add = $this->request->post();
        $res = CommentModel::add($add);
        return $res ? $this->saveSuccess() : $this->error();
    }

    // 编辑
    public function edit()
    {
        $post = $this->request->post();
        $post['id'] = isset($post['id']) ? $post['id'] : $this->request->get('id');
        $edit = CommentModel::edit($post);
        return $edit ? $this->saveSuccess() : $this->error();
    }

    // 删除
    public function del()
    {
        $id = $this->request->post('id');
        $del = CommentModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
    }
}