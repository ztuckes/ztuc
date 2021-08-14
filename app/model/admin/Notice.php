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

namespace app\model\admin;

use app\model\core\InitModel;


class Notice extends InitModel
{
    // 定义表
    protected $name = 'notice';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';
   
    protected $type = [
        'datetime'     => 'timestamp:Y-m-d',
    ];
    
    // 可用字段
    protected static $available = [
        'id',
        'article_id',
        'user_id',
        'ip',
        'content',
        'datetime',
        'createtime',
        'status',
    ];

    // 列表

    public static function lists($get)
    {
        // 初始化模型
        $model = Notice::order('createtime desc')->page($get['page'], $get['limit']);

       
         // 字段搜索
        if (!empty($get['uname'])) {
            $model->whereLike('content','%'.$get['uname'].'%');
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
        $count = Notice::count();
        return [
            'data' => $data,
            'count' => $count,
        ];
    }


    // 新增
    public static function add($post)
    {
        $model = new Notice();
        return $model->save($post);
    }

    // 删除
    public static function del($id)
    {
        $data = Notice::whereIn('id', $id)->select();
        if (!$data) return false;
        Notice::destroy($id);
        return true;
    }
/**
     * 连续签到
     * @param $post
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/17 21:25
     */
    public static function edit($post)
    {
        $id = (int)$post['id'];
        $model = Notice::where('id', $id)->find();
        if (!$model) return false;
        return $model->save($post);
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
    public static function notice($id)
    {
        $where = ['article_id' => $id, 'pid' => 0];
        $data = Notice::order('id','desc')
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

        $count = Notice::where($where)->count();

        return [
            'data' => $data,
            'count' => $count,
        ];

    }

    public static function reply($id)
    {
       $data = Notice::where('pid','>',0)->order('id','desc')
        ->where('article_id',$id)->select();
                                  
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                    $data[$key]['child'] = '';
                if ($val['user_id']){
                    $userInfo = User::findUser($val['user_id']);
                    $data[$key]['username'] = $userInfo['username'];
                }
            }
        }
        return $data;

    }

     //获取数据
     public static function chatZone()
    {
        $where = ['article_id' => 0, 'pid_id' => 0, 'status' => 1];
        $data = Notice::order('id','desc')
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

        $count = Notice::where(['article_id' => 0, 'status' => 1])->count();

        return [
            'data' => $data,
            'count' => $count,
        ];

    }
    
    public static function chatReply()
    {        $where = ['article_id' => 0, 'status' => 1];
       $data = Notice::order('id','desc')->where('pid_id','>',0)->where($where)->select();
                                  
        if (!empty($data)) {
            foreach ($data as $key => $val) {
            
                if ($val['user_id']){
                    $userInfo = User::findUser($val['user_id']);
                    $data[$key]['username'] = $userInfo['username'];
                }
            }
        }
        return $data;

    }

    // 阻止自己回复自己
    public static function findSelf($aid,$uid) : bool
    {
        $model = Notice::where(['article_id'=>$aid,'user_id'=>$uid])->find();
        if ($model) return false;
        return true;
    }

}