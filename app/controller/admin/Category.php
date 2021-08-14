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
namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Category as CategoryModel;

class Category extends InitController
{
    // 列表
    public function lists()
    {

        return View::fetch('list');
    }

    // 数据
    public function info()
    {
        $page = $this->request->get('page');
        $limit = $this->request->get('limit');
        $data = CategoryModel::lists($page,$limit);
        return $this->success($this->dropTree($data['data'],0,0), $data['count']);
    }

    // 首页分类新增
    public function add()
    {
        if ($this->request->isPost()){
            $post = $this->request->post();
            unset($post['id']);
            $post['type'] = CategoryModel::TYPE_INDEX;  //首页分类
            $res = CategoryModel::add($post);
            return $res ? $this->saveSuccess() : $this->error();
        }
        return $this->error('请求出错');
    }

    // 编辑
    public function edit()
    {
        $post = $this->request->post();
        $edit = CategoryModel::edit($post);
        return $edit ? $this->saveSuccess() : $this->error();
    }

    // 删除
    public function del()
    {
        $id = $this->request->post('id');
        $del = CategoryModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
    }
}