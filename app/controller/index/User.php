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

namespace app\controller\index;

use app\controller\core\InitController;
use app\model\admin\UserToken;
use think\facade\Cookie;
use think\facade\View;
use think\facade\Db;
use app\model\admin\User as UserModel;
use think\facade\Session;
use app\validate\index\User as UserValidate;
use app\controller\common\Common;
use app\controller\common\Smtp;
use app\validate\index\ChangePwd as ChangePwdValidate;
use app\validate\index\EmsRetrievePwd as EmsRetrievePwdValidate;
use app\validate\index\SmsRetrievePwd as SmsRetrievePwdValidate;
use app\validate\admin\Authentication as AuthenticationValidate;
use app\model\admin\Ems;
use app\model\admin\Sms;
use app\model\admin\Signin as SigninModel;
use app\model\admin\Admin as AdminModel;
use app\validate\admin\Admin as AdminValidate;
use app\controller\common\SendMail;
use app\model\admin\System as SystemModel;

/**
 * 用户
 * Class User
 * @package app\controller\index
 */
class User extends InitController
{

    /**
     * 个人中心
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/12 17:29
     */
     public function index()
    {  
        $notice = \app\model\admin\Notice::where('uid',$this->user['id'])->where('status','1')->whereDay('datetime')->order('createtime desc')->count();
        $userInfo = UserModel::findUser($this->user['id']);
   
    if(isMobile()){
    if (time()<=$userInfo['mobilelogintime']+3600*24*7){ 

            $logintime = $userInfo['mobilelogintime'];
            $overtime = floor((3600*24*7) - (time()-$userInfo['mobilelogintime'])); //实际剩下的时间（单位/秒）
            
        
      }else{

        $overtime=0;
      }
    
    }else{

    if (time()<=$userInfo['logintime']+3600*24*7){

            $logintime = $userInfo['logintime'];
            $overtime = floor((3600*24*7) - (time()-$userInfo['logintime'])); //实际剩下的时间（单位/秒）
            
        }else{
        $overtime=0;
      }
    }
        View::assign('days', UserModel::days($this->user['id']));
        View::assign('signin', SigninModel::where('user_id', $this->user['id'])->whereTime('createtime', 'today')->find());
        return View::fetch('index/user/index', ['userInfo' => $userInfo, 'overtime' => $overtime, 'logintime' => $logintime, 'notice' => $notice]);
    }

       // 后台登录跳转等待时间界面
    public function authentication()
    {
        if ($this->request->isPost()) {

        $uid = $this->request->post('uid');
        
        $email = $this->request->post('email');

        $list = SystemModel::where('key','emailqq')->find()['jdata'];
        $data = Ems::where(['email' => $email])->whereTime('createtime', 'today')
            ->group('email')->field(['email', 'MAX(times) AS times'])->findOrEmpty();

        if ($data->times >= 10) return $this->error(__('The limit has been reached today, please try again tomorrow!'));

        $exptime = time() + 60 * 10;//过期时间为十分钟

        $code = Common::GetfourStr($len = 6);
        
        $subject = __('Find the password');// 邮件标题
        $sendData = SendMail::sendEmail($email,$list,$code,$subject);
        if($sendData){
        $newData = [
            'event' => __('Member authentication'),
            'times' => $data->times + 1,
            'email' => $email,
            'code' => $code,
            'exptime' => $exptime,
            'ip' => $this->request->ip(),
        ];
        Ems::create($newData);
        return $this->success(true, 0, "$sendData", 1);
        
        }else{
            
       return $this->error("$sendData");
        }
        }
        return View::fetch('index/user/authentication');
    }

