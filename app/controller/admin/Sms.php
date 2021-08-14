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
 * Sms: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Sms as SmsModel;

class Sms extends InitController
{

    // 列表
    public function lists()
    {
        return View::fetch('list');
    }

       // 详情
    public function info()
    {
        $get = $this->request->get();
        $data = SmsModel::lists($get);
        return $this->success($data['data'], $data['count']);
    }

    // 新增
    public function add()
    {
        $add = $this->request->post();
        $res = SmsModel::add($add);
        return $res ? $this->saveSuccess() : $this->error();
    }

    // 编辑
    public function edit()
    {
        $post = $this->request->post();
        $edit = SmsModel::edit($post);
        return $edit ? $this->saveSuccess() : $this->error();
    }

    // 删除
    public function del()
    {
        $id = $this->request->post('id');
        $del = SmsModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
    }
}