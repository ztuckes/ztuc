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
 * ClickLog: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\model\admin\Notice as NoticeModel;

class Notice extends InitController
{

    // 列表
    public function lists()
    {
        return View::fetch('list');
    }
     // 详情
    public function info()
    {
        $get = $this->request->get();
        $data = NoticeModel::lists($get);
        return $this->success($data['data'], $data['count']);
    }
  // 编辑
    public function edit()
    {
        if ($this->request->isPost()) {
        $param = $this->request->param();
        $param['id'] = isset($param['id']) ? $param['id'] : $this->request->get('id');
        $edit = NoticeModel::update($param,['id'=> $param['id']]);
     
        return $edit ? $this->saveSuccess() : $this->error();
        }
    }

    /**
     * 最新消息
     * @return mixed
     */
    public function message()
    {
        $unread = NoticeModel::where('uid',$this->user['id'])->where('status','1')->whereDay('datetime')->limit(10)->order('id desc')->select();
        $read = NoticeModel::where('uid',$this->user['id'])->where('status','0')->limit(10)->order('id desc')->select();
        return $this->fetch('admin/notice/message', [
            'unread' => $unread,
            'read'   => $read
        ]);
    }

    // 消息
    public function get_notice()
    {
        $notice = NoticeModel::where('uid',$this->user['id'])->where('status','1')->whereDay('datetime')->limit(10)->order('datetime asc')->count();
        $this->result($notice);
        //return $notice;
    }
    
    /**
     * 设为已读
     */
    public function read()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            $result = NoticeModel::where('id','in',$param['id'])->update(['status'=>0,'update_time'=>time()]);
            $this->success(true, 0, '批量设置成功');
        }
    }
    
    /**
     * 设为未读
     */
    public function unread()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            $result = NoticeModel::where('id','in',$param['id'])->update(['status'=>1,'update_time'=>time()]);
            $this->success(true, 0, '批量设置成功');
        }
    }
    
    public function detail_json($limit='10',$date='')
    {
        $model = new NoticeModel();
        if(empty($date)){
            $date = date('Y-m-d');
        }
        //$model = $model->whereDay('datetime',$date);
        $list = $model->where('uid',$this->user['id'])->order('id desc')->paginate($limit);
        
        if (!empty($list)) {
            foreach ($list as $key => $val) {
                if ($val['user_id']){
                    $userInfo = \app\model\admin\User::findUser($val['user_id']);
                    $list[$key]['username'] = $userInfo['username'];
                }
            }
        }
        $this->result($list);
    }

    /**
     * 日程详情
     * @param string $date
     * @return mixed
     */
    public function detail($date='')
    {
        //当前日期
        if(empty($date)){
            $date = date('Y-m-d');
        }
        //日期集
        for($i=0;$i<=10;$i++){
                $list[$i]['day'] = date("Y-m-d",strtotime("+".($i-2)." day",strtotime($date)));
        }
        return $this->fetch('admin/notice/detail',[
            'date'   => $date,
            'list'   => $list
        ]);
    }
    // 新增
    public function add()
    {
        $add = $this->request->post();
        $res = NoticeModel::add($add);
        return $res ? $this->saveSuccess() : $this->error();
    }
        /**
     * 删除管理员
     */
    public function del()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            NoticeModel::destroy($param['id'],true);
        }
        return $this->success(true, 0, '删除成功', url('/user/detail'));
    }   
}