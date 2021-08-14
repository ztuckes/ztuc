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


class Image extends InitModel
{
    // 定义表
    protected $name = 'images';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段
    protected static $available = [
        'id',
        'table_id',
        'url',
        'types',
        'status',
        'createtime',
    ];

    /**
     * 列表
     * @param $get
     * @return array|bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/9 21:44
     */
    public static function lists($get)
    {
        if (!$get) return false;
        $page = (int)$get['page'];
        $limit = (int)$get['limit'];
        $data = Image::page($page,$limit)->select();
        $count = Image::count();

        if (!empty($data)){
            foreach ($data as $k=>$v){
                $data[$k]['image'] = request()->domain().$v['url'];
                $data[$k]['types'] = self::type($v['types']);
            }
        }

        return [
            'data'=>$data,
            'count'=>$count,
        ];
    }

    public static function type($type)
    {
        switch ($type){
            case 1:
                return $type = '轮播图片';
                break;
                case 2:
                return $type = '管理员头像图片';
                break;
                case 3:
                return $type = '会员头像图片';
                break;
                case 4:
                return $type = '文章图片';
                break;
                case 5:
                return $type = 'logo图片';
                break;
            default:
                return $type = '未知';
        }
    }

    /**
     * 获取图片
     * @param int $tableId
     * @param int $type
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/5 13:01
     */
    public static function image(int $tableId ,int $type)
    {
        // force强制索引
        $img = Image::where(['table_id'=>$tableId,'types'=>$type])->force('images')->find();
      
      if(!empty($img['url'])){
        return Upload::image($img['url']);
    }else{
        return Upload::image('/upload/404.png');
    }
       
    }

    /**
     * 新增和编辑
     * @param $post
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/5 13:00
     */
    public static function add($post)
    {
        if (!$post) return false;

        $model = Image::where(['table_id'=>$post['table_id'],'types'=>$post['types']])->find();

        if ($model){
            // 编辑逻辑
            return $model->save($post);

        }else{
            // 新增逻辑
            $image = new Image();
            foreach ($post as $key => $val) {
                if (in_array($key, self::$available)) {
                    $image->$key = $val;
                }
            }
           return $image->save();
        }
    }

    public static function del($id)
    {
        $data = Image::whereIn('id', $id)->select();
        if (!$data) return false;
        Image::destroy($id);
        return true;
    }

    public static function edit($post)
    {
        $id = (int)$post['id'];
        $model = Image::where(['id' => $id])->find();

        if (!$model) return false;
        return $model->save($post);
    }
}