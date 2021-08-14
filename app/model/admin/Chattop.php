<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\model\admin;


use app\model\core\InitModel;


class Chattop extends InitModel
{
    // 定义表
    protected $name = 'chattop';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段
    protected static $available = [
        'id',
        'user_id',
        'content',
        'ip',
        'createtime',
        'status',
    ];

  // 列表 
  public static function lists($get)
    {
        // 初始化模型
        $model = Chattop::order('createtime desc')->page($get['page'], $get['limit']);

         // 字段搜索
        if (!empty($get['uname'])) {
            $model->where(['content' => $get['uname']]);
        }

        // 时间搜索
        if (!empty($get['createtime'])) {
            // 切割时间 * 注意两边的空格 ' - '
            $time = explode(' - ', $get['createtime']);
            $start = strtotime($time[0]);
            $end = strtotime($time[1]);
            $model->whereBetweenTime('createtime', $start, $end);
        }

        $data = $model->select();
        // 获取用户信息
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if ($v['user_id']){
                    $userInfo = User::findUser($v['user_id']);
                    $data[$k]['user_id'] = $userInfo['username'];
                }
            }
        }
        $count = Chattop::count(); 
        return [
            'data'=>$data,
            'count'=>$count,
        ];
      
    }
    // 新增
    public static function add($post)
    {
        try {
            $model = new Chattop();
            foreach ($post as $key => $val) {
                if (in_array($key, self::$available)) {
                    $model->$key = $val;
                }
            }
            return $model->save();
        } catch (\Exception $e) {
            return false;
        }
    }

    // 删除
    public static function del($id)
    {
        $data = Chattop::whereIn('id', $id)->select();
        if (!$data) return false;
        Chattop::destroy($id);
        return true;
    }
     //获取数据
     public static function chat($id)
    {
        
        $data = Chattop::order('createtime','desc')
        ->where(['status' => 1])
        ->paginate(['list_rows' => 3, 'query' => request()
        ->param()]);

        // 获取用户信息
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if ($v['user_id']){
                    $userInfo = User::findUser($v['user_id']);
                    $data[$k]['username'] = $userInfo['username'];
                    $data[$k]['avatar'] = $userInfo['avatar'];
                }
            }
        }

        $count = Chattop::where(['status' => 1])->count();

        return [
            'data' => $data,
            'count' => $count,
        ];

    }
    

    // 编辑
    public static function edit($post)
    {
        if (!$post['id']) return false;
        $edit = Chattop::update($post);
        return $edit ? true : false;
    }
}