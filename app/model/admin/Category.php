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


use app\model\core\InitModel;


class Category extends InitModel
{
    // 定义表
    protected $name = 'category';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    const TYPE_INDEX = 1;   //首页
    const TYPE_HOT = 2;     // 热门
    const TYPE_RECOMMEND = 3;   // 推荐

    // 可用字段
    protected static $available = [
        'id',
        'pid',
        'type',
        'cat_name',
        'nickname',
        'column',
        'description',
        'createtime',
        'updatetime',
        'weigh',
        'status',
    ];

    // 列表
    public static function lists($page, $limit)
    {
        $data = Category::order('weigh desc')
            ->field(['id', 'pid', 'cat_name as name', 'cat_name', 'status', 'createtime', 'weigh', 'column'])
            ->page($page, $limit)
            ->select();
        $count = Category::count();
        return [
            'data' => $data,
            'count' => $count,
        ];
    }

    // 新增
    public static function add($post)
    {
        try {
            $model = new Category();
            foreach ($post as $key => $val) {
                if (in_array($key, self::$available)) {
                    $model->$key = $val;
                }
            }
            return $model->save();
        } catch (\Exception $e) {
            return false;
        }
    }

    // 删除
    public static function del($id)
    {
        $data = Category::whereIn('id', $id)->select();
        if (!$data) return false;
        Category::destroy($id);
        return true;
    }

    // 编辑
    public static function edit($post)
    {
        if (!$post['id']) return false;
        $model = Category::where(['id' => $post['id']])->find();
        if (!$model) return false;
        return Category::update($post);
    }

    /**
     * 栏目树----前台栏目展示
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/10 22:39
     */
    public static function getCategory()
    {
        $data = self::where('status', 1)
            ->field(['id', 'cat_name', 'pid'])
            ->order('weigh','desc')
            ->cache(3600)// 一小时缓存
            ->select();

        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $data[$key]['child'] = '';
            }
        }
        return $data;
    }

    // 查询单条栏目
    public static function findCategory($id)
    {
        $data = self::where(['id' => $id])->find();
        return $data;
    }

    /**
     * 栏目树-----后台
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/10 22:42
     */
    public static function category()
    {
        return Category::where(['status'=>1,'column'=>1])->field(['id','pid','cat_name as name'])->select()->toArray();
    }
}