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
 * Lottery: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Lottery as LotteryModel;
use app\model\admin\User as UserModel;

class Lottery extends InitController
{

    // 列表
    public function lists()
    {
        return View::fetch('list');
    }
  /**
     * 管理员首页JSON
     * @param string $limit 分页
     * @throws \think\db\exception\DbException
     */
    public function index_json($limit='15')
    {
        $list = LotteryModel::order('id desc')->paginate($limit);
        
        $this->result($list);
    }

    // 数据
    public function info()
    {
        $page = $this->request->get('page');
        $limit = $this->request->get('limit');
        $data = LotteryModel::lists($page, $limit);
        return $this->success($data['data'], $data['count']);
    }


    // 删除
    public function del()
    {
        $id = $this->request->post('id');
        $del = LotteryModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
    }
}