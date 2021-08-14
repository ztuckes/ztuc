<?php
namespace app\model;

use think\facade\Session;
use think\Model;

class Base extends Model
{
    // 获取左侧主菜单
    public static function getMenus($ids)
    {    $where = ['type' => 'nav', 'status' => 1];
        $authRule = \app\model\admin\AuthRule::where($where)
            ->order('weigh asc')
            ->force('rules')
            ->whereIn('id',$ids)
            ->field(['id','pid','name','url','icon','weigh','status','ismenu','remark as child'])
            ->select()
            ->toArray();

        $menus = [];
        // 查找一级
        foreach ($authRule as $key => $val) {
            $authRule[$key]['href'] = (string)url($val['url']);
            if ($val['pid'] == 0) {
                
                    $menus[] = $val;
                
            }
        }
        // 查找二级
        foreach ($menus as $k => $v) {
            $menus[$k]['children'] = [];
            foreach ($authRule as $kk => $vv) {
                if ($v['id'] == $vv['pid']) {
                 
                        $menus[$k]['children'][] = $vv;
                    }
              
            }
        }
        return $menus;
    }
}