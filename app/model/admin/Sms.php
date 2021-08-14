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
use app\controller\common\Common;

use app\model\core\InitModel;


class Sms extends InitModel
{
    // 定义表
    protected $name = 'sms';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段
    protected static $available = [
        'id',
        'event',
        'mobile',
        'code',
        'times',
        'ip',
        'exptime',
        'createtime',
    ];   

  // 列表
   public static function lists($get)
    {
       
        // 初始化模型
        $model = Sms::order('createtime', 'desc')->page($get['page'], $get['limit']);

     
        $data = $model->select();
        $count = Sms::count();
        return [
            'data' => $data,
            'count' => $count,
        ];
    }
    // 新增
    public static function add($post)
    {
        try {
            $model = new Sms();
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
        $data = Sms::whereIn('id', $id)->select();
        if (!$data) return false;
        Sms::destroy($id);
        return true;
    }

    // 编辑
    public static function edit($post)
    {
        if (!$post['id']) return false;
        $model = Sms::where(['id' => $post['id']])->find();
        if (!$model) return false;
        return Sms::update($post);
    }

}