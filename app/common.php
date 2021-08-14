<?php


use app\common\model\Taocan;
use think\facade\Session;
use think\facade\Request;
use think\facade\Config;
use think\facade\Cache;
use think\facade\Db;
use app\crm\model\CrmSetting;
use app\store\model\Store;
use app\store\model\StoreGroup;
use app\store\model\StoreRule;
use app\store\model\StoreLog;
use app\store\model\DictData;
use app\store\model\User;
// 应用公共文件
/**
 * 数组转xls格式的excel文件
 * @param $data
 * @param $title
 * 示例数据
 * $data = [
 *     [NULL, 2010, 2011, 2012],
 *     ['Q1', 12, 15, 21],
 *     ['Q2', 56, 73, 86],
 *     ['Q3', 52, 61, 69],
 *     ['Q4', 30, 32, 10],
 * ];
 * @throws PHPExcel_Exception
 * @throws PHPExcel_Reader_Exception
 * @throws PHPExcel_Writer_Exception
 */

// 公共助手函数
  
function export_excel($data, $title,$filename)
{
    //require_once __DIR__ . '/vendor/autoload.php';
 
    // Create new Spreadsheet object
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
 
    // 方法一，使用 setCellValueByColumnAndRow
    //表头
    //设置单元格内容
    foreach ($title as $key => $value) {
        // 单元格内容写入
        $sheet->setCellValueByColumnAndRow($key + 1, 1, $value);
    }
    $row = 2; // 从第二行开始
    foreach ($data as $item) {
        $column = 1;
        foreach ($item as $value) {
            // 单元格内容写入
            $sheet->setCellValueByColumnAndRow($column, $row, $value);
            $column++;
        }
        $row++;
    }
 
    // 方法二，使用 setCellValue
    //表头
    //设置单元格内容
    $titCol = 'A';
    foreach ($title as $key => $value) {
        // 单元格内容写入
        $sheet->setCellValue($titCol . '1', $value);
        $titCol++;
    }
    $row = 2; // 从第二行开始
    foreach ($data as $item) {
        $dataCol = 'A';
        foreach ($item as $value) {
            // 单元格内容写入
            $sheet->setCellValue($dataCol . $row, $value);
            $dataCol++;
        }
        $row++;
    }
 
    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');
 
    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
 
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
}

function extraconfig($arr = [], $file = '')
{
    if (is_array($arr)) {
        $filename = $file .'.php';
        $filepath = config_path() . $filename;
        if (!file_exists($filepath)) {
            $conf = "<?php return [];";
            file_put_contents($filepath, $conf);
        }
        $conf = include $filepath;
        foreach ($arr as $key => $value) {
            $conf[$key] = $value;
        }
        $time = date('Y/m/d H:i:s');
        $str = "<?php\r\n/**\r\n * 九月科技（http://www.ztuc.cn）.\r\n * $time\r\n */\r\nreturn [\r\n";
        foreach ($conf as $key => $value) {
            $str .= "\t'$key' => '$value',";
            $str .= "\r\n";
        }
        $str .= '];';
        file_put_contents($filepath, $str);
        
        return true;
    } else {
        return false;
    }
}
//在线时长
function lineTime($id)
{ 
    if(!empty($id)){
    $data = \app\model\admin\User::where('id',$id)->find();
    \app\model\admin\User::whereTime('login_time','<=',time()-180)->update(['login_time' => time()-1, 'exptime' => $data['line_time']]);    
    $model = \app\model\admin\User::where('id',$id)->find();
    $login_time = $model['login_time'];
    $line_time = (time() - $login_time)+$model['exptime'];
    \app\model\admin\User::where('id',$id)->update(['line_time' => $line_time]);
    return $model;
    }
}

//判断电脑手机
function isMobile(){    
    $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';    
    $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';      
    function CheckSubstrs($substrs,$text){    
        foreach($substrs as $substr)    
            if(false!==strpos($text,$substr)){    
                return true;    
            }    
            return false;    
    }  
    $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');  
    $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');    
                
    $found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||    
              CheckSubstrs($mobile_token_list,$useragent);    
                
    if ($found_mobile){    
        return true;    
    }else{    
        return false;    
    }    
}  

    //自定义函数：time2string($second) 输入秒数换算成多少天/多少小时/多少分/多少秒的字符串
function maktimes($second){
    $day = floor($second/(3600*24));
    $second = $second%(3600*24);//除去整天之后剩余的时间
    $hour = floor($second/3600);
    $second = $second%3600;//除去整小时之后剩余的时间 
    $minute = floor($second/60);
    $second = $second%60;//除去整分钟之后剩余的时间 
    //返回字符串
    return $day.'天'.$hour.'小时'.$minute.'分'.$second.'秒';
}

