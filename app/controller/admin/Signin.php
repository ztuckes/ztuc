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
 * Signin: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Signin as SigninModel;
use app\model\admin\User;

class Signin extends InitController
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
        $list = SigninModel::order('createtime desc')->paginate($limit);
        // 获取用户信息
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                if ($v['user_id']){
                    $userInfo = User::findUser($v['user_id']);
                    $list[$k]['username'] = isset($userInfo['username'])?$userInfo['username']:'';
                }
            }
        }
        $this->result($list);
    }

   // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
        $param = $this->request->param();
            $result = SigninModel::update($param,['id'=>$param['id']]);
            if ($result == true) {
                return $this->success('', '', '设置成功');
            }
        }
    }

    // 删除
    public function del()
    {
        
        if ($this->request->isPost()) { 
            $param = $this->request->param();
            $result = SigninModel::destroy($param['id']);
            if ($result == true) {
                return $this->success('', '', '删除成功');
            }
        }
    }
}