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
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\model\admin;


use app\controller\common\Upload;
use app\model\core\InitModel;

/**
 * 轮播图
 * Class Banner
 * @package app\model\admin
 */
class Banner extends InitModel
{
    // 定义表
    protected $name = 'banner';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段
    protected static $available = [
        'id',
        'url',
        'desc',
        'weigh',
        'createtime',
        'status',
    ];

    /**
     * 列表
     * @param $get
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/5 13:03
     */
    public static function lists($get)
    {
        $model = Banner::page($get['page'], $get['limit'])->order('weigh desc');

        $data = $model->select();

        if (!empty($data)){
            // 获取图片
            foreach ($data as $k=>$v){
                $data[$k]['image'] = Image::image($v['id'],Upload::TYPE_BANNER);
            }
        }

        $count = Banner::count();
        return [
            'data' => $data,
            'count' => $count,
        ];
    }

    /**
     * 新增
     * @param $post
     * @return bool
     * @author: MK
     * @Time: 2020/4/5 12:49
     */
    public static function add($post)
    {
        if (isset($post['id'])) unset($post['id']);
        try {
            $model = new Banner();
            foreach ($post as $key => $val) {
                if (in_array($key, self::$available)) {
                    $model->$key = $val;
                }
            }
            $model->save();
            // 获取自增id
            $tableId = $model->id;
            //保存图片
            if (!empty($post['image'])) {
                $newData = [
                    'table_id' => $tableId,
                    'url' => $post['image'],
                    'types' => Upload::TYPE_BANNER,
                ];
                Image::add($newData);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 删除
     * @param $id
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/5 13:03
     */
    public static function del($id)
    {
        $data = Banner::whereIn('id', $id)->select();
        if (!$data) return false;
        Banner::destroy($id);
        return true;
    }

    /**
     * 编辑
     * @param $post
     * @return bool
     * @author: MK
     * @Time: 2020/4/5 12:49
     */
    public static function edit($post)
    {
        try {
            $id = (int)$post['id'];
            $model = Banner::where(['id' => $id])->find();
            if (!$model) return false;
            $model->save($post);

            //保存图片
            if (!empty($post['image'])) {
                $newData = [
                    'table_id' => $id,
                    'url' => $post['image'],
                    'types' => Upload::TYPE_BANNER,
                ];
                Image::add($newData);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    // 首页轮播图展示
    public static function banner()
    {
        $data = Banner::where('status',1)
            ->order('weigh','desc')
            ->cache(3600)
            ->select();
        if (!empty($data)){
            // 获取图片
            foreach ($data as $k=>$v){
                $data[$k]['image'] = Image::image($v['id'],Upload::TYPE_BANNER);
            }
        }
        return $data;
    }
}