/**
 * 获取时间参数
 * @return integer 0/管理员ID
 */
function time_trans($the_time)
{   $time = $the_time;
    $now_time = time();
    $show_time = strtotime($the_time);
    $the_time = $now_time - $show_time;
    if($the_time < 60){
        return $the_time.'秒前';
    }else if($the_time < 3600){
        return floor($the_time/60).'分钟前';
    }else if($the_time < 86400) {
        return floor($the_time/3600).'小时前';
    }else if($the_time < 259200) {//3天内
        return floor($the_time / 86400) . '天前';
    }else{
        return $time;
    }
}

// 返回数据

function __($name)
{ 
    $data = Config::load('admin_code', 'set_code');
       return $data[$name];
} 

/**
 * 系统配置
 */
function sys_set($field)
{
    $data = get_system('website');
    return $data[$field];
}
/**
 * 系统配置
 */
function get_system($field)
{
    $data = \app\model\admin\System::where('key',$field)->cache($field)->find()['jdata'];
    return $data;
}
//网站信息
function seo($type)
{
    $website = get_system('website');
    $website[$type] = isset($website[$type])?$website[$type]:'';
    return $website[$type];
}   
/**
 * http请求
 * @param string $url 请求的地址
 * @param array $data 发送的参数
 */
function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

/**
 * 验证密码长度
 * @param string $password 需要验证的密码
 * @param int $min 最小长度
 * @param int $max 最大长度
 */
function check_password($password, $min, $max)
{
    if (strlen($password) < $min || strlen($password) > $max) {
        return false;
    }
    return true;
}
/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 把json字符串转数组
 * @param json $p
 * @return array
 */
function json_to_array($p)
{
    if (mb_detect_encoding($p, array('ASCII', 'UTF-8', 'GB2312', 'GBK')) != 'UTF-8') {
        $p = iconv('GBK', 'UTF-8', $p);
    }
    return json_decode($p, true);
}

/**
 * 获取随机位数数字
 * @param  integer $len 长度
 * @return string
 */
function rand_number($len = 6)
{
    return substr(str_shuffle(str_repeat('0123456789', 10)), 0, $len);
}

/**
 * 验证固定电话格式
 * @param string $tel 固定电话
 * @return boolean
 */
function check_tel($tel) {
    $chars = "/^([0-9]{3,4}-)?[0-9]{7,8}$/";
    if (preg_match($chars, $tel)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 验证QQ号码是否正确
 * @param number $mobile
 */
function check_qq($qq)
{
    if (!is_numeric($qq)) {
        return false;
    }
    return true;
}

/**
 * 配置值解析成数组
 * @param string $value 配置值
 * @return array|string
 */
function parse_attr($value)
{
    if (is_array($value)) {
        return $value;
    }
    $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
    if (strpos($value, ':')) {
        $value = array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k] = $v;
        }
    } else {
        $value = $array;
    }
    return $value;
}

/**
 * 数组层级缩进转换
 * @param array $array 源数组
 * @param int $pid
 * @param int $level
 * @return array
 */
function list_to_level($array, $pid = 0, $level = 1)
{
    static $list = [];
    foreach ($array as $k => $v) {
        if ($v['pid'] == $pid) {
            $v['level'] = $level;
            $list[]     = $v;
            unset($array[$k]);
            list_to_level($array, $v['id'], $level + 1);
        }
    }
    return $list;
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = 'children', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent           = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree 原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array $list 过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list($tree, $child = 'children', $order = 'id', &$list = array())
{
    if (is_array($tree)) {
        $refer = array();
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if (isset($reffer[$child])) {
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby = 'asc');
    }
    return $list;
}

/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list, $field, $sortby = 'asc')
{
    if (is_array($list)) {
        $refer = $resultSet = array();
        foreach ($list as $i => $data) {
            $refer[$i] = &$data[$field];
        }

        switch ($sortby) {
            case 'asc': // 正向排序
                asort($refer);
                break;
            case 'desc': // 逆向排序
                arsort($refer);
                break;
            case 'nat': // 自然排序
                natcasesort($refer);
                break;
        }
        foreach ($refer as $key => $val) {
            $resultSet[] = &$list[$key];
        }

        return $resultSet;
    }
    return false;
}

// 驼峰命名法转下划线风格
function to_under_score($str)
{
    $array = array();
    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] == strtolower($str[$i])) {
            $array[] = $str[$i];
        } else {
            if ($i > 0) {
                $array[] = '_';
            }
            $array[] = strtolower($str[$i]);
        }
    }
    $result = implode('', $array);
    return $result;
}

