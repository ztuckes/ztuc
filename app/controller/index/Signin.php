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
 * Date: 2020/4/16
 * Time: 22:35
 */

namespace app\controller\index;

use app\controller\common\Common;
use app\controller\core\Calendar;
use app\controller\core\InitController;
use think\facade\Db;
use think\facade\View;
use app\model\admin\Signin as SigninModel;
use app\model\admin\User;

class Signin extends InitController
{
    /**
     * 签到首页
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/17 22:00
     */
    public function index()
    {

            // 获取签到规则
            $rule = SigninModel::signRule();
            $signData = $rule['signinscore'];
            $date = $this->request->request('date', date("Y-m-d"), "trim");
            $time = strtotime($date);

            // 获取签到数据
            $lastData = SigninModel::where('user_id', $this->user['id'])->order('createtime', 'desc')->findOrEmpty();
          
           // print_r($lastData);
            $successions = $lastData && strtotime($lastData['createtime']) > Common::unixtime('day',-1) ? $lastData['successions'] : 0;
            $signin = SigninModel::where('user_id', $this->user['id'])->whereTime('createtime', 'today')->find();
           // print_r($signin);
            // 获取签到表
            $calendar = new Calendar();
            $list = SigninModel::findSign($this->user['id'],$time);

            foreach ($list as $key => $item) {
                $createtime = strtotime($item->createtime);
                $calendar->addEvent(date("Y-m-d", $createtime), date("Y-m-d", $createtime), "", false, "signed");
            }
            // 渲染视图
            View::assign('calendar', $calendar);
            View::assign('date', $date);
            View::assign('successions', $successions);
            $successions++;
            $score = isset($signData['value']['s' . $successions]) ? $signData['value']['s' . $successions] : $signData['value']['sn'];
            View::assign('signin', $signin);
            View::assign('fillupscore', $rule['fillupscore']);
            View::assign('score', $score);
            View::assign('rank', $this->rank());
            View::assign('signinscore', $rule['signinscore']['value']);
            //更新等级金额
            $modle = User::where(['id' => $this->user['id']])->find();
              
              //未退出登录更新连续登录和最大连续登录/时间
             if ($modle->logintime < Common::unixtime('day')) {
            $modle->successions = $modle->logintime < Common::unixtime('day', -1) ? 1 : $modle->successions + 1;
            $modle->maxsuccessions = max($modle->successions, $modle->maxsuccessions);
            // 更新登录时间
            $modle->save(['prevtime' => $modle->logintime, 'logintime' => time()]);
        }
            if ($modle->score >= 100) {
            $number = round($modle->score/100);//1.25
            $modle->save(['level' => $number]);
            $modle->save(['money' => $modle->level*0.05]);
        }
            return View::fetch('/index/signin/index');
    }

    /**
     * 签到
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/18 22:16
     */
    public function doSign()
    {
        if ($this->request->isPost()) {
            $config = SigninModel::signRule();
            $signdata = $config['signinscore'];

          //$lastdata = SigninModel::where('user_id', $this->user['id'])->whereTime('createtime', 'desc')->find();

         // $successions = $lastdata && strtotime($lastdata['createtime']) > Common::unixtime('day', -1) ? $lastdata['successions'] : 0;
            $signin = SigninModel::where('user_id', $this->user['id'])->whereTime('createtime', 'today')->find();
            if ($signin) {
               return $this->error(__('We have signed in today, please come back tomorrow'));
            } else {
                
               // $score = isset($signdata['value']['s' . $successions]) ? $signdata['value']['s' . $successions] : $signdata['value']['sn'];

                // 开启数据库事务
                Db::startTrans();
                try {

                    $lastdata = SigninModel::where('user_id', $this->user['id'])->order('createtime', 'desc')->findOrEmpty();
                    
                    $successions = strtotime($lastdata['createtime']) < Common::unixtime('day', -1) ? 1 : $lastdata['successions']+1;
                   $score = isset($signdata['value']['s' . $successions]) ? $signdata['value']['s' . $successions] : $signdata['value']['sn'];
                    SigninModel::add(['user_id' => $this->user['id'], 'successions' => $successions, 'ip' => $this->request->ip()]);
                    User::score($score, $this->user['id'], str_replace('%s', $successions, __('Continuous sign in for days')));
                    Db::commit();  
                    
                   
                } catch (\Exception $e) {
                    Db::rollback();
                   return $this->error(__('Check in failed, please try again'));
                }
                return $this->success('',0,str_replace(array('%a', '%b'), array('<b style="color: #ff0000;">' . $successions . '</b>', '<b style="color: #ff0000;">' . $score . '</b>'), __('Continue to sign in')),'',1);
            }
        }
        return $this->error(__('Request error'));
    }

