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
 * ClickLog: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Tourist as TouristModel;

class Tourist extends InitController
{
    /**
     * 管理员首页JSON
     * @param string $limit 分页
     * @throws \think\db\exception\DbException
     */
    public function index_json($limit='15')
    {
        $param = $this->request->param();
        $touris = new TouristModel();
        if (isset($param['locks'])) {
            $touris = $touris->where('locks',$param['locks']);
        }
        if (isset($param['subscribe'])) {
            $touris = $touris->whereLike('tourist_name|ip','%'.$param['subscribe'].'%');
        }
        $list = $touris->order('updatetime desc')->paginate($limit);
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
        
        $param['exptime'] = time();
            $result = TouristModel::update($param,['id'=>$param['id']]);
            if ($result == true) {
                return $this->success('', '', '设置成功');
            }
        }
        return $this->fetch('save', ['data' => TouristModel::where('id', $id)->find()]);
    }


    // 删除
    public function del()
    {
        
        if ($this->request->isPost()) { 
            $param = $this->request->param();
            $result = TouristModel::destroy($param['id']);
            if ($result == true) {
                return $this->success('', '', '删除成功');
            }
        }
    }
}