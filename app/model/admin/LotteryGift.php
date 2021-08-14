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
 * Date: 2020/4/10
 * Time: 21:59
 */

namespace app\model\admin;

use app\model\core\InitModel;


/**
 * 点赞记录
 * Class LotteryActivity
 * @package app\model\admin
 */
class LotteryGift extends InitModel
{
    // 定义表
    protected $name = 'lottery_gift';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段id id    
    protected static $available = [
        'id',
        'activity_id',
        'title',
        'val',
        'desc',
        'rate',
        'status',
        'createtime',
        'updatetime',
    ];
   // 列表
  
   public static function lists($page,$limit)
    {  
        $data = LotteryGift::order('id', 'desc')->page($page,$limit)->select();
        $count = LotteryGift::count();
        return [
            'data'=>$data,
            'count'=>$count,
        ];
      
    }
    // 删除
    public static function del($id)
    {
        $data = LotteryGift::whereIn('id', $id)->find();
        if (!$data) return false;
        LotteryGift::destroy($id);
        return true;
    }

    // 新增
    public static function add($post)
    {
        $model = new LotteryGift();
        return $model->save($post);
    }

     // 编辑
    public static function edit($post)
    {
        if (!$post['id']) return false;
        $model = LotteryGift::where(['id' => $post['id']])->find();
        if (!$model) return false;
        return LotteryGift::update($post);
    }
}