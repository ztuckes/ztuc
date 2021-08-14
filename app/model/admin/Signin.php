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
 * Date: 2020/4/17
 * Time: 21:13
 */

namespace app\model\admin;

use app\controller\common\Common;
use app\model\core\InitModel;
use think\facade\Db;

class Signin extends InitModel
{
    // 定义表
    protected $name = 'signin';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';

    protected static $available = [
        'id',
        'user_id',
        'ip',
        'successions',
        'createtime',
        'types',
    ];
     public static function signRule()
    {
        return [
            'signinscore' => [          // 签到积分
                'name' => 'signinscore',
                'title' => '签到积分',
                'type' => 'array',
                'content' => [],
                'value' => [
                    's1' => '101',
                    's2' => '201',
                    's3' => '301',
                    's4' => '401',
                    's5' => '501',
                    's6' => '601',
                    's7' => '701',
                    'sn' => '1001',
                ],
            ],
            'isfillup' => true,         //开启补签 默认true 关闭 false
            'fillupscore' => 100,       // 补签消耗积分 默认100积分
            'fillupdays' => 7,          // 多少天内可以补签 默认7天
            'fillupnumsinmonth' => 3,   // 每月允许补签次数 默认3次
        ];
    }


    /**
     * 签到
     * @param $post
     * @return bool
     * @author: MK
     * @Time: 2020/4/17 21:25
     */
    public static function add($post)
    {
        if (isset($post['id'])) unset($post['id']);
        $model = new Signin();
        return $model->save($post);
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
        $model = Signin::where('id', $id)->find();
        if (!$model) return false;
        return $model->save($post);
    }

    /**
     * 签到
     * @param $uid
     * @param $time
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/19 15:13
     */
    public static function findSign($uid, $time)
    {
        $list = Signin::where('user_id', $uid)
            ->field(['id', 'createtime'])
            ->whereBetweenTime('createtime', date("Y-m-1", $time), date("Y-m-1", strtotime("+1 month", $time)))
            ->select();
        return $list;
    }

    /**
     * 签到排行
     * @author: MK
     * @Time: 2020/4/19 15:14
     */
    public static function signRank()
    {

        $data = Db::table('group_signin')->where('createtime','>',Common::unixtime('day',-1))
            ->field(['user_id','MAX(successions) AS days'])
            ->group('user_id')
            ->order('days','desc')
            ->paginate(10)
            ->each(function ($item,$key){
                $user = User::findUser($item['user_id']);
                $item['avatar'] = isset($user['avatar'])?$user['avatar']:'';
                $item['username'] = isset($user['username'])?$user['username']:'';
                return $item;
            });
        return $data;
    }
}