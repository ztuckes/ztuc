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
 * Date: 2020/4/10
 * Time: 21:59
 */

namespace app\model\admin;

use app\controller\common\Upload;
use app\model\core\InitModel;
use think\facade\Db;
use app\model\admin\UserBlack;

/**
 * 文章
 * Class Article
 * @package app\model\admin
 */
class Article extends InitModel
{
    // 定义表
    protected $name = 'article';

    // 第一自动写入时间字段
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    // 可用字段
    protected static $available = [
        'id',
        'cat_id',
        'title',
        'content',
        'types',
        'flag',
        'view',
        'click',
        'weigh',
        'createtime',
        'updatetime',
        'status',
    ];

    // 栏目类型,声明int类型
    public static function flag($flag)
    {
        switch ($flag) {
            case 1:
                return $flag = 1;
                break;
            case 2:
                return $flag = 2;
                break;
            case 3:
                return $flag = 3;
                break;
            default:
                return $flag = '未知';
        }
    }

    /**
     * 列表
     * @param $get
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/10 22:04
     */
    public static function lists($get)
    {
        $page = (int)$get['page'];
        $limit = (int)$get['limit'];
        $model = Article::page($page, $limit); 
         // 字段搜索
        if (!empty($get['uname'])) {
            $model->whereLike('title','%'.$get['uname'].'%');
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
        $count = Article::count();

        if (!empty($data)) {
            // 获取图片
            foreach ($data as $k => $v) {
                $data[$k]['image'] = Image::image($v['id'], Upload::TYPE_ARTICLE);
                $data[$k]['flag'] = self::flag($v['flag']);
                   if(!empty($v['cat_id'])){
                    
                $data[$k]['cat_name'] = Category::findCategory($v['cat_id'])['cat_name'];
                  }
            
            }
        }

        return [
            'data' => $data,
            'count' => $count
        ];
    }

    /**
     * 新增
     * @param $post
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/10 23:16
     */
    public static function add($post)
    {
        try {
            if (isset($post['id'])) unset($post['id']);

            if (!$post) return false;
            $model = new Article();
            $model->allowField(self::$available)->save($post);

            // 获取自增id
            $tableId = $model->id;
            //保存图片
            if (!empty($post['image'])) {
                $newData = [
                    'table_id' => $tableId,
                    'url' => $post['image'],
                    'types' => Upload::TYPE_ARTICLE,
                ];
                Image::add($newData);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 编辑
     * @param $post
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/10 22:08
     */
    public static function edit($post)
    {
        try {
            $model = Article::where(['id' => $post['id']])->find();
            if (!$model) return false;
            $model->allowField(self::$available)->save($post);

            //保存图片
            if (!empty($post['image'])) {
                $newData = [
                    'table_id' => $post['id'],
                    'url' => $post['image'],
                    'types' => Upload::TYPE_ARTICLE,
                ];
                Image::add($newData);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

    /**
     * 删除
     * @param $ids
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/10 22:08
     */
    public static function del($ids)
    {
        $model = Article::whereIn('id', $ids)->select();
        if (!$model) return false;
        return Article::destroy($ids);
    }

    /**
     * 前端展示
     * @param int $id
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     * @author: MK
     * @Time: 2020/4/13 21:34
     */
    public static function getArticle($id)
    {
        $data = Article::order('weigh', 'desc')->where(['status' => 1, 'cat_id' => $id])
            ->force('idx_status')
            ->order('createtime', 'desc')
            ->paginate(['list_rows' => 5, 'query' => request()->param()])
            ->each(function ($item, $key) {
                $item['image'] = Image::image($item['id'], Upload::TYPE_ARTICLE);
                $data = Article::flag($item['flag']);
                $item['flag'] = $data == 1 ? '最新' : ($data == 2 ? '热门' : ($data == 3 ? '推荐' : '未知'));
                 $count = Notice::where('article_id', $item['id'])->count();
                $item['count'] = isset($count)?$count:0;
                return $item;
            });
         return $data;
    }

    /**
     * 浏览+1
     * @param int $id
     * @return bool
     * @author: MK
     * @Time: 2020/4/12 21:54
     */
    public static function view($id, $uid, $ip)
    {
        //判断帖子id是否存在
        $model = Article::where(['id' => $id])->find();
        
        if (!empty($model->id)) {
            //更新浏览
            Article::update(['view' => Db::raw('view+1')], ['id' => $id]);
            //组装数据
             $map = [
            'uid' => $uid,
            'ip' => $ip,
            'article_id' => $id,
            'view' => Db::raw('view+1'),
            'url' => request()->url(),
            'agent' => substr(request()->server('HTTP_USER_AGENT'), 0, 255),
        ]; 
             //查询今天帖子是否存在
            $model = ArticleLog::whereTime('createtime', 'today')->where(['article_id' => $id])->find();
            
        if(!empty($model)) 
        {
            //存在更新数据
        ArticleLog::whereTime('createtime', 'today')->where(['article_id' => $id])->update(['view' => Db::raw('view+1')]);
        
         }else{   
             //不存在就插入
        ArticleLog::add($map);
        
        }
        }
        return true;
    }

    /**
     * 详情
     * @param $id
     * @return array|null|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/12 18:08
     */
    public static function findArticle($id)
    {
        return Article::where(['id' => $id])->find();
    }

    
    // 上一页
    public static function minCode($id)
    {
        return Article::where('cat_id',$id)->min('id');
    }

    // 下一页
    public static function maxCode($id)
    {
        return Article::where('cat_id',$id)->max('id');
    }

    // 浏览量
    public static function viewCode()
    {
        return Article::where(['status' => 1])->sum('view');
    }

    // 点赞量
    public static function clickCode()
    {
        return Article::where(['status' => 1])->sum('click');
    }


    // 总贴量
    public static function catCode()
    {
        return Article::where(['status' => 1])->sum('status');
    }
 // 今日发贴
    public static function todaysDataCode()
    {

       return Article::whereTime('createtime', 'today')->count();
}
    /**
     * 点赞
     * @param int $uid
     * @param int $id
     * @return bool
     * @author: MK
     * @Time: 2020/4/12 22:02
     */
    public static function click($uid, $id)
    {

        $map = [
            'uid' => $uid,
            'article_id' => $id,
            'ip' => request()->ip(),
        ];

       // $time = time() + 3600 * 24; // 一天

        $where = ['article_id' => $map['article_id'], 'ip' => $map['ip'],'createtime'=>['<=',time() + 3600 * 24]];
        $log = ClickLog::where($where)
            ->force('click_force')// 强制索引
            ->lock(true)// 数据库锁，防止多人同时点击出错
            ->count();

        if ($log >= 1) return false;
        
        Article::update(['click' => Db::raw('click+1')], ['id' => $id]);
        ClickLog::add($map);
        return true;
    }
     
}