/**
 * 自动生成新尺寸的图片
 * @param string $filename 文件名
 * @param int $width 新图片宽度
 * @param int $height 新图片高度(如果没有填写高度，把高度等比例缩小)
 * @param int $type 缩略图裁剪类型
 *                    1 => 等比例缩放类型
 *                    2 => 缩放后填充类型
 *                    3 => 居中裁剪类型
 *                    4 => 左上角裁剪类型
 *                    5 => 右下角裁剪类型
 *                    6 => 固定尺寸缩放类型
 * @return string     生成缩略图的路径
 */
function thumb($src = '', $width = 500, $height = 500, $type = 1, $replace = false)
{
    //判断URL
    if(strstr($src, request()->domain())){
        $src = './' .str_replace(request()->domain(),'',$src);
    }else{
        $src = './' . $src;
    }
    if (is_file($src) && file_exists($src)) {
        // 如果没有填写高度，把高度等比例缩小
        if ($height == null) {
            $info = getimagesize(root_path() . $filename);
            if ($width > $info[0]) {
                // 如果缩小后宽度尺寸大于原图尺寸，使用原图尺寸
                $width  = $info[0];
                $height = $info[1];
            } elseif ($width < $info[0]) {
                $height = floor($info[1] * ($width / $info[0]));
            } elseif ($width == $info[0]) {
                return $filename;
            }
        }
        $ext = pathinfo($src, PATHINFO_EXTENSION);
        $name = basename($src, '.' . $ext);
        $dir = dirname($src);
        if (in_array($ext, array('gif', 'jpg', 'jpeg', 'bmp', 'png'))) {
            $name = $name . '_thumb_' . $width . '_' . $height . '.' . $ext;
            $file = $dir . '/' . $name;
            if (!file_exists($file) || $replace == true) {
                $image = \think\Image::open($src);
                $image->thumb($width, $height, $type);
                $image->save($file);
            }
            $file = str_replace("\\", "/", $file);
            $file = '/' . trim($file, './');
            return $file;
        }
    }
    $src = str_replace("\\", "/", $src);
    $src = '/' . trim($src, './');
    return $src;
}


/**
 * 数据签名认证
 * @param  array $data 被认证的数据
 * @return string       签名
 */
function data_auth_sign($data)
{
    // 数据类型检测
    if (!is_array($data)) {
        $data = (array)$data;
    }
    ksort($data); // 排序
    $code = http_build_query($data); // url编码并生成query字符串
    $sign = sha1($code); // 生成签名
    return $sign;
}

/**
 * 清除系统缓存
 */
function clear_cache($directory = null)
{
    $directory = empty($directory) ? root_path() . 'runtime/cache/' : $directory;
    if (is_dir($directory) == false) {
        return false;
    }
    $handle = opendir($directory);
    while (($file = readdir($handle)) !== false) {
        if ($file != "." && $file != "..") {
            is_dir($directory . '/' . $file) ? clear_cache($directory . '/' . $file) : unlink($directory . '/' . $file);
        }
    }
    if (readdir($handle) == false) {
        closedir($handle);
        rmdir($directory);
    }
}

/**
 * 数组转换为数据集对象
 * @param array $resultSet 数据集数组
 * @return \think\model\Collection|\think\Collection
 */
function collection($resultSet)
{
    $item = current($resultSet);
    if ($item instanceof Model) {
        return \think\model\Collection::make($resultSet);
    } else {
        return \think\Collection::make($resultSet);
    }
}
/**
 * 期间日期
 * @param $startDate
 * @param $endDate
 * @return array
 */
function periodDate($startDate, $endDate){
    $startTime = strtotime($startDate);
    $endTime = strtotime($endDate);
    $arr = array();
    while ($startTime <= $endTime){
        $arr[] = date('Y-m-d', $startTime);
        $startTime = strtotime('+1 day', $startTime);
    }
    return $arr;
}
/**
 * @param $str 字符串
 * @param $start 替换字符的开始文字
 * @param $len  替换字符的长度
 * @param $symbol 替换的字符  例如*、#等
 * @return string
 */
function str_replaces($str, $start, $len, $symbol='*')
{
    $end = $start + $len;
    // 截取头保留的字符
    $str1 = mb_substr($str, 0, $start);
    // 截取尾保留的字符
    $str2 = mb_substr($str, $end);

    //  生产要替换的字符
    $symbol_num = '';
    for ($i = 0; $i < $len; $i++) {
        $symbol_num .= $symbol;
    }
    return $str1 . $symbol_num . $str2;
}

