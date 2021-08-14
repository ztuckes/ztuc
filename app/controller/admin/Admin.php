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
 * Date: 2020/3/10
 * Time: 20:36
 */

namespace app\controller\admin;

use app\controller\common\Upload;
use app\controller\core\InitController;
use app\model\admin\AuthGroupAccess;
use think\facade\Cache;
use think\facade\View;
use app\model\admin\Admin as AdminModel;
use think\facade\Session;
use think\facade\Cookie;
use app\model\admin\AuthRule;
use app\model\admin\AuthGroup;
use app\model\admin\UserToken;
use app\model\admin\Ems;
use think\facade\Db;
use app\controller\common\Smtp;
use app\controller\common\Common;
use app\validate\admin\Admin as AdminValidate;
use app\validate\admin\Authentication as AuthenticationValidate;
use app\model\admin\User as UserModel;
use app\model\admin\ArticleLog;
use app\model\admin\Tourist;
use app\model\admin\User;
use app\model\admin\Signin;
use app\model\admin\Article;
use app\model\admin\ClickLog;
use app\model\admin\System as SystemModel;
use app\controller\common\SendMail;
 /* 登录
 * Class Login
 * @package app\controller\admin
 */
class Admin extends InitController
{

    function get_week($time = '', $format='Y-m-d'){
        $time = $time != '' ? $time : time();
        //获取当前周几
        $week = date('w', $time);
        $date = [];
        for ($i=1; $i<=7; $i++){
        $date[$i] = date($format ,strtotime( '+' . $i-$week .' days', $time));
        }
        return $date;

    }
    function get_day($time = '', $format='Y-m-d'){
        $time = $time != '' ? $time : time();
        $days = date('t', $time);
        $sday = strtotime(date('Y-m-01'));
        $date = [];
        for ($i=0; $i<date('d'); $i++){
            $date[$i] = date($format ,$sday+$i*86400);
        }
        return $date;

    }
    // 默认首页
    public function home()
    { 
     $list = Signin::order('createtime desc')->paginate(10);
        // 获取用户信息
     
        if (!empty($list)) {
            $data=[
                'msg'=>'操作成功',
                'signNum'=>Signin::whereTime('createtime', 'today')->count(),
                'code'=>200,
                'allNum'=>User::inlineIp()
            ];
            foreach ($list as $k => $v) {
                if ($v['user_id']){
                    $userInfo = User::findUser($v['user_id']);
                    $list[$k]['username'] = isset($userInfo['username'])?$userInfo['username']:'';
                    $data['signList'][]=[
                        'number'=>$v['user_id'],
                        'name'=>$userInfo['username']??'',
                        'time'=>$v['createtime'],
                    ];
                }
            }
            $datajson=json_encode($data);
        }//日统计
       
     $lists = Signin::order('createtime desc')->whereWeek('createtime')->count();
        // 获取用户信息

             $data=[     
                'msg'=>'操作成功',
                'code'=>200
                  ];

             foreach( $this->get_week() as $v)     {
                $data['data'][]=[
                    'date'=>$v,
                    'signNum'=>Signin::whereDay('createtime', $v)->count()??0,
                    'unSignNum'=>User::inlineIp()-Signin::whereDay('createtime', $v)->count()??0,
                ];

            }
            $datajsonlist=json_encode($data);
//周统计

     $lists = Signin::order('createtime desc')->whereMonth('createtime')->select(); 
        // 获取用户信息

             $data=[     
                'msg'=>'操作成功',
                'code'=>200
                  ];
             foreach( $this->get_day() as $v)     {
                $data['data'][]=[
                    'date'=>$v,
                    'signNum'=>Signin::whereDay('createtime', $v)->count()??0,
                    'unSignNum'=>User::inlineIp()-Signin::whereDay('createtime', $v)->count()??0,
                ];

            }
            $datajsonlist2=json_encode($data);
//月统计
        $model = AdminModel::where('id', $this->admin->id)->find();
        View::assign([
            'datajsonlist2'=>$datajsonlist2,
            'datajsonlist'=>$datajsonlist,
            'datajson'=>$datajson,
            'count' => User::inlineIp(),//查询应签到人数
            'signin'=>Signin::whereTime('createtime', 'today')->count(),//查询今天签到人数
            'view'  => Article::viewCode(),//总浏览
            'click' => Article::clickCode(),//总点赞
            'cat' => Article::catCode()//总发贴
        ]);
        return View::fetch('home', ['model' => $model]);
    }


