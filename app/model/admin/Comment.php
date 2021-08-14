<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\model\admin;

use app\model\core\InitModel;


class Comment extends InitModel
{
    // 定义表
    protected $name = 'comment';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    // 可用字段
    protected static $available = [
        'id',
        'article_id',
        'user_id',
        'ip',
        'content',
        'createtime',
        'status',
    ];

    // 列表

    public static function lists($get)
    {
        // 初始化模型
        $model = Comment::order('createtime desc')->page($get['page'], $get['limit']);

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
        //获取用户信息
        if(!empty($data)) {
            foreach ($data as $k => $v) {
                if ($v['user_id']) {
                   $userInfo = User::findUser($v['user_id']);
                   $data[$k]['user_id'] = $userInfo['username'];    
                   }
                }
            }
        $count = Comment::count();
        return [
            'data' => $data,
            'count' => $count,
        ];
    }


    // 新增
    public static function add($post)
    {
        $model = new Comment();
        return $model->save($post);
    }

    // 删除
    public static function del($id)
    {
        $data = Comment::whereIn('id', $id)->select();
        if (!$data) return false;
        Comment::destroy($id);
        return true;
    }

    // 编辑
    public static function edit($post)
    {
        if (!$post['id']) return false;
        $edit = Comment::update($post);
        return $edit ? true : false;
    }

    /**
     * 评论
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/14 21:34
     */
    public static function comment($id)
    {
        $where = ['article_id' => $id, 'status' => 1];
        $data = Comment::order('id','desc')
        ->where($where)
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

        $count = Comment::where($where)->count();

        return [
            'data' => $data,
            'count' => $count,
        ];

    }

    // 阻止自己回复自己
    public static function findSelf($aid,$uid) : bool
    {
        $model = Comment::where(['article_id'=>$aid,'user_id'=>$uid])->find();
        if ($model) return false;
        return true;
    }

}