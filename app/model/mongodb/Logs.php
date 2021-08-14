<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/4/29
 * Time: 19:05
 */

namespace app\model\mongodb;

use app\model\core\InitModel;

class Logs extends InitModel
{
    protected $connection = 'mongo_log';   // 数据库配置

    protected $name = 'logs';

    protected $createTime = 'createtime';

    protected static $available = [
        '_id',
        'title',
        'content',
        'ip',
        'types',    // sql = sql查询、性能
        'url',
        'agent',
        'remark',
        'createtime',
    ];

    /**
     * 列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function lists($page, $limit)
    {
        //return Logs::select()->toArray();
   
        $data = Logs::order('_id', 'desc')->page($page,$limit)->select();
        $count = Logs::count();
        return [
            'data'=>$data,
            'count'=>$count,
        ];
       }
    // object id change to number id
    public static function maxId()
    {
        return Logs::max('_id');
    }

    // 写入日志
    public static function mongoLogs($log)
    {
        if (!empty($log['sql'])){
            foreach ($log['sql'] as $k=>$v){
                $data = [
                    '_id' => self::maxId() + 1 ?: 1,
                    'title' => request()->action(),
                    'content' => $v,
                    'url' => substr(request()->url(), 0, 1500),
                    'agent' => substr(request()->server('HTTP_USER_AGENT'), 0, 255),
                    'ip' => request()->ip(),
                    'types' => 'sql',
                    'remark' => '',
                    'createtime' => time()
                ];
                Logs::insert($data);
            }
        }
        return true;
    }
    // 删除
    public static function del($_id)
    {
        $data = Logs::whereIn('_id', $_id)->select();
        if (!$data) return false;
        Logs::destroy($_id);
        return true;
    }
}