    // 身份验证
    public function authenticationCheck()
    {
        if ($this->request->isPost()) {
        $post = $this->request->post();
        $email = $post['email'];
        $keeplogin = (int)$this->request->post('keeplogin',0);
        
        // 实例化验证器
        $validate = new AuthenticationValidate();
        $authentication = $validate->check($post);
 
        // 输出验证器错误信息
        if (true !== $authentication) return $this->error($validate->getError());
        $keeplogin = (int)$this->request->post('keeplogin',0);
        $code = $post['code'];//字母全部转换成小写
        $model = Ems::where(['email' => $email, 'code' => $code])->find();
         if(strtoupper($code)<>strtoupper($model['code'])) return $this->error(__('Verification code error'));
        if ($model['exptime'] < time()) return $this->error(__('The verification code has expired'));
        $auth = UserModel::where(['email' => $email])->find();

        
        //记录登录IP
        //$auth->save(['loginip' => $this->request->ip()]);
        //判断连续登录和最大连续登录
        if ($auth->logintime < Common::unixtime('day')) {
            $auth->successions = $auth->logintime < Common::unixtime('day', -1) ? 1 : $auth->successions + 1;
            $auth->maxsuccessions = max($auth->successions, $auth->maxsuccessions);
                  // 更新登录时间
        if (isMobile()){ 
      
            $auth->save(['loginip' => $this->request->ip(), 'mobileprevtime'=>$auth->mobilelogintime, 'mobilelogintime'=>time(), 'login_time'=>time()]);
      }else{

        $auth->save(['loginip' => $this->request->ip(), 'prevtime'=>$auth->logintime, 'logintime'=>time(), 'login_time'=>time()]);
    }
        } elseif ($auth->logintime > Common::unixtime('day')) {
                  // 更新登录时间
        if (isMobile()){ 
      
            $auth->save(['loginip' => $this->request->ip(), 'mobileprevtime'=>$auth->mobilelogintime, 'mobilelogintime'=>time(), 'login_time'=>time()]);
      }else{

        $auth->save(['loginip' => $this->request->ip(), 'prevtime'=>$auth->logintime, 'logintime'=>time(), 'login_time'=>time()]);
    }
        }
        // 保持会话
        $map = [
            'user_id' => $auth->id,
            'token' => $auth->token,
            'expiretime' => time()+60*60*24*7,   // 7天
        ];
      

        // 设置token
        Session::set('userToken', $auth->token);
        if ($keeplogin === 1) {
            $model = UserToken::where('user_id', $auth->id)->find();
            if(isset($model['user_id'])==$auth->id){
        Cookie::set('userToken', $auth->token, 604800);
            UserToken::update(['expiretime' => time()+60*60*24*7], ['user_id' => $auth->id]);
            }else{
        Cookie::set('userToken', $auth->token, 604800);
            UserToken::add($map);
            } 
        }

        return $this->success('', 0, __('Verification successful, logging in'), url('user/index'));
    }
    }
    /**
     * 个人中心
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/15 22:34
     */
    public function profile()
    {  
        View::assign('users', UserModel::findUser($this->user['id']));
        return View::fetch('/index/user/profile');
    }
    // 修改密码
    public function changePwd()
    {
        return View::fetch('/index/user/changepwd');
    }

    // 登录检查
    public function auth()
    {
        $post = $this->request->post();
        // ajax回传数据处理
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        $keeplogin = (int)$this->request->post('keeplogin',0);
        $authentication = (int)$this->request->post('authentication',0);
        
        // 实例化验证器
        $validate = new AdminValidate();
        $admin = $validate->check($post);
 
        // 输出验证器错误信息
        if (true !== $admin) return $this->error($validate->getError());
            
        $auth = UserModel::auth($username);
           //判断用户名登录结束
        if (!$auth) 
        {
           //判断手机登录开始
            $auth = UserModel::where(['mobile' => $username])->find();
                if (!$auth) 
            {
           
           //判断邮箱登录开始
            $auth = UserModel::where(['email' => $username])->find();
                  if (!$auth) return $this->error(__('Login account does not exist'));
            }
           
        } 

        if ($auth->status <> 1) return $this->error(__('The account number is abnormal, please contact the administrator'));

        // 效验码密码

        if ($auth->password !== md5($password . $auth->salt)) {
            // 记一次登录失败次数
            $auth->save(['loginfailure' => $auth->loginfailure + 1]);
            return $this->error(__('Login password error'));
        }
        //记录登录IP
        //$auth->save(['loginip' => $this->request->ip()]);
        //判断连续登录和最大连续登录
        if ($auth->logintime < Common::unixtime('day')) {
            $auth->successions = $auth->logintime < Common::unixtime('day', -1) ? 1 : $auth->successions + 1;
            $auth->maxsuccessions = max($auth->successions, $auth->maxsuccessions);
                      // 更新登录时间
        if (isMobile()){ 
      
            $auth->save(['loginip' => $this->request->ip(), 'mobileprevtime'=>$auth->mobilelogintime, 'mobilelogintime'=>time(), 'login_time'=>time()]);
      }else{

        $auth->save(['loginip' => $this->request->ip(), 'prevtime'=>$auth->logintime, 'logintime'=>time(), 'login_time'=>time()]);
    }
        } elseif ($auth->logintime > Common::unixtime('day')) {
                      // 更新登录时间
        if (isMobile()){ 
      
            $auth->save(['loginip' => $this->request->ip(), 'mobileprevtime'=>$auth->mobilelogintime, 'mobilelogintime'=>time(), 'login_time'=>time()]);
      }else{

        $auth->save(['loginip' => $this->request->ip(), 'prevtime'=>$auth->logintime, 'logintime'=>time(), 'login_time'=>time()]);
    }
        }
        
        if($authentication === 1){
            
        return $this->success(true, 0, __('Submitted successfully, skipping identity authentication'),url('user/authentication?email='.base64_encode($auth->email)));
        }
        
        
       // 保持会话
        $map = [
            'user_id' => $auth->id,
            'token' => $auth->token,
            'expiretime' => time()+60*60*24*7,   // 7天
        ];
      
        // 设置token
        Session::set('userToken', $auth->token);
        if ($keeplogin === 1) {
            $model = UserToken::where('user_id', $auth->id)->find();
            if(isset($model['user_id'])==$auth->id){
        Cookie::set('userToken', $auth->token, 604800);
            UserToken::update(['expiretime' => time()+60*60*24*7], ['user_id' => $auth->id]);
            }else{
        Cookie::set('userToken', $auth->token, 604800);
            UserToken::add($map);
            } 
        }
        return $this->success('', 0, __('Verification successful, logging in'), url('user/index'));
    }

