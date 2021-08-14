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
 * Time: 20:41
 */

namespace app\model\admin;

use app\controller\common\Common;
use app\controller\common\Upload;
use app\model\core\InitModel;
use app\model\admin\User as UserModel;

/**
 * 管理员
 * Class Admin
 * @package app\model\admin
 */
class Admin extends InitModel
{
    // 定义表
    protected $name = 'admin';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    // 可用字段
    protected static $available = [
        'id',
        'groups_id',
        'username',
        'nickname',
        'password',
        'salt',
        'email',
        'loginip',
        'lastloginip',
        'loginfailure',
        'logintime',
        'createtime',
        'updatetime',
        'token',
        'status',
    ];

    /**
     * 管理员列表
     * @param $get
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/5 13:02
     */
    public static function lists($get)
    {
        // 初始化模型
        $model = Admin::page($get['page'], $get['limit']);
        $data = $model->select();

        if (!empty($data)){
            // 获取图片
            foreach ($data as $k=>$v){
                $data[$k]['image'] = Image::image($v['id'],Upload::TYPE_ADMIN);
                 if (!empty($v['groups_id'])){
                $data[$k]['group_name'] = AuthGroup::findGroup($v['id'])['group_name'];
     
            }
              
            }
        }

        $count = Admin::count();
        return [
            'data' => $data,
            'count' => $count,
        ];
    }


    // 新增管理员
    public static function add($post)
    {
        if (isset($post['id'])) unset($post['id']);
        try {
            $model = new Admin();
            foreach ($post as $key => $val) {
                if (in_array($key, self::$available)) {
                    $model->$key = $val;
                }
            }
            $model->groups_id = $post['group_id'];
            $model->nickname = $post['username'];
            $model->username = $post['username'];
            $model->token = Common::token();
            $model->salt = Common::pwdMd5($post['password'])['salt'];
            $model->password = Common::pwdMd5($post['password'])['password'];
            $model->save();

            // 保存图片
            if (!empty($post['image'])) {
                $newData = [
                    'table_id' => $model->id,
                    'url' => $post['image'],
                    'types' => Upload::TYPE_ADMIN,
                ];
                Image::add($newData);
            }
            // 写入权限组
            if (!empty($post['group_id'])){
                AuthGroupAccess::add($post['group_id'],$model->id);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    // 检查登录
    public static function check($name)
    {
        return Admin::where(['username' => $name])->find();
    }

    // 检测token
    public static function checkToken($token)
    {
        return Admin::where(['token' => $token])->field(['id', 'nickname', 'groups_id', 'username', 'token'])->find();
    }

    // 删除检查
    public static function del($id)
    {
        AuthGroupAccess::del($id);
        $data = Admin::whereIn('id', $id)->select();
        if (!$data) return false;
        Admin::destroy($id);
        return true;
    }

    // 编辑
    public static function edit($post)
    {
        try{
            $id = (int)$post['id'];
            $model = Admin::where(['id' => $id])->find();
            if (!$model) return false;
                
            $model->username = $post['username'];
            $model->nickname = $post['username'];
            $model->groups_id = $post['group_id'];
            $model->email = $post['email'];
            $model->status = $post['status'];

            // 密码不填则是原始密码
            if (!empty($post['password'])) {
                $model->salt = Common::pwdMd5($post['password'])['salt'];
                $model->password = Common::pwdMd5($post['password'])['password'];
            }
            // 保存
            $model->save();

            //保存图片
            if (!empty($post['image'])) {
                $newData = [
                    'table_id' => $id,
                    'url' => $post['image'],
                    'types' => Upload::TYPE_ADMIN,
                ];
                Image::add($newData);
            }

            // 写入权限组
            if (!empty($post['group_id'])){

               UserModel::update(['group_id' => $post['group_id']], ['username' => $post['username']]);
                AuthGroupAccess::add($post['group_id'],$id);
            }else{
                AuthGroupAccess::del($id);
               UserModel::update(['group_id' => $post['group_id']], ['username' => $post['username']]);
            }
            return true;
        }catch (\Exception $e){
            return false;
        }

    }
         //权限调用
           public static function group($id)
           {
             return Admin::where(['id' => $id])->find();
            }
}