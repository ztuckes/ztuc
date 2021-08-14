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
 * Class ViewLog
 * @package app\model\admin
 */
class ArticleLog extends InitModel
{
    // 定义表
    protected $name = 'article_log';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段
    protected static $available = [
        'id',
        'uid',
        'url',
        'agent',
        'view',
        'article_id',
        'ip',
        'createtime',
    ];
   // 列表
  
   public static function lists($page,$limit)
    {  
        $data = ArticleLog::order('id', 'desc')->page($page,$limit)->select();
        // 获取用户信息
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if ($v['ip']){
                    $userInfo = Tourist::touristIp($v['ip']);
                    $data[$k]['uid'] = $userInfo['tourist_name'];
                }
            }
        }
        $count = ArticleLog::count();
        return [
            'data'=>$data,
            'count'=>$count,
        ];
      
    }
    // 删除
    public static function del($id)
    {
        $data = ArticleLog::whereIn('id', $id)->find();
        if (!$data) return false;
        ArticleLog::destroy($id);
        return true;
    }

    // 新增
    public static function add($post)
    {
        $model = new ArticleLog();
        return $model->save($post);
    } 


   // 今日发贴浏览点赞查询
    public static function todaysDataClick()
    {

       return ArticleLog::whereDay('createtime')->count();
  }
    // 今日浏览量
    public static function todaysDataView()
    {
        return ArticleLog::whereTime('createtime', 'today')->sum('view');
    }

     //昨日发贴浏览点赞查询
    public static function yesterDayview()
    {

       return ArticleLog::whereDay('createtime', 'yesterday')->sum('view');
}
   
   
     //昨日发贴浏览点赞查询
    public static function theDayBeforeYesterday()
    {

       return ArticleLog::whereDay('createtime', 'yesterday', -1)->sum('view');
}
   
    
}