    // 退出登录
    public function logout()
    {
        $user_id = $this->user['id'];
        UserToken::del($user_id);
        return $this->success(true, 0, __('Exit successful'),url('user/login'));  
    }

      // 修改密码
    public function change()
    {
        
        if ($this->request->isPost()) {
            $param = $this->request->param();
      // 验证条件
            empty($param['oldpassword']) && $this->error(__('Please enter the old password'));
            empty($param['newpassword']) && $this->error(__('Please enter a new password'));
            empty($param['renewpassword']) && $this->error(__('Please enter the confirmation password'));
        $username = $param['username'];
        $oldpassword = $param['oldpassword'];
        $newpassword = $param['newpassword'];
        
       $pattern = '/^(?![0-9]+$)(?![a-z]+$)(?![A-Z]+$)(?!([^(0-9a-zA-Z)]|[\(\)])+$)([^(0-9a-zA-Z)]|[\(\)]|[a-z]|[A-Z]|[0-9]){6,}$/';
        if (!preg_match($pattern,$newpassword)) return $this->error(__('The password must contain any combination of uppercase and lowercase letters / numbers / symbols'));
        $renewpassword = $param['renewpassword'];

        $model = UserModel::where(['id' => $this->user['id']])->find();

        if (!$model) return $this->error(__('ID does not exist'));
        
        $oldpass = md5($oldpassword . $model->salt);
        if ($oldpass !== $model->password) return $this->error(__('The original password is wrong'));

        $data = [
            'salt' => Common::pwdMd5($newpassword)['salt'],
            'password' => Common::pwdMd5($newpassword)['password'],
        ];
        $res = UserModel::update($data, ['id' => $this->user['id']]);
        if (!$res) return false;
           
       $data = AdminModel::where(['username' => $username])->find();
 
           if(!empty($data)){
                   // 密码不填则是原始密码
            if (!empty($newpassword)) {
               $data = [
            'salt' => Common::pwdMd5($newpassword)['salt'],
            'password' => Common::pwdMd5($newpassword)['password'],
        ];
        AdminModel::update($data, ['username' => $username]);
            
            Session::delete('userToken');
            cookie('userToken',null);
        cookie('token',null);
        Session::delete('token');
            }
            }
        return $res ? $this->success('', 0, __('Modified successfully'), url('user/index')) : $this->error(__('Modification failed'));
    }
        
    }
    /**
     * 修改个人信息
     * @return array
     * @author: MK
     * @Time: 2020/4/16 20:52
     */
    
