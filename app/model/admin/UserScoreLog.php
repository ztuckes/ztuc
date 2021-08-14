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
 * UserScoreLog: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\model\admin;
use app\controller\common\Common;

use app\model\core\InitModel;

/**
 * 用户积分
 * Class UserScoreLog
 * @package app\model\admin
 */
class UserScoreLog extends InitModel
{
    // 定义表
    protected $name = 'user_score_log';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段
    protected static $available = [
        'id',
        'user_id',
        'score',
        'before',
        'after',
        'memo',
        'createtime',
    ];   

    // 列表
     public static function lists($page,$limit)
    {  
        $data = UserScoreLog::order('id desc')->page($page,$limit)->select();
        
        // 获取用户信息
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if ($v['user_id']){
                    $userInfo = User::findUser($v['user_id']);
                    $data[$k]['username'] = isset($userInfo['username'])?$userInfo['username']:"";
                }
            }
        }
        $count = UserScoreLog::count(); 
        return [
            'data'=>$data,
            'count'=>$count,
        ];
      
    }

    public static function add($post)
    {
        if (isset($post['id'])) unset($post['id']);
        $model = new UserScoreLog();
        return $model->save($post);
    }

    public static function edit($post)
    {
        $id = (int)$post['id'];
        $model = UserScoreLog::where('id',$id)->find();
        if (!$model) return false;
        return $model->save($post);
    }


    public static function del($id)
    {
        $data = UserScoreLog::whereIn('id', $id)->find();
        if (!$data) return false;
        UserScoreLog::destroy($id);
        return true;
    }


}