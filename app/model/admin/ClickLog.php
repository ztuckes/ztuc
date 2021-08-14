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
 * Class ClickLog
 * @package app\model\admin
 */
class ClickLog extends InitModel
{
    // 定义表
    protected $name = 'click_log';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段
    protected static $available = [
        'id',
        'uid',
        'article_id',
        'ip',
        'createtime',
    ];
   // 列表
  
   public static function lists($page,$limit)
    {  
        $data = ClickLog::order('id', 'desc')->page($page,$limit)->select();
       
       //获取用户信息
        if(!empty($data)) {
            foreach ($data as $k => $v) {
                if ($v['uid']) {
                   $userInfo = User::findUser($v['uid']);
                   $data[$k]['uid'] = $userInfo['username'];  
                   }
                }
            }
        $count = ClickLog::count();
        return [
            'data'=>$data,
            'count'=>$count,
        ];
      
    }
    // 删除
    public static function del($id)
    {
        $data = ClickLog::whereIn('id', $id)->find();
        if (!$data) return false;
        ClickLog::destroy($id);
        return true;
    }

    // 新增
    public static function add($post)
    {
        $model = new ClickLog();
        return $model->save($post);
    } 

     // 点赞查询
    public static function findClickLog($id, $uid, $ip)
    {

        return ClickLog::where(['article_id' => $id, 'uid' => $uid, 'ip' => $ip])->whereTime('createtime', '>=', time()-60*60*4)->find();
}
 // // 今日发贴浏览点赞查询
    public static function todaysDataClick()
    {

       return ClickLog::whereDay('createtime')->count();
}

}