    //邮箱找回密码
    public function retrievePwd()
    {
 
        $uid = $this->request->post('uid');
        
        $email = $this->request->post('email');
        if (!$email) return $this->error(__('Email cannot be empty'));
        $pattern = '/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';
        if (!preg_match($pattern,$email)) return $this->error(__('Email format is incorrect'));
      
        switch ($uid)
            {
            case 2:
              $list = SystemModel::where('key','sina')->find()['jdata'];
              break;
            case 3:
              $list = SystemModel::where('key','emailqq')->find()['jdata'];
              break;
            default:
              $list = SystemModel::where('key','mail126')->find()['jdata'];
            }
        
        
        if ($list['status'] == 0) return $this->error(__('Email function has not been turned on, please contact the administrator'));

        $model = UserModel::where(['email' => $email])->find();
        if (empty($model)) return $this->error(__('Email does not exist'));
        $data = Ems::where(['email' => $email])->whereTime('createtime', 'today')
            ->group('email')->field(['email', 'MAX(times) AS times'])->findOrEmpty();

        if ($data->times >= 10) return $this->error(__('The limit has been reached today, please try again tomorrow'));

        $exptime = time() + 60 * 10;//过期时间为十分钟

        $code = Common::GetfourStr($len = 6);//验证码
         
        $subject = __('Find the password');// 邮件标题
        $sendData = SendMail::sendEmail($email,$list,$code,$subject);
        
        if($sendData == __('Sent successfully')){
            //插入数据
        $newData = [
            'event' => __('Find the password'),
            'times' => $data->times + 1,
            'email' => $email,
            'code' => $code,
            'exptime' => $exptime,
            'ip' => $this->request->ip(),
        ];
         Ems::create($newData);
      
        //return ['code' => 0, 'captcha' => $code,'msg'=>'发送成功'];
       return $this->success(true, 0, "$sendData", 1);
        
        }else{
            
       return $this->error("$sendData");
        }
        

    }

    // 邮箱找回密码验证
    public function emailcheck()
    {
        $post = $this->request->post();
        $email = $post['email'];
        
        // 实例化验证器
        $validate = new EmsRetrievePwdValidate();
        $ems = $validate->check($post);

        // 输出验证器错误信息
        if (true !== $ems) return $this->error($validate->getError());
        $code = $post['code'];//字母全部转换成小写
        
        $password = $post['password'];
        $model = Ems::where(['email' => $email, 'code' => $code])->find();
         if(strtoupper($code)<>strtoupper($model['code'])) return $this->error(__('Verification code error'));
        if ($model['exptime'] < time()) return $this->error(__('The verification code has expired'));
        
        $data = [
            'salt' => Common::pwdMd5($password)['salt'],
            'password' => Common::pwdMd5($password)['password'],
        ];
        //判断是否管理员
        $datas = AdminModel::where(['email' => $email])->find();
           if($datas){
                 
               $data = [
            'salt' => Common::pwdMd5($password)['salt'],
            'password' => Common::pwdMd5($password)['password'],
        ];
        AdminModel::update($data, ['email' => $email]);
            }
           
        $res = UserModel::update($data, ['email' => $email]);

        return $res ? $this->success('', 0, __('Modified successfully'), url('user/index')) : $this->error(__('Modification failed'));
    }

    //手机找回密码
    public function smsPwd()
    {
        $uid = $this->request->post('uid');
        $mobile = $this->request->post()['mobile'];
        $preg_phone='/^1[34578]\d{9}$/ims';
 
        if (!$mobile) return $this->error(__('Mobile phone cannot be empty'));
        if (!preg_match($preg_phone,$mobile)) return $this->error(__('Incorrect format of mobile phone number'));
        
        $model = UserModel::where(['mobile' => $mobile])->find();

        if (!$model) return $this->error(__('Mobile phone does not exist'));

        $list = SystemModel::where('key','sms')->find()['jdata'];
        if ($list['status'] == 0) return $this->error(__('SMS function has not been turned on, please use email to retrieve'));

        $data = Sms::where(['mobile' => $mobile])->whereTime('createtime', 'today')
            ->group('mobile')->field(['mobile', 'MAX(times) AS times'])->findOrEmpty();
        if ($data->times >= 3) return $this->error(__('The limit has been reached today, please try again tomorrow'));

        $statusStr = array(
            "0"  => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        );
        $smsapi = "http://api.smsbao.com/";
        $user = $list['name']; //短信平台帐号
        $pass = md5($list['password']); //短信平台密码

        $code = Common::GetfourStr($len = 6);
        $content = str_replace('{code}', $code, $list['moban']);//要发送的短信内容
        $phone = $mobile;//要发送短信的手机号码
        $sendurl = $smsapi . "sms?u=" . $user . "&p=" . $pass . "&m=" . $phone . "&c=" . urlencode($content);
        $result = file_get_contents($sendurl);

        if ($result == '0') {
            $exptime = time() + 60 * 10;//过期时间为十分钟

            // 重新组装数据
            $newData = [
                'event'   => __('Click Edit'),
                'times'   => $data->times + 1,
                'mobile'  => $mobile,
                'code'    => $code,
                'exptime' => $exptime,
                'ip'      => $this->request->ip(),
            ];
            Sms::add($newData);

        return ['code' => 0, 'captcha' => $code,'msg'=>__('Sent successfully')];
            //return $res ? $this->success(true, 0, '发送成功！', 1) : $this->error('发送失败！');
        } else {
            return $this->error(__('Unknown error, failed to send'));
        }
    }

