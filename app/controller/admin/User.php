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
 * User: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use think\facade\Db;
use app\controller\common\Common;
use app\model\admin\User as UserModel;
use app\model\admin\Admin as AdminModel;
use think\facade\Filesystem;
use app\controller\common\Upload;
use app\model\admin\Image;
/**
 * 用户
 * Class User
 * @package app\controller\index
 */
class User extends InitController
{
      //列表详情
    public function index_json($limit='15')
    {
        $param = $this->request->param();
        $user = new UserModel();
        if (isset($param['status'])) {
            $user = $user->where('status',$param['status']);
        }
        if (isset($param['subscribe'])) {
            $user = $user->whereLike('mobile|email|username|qq','%'.$param['subscribe'].'%');
        }
        $list = $user->order('id asc')->paginate($limit);
        
        if (!empty($list)) {
            // 获取图片
            foreach ($list as $k => $v) {
                $v['image'] = Image::image($v['id'], Upload::TYPE_USER);
            }
        }

        $this->result($list);
    }
    // 列表
    public function lists()
    {
        return View::fetch('list');
    }

    // 新增
    public function add()
    {      
        if ($this->request->isPost()) {
            $param = $this->request->param();
            
            !check_password($param['password'], 6, 12) && $this->error('请输入6-12位的密码');
            $param['nickname'] = $param['username'];
            $param['token'] = Common::token();
            $param['salt'] = Common::pwdMd5($param['password'])['salt'];
            $param['password'] = Common::pwdMd5($param['password'])['password'];
            $jm = $this->request->param('openid');
            $param['openid'] = base64_decode($jm);
            $verify = input('_verify', true);
                 //验证规则
            if($verify!='0'){
                try{
                    $this->validate($param, 'index/user');
                }catch (\Exception $e){
                    $this->error($e->getMessage());
                }
            }

        $res = UserModel::create($param);
         return $res ? $this->success(true,0,__('Added successfully')) : $this->error(__('Registration failed'));
    }
  }

        /*/ 详情
    public function info()
    {
        $get = $this->request->get();
        $data = UserModel::lists($get);
        return $this->success($data['data'], $data['count']);
    }*/
    // 删除
    public function del()
    {
        
        if ($this->request->isPost()) { 
            $param = $this->request->param();
            $result = UserModel::destroy($param['id']);
            if ($result == true) {
                return $this->success('', '', '删除成功');
            }
        }
    }
   // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
           
              //保存图片
            if (!empty($param['image'])) {
                $newData = [
                    'table_id' => $id,
                    'url' => $param['image'],
                    'types' => Upload::TYPE_USER,
                ];
                Image::add($newData);
            }
             // 密码不填则是原始密码
            if (!empty($param['password'])) {  
                $data = [
            'salt' => Common::pwdMd5($param['password'])['salt'],
            'password' => Common::pwdMd5($param['password'])['password'],
                ];
        UserModel::update($data, ['username' => $param['username']]);
        AdminModel::update($data, ['username' => $param['username']]);
            }
            unset($param['password']);//删除密码
        $verify = input('_verify', true);
                 //验证规则
            if($verify!='0'){
                try{
                    $this->validate($param, 'admin/profile');
                }catch (\Exception $e){
                    $this->error($e->getMessage());
                }
            }
           $model = UserModel::where(['id' => $param['id']])->find();
               if(isset($param['status'])){
                  if((int)$model["id"] ==1) return $this->error(__('Error'));
           UserModel::update(['status' => $param['status']], ['id'=>$param['id']]); 
        return $this->success(true, 0, __('Modified successfully'));
               }

            $list = AdminModel::where(['username' => $model['username']])->find();
           
            if (isset($param['group_id'])) 
            { 
           if($model['group_id'] >= 1) return $this->error(__('Cancel administrator, please go to administrator list'));

            if(!empty($list)) return $this->error(__('Upgrade failed. The database already exists. Please go to the administrator list to add permissions'));
           // 重新组装数据
            $token = Common::token();
           $newData = ['username' => $model['username'], 'password' => $model['password'], 'email' => $model['email'], 'salt' =>$model['salt'], 'token' => $token, 'createtime' => time()];
               $result = AdminModel::insertGetId($newData);
                  if(!empty($result)){
            UserModel::update(['group_id' => $param['group_id']], ['id'=>$param['id']]);
                return $this->success(true, 0, str_replace('%a', '<b style="color: #ff0000;">' . $result . '</b>', __('Upgrade administrator succeeded! Successfully added a record with ID 0')), '', 0);
                  }
            }
                if(!empty($list)){
               if((int)$model["group_id"] < (int)$param['groups_id'] && $model["group_id"] !== 0) return $this->error(__('Error'));
                }
        $lists = UserModel::where(['status' => 1])->select();
        // 判断昵称是否唯一性
        
            foreach ($lists as $k => $v) 
            {  
                if ($v['mobile'] == $param['mobile'] && $v['id'] == (int)$param['id']) unset($v['mobile']);
                if ($v['mobile'] == $param['mobile']) return $this->error(__('Mobile phone already exists'));
                if ($v['email'] == $param['email'] && $v['id'] == (int)$param['id']) unset($v['email']);
                if ($v['email'] == $param['email']) return $this->error(__('Mailbox already exists'));
                if ($v['username'] == $param['username'] && $v['id'] == (int)$param['id']) unset($v['username']);
                if ($v['username'] == $param['username']) return $this->error(__('User name exists'));
            }
               AdminModel::update(['email' => $param['email']], ['username' => $param['username']]);
           $edit = UserModel::update($param, ['id'=>$param['id']]);
          
        return $edit ? $this->saveSuccess() : $this->error();
   
    }
        return $this->fetch('save', ['data' => UserModel::where('id', $id)->find(), 'list' => Image::where(['table_id' => $id, 'types' => 3])->force('images')->find()]);
    }
    // 头像上传
    public function upload()
    {
        $upload = Upload::upload(Upload::USER_PATH);
        return $this->success($upload['file'],0,$upload['msg']);
    }
    //上传图片
    public function uploadImage()
    {
        try {
            $file = request()->file('file');
            //处理图片
         
                $savename = Filesystem::disk('public')->putFile('user',$file);
                $url = '/upload/'.str_replace('\\','/',$savename);
                return ['code' => 0, 'url' => $url,'msg'=>__('Upload success')];
           
        } catch (\Exception $e) {
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }
}