/**
 * 权限验证
 * @param $url
 * @return bool
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\DbException
 * @throws \think\db\exception\ModelNotFoundException
 */
function auth_url($url)
{
    //检查管理员
    $store = Store::where('id',StoreId())->cache('store_info'.StoreId(),86400,'store'.StoreId())->find();
    if (!(new \core\StoreAuth())->check($url, Session::get('user_auth.user_id')) && $store['admin_id'] != UserId()) {
        return false;
    }
    return true;
}
/**
 * 检测会员是否登录
 * @return integer 0/管理员ID
 */
function is_user_login()
{
    $user = Session::get('user_auth');
    if (empty($user)) {
        return 0;
    } else {
        return Session::get('user_auth_sign') == data_auth_sign($user) ? $user['user_id'] : 0;
    }
}
/**
 * 保存前台用户行为
 * @param string $remark 日志备注
 */
function insert_user_log($remark)
{
    if (session('?user_auth')) {
        StoreLog::create([
            'store_id'    => Session::get('user_auth.store_id'),
            'client'      => request()->isMobile()?'1':'0',
            'user_id'     => Session::get('user_auth.user_id'),
            'ip'          => request()->ip(),
            'url'         => request()->url(true),
            'method'      => request()->method(),
            'type'        => request()->type(),
            'param'       => json_encode(request()->param()),
            'remark'      => $remark
        ]);
    }
}
//获取管理员ID
function AdminId()
{
    $info = session('admin_auth.admin_id');
    return $info;
}
//获取用户ID
function UserId()
{
    $info = session('user_auth.user_id');
    return $info;
}
//获取商家ID
function StoreId()
{
    $info = session('user_auth.store_id');
    return $info;
}
/**
 * 字典列表
 * @param string $dict_id 字典类别ID
 */
function get_dict_list($dict_id)
{
    $list = DictData::field('id,id as value,store_id,dict_id,name,is_default')->where('dict_id',$dict_id)->cache('dict_list'.$dict_id.StoreId(),86400,'store'.StoreId())->where('status','1')->order('sort_order desc,id desc')->select();
    return $list;
}
/**
 * 字典列表
 * @param string $id 字典ID
 */
function get_dict_value($id)
{
    $list = DictData::where('id',$id)->value(['name']);
    return $list;
}
/**
 * 获取默认值
 * @param string $id 字典ID
 */
function default_value($dict_id)
{
    $list = DictData::where('dict_id',$dict_id)->where('is_default',1)->value('id');
    return $list;
}

/**
 * 获取我所在的权限
 * @param string $id 字典ID
 */
function my_auth()
{
    $myauth = cache('user_auth'.UserId());
    if(empty($myauth)){
        $groupid = StoreGroup::get_group_list();
        //得到所有子部门的ID
        $myauth = User::where('group_id','in',$groupid)->cache('user_auth'.UserId(),86400,'store'.StoreId())->column('id');
    }
    return $myauth;
}
/**
 * 获取我的角色所在的权限
 */
function my_rule()
{
    //查询我是不是主管理员
    $store = Store::where('id',StoreId())->cache('store_info'.StoreId(),86400,'store'.StoreId())->find();
    if($store['admin_id'] == UserId()){
        $myrule = \app\common\model\Taocan::where('id',$store['taocan'])->value('rules');
    }else{
        //获取我的角色ID
        $ruleIds = User::where('id',UserId())->cache('user_rule_id'.UserId(),86400,'store'.StoreId())->where('id',UserId())->value('rule_id');
        $rules = StoreRule::where('id','in',$ruleIds)->cache('user_rule'.UserId(),86400,'store'.StoreId())->column('rules');
        $myrule = implode(',',$rules);
    }
    return $myrule;
}

/**
 * 清空所有的权限缓存
 * @param string $user_id 用户ID
 */
function clear_store_cache()
{
    //检查是否传入USERID
    Cache::tag('store'.StoreId())->clear();
    return ;
}
/**
 * 我的商户资料
 */
function shopinfo(){
    $data = Store::where('id',StoreId())->cache('shop_info'.StoreId(),86400,'store'.StoreId)->find();
    return $data;
}

/**
 * 读取CRM设置
 * @param $name
 * @return mixed
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\DbException
 * @throws \think\db\exception\ModelNotFoundException
 */
function crm_setting($name){
    $data = CrmSetting::where('name','crm')->cache('setting_crm'.StoreId(),864000,'store'.StoreId())->find();
    if(isset($data)){
        return $data['jdata'];
    }else{
        return ;
    }
}