    // 手机找回密码验证
    public function mobilecheck()
    {
        $post = $this->request->post();
        $mobile = $post['mobile'];
         
        // 实例化验证器
        $validate = new SmsRetrievePwdValidate();
        $sms = $validate->check($post);

        // 输出验证器错误信息
        if (true !== $sms) return $this->error($validate->getError());
        $code = $post['code'];
        $password = $post['password'];
        $model = Sms::where(['mobile' => $mobile, 'code' => $code])->find();
         if(empty($model)) return $this->error(__('Verification code error'));
         if ($model['exptime'] < time()) return $this->error(__('The verification code has expired'));
        
        
        $data = [
            'salt' => Common::pwdMd5($password)['salt'],
            'password' => Common::pwdMd5($password)['password'],
        ];
        $datas = UserModel::where(['mobile' => $mobile])->find();
         //判断是否管理员
      $username = $datas->username;
        $models = AdminModel::where(['username' => $username])->find();
           if($models){  
               $data = [
            'salt' => Common::pwdMd5($password)['salt'],
            'password' => Common::pwdMd5($password)['password'],
        ];
        AdminModel::update($data, ['username' => $username]);
            }
        $res = UserModel::update($data, ['mobile' => $mobile]);
        return $res ? $this->success('', 0, __('Modified successfully'), url('user/index')) : $this->error('修改失败!');
    }

    //修改邮箱
    public function email()
    {
  
        $uid = $this->request->post('uid');
        $email = $this->request->post('email');
        $pattern = '/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';
        if (!$email) return $this->error(__('Email cannot be empty')); 
        if (!preg_match($pattern,$email)) return $this->error(__('Email format is incorrect'));

        switch ($uid)
            {
            case 2:
              $list = SystemModel::where('key','sina')->find()['jdata'];
              break;
            case 3:
              $list = SystemModel::where('key','emailqq')->find()['jdata'];
              break;
            default:
              $list = SystemModel::where('key','mail126')->find()['jdata'];
            }
        
        
        if ($list['status'] == 0) return $this->error(__('Email function has not been turned on, please contact the administrator'));
        $model = UserModel::where(['status' => 1])->select();
             
              // 判断是否存在
        
            foreach ($model as $k => $v) 
            {
                     
                if ($v['email'] == $email) return $this->error(__('Mailbox already exists'));
            
        }

        $data = Ems::where(['email' => $email])->whereTime('createtime', 'today')
            ->group('email')->field(['email', 'MAX(times) AS times'])->findOrEmpty();

        if ($data->times >= 10) return $this->error(__('The limit has been reached today, please try again tomorrow'));

        $exptime = time() + 60 * 10;//过期时间为十分钟

        $code = Common::GetfourStr($len = 6);
        $subject = __('Modify mailbox');// 邮件标题
        $sendData = SendMail::sendEmail($email,$list,$code,$subject);
        
        if($sendData == __('Sent successfully')){
            //插入数据
        $newData = [
            'event' => __('Change mailbox'),
            'times' => $data->times + 1,
            'email' => $email,
            'code' => $code,
            'exptime' => $exptime,
            'ip' => $this->request->ip(),
        ];
         Ems::create($newData);
      
        //return ['code' => 0, 'captcha' => $code,'msg'=>'发送成功'];
       return $this->success(true, 0, "$sendData", 1);
        
        }else{
            
       return $this->error("$sendData");
        }
        

    }



