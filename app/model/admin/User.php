<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\model\admin;

use app\controller\common\Common;

use app\controller\common\Upload;
use app\model\core\InitModel;


class User extends InitModel
{
    // 定义表
    protected $name = 'user';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

   
    // 可用字段
    protected static $available = [
        'id',
        'group_id',
        'username',
        'qq',
        'nickname',
        'password',
        'salt',
        'openid',
        'email',
        'mobile',
        'avatar',
        'level',
        'gender',
        'birthday',
        'bio',
        'money',
        'score',
        'successions',
        'maxsuccessions',
        'prevtime',
        'mobileprevtime',
        'logintime',
        'loginip',
        'loginfailure',
        'mobilelogintime',
        'joinip',
        'jointime',
        'createtime',
        'updatetime',
        'token',
        'status',
        'verification',
    ];

    /*/ 列表

    public static function lists($get)
    {
        // 初始化模型
        $model = User::page($get['page'], $get['limit']);

        // 字段搜索
        if (!empty($get['datasearch'])) {
            $model->whereLike('mobile|email|username|qq','%'.$get['datasearch'].'%');
        }
          if (!empty($get['createtime'])) {
            // 切割时间 * 注意两边的空格 ' - '
            $time = explode(' - ', $get['createtime']);
            $start = strtotime($time[0]);
            $end = strtotime($time[1]);
            $model->whereBetweenTime('createtime', $start, $end);
     }
    
        $data = $model->select();

        if (!empty($data)) {
            // 获取图片
            foreach ($data as $k => $v) {
                $v['image'] = Image::image($v['id'], Upload::TYPE_USER);
            }
        }

        $count = User::count();
        return [
            'data' => $data,
            'count' => $count,
        ];
    }*/

    // 检查登录
    public static function auth($name)
    {
        return User::where(['username' => $name])->find();
    }

    // 检测token
    public static function checkToken($token)
    {
        return User::where(['token' => $token])
            ->field([
                'id',
                'username',
                'token',
                'score',
                'createtime',
            ])
            ->find();
    }


    /*/ 编辑
    public static function edit($post)
    {
          //判断密码是否存在
        if(empty($post['password'])){
                 unset($post['password']);
            }
   
        try {
            $id = (int)$post['id'];
            $model = User::where(['id' => $id])->find();
            if (!$model) return false;

            foreach ($post as $key => $val) {
                if (in_array($key, self::$available)) {
                    $model->$key = $val;
                }
            }
         
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
                    'types' => Upload::TYPE_USER,
                ];
                Image::add($newData);
            }

            return true;
        } catch (\Exception $e) {
            return [$e->getMessage(), $e->getFile(), $e->getLine()];
        }

    }*/

    /*// 删除
    public static function del($id)
    {
        $data = User::whereIn('id', $id)->find();
        if (!$data) return false;
        User::destroy($id);
        return true;
    }*/

    /**
     * 单个用户信息
     * @param $uid
     * @return array|bool|null|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/12 17:24
     */
    public static function findUser($uid)
    {
        if (!$uid) return false;
        $user = User::where('id', $uid)->field([
            'id',
            'avatar',
            'nickname',
            'qq',
            'username',
            'group_id',
            'mobile',
            'email',
            'openid',
            'level',
            'bio',
            'money',
            'score',
            'logintime',
            'maxsuccessions',
            'mobilelogintime',
            'mobileprevtime',
            'successions',
            'prevtime',
        ])->find();
         
        if (!empty($user->id)) {
            $user->avatar = Image::image($user->id, Upload::TYPE_USER);
        }
        return $user;
    }

    /**
     * 加积分
     * @param $score
     * @param $uid
     * @param string $memo
     * @return bool
     * @author: MK
     * @Time: 2020/4/18 22:18
     */
     public static function score($score, $uid, $memo = '')
    {
        try {
            $model = User::where('id', $uid)->find();
            if (!$model) return false;
            $before = $model->score;
            $model->score = $model->score + $score;
            $model->save();
            $log = [
                'user_id' => $uid,
                'score' => (int)$score,
                'before' => (int)$before,
                'after' => (int)$model->score,
                'memo' => $memo,
            ];
            UserScoreLog::add($log);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
     //更新等级金额
    public static function days($id)
    {
    
            $modle = User::where(['id' => $id])->find();
              
              //未退出登录更新连续登录和最大连续登录/时间
             if ($modle->logintime < Common::unixtime('day')) {
            $modle->successions = $modle->logintime < Common::unixtime('day', -1) ? 1 : $modle->successions + 1;
            $modle->maxsuccessions = max($modle->successions, $modle->maxsuccessions);
            // 更新登录时间
            $modle->save(['prevtime' => $modle->logintime, 'logintime' => time()]);
        }
    }
   // 查询人数
    public static function inlineIp()
    {

       return User::where(['status' => 1])->comment('查询人数')->count();
    }
}