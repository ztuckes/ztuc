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
 * Class Lottery
 * @package app\model\admin
 */
class Lottery extends InitModel
{
    // 定义表
    protected $name = 'lottery';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段
    protected static $available = [
        'id',
        'user_id',
        'gift_id',
        'ip',
        'createtime',
    ];
   // 列表
  
   public static function lists($page,$limit)
    {  
        $data = Lottery::order('id', 'desc')->page($page,$limit)->select();

        // 获取用户信息
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if ($v['user_id']){
                    $userInfo = User::findUser($v['user_id']);
                    $data[$k]['username'] = $userInfo['username'];
                }
            }
        }
        $count = Lottery::count();
        return [
            'data'=>$data,
            'count'=>$count,
        ];
      
    }
    // 删除
    public static function del($id)
    {
        $data = Lottery::whereIn('id', $id)->find();
        if (!$data) return false;
        Lottery::destroy($id);
        return true;
    }

    // 新增
    public static function add($post)
    {
        $model = new Lottery();
        return $model->save($post);
    }
}