    // 修改邮箱验证
    public function changeemail()
    {
        $post  = $this->request->post();
        $id    = $post['id'];
        $username    = $post['username'];
        $email = $post['email'];
        
        $pattern = '/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';
        if (!$email) return $this->error(__('Email cannot be empty')); 
        if (!preg_match($pattern,$email)) return $this->error(__('Email format is incorrect'));
        $code  = $post['code'];//字母全部转换成大写
         if (strlen($code) < 6 or strlen($code) > 6) return $this->error(__('Incorrect length of verification code'));
        $model = Ems::where(['email' => $email, 'code' => $code])->find();

        if(strtoupper($code)<>strtoupper($model['code'])) return $this->error(__('Verification code error'));
        
        if ($model['exptime'] < time()) return $this->error(__('The verification code has expired'));
        //判断是否管理员
        $data = AdminModel::where(['username' => $username])->find();
           if($data){
            $data->save(['email' => $email]);
            }
        $res = UserModel::update(['email' => $email], ['id' => $id]); 

        return $res ? $this->success('', 0, __('Modified successfully'), 1) : $this->error(__('修改失败'));
    }

    //修改手机
    public function mobile()
    {
        $uid = $this->request->post('uid');
        $mobile = $this->request->post()['mobile'];
        $preg_phone='/^1[34578]\d{9}$/ims';
        if (!$mobile) return $this->error(__('Mobile phone cannot be empty'));
        if (!preg_match($preg_phone,$mobile)) return $this->error(__('Incorrect format of mobile phone number'));
        
       
        $list = SystemModel::where('key','sms')->find()['jdata'];
        if ($list['status'] == 0) return $this->error(__('SMS function has not been turned on, please use email to retrieve'));

         $model = UserModel::where(['status' => 1])->select();
             
              // 判断是否存在
        
            foreach ($model as $k => $v) 
            {
                     
                if ($v['mobile'] == $mobile) return $this->error(__('Mobile phone already exists'));
            
        }
       
        
        $data = Sms::where(['mobile' => $mobile])->whereTime('createtime', 'today')
            ->group('mobile')->field(['mobile', 'MAX(times) AS times'])->findOrEmpty();
        if ($data->times >= 3) return $this->error(__('The limit has been reached today, please try again tomorrow'));

        $statusStr = array(
            "0"  => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        );
        $smsapi = "http://api.smsbao.com/";
        $user = $list['name']; //短信平台帐号
        $pass = md5($list['password']); //短信平台密码

        $code = Common::GetfourStr($len = 6);
        $content = str_replace('{code}', $code, $list['moban']);//要发送的短信内容
        $phone = $mobile;//要发送短信的手机号码
        $sendurl = $smsapi . "sms?u=" . $user . "&p=" . $pass . "&m=" . $phone . "&c=" . urlencode($content);
        $result = file_get_contents($sendurl);

        if ($result == '0') {
            $exptime = time() + 60 * 10;//过期时间为十分钟

            // 重新组装数据
            $newData = [
                'event'   => '更换手机',
                'times'   => $data->times + 1,
                'mobile'  => $mobile,
                'code'    => $code,
                'exptime' => $exptime,
                'ip'      => $this->request->ip(),
            ];
            Sms::add($newData);

            return ['code' => 0, 'captcha' => $code,'msg'=>__('Sent successfully')];
        } else {
            return $this->error(__('Unknown error, failed to send'));
        }
    }

    // 修改手机验证
    public function changemobile()
    {
        $post   = $this->request->post();
        $mobile = $post['mobile'];
        
        
        $preg_phone='/^1[34578]\d{9}$/ims';
        if (!$mobile) return $this->error(__('Mobile phone cannot be empty'));
        if (!preg_match($preg_phone,$mobile)) return $this->error(__('Incorrect format of mobile phone number'));
        $code   = $post['code'];
          if (!$code) return $this->error(__('Verification code cannot be empty'));
          if (strlen($code) < 6 or strlen($code) > 6) return $this->error(__('Incorrect length of verification code'));
        $id     = $post['id'];
        $model  = Sms::where(['mobile' => $mobile, 'code' => $code])->find();

        $newtime = time();
        if ($model['code'] !== $code) return $this->error(__('Verification code error'));
        if ($model['exptime'] < $newtime) return $this->error(__('The verification code has expired'));
       
        $res = UserModel::update(['mobile' => $mobile], ['id' => $id]);

        return $res ? $this->success('', 0, __('Modified successfully'), 1) : $this->error(__('Modification failed'));
    }
      

}