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
 * ClickLog: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\ClickLog as ClickLogModel;

class ClickLog extends InitController
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
        $data = ClickLogModel::lists($page, $limit);
        return $this->success($data['data'], $data['count']);
    }


    // 删除
    public function del()
    {
        $id = $this->request->post('id');
        $del = ClickLogModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
    }
}