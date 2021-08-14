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
 * Time: 21:58
 */
namespace app\controller\admin;

use app\controller\core\InitController;
use app\model\admin\Article as ArticleModel;
use think\facade\View;
use think\facade\Filesystem;
use app\model\admin\SensitiveWords as Words;
use app\model\admin\Click;
use think\facade\Db;
use app\controller\common\Upload;
use app\model\admin\Image;
use app\model\admin\Category;
/**
 * 文章
 * Class Article
 * @package app\controller\admin
 */
class Article extends InitController
{

    /**
     * 页面
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/10 22:41
     */
    public function lists()
    {
        return $this->fetch('list');
    }

     //列表详情
    public function index_json($limit='15')
    {
        $param = $this->request->param();
        $article = new ArticleModel();
        
        if (isset($param['subtitle'])) {
            $article = $article->whereLike('title','%'.$param['subtitle'].'%');
        }
        $list = $article->order('id desc')->paginate($limit);
        
        if (!empty($list)) {
            // 获取图片
            foreach ($list as $k => $v) {
                $v['image'] = Image::image($v['id'], Upload::TYPE_ARTICLE);
                      if(!empty($v['cat_id'])){
                    
                $list[$k]['cat_name'] = Category::findCategory($v['cat_id'])['cat_name'];
                  }
            
            }
        }

        $this->result($list);
    }
    //// 通用搜索
   public function search_json()
    {
        $keywords = $this->request->get('search');
       
        if(!empty($keywords)){
            $map=[['title','like','%'.$keywords.'%']];
        
        }
        else{
            $map=true;
        }

        $data = ArticleModel::where($map)->order('id desc')->select();
       if (!empty($data)) {
            // 获取图片
            foreach ($data as $k => $v) {
                $data[$k]['image'] = Image::image($v['id'], Upload::TYPE_ARTICLE);
                $data[$k]['flag'] = ArticleModel::flag($v['flag']);
                   if(!empty($v['cat_id'])){
                    
                $data[$k]['cat_name'] = Category::findCategory($v['cat_id'])['cat_name'];
                  }
            
            }
        }

        return view('/index/user/search', ['data' => $data, 'keywords' => $keywords]);
    }
    /**
     * 列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/10 22:10
     */
   

    /**
     * 新增
     * @return array
     * @author: MK
     * @Time: 2020/4/10 22:12
     */
    public function add()
    {
        if ($this->request->isPost()) {
        $param = $this->request->param();
         /*过滤关键字*/
        $model = Words::keyWordCheck();
        $item = [];

         foreach($model as $k=>$v)
         {
            $item[$k] = $v['word'];
         }
        
        $replace =array_combine($item,array_fill(0,count($item),'*'));
        $content = strtr($param['content'],$replace);
        $param['content'] = $content; 
      
        $data = ArticleModel::add($param);

        
        if ($data == true) {
                return $this->success('', '', '新增成功');
            }
    }
      
        $data = \app\model\admin\Category::category();
        $tree = $this->dropTree($data,0,0);
      
        return $this->fetch('save', ['name' => $tree]);
    }

    /**
     * 编辑
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/10 22:12
     */
   
  
   // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
        $param = $this->request->param();
               //保存图片
            if (!empty($param['image'])) {
                $newData = [
                    'table_id' => $id,
                    'url' => $param['image'],
                    'types' => Upload::TYPE_ARTICLE,
                ];
                Image::add($newData);
            }
            $result = ArticleModel::update($param,['id'=>$param['id']]);
            if ($result == true) {
                return $this->success('', '', '修改成功');
            }
        }
        
        $data = \app\model\admin\Category::category();
        $tree = $this->dropTree($data,0,0);
      
        return $this->fetch('save', ['list' => ArticleModel::where('id', $id)->find(),'name' => $tree]);
    }
    /**
     * 删除
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/10 22:13
     */
  
  // 删除
    public function del()
    {
        
        if ($this->request->isPost()) { 
            $param = $this->request->param();
            $result = ArticleModel::destroy($param['id']);
            if ($result == true) {
                return $this->success('', '', '删除成功');
            }
        }
    }
    /**
     * 图片上传
     * @return array
     * @author: MK
     * @Time: 2020/4/10 22:20
     */
   
    // 头像上传
    public function upload()
    {
        $upload = Upload::upload(Upload::ARTICLE_PATH);
        return $this->success($upload['file'],0,$upload['msg']);
    }
    //上传图片
    public function uploadImage()
    {
        try {
            $file = request()->file('file');
            //处理图片
         
                $savename = Filesystem::disk('public')->putFile('article',$file);
                $url = '/upload/'.str_replace('\\','/',$savename);
                return ['code' => 1, 'url' => $url,'msg'=>'上传成功'];
           
        } catch (\Exception $e) {
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }
   
}