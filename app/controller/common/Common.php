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
 * Date: 2020/3/12
 * Time: 4:24
 */

namespace app\controller\common;

class Common
{
    const YEAR = 31536000;
    const MONTH = 2592000;
    const WEEK = 604800;
    const DAY = 86400;
    const HOUR = 3600;
    const MINUTE = 60;

    /**
     * 加密算法
     * @param $password
     * @return array
     * @author: MK
     * @Time: 2020/4/5 12:34
     */
    public static function pwdMd5($password)
    {
        $salt = substr(md5(time()), -10);    //密码盐
        return [
            'salt' => $salt,
            'password' => md5($password . $salt),   // 密码
        ];
    }

    /**
     * 生成token算法
     * @return string
     * @author: MK
     * @Time: 2020/4/5 12:34
     */
    public static function token()
    {
        $token = md5(uniqid(md5(microtime(true)), true));  //生成一个不会重复的字符串
        return sha1($token); // 加密
    }

    // 获取当月天数
    public static function cal_days_in_month($month,$year)
    {
        return date('t',mktime(0,0,0,$month,1,$year));
    }

     /**
     * 获取一个基于时间偏移的Unix时间戳
     *
     * @param string $type     时间类型，默认为day，可选minute,hour,day,week,month,quarter,year
     * @param int    $offset   时间偏移量 默认为0，正数表示当前type之后，负数表示当前type之前
     * @param string $position 时间的开始或结束，默认为begin，可选前(begin,start,first,front)，end
     * @param int    $year     基准年，默认为null，即以当前年为基准
     * @param int    $month    基准月，默认为null，即以当前月为基准
     * @param int    $day      基准天，默认为null，即以当前天为基准
     * @param int    $hour     基准小时，默认为null，即以当前年小时基准
     * @param int    $minute   基准分钟，默认为null，即以当前分钟为基准
     * @return int 处理后的Unix时间戳
     */
    public static function unixtime($type = 'day', $offset = 0, $position = 'begin', $year = null, $month = null, $day = null, $hour = null, $minute = null)
    {
        $year = is_null($year) ? date('Y') : $year;
        $month = is_null($month) ? date('m') : $month;
        $day = is_null($day) ? date('d') : $day;
        $hour = is_null($hour) ? date('H') : $hour;
        $minute = is_null($minute) ? date('i') : $minute;
        $position = in_array($position, array('begin', 'start', 'first', 'front'));

        switch ($type) {
            case 'minute':
                $time = $position ? mktime($hour, $minute + $offset, 0, $month, $day, $year) : mktime($hour, $minute + $offset, 59, $month, $day, $year);
                break;
            case 'hour':
                $time = $position ? mktime($hour + $offset, 0, 0, $month, $day, $year) : mktime($hour + $offset, 59, 59, $month, $day, $year);
                break;
            case 'day':
                $time = $position ? mktime(0, 0, 0, $month, $day + $offset, $year) : mktime(23, 59, 59, $month, $day + $offset, $year);
                break;
            case 'week':
                $time = $position ?
                    mktime(0, 0, 0, $month, $day - date("w", mktime(0, 0, 0, $month, $day, $year)) + 1 - 7 * (-$offset), $year) :
                    mktime(23, 59, 59, $month, $day - date("w", mktime(0, 0, 0, $month, $day, $year)) + 7 - 7 * (-$offset), $year);
                break;
            case 'month':
                $time = $position ? mktime(0, 0, 0, $month + $offset, 1, $year) : mktime(23, 59, 59, $month + $offset, self::cal_days_in_month($month + $offset, $year), $year);
                break;
            case 'quarter':
                $time = $position ?
                    mktime(0, 0, 0, 1 + ((ceil(date('n', mktime(0, 0, 0, $month, $day, $year)) / 3) + $offset) - 1) * 3, 1, $year) :
                    mktime(23, 59, 59, (ceil(date('n', mktime(0, 0, 0, $month, $day, $year)) / 3) + $offset) * 3, self::cal_days_in_month((ceil(date('n', mktime(0, 0, 0, $month, $day, $year)) / 3) + $offset) * 3, $year), $year);
                break;
            case 'year':
                $time = $position ? mktime(0, 0, 0, 1, 1, $year + $offset) : mktime(23, 59, 59, 12, 31, $year + $offset);
                break;
            default:
                $time = mktime($hour, $minute, 0, $month, $day, $year);
                break;
        }
        return $time;
    }

    /**
     * 计算两个时间戳之间相差的时间
     *
     * $span = self::span(60, 182, 'minutes,seconds'); // array('minutes' => 2, 'seconds' => 2)
     * $span = self::span(60, 182, 'minutes'); // 2
     *
     * @param   int    $remote timestamp to find the span of
     * @param   int    $local  timestamp to use as the baseline
     * @param   string $output formatting string
     * @return  string   when only a single output is requested
     * @return  array    associative list of all outputs requested
     *
     */
    public static function span($remote, $local = null, $output = 'years,months,weeks,days,hours,minutes,seconds')
    {
        $output = trim(strtolower((string)$output));
        if (!$output) {
            return false;
        }
        $output = preg_split('/[^a-z]+/', $output);
        $output = array_combine($output, array_fill(0, count($output), 0));
        extract(array_flip($output), EXTR_SKIP);
        if ($local === null) {
            $local = time();
        }
        $timespan = abs($remote - $local);
        if (isset($output['years'])) {
            $timespan -= self::YEAR * ($output['years'] = (int)floor($timespan / self::YEAR));
        }
        if (isset($output['months'])) {
            $timespan -= self::MONTH * ($output['months'] = (int)floor($timespan / self::MONTH));
        }
        if (isset($output['weeks'])) {
            $timespan -= self::WEEK * ($output['weeks'] = (int)floor($timespan / self::WEEK));
        }
        if (isset($output['days'])) {
            $timespan -= self::DAY * ($output['days'] = (int)floor($timespan / self::DAY));
        }
        if (isset($output['hours'])) {
            $timespan -= self::HOUR * ($output['hours'] = (int)floor($timespan / self::HOUR));
        }
        if (isset($output['minutes'])) {
            $timespan -= self::MINUTE * ($output['minutes'] = (int)floor($timespan / self::MINUTE));
        }
        if (isset($output['seconds'])) {
            $output['seconds'] = $timespan;
        }
        if (count($output) === 1) {

            return array_pop($output);
        }

        return $output;
    }
    
    //验证码
      public static function GetfourStr($len, $chars=null)
        {
    if (is_null($chars)){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    } 
    mt_srand(10000000*(double)microtime());
    for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
        $str .= $chars[mt_rand(0, $lc)]; 
    }
    return $str;
    }
    //验证码
    public static function getRandomString($len = 6) 
    { 
       $chars_array = array( 
       "0", "2", "3", "4", "5", "6", "7", "8", "9",
       "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", 
       "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "+", 
       "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", 
       "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", 
       "S", "T", "U", "V", "W", "X", "Y", "Z", 
       ); 
       $charsLen = count($chars_array) - 1; 
 
       $outputstr = ""; 
       for ($i=0; $i<$len; $i++) 
    { 
      $outputstr .= $chars_array[mt_rand(0, $charsLen)]; 
    } 
      return $outputstr; 
    } 
}