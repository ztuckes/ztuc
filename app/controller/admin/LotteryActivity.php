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
 * LotteryActivity: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\LotteryActivity as LotteryActivityModel;

class LotteryActivity extends InitController
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
        $data = LotteryActivityModel::lists($page, $limit);
        return $this->success($data['data'], $data['count']);
    }


    // 删除
    public function del()
    {
        $id = $this->request->post('id');
        $del = LotteryActivityModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
    } 

     // 编辑
    public function edit()
    {
        $post = $this->request->post();
        $post['id'] = isset($post['id']) ? $post['id'] : $this->request->get('id');
        $edit = LotteryActivityModel::edit($post);
        return $edit ? $this->saveSuccess() : $this->error();
    }

    // 新增
    public function add()
    {
        $add = $this->request->post();
        $res = LotteryActivityModel::add($add);
        return $res ? $this->saveSuccess() : $this->error();
    }
}