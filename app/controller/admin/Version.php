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
 * Version: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Version as VersionModel;

class Version extends InitController
{

    // 列表
    public function lists()
    {
        return View::fetch('list');
    }

    /**
     * 数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/6 19:01
     */
    public function info()
    {
        $data = VersionModel::lists();
        return $this->success($data['data'], $data['count']);
    }

    // 新增
    public function add()
    {
        $add = $this->request->post();
        $res = VersionModel::add($add);
        return $res ? $this->saveSuccess() : $this->error();
    }

    // 编辑
    public function edit()
    {
        $post = $this->request->post();
        $edit = VersionModel::edit($post);
        return $edit ? $this->saveSuccess() : $this->error();
    }

    /**
     * 删除
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/6 19:01
     */
    public function del()
    {
        $id = $this->request->post('id');
        $del = VersionModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
    }
}