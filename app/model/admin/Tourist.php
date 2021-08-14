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
 * Tourist: Administrator
 * Date: 2020/4/10
 * Time: 21:59
 */

namespace app\model\admin;

use app\model\core\InitModel;

/**
 * 点赞记录
 * Class Tourist
 * @package app\model\admin
 */
class Tourist extends InitModel
{
    // 定义表
    protected $name = 'tourist';

     // 第一自动写入时间字段
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    
     // 记录游客IP
    public static function touristIp($ip)
    {

       return Tourist::where(['ip' => $ip])->comment('查询IP是否存在')->find();
    }
   // 查询在线人数
    public static function inlineIp()
    {

       return Tourist::where(['status' => 1])->comment('查询在线人数')->count();
    }

     //昨日访问IP
    public static function yesterDayIp()
    {

       return Tourist::whereDay('createtime', 'yesterday')->where(['status' => 1])->comment('昨日访问IP')->count();
}
   
}