    /**
     * 补签
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: MK
     * @Time: 2020/4/19 14:45
     */
    public function signature()
    {
        $date = $this->request->request('date');
        $time = strtotime($date);
        $config = SigninModel::signRule();
        if (true !== $config['isfillup']) {
            return $this->error(__('Sign in and countersignature have not been opened yet'));
        }
        if ($time > time()) {
            return $this->error(__('No future date can be countersigned'));
        }
                  if(strtotime($this->user['createtime']) > $time + 86400)
          {
             return $this->error(__('The supplementary signature date cannot be greater than the registration date'));
          }
        if ($config['fillupscore'] > $this->user['score']) {
            return $this->error(__('You dont have enough points at the moment'));
        }
        $days = Common::span(time(), $time, 'days');
        if ($config['fillupdays'] < $days) {
            return $this->error(str_replace('%a', $config['fillupdays'], __('Only supplementary')));
        }
        $count = SigninModel::where(['user_id'=>$this->user->id,'types'=>'fillup'])
            ->whereTime('createtime', 'between', [Common::unixtime('month'), Common::unixtime('month', 0, 'end')])
            ->count();

        if ($config['fillupnumsinmonth'] <= $count) {
            return $this->error(str_replace('%a', $config['fillupnumsinmonth'], __('Only% a supplementary signature is allowed per month')));
        }
        Db::name('signin')->whereTime('createtime', 'd')->select();
        $signin = SigninModel::where(['user_id'=>$this->user->id,'types'=>'fillup'])
            ->whereTime('createtime', 'between', [$date, date("Y-m-d 23:59:59", $time)])
            ->count();
        if ($signin) {
            return $this->error(__('There is no need to sign in on this date'));
        }
        $successions = 1;
        $prev = $signin = SigninModel::where('user_id', $this->user->id)
            ->whereTime('createtime', 'between', [date("Y-m-d", strtotime("-1 day", $time)), date("Y-m-d 23:59:59", strtotime("-1 day", $time))])
            ->find();
        if ($prev) {
            $successions = $prev['successions'] + 1;
        }

        Db::startTrans();
        try {
            User::score(-$config['fillupscore'], $this->user->id, __('Sign in and countersign'));
            //寻找日期之后的
            $nextList = SigninModel::where('user_id', $this->user->id)
                ->where('createtime', '>=', strtotime("+1 day", $time))
                ->order('createtime', 'asc')
                ->select();

            foreach ($nextList as $index => $item) {
                $createtime = strtotime($item->createtime);
                //如果是阶段数据，则中止
                if ($index > 0 && $item->successions == 1) {
                    break;
                }
                $day = $index + 1;
                if (date("Y-m-d", $createtime) == date("Y-m-d", strtotime("+{$day} day", $time))) {
                    $item->successions = $successions + $day;
                    $item->save();
                }
            }
            SigninModel::add(['user_id' => $this->user->id,'types' => 'fillup', 'successions' => $successions, 'createtime' => $time + 43200,'ip'=>$this->request->ip()]);
            Db::commit();
        }  catch (\Exception $e) {
            Db::rollback();
            return $this->error(__('Re signing failed. Please try again later'));
        }

       return $this->success('',0,__('Successful countersignature'),'',1);
    }

    /**
     * 排行榜
     * @return array
     * @author: MK
     * @Time: 2020/4/19 13:18
     */
    public function rank()
    {
        $data = SigninModel::signRank();
        return $data;
    }

}