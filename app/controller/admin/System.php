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
/**
 * Created by PhpStorm.
 * SmsMoban: Administrator
 * Date: 2020/3/14
 * Time: 17:18
 */

namespace app\controller\admin;

use app\controller\core\InitController;
use think\facade\View;
use app\controller\common\Upload;
use app\model\admin\System as SystemModel;
use app\model\admin\Image;
use think\facade\Filesystem;
use think\facade\Config;

class System extends InitController
{

    // 列表
    public function sina()
    { 
        if ($this->request->isPost()) {
            $param = $this->request->param();
            extraconfig($param, 'admin/sina');//存本地config的admin下
            SystemModel::where('key','sina')->update(['jdata'=>$param]);
            cache('sina',null);
            $this->success('', '', __('Set successfully'));
        }
        $data = Config::load('admin/sina','sina');
        return View::fetch('param_sina', ['data' => $data]);
        //$data = SystemModel::where('key','sina')->find()['jdata'];
        //return $this->fetch('param_sina', ['data' => $data]);
    }

    // 列表
    public function list126()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            extraconfig($param, 'admin/list126');//存本地config的admin下
            SystemModel::where('key','mail126')->update(['jdata'=>$param]);
            
            cache('mail126',null);
            return $this->success('', '', __('Set successfully'));
        }
        $data = SystemModel::where('key','mail126')->find()['jdata'];
        return $this->fetch('param_126', ['data' => $data]);
    }
    // 列表
    public function listqq()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            extraconfig($param, 'admin/listqq');//存本地config的admin下
            SystemModel::where('key','emailqq')->update(['jdata'=>$param]);
            
            cache('emailqq',null);
            return $this->success('', '', __('Set successfully'));
        }
        $data = SystemModel::where('key','emailqq')->find()['jdata'];
        return $this->fetch('param_qq', ['data' => $data]);
    }
    // 列表
    public function listsms()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            extraconfig($param, 'admin/listsms');//存本地config的admin下
            SystemModel::where('key','sms')->update(['jdata'=>$param]);
           
            cache('sms',null);
            return $this->success('', '', __('Set successfully'));
        }
        $data = SystemModel::where('key','sms')->find()['jdata'];
        return $this->fetch('param_sms', ['data' => $data]);
    }
    // 列表
    public function sitting()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param(); 

            extraconfig($param, 'admin/sitting');//存本地config的admin下
           //保存图片
            if (!empty($param['logo'])) {
                $newData = [
                    'table_id' => 6,
                    'url' => $param['logo'],
                    'types' => Upload::TYPE_SYSTEM,
                ];
                Image::add($newData);
            }
            //保存图片
            if (!empty($param['image'])) {
                $newData = [
                    'table_id' => 5,
                    'url' => $param['image'],
                    'types' => Upload::TYPE_SYSTEM,
                ];
                Image::add($newData);
            }
            SystemModel::where('key','website')->update(['jdata'=>$param]);
           
            cache('website',null);
            return $this->success('', '', __('Set successfully'));
        }
        $model = SystemModel::where('key','website')->find()['jdata'];
        return $this->fetch('param_sitting', ['model' => $model]);
    }

    /**
     * 图片上传
     * @return array
     * @author: MK
     * @Time: 2020/4/5 12:29
     */
    public function upload()
    {
        $upload = Upload::upload(Upload::SYSTEM_PATH);
        return $this->success($upload['file'],0,$upload['msg']);
    }

    //上传图片
    public function uploadImage()
    {
        try {
            $file = request()->file('file');
            //处理图片
         
                $savename = Filesystem::disk('public')->putFile('system',$file);
                $url = '/upload/'.str_replace('\\','/',$savename);
                return ['code' => 1, 'url' => $url,'msg'=>__('Upload success')];
           
        } catch (\Exception $e) {
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }
   }