<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/3
 * Time: 18:35
 */
namespace app\http;

use think\worker\Server;
use think\facade\Request;
use Workerman\Lib\Timer;

class Worker extends Server
{
    protected $socket = 'websocket://0.0.0.0:2345';

    public function onWorkerStart()
    {

    }

    public function onMessage($connection,$data)
    {
        $connection->send('hello word'.$data);
    }

}