    /**
     * 控制台
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/5 21:46
     */
    public function index()
    { 
        $model = AdminModel::group($this->admin->id);
        $group = AuthGroup::findGroup($this->admin->id);
        $ids = explode(',',$group['rules']);
        if(isMobile()){
        $prevtime = $model['mobilelogintime'];
        }else{
        $prevtime = $model['logintime'];
        }
        
        View::assign('loginip',$model['loginip']);
        View::assign('rule',$this->tree(AuthRule::leftTree($ids)));
        return View::fetch('index', ['prevtime' => $prevtime]);

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

        if ($data->times >= 3) return $this->error(__('The limit has been reached today, please try again tomorrow'));

        $exptime = time() + 60 * 10;//过期时间为十分钟
        
        $code = Common::GetfourStr($len = 6);
         
        $subject = __('Find the password');// 邮件标题
        $sendData = SendMail::sendEmail($email,$list,$code,$subject);
        if($sendData){

        $newData = [
            'event' => __('Administrator authentication'),
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
        return View::fetch('authentication');
    }

    // 身份验证
    public function authenticationCheck()
    {
        if ($this->request->isPost()) {
        $post = $this->request->post();
        $email = $post['email'];
        
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
        $check = AdminModel::where(['email' => $email])->find();
        
       
        // 设置token
        Session::set('token', $check->token);

        if ($keeplogin === 1) {
        Cookie::set('token', $check->token, 604800);
       }


        return $this->success('', 0, __('Verification successful, logging in'), url('admin/index'));
       }
    }
    // 登录
    public function login()
    {
        return View::fetch('login');
    }
    // 列表
    public function lists()
    {
        View::assign('group',AuthGroup::groupName());
        return View::fetch('list');
    }
    // 登录检查
    public function check()
    {
        $post = $this->request->post();
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        $keeplogin = (int)$this->request->post('keeplogin',0);
        $adminauth = (int)$this->request->post('adminauth',0);

        if (!$username || !$password){
            return $this->error(__('Please input user name or password'));
        }

        
        // 实例化验证器
        $validate = new AdminValidate();
        $admin = $validate->check($post);
 
        // 输出验证器错误信息
        if (true !== $admin) return $this->error($validate->getError());
              
        $check = AdminModel::check($username);
        if (!$check) 
            {
            $check = AdminModel::where(['email' => $username])->find();
            if(!$check) return $this->error(__('Account does not exist'));
            }

        if ($check->status <> 1) {
            return $this->error(__('The account number is abnormal, please contact the administrator'));
        }
        //记录登录时间IP
        
        // 效验密码
        $salt = $check->salt;
        if ($check->password !== md5($password . $salt)) {
            // 记一次登录失败次数
            $check->loginfailure = $check->loginfailure + 1;
            $check->save();
            return $this->error(__('Login password error'));
        }

        $uid = AuthGroupAccess::findAccess($check->id);
        if (!$uid){
            return $this->error(__('The role is not assigned permissions'));
        }

        // 更新登录时间
        if (isMobile()){ 
        $check->save(['loginip' => $this->request->ip(), 'prevtime' => $check->mobilelogintime, 'mobilelogintime' => time()]);
      }else{
        $check->save(['loginip' => $this->request->ip(), 'prevtime' => $check->logintime, 'logintime' => time()]);
       
    }
        $check->save();
        
         if($adminauth === 1){
         
        return $this->success(true, 0, __('Submitted successfully'),url('admin/authentication?email='.base64_encode($check->email)));   
        }
        
        // 设置token
        Session::set('token', $check->token);
        if ($keeplogin === 1) {
        Cookie::set('token', $check->token, 604800);
       }

        return $this->success('', 0, __('Verification successful, logging in'), url('admin/index'));

    }

    // 退出登录
    public function logout()
    {
        cookie('token',null);
        Session::delete('token'); 
        return $this->success('', '', __('Exit successful'));
    }

    // 新增
    public function add()
    {
        $post = $this->request->post();
             if ((int)$post['group_id'] == 1) return $this->error(__('No additional administrator privileges can be added'));
        $add = $this->request->post();
        $res = AdminModel::add($add);
        return $res ? $this->saveSuccess() : $this->error();
    }


    // 详情
    public function info()
    {
        $get = $this->request->get();
        $data = AdminModel::lists($get);
        return $this->success($data['data'], $data['count']);
    }

    // 删除
    public function del()
    {
        $post = $this->request->post();
        $id = $this->request->post('id');

        $uid = $this->request->get('uid');
        if ((int)$uid !== 1) return $this->success(true, 0, __('No right to delete'));
        $del = AdminModel::del($id);
        return $del ? $this->delSuccess() : $this->error();
   
}
        

    // 编辑
    public function edit()
    {
        $post = $this->request->post();
        $post['id'] = isset($post['id']) ? $post['id'] : $this->request->get('id');
       
        $email = isset($post['email']) ? $post['email'] : '';
        $username = isset($post['username']) ? $post['username'] : '';  
        $password = isset($post['password']) ? $post['password'] : '';
         
        $post['groups_id'] = isset($post['groups_id']) ? $post['groups_id'] : '';
        $post['group_id'] = isset($post['group_id']) ? $post['group_id'] : '';

          if(isset($post['status'])){
            AdminModel::update(['status' => $post['status']], ['id'=>$post['id']]); 
           return $this->success(true, 0, __('Modified successfully'));
           }
        $model = UserModel::where(['username' => $username])->find();
        if(!empty($model))
        {
                   // 密码不填则是原始密码
            if (!empty($password)) 
            {
               $data = [
            'salt' => Common::pwdMd5($password)['salt'],
            'password' => Common::pwdMd5($password)['password'],
            
        ];
        $model->save(['email' => $email]);
        UserModel::update($data, ['username' => $post['username']]);
            }else{
                $model->save(['email' => $email]);
                } 
        }
              //查询
              $data = AdminModel::group($post['id']);
       $post['status'] = isset($post['status']) ? $post['status'] : $data['status'];
             if ($data['id'] == 1 && (int)$post['group_id'] !== 1) return $this->error(__('Undeliverable right'));
             if ($data['id'] !== 1 && (int)$post['group_id'] == 1) return $this->error(__('Super administrator privilege cannot be upgraded'));
        
         if(!empty($post['username'])){
              //权限大于自己
             if ($data['groups_id'] < (int)$post['groups_id'])
            {
                if ((int)$post['group_id'] == 0) return $this->error(__('Please select permission'));
                    if($post['group_id'] >= (int)$post['groups_id'])
                    { 
                      if ((int)$post['group_id'] <= (int)$post['groups_id']) return $this->error(__('No upgrade is the same as or higher than your own permission'));
                      AdminModel::edit($post);
                    return $this->success(true, 0, __('Add administrator rights successfully'));
                    } 
                     return $this->error(__('Operation without permission'));
            }
             //权限小于自己
               if ($data['groups_id'] > (int)$post['groups_id'])
                    {
                        if ((int)$post['group_id'] !== 0) 
                       {
                      if ((int)$post['group_id'] <= (int)$post['groups_id']) return $this->error(__('No upgrade is the same as or higher than your own permission'));
                     AdminModel::edit($post);
                 return $this->success(true, 0, __('Modified successfully'));
                       }else{
                        AdminModel::edit($post);
                    return $this->success(true, 0, __('Cancel permission successfully'));
                       }
                    }  
               //   权限等于自己  
              if ($data['groups_id'] == (int)$post['groups_id'])
                    {
                      if ((int)$post['group_id'] < (int)$post['groups_id'] or (int)$post['group_id'] > (int)$post['groups_id']) return $this->error(__('No right to operate lifting right'));
                    }  
                }
               
           $edit = AdminModel::edit($post);
      
        return $edit ? $this->saveSuccess() : $this->error();
    }

    // 清除模板，日志缓存
    public function clearTempLog()
    {
        $years = date('Y').date('m');
        array_map( 'unlink', glob( app()->getRuntimePath() . 'log' . DIRECTORY_SEPARATOR . $years . DIRECTORY_SEPARATOR . '*.log' ) );
        array_map( 'unlink', glob( app()->getRuntimePath() . 'temp' . DIRECTORY_SEPARATOR . '*.php' ) );
        Cache::clear();
        return $this->success('', '', __('Data cache cleared successfully'),url('admin/home'));
    }
//修改密码
    public function editPassword()
    {
            $id = $this->request->get('id');
        if ($this->request->isPost()) {
            $param = $this->request->param();
            // 验证条件
            empty($param['password']) && $this->error('请输入旧密码');
            empty($param['new_password']) && $this->error('请输入新密码');
            empty($param['rep_password']) && $this->error('请输入确认密码');
            !check_password($param['new_password'], 6, 16) && $this->error('请输入6-16位的密码'); 
            $pattern = '/^(?![0-9]+$)(?![a-z]+$)(?![A-Z]+$)(?!([^(0-9a-zA-Z)]|[\(\)])+$)([^(0-9a-zA-Z)]|[\(\)]|[a-z]|[A-Z]|[0-9]){6,}$/';
        if (!preg_match($pattern,$param['new_password'])) return $this->error('密码必须包含大小写字母/数字/符号任意两者组合！');
            $param['new_password'] != $param['rep_password'] && $this->error('两次密码不一致');
            $model = AdminModel::where('id', $id)->find();
            //$model['password'] != md5($param['password'].$model['salt']) && $this->error('旧密码错误');

             if ($model['password'] !== md5($param['password'] . $model['salt'])) {
            
            return $this->error('旧密码错误');
        }

                $salt = Common::pwdMd5($param['new_password'])['salt'];
                $password = Common::pwdMd5($param['new_password'])['password'];
          
            $param['salt'] = substr(md5(time()), -10);    //密码盐
            $data = ['id' => $id, 'password' => $password, 'salt' => $salt];
            $result = AdminModel::update($data);
            if ($result == true) {
                session('admin_auth', null);
                session('admin_auth_sign', null);
                $this->success('更新成功', url('admin/index'));
            } else {
                $this->error($this->errorMsg);
            }
        }
        return $this->fetch('editpassword',['id' => $id]);
    }
    // 头像上传
    public function upload()
    {
        $upload = Upload::upload(Upload::ADMIN_PATH);
        return $this->success($upload['file'],0,$upload['msg']);
    }
}