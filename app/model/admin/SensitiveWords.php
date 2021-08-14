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
 * SensitiveWords: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\model\admin;
use app\controller\common\Common;

use app\model\core\InitModel;

/**
 * 敏感词
 * Class SensitiveWords
 * @package app\model\admin
 */
class SensitiveWords extends InitModel
{
    // 定义表
    protected $name = 'sensitive_words';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    const TYPE_WORD = 1; //通用

    // 可用字段
    protected static $available = [
        'id',
        'word',
        'type',
        'createtime',
        'updatetime',
        'status',
    ];   
  

    // 列表
   public static function lists($get)
    {
       
        // 初始化模型
        $model = SensitiveWords::page($get['page'], $get['limit']);

        // 字段搜索
        if (!empty($get['uname'])) {
            $model->whereLike('word','%'.$get['uname'].'%');
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
        $count = SensitiveWords::count();
        return [
            'data' => $data,
            'count' => $count,
        ];
    }
    
    //数据
    public static function keyWordCheck()
    {
        
        return SensitiveWords::where(['status' => 1])->field('word')->select();
     
    }
    
    /*/ 列表
   public static function lists($page, $limit)
    {
        
        $data = SensitiveWords::order('id desc')
            ->page($page, $limit)->select();
        $count = SensitiveWords::count();
        return [
            'data' => $data,
            'count' => $count,
        ];
    }*/

    // 新增
    public static function add($post)
    {
        $model = new SensitiveWords();
        foreach ($post as $key=>$val){
            $model->$key = $val;
        }
        return $model->save();
    }
    // 删除
    public static function del($id)
    {
        $data = SensitiveWords::whereIn('id', $id)->select();
        if (!$data) return false;
        SensitiveWords::destroy($id);
        return true;
    }

    // 编辑
    public static function edit($post)
    {
        if (!$post['id']) return false;
        $model = SensitiveWords::where(['id'=>$post['id']])->find();
        if (!$model) return false;
        return SensitiveWords::update($post);
    }

    // 类型
    public static function type($type)
    {
        switch ($type){
            case 1:
                return $type = '聊天';
                break;
            default:
                return $type = '未知';
        }
    }


}