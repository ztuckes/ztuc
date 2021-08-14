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
 * Ems: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Ems as EmsModel;

class Ems extends InitController
{
  /**
     * 管理员首页JSON
     * @param string $limit 分页
     * @throws \think\db\exception\DbException
     */
    public function index_json($limit='15')
    {
        $list = EmsModel::order('id desc')->paginate($limit);
        $this->result($list);
    }


    // 列表
    public function lists()
    {
        return View::fetch('list');
    }

   
   // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
        $param = $this->request->param();
        
            $result = EmsModel::update($param,['id'=>$param['id']]);
            if ($result == true) {
                return $this->success('', '', '设置成功');
            }
        }
        return $this->fetch('save', ['data' => EmsModel::where('id', $id)->find()]);
    }

    // 删除
    public function del()
    {
        
        if ($this->request->isPost()) { 
            $param = $this->request->param();
            $result = EmsModel::destroy($param['id']);
            if ($result == true) {
                return $this->success('', '', '删除成功');
            }
        }
    }
}