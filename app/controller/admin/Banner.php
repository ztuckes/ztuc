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
 * User: Administrator
 * Date: 2020/3/10
 * Time: 20:36
 */

namespace app\controller\admin;

use app\controller\common\Upload;
use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Banner as BannerModel;

/**
 * 轮播图
 * Class Banner
 * @package app\controller\admin
 */
class Banner extends InitController
{
    /**
     * 列表
     * @return string
     * @throws \Exception
     * @author: MK
     * @Time: 2020/4/5 12:32
     */
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
     * @Time: 2020/4/5 13:09
     */
    public function info()
    {
        $get = $this->request->get();
        $data = BannerModel::lists($get);
        return $this->success($data['data'], $data['count']);
    }

    /**
     * 新增
     * @return array
     * @author: MK
     * @Time: 2020/4/5 12:32
     */
    public function add()
    {
        $add = $this->request->post();
        $res = BannerModel::add($add);
        return $res ? $this->saveSuccess() : $this->error();
    }

    /**
     * 编辑
     * @return array
     * @author: MK
     * @Time: 2020/4/5 12:32
     */
    public function edit()
    {
        $post = $this->request->post();
        $edit = BannerModel::edit($post);
        return $edit ? $this->saveSuccess() : $this->error();
    }

    /**
     * 删除
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/5 13:37
     */
    public function del()
    {
        $id = $this->request->post('id');
        $del = BannerModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
    }

    /**
     * 图片上传
     * @return array
     * @author: MK
     * @Time: 2020/4/5 12:29
     */
    public function upload()
    {
        $upload = Upload::upload(Upload::BANNER_PATH);
        return $this->success($upload['file'],0,$upload['msg']);
    }
}