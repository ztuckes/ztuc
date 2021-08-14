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
 * AuthRule: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */
namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use think\facade\Db;
use app\model\admin\AuthRule as AuthRuleModel;
use app\model\admin\AuthGroup as AuthGroupModel;

class AuthRule extends InitController
{

    protected function _initialize()
    {
        parent::_initialize();
    }
    /**
     * 部门管理
     * @return mixed
     */
    public function group()
    {
        return $this->fetch('group');
    }

    /**
     * 部门管理JSON
     * @param string $limit 分页
     * @throws \think\db\exception\DbException
     */
    public function group_json($limit='15')
    {
        $list =  AuthGroupModel::paginate($limit);
        $this->result($list);
    }

    /**
     * 添加新的部门
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function addGroup()
    {
        if ($this->request->isPost()) {

            $param = $this->request->param();
            $verify = input('_verify', true);
            //验证规则
            if($verify!='0'){
                try{
                    $this->validate($param, 'authGroup');
                }catch (\Exception $e){
                    $this->error($e->getMessage());
                }
            }
            $result = AuthGroupModel::create($param);
            if ($result == true) {
                $this->success('true','','添加成功', url('group/group'));
            } else {
                $this->error($this->errorMsg);
            }
        }
        $authRule = collection(AuthRuleModel::where(['status' => 1])->order('weigh asc')->select())->toArray();
        foreach ($authRule as $k => $v) {
            //$authRule[$k]['open'] = true;
        }
        
        return View::fetch('saveGroup', ['authRule' => list_to_tree($authRule)]);
    }

    /**
     * 修改部门
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function editGroup()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
          $verify = input('_verify', true);
            //验证规则
            if($verify!='0'){
                try{
                    $this->validate($param, 'authGroup');
                }catch (\Exception $e){
                    $this->error($e->getMessage());
                }
            }
            //更新数据
            $resule = AuthGroupModel::update($param);
           if ( $resule == true) {
                $this->success('true','','修改成功', url('group/group'));
            } else {
                $this->error($this->errorMsg);
            }
        }
        $data     = AuthGroupModel::where('id', input('id'))->find();
        $authRule = collection(AuthRuleModel::where(['status' => 1])->order('weigh asc')->select())->toArray();
        foreach ($authRule as $k => $v) {
            // $authRule[$k]['open'] = true;
            $authRule[$k]['checked'] = in_array($v['id'], explode(',', $data['rules']));
        }
        return $this->fetch('saveGroup', ['data' => $data, 'authRule' => list_to_tree($authRule)]);
    }

    /**
     * 删除部门
     */
    public function delGroup()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            AuthGroupModel::destroy($param['id']);
            $this->success('删除成功');
        }
    }

    /**
     * 角色管理
     * @return mixed
     */
    public function rule()
    {
        return $this->fetch('rule');
    }

    /**
     * 角色管理JSON
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function rule_json()
    {
        $authRule = collection(AuthRuleModel::order('weigh asc')->select())->toArray();
        $count = collection(AuthRuleModel::order('weigh asc')->select())->count();
        foreach ($authRule as $k => $v) {
            $data[$k] = array(
                  'authorityId' =>$v['id'],
                  "authorityName" => $v['name'],
                  "authority" =>$v['url'],
                  "menuUrl" =>$v['url'],
                  "parentId" =>$v['pid'],
                  "ismenu" =>$v['type']=='nav'?0:1,
                  "orderNumber" =>$v['weigh'],
                  "menuIcon" =>$v['icon'],
                  "status" =>$v['status'],
                  "createTime" =>'',
                  "updateTime" =>'',
                  "open"=> $v['status']?true:false
                );
        }
        $arrayName = array('code' =>0,'msg' =>'加载成功','count' =>$count,'data' =>$data);
        return json_encode($arrayName);
    }

    /**
     * 添加新的角色
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function addRule()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();  
            $verify = input('_verify', true);
            //验证规则
            if($verify!='0'){
                try{
                    $this->validate($param, 'authRule');
                }catch (\Exception $e){
                    $this->error($e->getMessage());
                }
            }
            $result = AuthRuleModel::create($param);
            if ($result == true) {
                return $this->success('', 0,'添加成功',url('rule/rule'));
            } else {
                $this->error($this->errorMsg);
            }
        }
        $authRule = AuthRuleModel::where(['status' => 1])->order('weigh asc')->select();
        return $this->fetch('saveRule', ['authRule' => list_to_level($authRule)]);
    }

    /**
     * 修改角色
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function editRule()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            $verify = input('_verify', true);
            //验证规则
            if($verify!='0'){
                try{
                    $this->validate($param, 'authRule');
                }catch (\Exception $e){
                    $this->error($e->getMessage());
                }
            }
            $result = AuthRuleModel::update($param,['id'=>$param['id']]);
            if ($result == true) {
                return $this->success('', 0,'修改成功',url('rule/rule'));
            } else {
                $this->error($this->errorMsg);
            }
        }
        $authRule = AuthRuleModel::where(['status' => 1])->order('weigh asc')->select();
        return $this->fetch('saveRule', ['data' => AuthRuleModel::where('id', input('id'))->find(),'authRule' => list_to_level($authRule)]);
    }

    /**
     * 删除角色
     */
    public function delRule()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            AuthRuleModel::where('pid', input('id'))->count() && $this->error('请先删除子节点');
            AuthRuleModel::destroy($param['id']);
            $this->success('删除成功');
        }
    }
    
}
