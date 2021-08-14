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
/**
 * Created by PhpStorm.
 * UserScoreLog: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\UserScoreLog as UserScoreLogModel;

class UserScoreLog extends InitController
{

    // 列表
    public function lists()
    {
        return View::fetch('admin/userscorelog/list');
    }

    // 新增
    public function add()
    {
        $add = $this->request->post();
        $res = UserScoreLogModel::add($add);
        return $res ? $this->saveSuccess() : $this->error();
    }

    // 数据 
     public function info()
    {
        $page = $this->request->get('page');
        $limit = $this->request->get('limit');
        $data = UserScoreLogModel::lists($page, $limit);
        return $this->success($data['data'], $data['count']);
    }


    // 编辑
    public function edit()
    {
        $post = $this->request->post();
        $edit = UserScoreLogModel::edit($post);
        return $edit ? $this->saveSuccess() : $this->error();
    }

    // 删除
    public function del()
    {
        $id = $this->request->post('id');
        $del = UserScoreLogModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
    }
}