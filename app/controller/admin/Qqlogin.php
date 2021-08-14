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
/**
 * Created by PhpStorm.
 * LotteryGift: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\controller\admin;

use think\facade\Session;
use think\facade\Cookie;
use app\model\admin\UserToken;
use app\controller\core\InitController;
use think\facade\View;
use app\controller\common\Common;
use app\model\admin\User as UserModel;
use app\validate\admin\Admin as AdminValidate;
use app\model\admin\Setting as SettingModel;
class Qqlogin extends InitController
{
         // 绑定检查
    public function auth()
    {
        $post = $this->request->post();  
        // ajax回传数据处理
        $username = $this->request->post('username');
        $password = $this->request->post('password');

        $openid = $this->request->post('openid');
       
        // 实例化验证器
        $validate = new AdminValidate();
        $admin = $validate->check($post);
 
        // 输出验证器错误信息
        if (true !== $admin) return $this->error($validate->getError());
        $auth = UserModel::auth($username);
        if (!$auth) return $this->error('用户名不存在！');
        if ($auth['status'] <> 1) {
            return $this->error('账号已异常，请联系管理员！');
        }

            // 效验码密码
       
        if ($auth->password !== md5($password . $auth->salt)) {
            // 记一次登录失败次数
            $auth->save(['loginfailure'=>$auth->loginfailure + 1]);
            return $this->error('密码错误！');
        }
         UserModel::where(['status'=>1, 'username'=>$username])->update(['openid'=>$openid]);
            //判断连续登录和最大连续登录
        if ($auth->logintime < Common::unixtime('day')) {
            $auth->successions = $auth->logintime < Common::unixtime('day',-1) ? 1 : $auth->successions + 1;
            $auth->maxsuccessions = max($auth->successions, $auth->maxsuccessions);
            // 更新登录时间
            $auth->save(['prevtime'=>$auth->logintime, 'logintime'=>time()]);
            }elseif($auth->logintime > Common::unixtime('day')) {
             $auth->save(['prevtime'=>$auth->logintime, 'logintime'=>time()]);   
            }

        // 设置token
        Session::set('userToken', $auth->token);

        return $this->success(true, 0, '绑定成功！', url('user/index'), 1);
    }
  
      // 处理qq登录
    public function qqlogin()
    {
     //应用APP ID
     $app_id = "101549464";
      //应用APP Key
     $app_secret = "06a102ab136ec68afa05624792e5061a";
      //应用填写的网站回调域
     $my_url = "http://m.ztuc.cn/qqlogin";
     
      //Step1：获取Authorization Code
      $code=isset($_REQUEST["code"])?$_REQUEST["code"]:0;//存放Authorization Code
   
      if(empty($code)) {
        //state参数用于防止CSRF攻击，成功授权后回调时原样带回
        $state = md5(uniqid(rand(), TRUE));
        Session::set('state',$state);
        //拼接URL
        $dialog_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=".$app_id."&redirect_uri=".urlencode($my_url)."&state=".Session::get('state');
        return redirect($dialog_url)->send();
    }
       $stream_opts = [
         "ssl" => [
             "verify_peer"=>false,
             "verify_peer_name"=>false,
           ]
        ]; 

       //$response = file_get_contents("https://xxx.xxx.xxx",false, stream_context_create($stream_opts));
        //Step2：通过Authorization Code获取Access Token
       if($_REQUEST['state'] == Session::get('state') || 1) {
        //拼接URL
        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"."client_id=".$app_id."&redirect_uri=".urlencode($my_url)."&client_secret=".$app_secret."&code=".$code;
        //$response = file_get_contents($token_url);
         $response = file_get_contents($token_url,false, stream_context_create($stream_opts));
 
        //如果用户临时改变主意取消登录，返回true!==false,否则执行step3  
        if (strpos($response, "callback") !== false) {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);
            if (isset($msg->error)) {
               
              return $msg->error.$msg->error_description;
            }
        }
  
        //Step3：使用Access Token来获取用户的OpenID
        $params = array();
        parse_str($response, $params);//把传回来的数据参数变量化
        $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$params['access_token'];
        $str = file_get_contents($graph_url,false, stream_context_create($stream_opts));
        if (strpos($str, "callback") !== false) {
            $lpos = strpos($str, "(");
            $rpos = strrpos($str, ")");
            $str = substr($str, $lpos + 1, $rpos - $lpos -1);
        }
        $user = json_decode($str);//存放返回的数据 client_id ，openid
        if (isset($user->error)) {
           
            return $user->error.$user->error_description;
        }
  
        //Step4：使用openid和access_token获取用户信息
        $user_data_url = "https://graph.qq.com/user/get_user_info?access_token={$params['access_token']}&oauth_consumer_key={$app_id}&openid={$user->openid}&format=json";
      
        $user_data = json_decode(file_get_contents($user_data_url,false, stream_context_create($stream_opts)));//获取到的用户信息

        //以下为授权成功后的自定义操作
        if($user_data){
            $model =UserModel::where(['openid'=>$user->openid])->where('status', 1)->find();
      
        if (isset($model['openid'])==$user->openid){
           //系统设置
          if (seo('authentication') == '0') {
          if ($model->logintime < Common::unixtime('day')) {
          
            $model->successions = $model->logintime < Common::unixtime('day',-1) ? 1 : $model->successions + 1;
            $model->maxsuccessions = max($model->successions, $model->maxsuccessions);
            // 更新登录时间
        if (isMobile()){ 
      
            $model->save(['loginip' => $this->request->ip(), 'mobileprevtime'=>$model->mobilelogintime, 'mobilelogintime'=>time(), 'login_time'=>time()]);
      }else{

        $model->save(['loginip' => $this->request->ip(), 'prevtime'=>$model->logintime, 'logintime'=>time(), 'login_time'=>time()]);
    }
            }elseif($model->logintime > Common::unixtime('day')) {
              if (isMobile()){ 
      
            $model->save(['loginip' => $this->request->ip(), 'mobileprevtime'=>$model->mobilelogintime, 'mobilelogintime'=>time(), 'login_time'=>time()]);
      }else{

        $model->save(['loginip' => $this->request->ip(), 'prevtime'=>$model->logintime, 'logintime'=>time(), 'login_time'=>time()]);
    }   
            }
            $id = isset($this->user['id']);
           $userInfo = UserModel::findUser($id);
        View::assign('userInfo',$userInfo);
        
         // 保持会话
        $map = [
            'user_id' => $model->id,
            'token' => $model->token,
            'expiretime' => time() + 60*60*24*30,   // 7天
        ];
      
        
            $data = UserToken::where('user_id', $model->id)->find();
            if(isset($data['user_id'])==$model->id){
            UserToken::update(['expiretime' => time() + 60*60*24*30], ['user_id' => $model->id]);
            }else{
            UserToken::add($map);
            } 
       
            Session::set('userToken', $model->token);
            Cookie::set('userToken', $model->token, 2592000);

        return $this->success('', 0, '验证成功，正在登录', url('user/index'));
           }
       return $this->success(true, 0, '提交成功,正在跳转',url('user/authentication?email='.base64_encode($model->email)));
        }else{
            
          View::assign('name',$user_data->nickname);
          View::assign('image',$user_data->figureurl_qq_2);
          View::assign('openid',$user->openid);
          return View::fetch('index/user/binding');

        
     }

        }else{
       
            return $this->error('未知错误！');
        }
    }else{
         return $this->error('The state does not match. You may be a victim of CSRF');
    }
 
 }

}