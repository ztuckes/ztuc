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
 * Date: 2020/4/25
 * Time: 21:58
 */

namespace app\controller\common;

use Predis\Client;

/**
 * Redis
 * Class Redis
 * @package app\controller\common
 */
class Redis
{

    // redis
    protected $redis = null;

    /**
     * 构造方法
     * Redis constructor.
     */
    public function __construct()
    {
        $this->redis = $this->redis();
    }

    /**
     * 实例化redis
     * @return Client
     */
    public function redis()
    {
        $options = [
            'host' => '127.0.0.1',
            'port' => '6379',
        ];

        $redis = new Client($options);
        return $redis;
    }

    /**
     * 设置redis缓存
     * @param $key
     * @param $val
     * @param int $timeout
     * @return Client
     */
    public function setKey($key, $val, $timeout = 30)
    {

        $this->redis->set($key, $val);

        if (!empty($timeout)) {
            $this->redis->expire($key, $timeout);
        }
        return $this->redis;
    }

    /**
     * 获取redis缓存
     * @param $key
     * @return string
     */
    public function getKey($key)
    {
        return $this->redis->get($key);
    }

    /**
     * redis ip限制访问次数
     * @param string $ip
     * @param int $limit 限制次数 1 次
     * @param int $timeout 超时时间 60 秒
     * @return bool
     */
    public function checkRule($ip='', $limit = 1, $timeout = 10): bool
    {
        if (empty($ip)) $ip = request()->ip();
        $check = $this->redis->exists($ip);
        if ($check) {
            $this->redis->incr($ip);
            $count = $this->redis->get($ip);
            if ($count > $limit) {
                return false;     //已超出限制次数
            }
        } else {
            $this->redis->incr($ip);
            $this->redis->expire($ip, $timeout);
        }

        return true;
    }
}