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
class LotteryActivity extends InitModel
{
    // 定义表
    protected $name = 'lottery_activity';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段
    protected static $available = [
        'id',
        'title',
        'day_num',
        'score_num',
        'rate',
        'status',
        'createtime',
        'updatetime',
    ];
   // 列表
  
   public static function lists($page,$limit)
    {  
        $data = LotteryActivity::order('id', 'desc')->page($page,$limit)->select();
        $count = LotteryActivity::count();
        return [
            'data'=>$data,
            'count'=>$count,
        ];
      
    }
    // 删除
    public static function del($id)
    {
        $data = LotteryActivity::whereIn('id', $id)->find();
        if (!$data) return false;
        LotteryActivity::destroy($id);
        return true;
    }

    // 新增
    public static function add($post)
    {
        $model = new LotteryActivity();
        return $model->save($post);
    }

     // 编辑
    public static function edit($post)
    {
        if (!$post['id']) return false;
        $model = LotteryActivity::where(['id' => $post['id']])->find();
        if (!$model) return false;
        return LotteryActivity::update($post);
    }
}