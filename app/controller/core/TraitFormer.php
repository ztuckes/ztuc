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
declare (strict_types = 1);
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/11
 * Time: 20:28
 */

namespace app\controller\core;
use think\facade\View as ViewTemplate;


use think\App;
use think\facade\Request;
use think\Response;
use think\exception\HttpResponseException;
/**
 * 复用类
 * Trait TraitFormer
 * @package app\controller\core
 */
trait TraitFormer
{
  public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 请求成功
    protected function success($data = [], $count = 0, $msg = '', string $url = null, $code = 0, int $wait = 3, array $header = [])
    {
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        } elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : app('route')->buildUrl($url);
        }
        $result = [
            'data' => $data,
            'msg' => $msg ?: '操作成功',
            'code' => $code ?: 0,
            'url'  => $url,
            'wait' => $wait,
            'count' => $count,  //layui分页

        ];
     $type = $this->getResponseType();
      
        if ($type == 'html'){
            $response = view($this->app->config->get('app.dispatch_success_tmpl'), $result);
        } else if ($type == 'json') {
            $response = json($result);
        }
        throw new HttpResponseException($response);
    }
 /**
     * 获取当前的response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType()
    {
        return $this->request->isJson() || $this->request->isAjax() ? 'json' : 'html';
    }
    // 保存成功
    protected function saveSuccess()
    {
        return [
            'msg' => '保存成功',
            'code' => 0,
        ];
    }

    /**
     * 加载模板输出
     * @access protected
     * @param  string $template 模板文件名
     * @param  array  $vars     模板输出变量
     * @param  array  $replace  模板替换
     * @param  array  $config   模板参数
     * @return mixed
     */
    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
        return ViewTemplate::fetch($template, $vars, $replace, $config);
    }
    // 删除成功
    protected function delSuccess()
    {
        return [
            'msg' => '删除成功',
            'code' => 0,
        ];
    }

    // 失败请求
    protected function error($msg = '', string $url = null, $data = '', int $wait = 5, array $header = [])
    {
        if (is_null($url)) {
            $url = $this->request->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : $this->app->route->buildUrl($url);
        }

        $result = [
            'code' => 1,
            'msg'  => $msg ?: '未知错误',
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();

        if ($type == 'html'){
            $response = view($this->app->config->get('app.dispatch_error_tmpl'), $result);
        } else if ($type == 'json') {
            $response = json($result);
        }
        throw new HttpResponseException($response);
    }


    /**
     * 无限分类
     * @param $data
     * @param int $pid
     * @param int $lev
     * @return array
     * @author: MK
     * @Time: 2020/4/5 17:07
     */
    public function tree($data, $pid = 0, $lev = 0)
    {
        $tree = [];
        foreach ($data as $key => $val) {
            if ($val['pid'] == $pid) {
                $val['child'] = $this->tree($data, $val['id'], $lev + 1);
                $tree[] = $val;
            }
        }
        return $tree;
    }
 
    /**
     * 返回封装后的 API 数据到客户端
     * @access protected
     * @param mixed  $data   要返回的数据
     * @param int    $code   返回的 code
     * @param mixed  $msg    提示信息
     * @param string $type   返回数据格式
     * @param array  $header 发送的 Header 信息
     * @return void
     * @throws HttpResponseException
     */
    function result($data, $code = 0, $msg = '', $type = 'json', array $header = [])
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'time' => $this->request->server('REQUEST_TIME'),
            'data' => $data,
        ];
        $type     = $type ?: $this->getResponseType();
        $response = Response::create($result, $type)->header($header);

        throw new HttpResponseException($response);
    }
    /**
     * 无限级分类-下拉式
     * @param array $data 分类数组
     * @param int $pid 父级id
     * @param int $lev 等级
     * @return array
     */
    public function dropTree($data, $pid = 0, $lev = 0)
    {
        $tree = [];
        foreach ($data as $value) {
            if ($value['pid'] == $pid) {
                $value['name'] = str_repeat('└- ', $lev) . $value['name'];
                $tree[] = $value;
                $tree = array_merge($tree, $this->dropTree($data, $value['id'], $lev + 1));
            }
        }
        return $tree;
    }
    
}