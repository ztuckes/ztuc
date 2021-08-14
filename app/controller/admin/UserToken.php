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
 * UserToken: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\UserToken as UserTokenModel;

class UserToken extends InitController
{

    // 列表
    public function lists()
    {
        return View::fetch('list');
    }

    // 数据
    public function info()
    {
        $data = UserTokenModel::lists();
        return $this->success($data, count($data));
    }

    // 新增
    public function add()
    {
        $add = $this->request->post();
        $res = UserTokenModel::add($add);
        return $res ? $this->saveSuccess() : $this->error();
    }

    

    // 删除
    public function del()
    {
        $user_id = $this->request->post('user_id');
        $del = UserTokenModel::del($user_id);
        return $del ? $this->delSuccess() : $this->error();
    }
}