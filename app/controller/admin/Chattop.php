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
use app\model\admin\Chattop as ChattopModel;
use think\facade\Session;
use app\model\admin\SensitiveWords as Words;
use app\validate\admin\Chat as ChatValidate;

/**
 * 登录
 * Class Login
 * @package app\controller\admin
 */
class Chattop extends InitController
{
    // 列表
    public function lists()
    {
        return View::fetch('admin/chattop/list');
    }

    // 数据
    public function info()
    {
        
        $get = $this->request->get();
        $data = ChattopModel::lists($get);
        return $this->success($data['data'], $data['count']);
        
    }

    // 新增
    public function add()
    {
        $post = $this->request->post();
        if (!$post) return $this->error();
        // 实例化验证器
        $validate = new ChatValidate();
        $ContentValidate = $validate->check($post);

        // 输出验证器错误信息
        if (true !== $ContentValidate) return $this->error($validate->getError());

        /*/过滤关键字*/
        $model = Words::keyWordCheck();
        $item = [];

         foreach($model as $k=>$v)
         {
            $item[$k] = $v['word'];
         }
        
        $replace =array_combine($item,array_fill(0,count($item),'*'));
        $content = strtr($post['content'],$replace);

        
       // 重新组装数据
        $newDate = [
            'content' => $content,
            'user_id' => $this->user['id'],
            'ip' => $this->request->ip(),
        ];

        $res = ChattopModel::add($newDate);
        return $res ? $this->success('', 0, '留言成功！', 1) : $this->error();
    }

    // 编辑
    public function edit()
    {
        $post = $this->request->post();
        $post['id'] = isset($post['id']) ? $post['id'] : $this->request->get('id');
        $edit = ChattopModel::edit($post);
        return $edit ? $this->saveSuccess() : $this->error();
    }

    // 删除
    public function del()
    {
        $id = $this->request->post('id');
        $del = ChattopModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
    }
}