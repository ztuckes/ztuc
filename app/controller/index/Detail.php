<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/22
 * Time: 12:27
 */

namespace app\controller\index;

use app\controller\common\Redis;
use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Article;
use app\model\admin\Notice;
use app\model\admin\ClickLog;
use app\model\admin\SensitiveWords as Words;
use app\model\admin\User;
use app\validate\admin\Chat as ChatValidate;

class Detail extends InitController
{
    /**
     * 详情
     * @return string|\think\response\Redirect
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/12 21:24
     */
    public function index()
    {
        $get = $this->request->get('Art');
    
         if(is_numeric($get)){
           
           $id = $get;
      
         }else{
           // 解密
        $id = base64_decode($get);
      }
        // 恶意请求
        if (!$id) {
            return redirect('/');
        }

        $ip = $this->request->ip();
        $uid = isset($this->user['id'])?$this->user['id']:0;
        // 浏览view+1
        Article::view($id, $uid, $ip);
        $article = Article::findArticle($id);
        //上一条
        $mins = Article::order('id desc')->where(['status' => 1, 'cat_id' => $article['cat_id']])
            ->where('id', '<', $article['id'])->limit(0, 2)->find();
        View::assign('mins', $mins);
        //下一条
        $maxs = Article::order('id asc')->where(['status' => 1, 'cat_id' => $article['cat_id']])
            ->where('id', '>', $article['id'])->limit(0, 2)->find();
        View::assign('maxs', $maxs);
        // 渲染视图
        View::assign('article', $article);
        // 上一页
        View::assign('min', Article::minCode($article['cat_id']));
        // 下一页
        View::assign('max', Article::maxCode($article['cat_id']));
        //查询今日是否点赞
        $clickLog = ClickLog::findClickLog($id, $uid, $ip);
       
        View::assign('clickLog', $clickLog);
        //回复评论
        $comment = Notice::notice($id);
         //点赞倒计时
            if(!empty($clickLog['createtime'])){
            $overtime = floor((60*60*4) - (time()-strtotime($clickLog['createtime'])));
            }else{
              $overtime = 0;  
            }
        $reply = Notice::reply($id);
        View::assign('comment', $comment['data']);
        View::assign('count', $comment['count']);
        return View::fetch('/index/index/detail', ['overtime' => $overtime, 'reply' => $reply]);
    }

    /**
     * 点赞
     * @return array
     * @author: MK
     * @Time: 2020/4/12 22:04
     */
    public function click()
    {
            $id = (int)$this->request->post('id');
            $uid = (int)isset($this->user['id']) ?$this->user['id']: 0;
            $res = Article::click($uid, $id);
            return $res ? $this->success('', '', __('Like success'),'', 1) : $this->error();
    }
    ///聊天
    public function chatzone()
    {
       $post = $this->request->post();
        // 实例化验证器
        $validate = new ChatValidate();
        $ContentValidate = $validate->check($post);

        // 输出验证器错误信息
        if (true !== $ContentValidate) return $this->error($validate->getError());

        /*/过滤关键字*/
        $model = Words::keyWordCheck();
        $item = [];

         foreach($model as $k=>$v)
         {
            $item[$k] = $v['word'];
         }
        
        $replace =array_combine($item,array_fill(0,count($item),'*'));
        $content = strtr($post['content'],$replace);
        $newData = [
            'pid_id'     => $post['pid_id'],
            'uid'        => $post['uid'],
            'datetime'   => date("Y-m-d", time()),
            'user_id'    => $this->user['id'],
            'content'    => trim($content),
            'ip'         => $this->request->ip(),
        ];
        $result = Notice::add($newData);
        return $result ? $this->success('', 0, '留言成功！', 1) : $this->error();
    }

    
    // 评论 
    public function notices(Redis $redis)
    {
       
        $post = $this->request->post();
        $article_id = $this->request->post('article_id');
        $content = trim($this->request->post('content'));
        $pid = $this->request->post('pid');
        $uid = $this->request->post('uid');
        // 实例化验证器
        $validate = new ChatValidate();
        $Chat = $validate->check($post);

        // 输出验证器错误信息
        if (true !== $Chat) return $this->error($validate->getError());
        /*/过滤关键字*/
        $model = Words::keyWordCheck();
        $item = [];

         foreach($model as $k=>$v)
         {
            $item[$k] = $v['word'];
         }
        
        $replace =array_combine($item,array_fill(0,count($item),'*'));
        $content = strtr($content,$replace);
         /*过滤关键字结束*/
        if (!$article_id || !$content) return $this->error(__('Content cannot be empty'));

        $newData = [
            'pid'        => $post['pid'],
            'uid'        => $post['uid'],
            'datetime'   => date("Y-m-d", time()),
            'article_id' => $article_id,
            'user_id'    => $this->user['id'],
            'content'    => trim($content),
            'ip'         => $this->request->ip(),
        ];


       //if (false === Comment::findSelf($newData['article_id'],$newData['user_id'])) return $this->error('不能自己回复自己！');

        if (true !== $redis->checkRule()) return $this->error(__('Take a break and comment'));
        
        //评论活动积分
            $modle = User::where(['id' => $this->user['id']])->find();
          
            if ($modle) {
                $count = Notice::where(['user_id' => $this->user['id']])->whereTime('createtime', 'today')->count();
                if($count <= 9)
                {
               $modle->save(['score' => $modle->score+2]);
               $res = Notice::add($newData);
        return $res ? $this->success('', '', __('Comment success! Get 2 points'), '', 1) : $this->error('评论失败！'); 
                }else{

        $res = Notice::add($newData);
        return $res ? $this->success('', '', __('Comment success'),'' , 1) : $this->error(__('Comment failed'));   
                }
        }

    }
}
