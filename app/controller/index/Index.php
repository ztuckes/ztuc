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
 * Date: 2020/3/13
 * Time: 20:11
 */
namespace app\controller\index;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Category;
use app\model\admin\Notice;
use app\model\admin\Tourist;
/**
 * 首页控制器
 * Class Index
 * @package app\controller\index
 */
class Index extends InitController
{

   //判断游客ip
    public static function touristRecords() 
    {
        Tourist::whereTime('updatetime','<=',time()-60*60*4)->where(['locks' => 0])->update(['locks' => 1]);//更新解黑状态
        
    $result = Tourist::touristIp(request()->ip());
    if(!empty($result)){ 
            Tourist::update(['status' => 1], ['ip' => request()->ip()]); 
          }else{
            $data = ['tourist_name' => 'SB_'.substr(md5(time()), -4), 'ip' => request()->ip(), 'agent' => substr(request()->server('HTTP_USER_AGENT'), 0, 255)];
        Tourist::create($data);
        }
        Tourist::whereTime('updatetime','<=',time()-60*60*8)->where(['status' => 1])->update(['status' => 2]);//更新在线状态
        
        return Tourist::touristIp(request()->ip());

   } 
     // 聊天
    public function chat()
    {    
         //聊天评论 
        $chatzone = Notice::chatZone();
        $chatreply = Notice::chatReply();
        View::assign('count', $chatzone['count']);
        return View::fetch('chat',['chatreply' => $chatreply, 'chatzone' => $chatzone['data']]);
    }
    // 投稿
    public function contribution()
    { 
        $data = Category::category();
        $tree = $this->dropTree($data,0,0);
        View::assign('name',$tree);
        return View::fetch('contribution');
    }
    // 首页
    public function index()
    { 
        $model = Tourist::touristIp(request()->ip());
     
      if ($model['locks'] == 0){ 

            $overtime = floor((60*60*4) - (time()-$model['exptime'])); //实际剩下的时间（单位/秒）
            
          return View::fetch('dispatch_jump', ['overtime' => $overtime]);
      }else{

        $overtime=0;

          return View::fetch('index', ['overtime' => $overtime]);
      }
          return View::fetch('index');
    } 
     // 登录
    public function welcome()
    {
        return View::fetch('welcome');
    }
    // 用户登录
    public function login()
    {
        return View::fetch('login');
    }

    // 用户注册
    public function register()
    {
        return View::fetch('register');
    }

    // 邮箱找回密码
    public function ems()
    {
         return View::fetch('emsretrievepwd');
    }
     // 手机找回密码
    public function sms()
    {
         return View::fetch('smsretrievepwd');
    }
    
}
