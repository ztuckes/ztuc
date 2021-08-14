<?php /*a:6:{s:56:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\user\index.html";i:1614254586;s:57:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\head.html";i:1614254586;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\header.html";i:1614885714;s:60:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\sidenav.html";i:1614254586;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\footer.html";i:1614885790;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\script.html";i:1615793640;}*/ ?>
<!DOCTYPE html>
<html>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo htmlentities($user['username']); ?> - <?php echo seo('title'); ?></title>
    <link rel="stylesheet" href="/static/hqui/libs/layui/css/layui.css"/>
    <link rel="stylesheet" href="/static/hqui/module/admin.css"/>
<style>
    .basicinfo {
        margin: 15px 0;
    }

    .basicinfo .row > .col-xs-4 {
        padding-right: 0;
    }

    .basicinfo .row > div {
        margin: 5px 0;
    }
</style>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="renderer" content="webkit">
    <title><?php echo seo('title'); ?></title>
    <meta name="keywords" content="<?php echo seo('keywords'); ?>"/>
    <meta name="description" content="<?php echo seo('description'); ?>"/>

    <link rel="stylesheet" media="screen" href="/static/behand/css/bootstrap.min.css"/>
    <link rel="stylesheet" media="screen" href="/static/behand/css/font-awesome.min.css"/>
    <link rel="stylesheet" media="screen" href="/static/behand/css/swiper.min.css">
    <link rel="stylesheet" media="screen" href="/static/behand/css/common.css"/>
    <link rel="stylesheet" media="screen" href="/static/behand/css/font_1104524_z1zcv22ej09.css"/>
    <link media="screen" href="/static/behand/css/frontend.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script><script src="vue.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
    <link rel="stylesheet" href="/static/prism/prism.css" media="all">
    <script type="text/javascript" src="/static/prism/prism.js" charset="utf-8"></script>
    
    <script type="text/javascript" src="/static/prism/vue.js"></script> 
</head>
<body>

<header class="header">
    <!-- S 导航 -->
<?php
$pagestartime=microtime();
?>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                     <span class="sr-only">Toggle</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <?php  $arr=array(10,20); $rand=array_rand($arr); if($rand == 0): ?>
            
                <a class="navbar-brand" style="padding:6px 15px;" href="/"><img src="<?php echo seo('image'); ?>" width="120" height="40" alt=""></a>
         <?php else: ?>
                <a class="navbar-brand" style="padding:6px 15px;" href="/"><img src="<?php echo seo('logo'); ?>" width="120" height="40" alt=""></a>
          <?php endif; ?>   
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <!--如果你需要自定义NAV,可使用channellist标签来完成,这里只设置了2级,如果显示无限级,请使用cms:nav标签-->
                    <!--判断是否有子级或高亮当前栏目-->
                    <li class="">
                        <a href="/"><?php echo __('home page'); ?></a> 
                        <ul class="dropdown-menu" role="menu">
                        </ul>
                    </li>
                    <!--判断是否有子级或高亮当前栏目-->
                    <?php foreach($cat as $vo): ?>
                    <li class="dropdown">
                        <a href="/column?ZcT=<?php echo base64_encode($vo['id']);?>&NcT=<?php echo base64_encode($vo['cat_name']);?>" <?php if($vo['child']): ?> data-toggle="dropdown"<?php endif; ?>><?php echo htmlentities($vo['cat_name']); if($vo['child']): ?><b class="caret"></b><?php endif; ?></a>
                        <?php if($vo['child']): ?>
                        <ul class="dropdown-menu">
                            <?php foreach($vo['child'] as $v): ?>
                            <li><a href="/column?ZcT=<?php echo base64_encode($v['id']);?>&NcT=<?php echo base64_encode($v['cat_name']);?>"><?php echo htmlentities($v['cat_name']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>

                    <!--判断是否有子级或高亮当前栏目-->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <!--search-->
                   <li>
                        <form class="form-inline navbar-form form-search" action="/search_json" method="get">
                            <div class="form-search hidden-sm hidden-md">
                                <input style="border-radius:5px;" class="form-control typeahead" name="search" type="text"
                                       data-typeahead-url="/" type="text"
                                       id="searchinput" placeholder="搜索">
</form>
                            </div>
                        </form>
                    </li>
                   <li class="dropdown">
                        <?php if(isset($user['username'])): ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                class="hidden-sm"><i><?php echo !empty($user['username']) ? htmlentities($user['username']) : ''; ?></i></span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/user/index"><i class="fa fa-sign-in fa-fw"></i><?php echo __('Membership Center'); ?></a></li>
                            <li><a href="/user/logout" onclick="return confirm('确认要安全退出？');"><i class="fa fa-sign-in fa-fw"></i><?php echo __('Log out'); ?></a></li>
                        </ul>
                           <?php else: ?>

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                class="hidden-sm"><i><?php echo !empty($tourist) ? htmlentities($tourist) : ''; ?></i></span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/user/login"><i class="fa fa-sign-in fa-fw"></i><?php echo __('Sign in now'); ?></a></li>
                            <li><a href="/user/register"><i class="fa fa-user-o fa-fw"></i><?php echo __('Register now'); ?></a></li>

                           <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <!-- E 导航 -->
</header>
<div id="content-container" class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="sidenav">
    <ul class="list-group">
        <li class="list-group-heading"><?php echo __('Membership Center'); ?></li>
         <?php foreach($sidebar as $vo): ?>
         
        <li class="list-group-item "> <a href="<?php echo htmlentities($vo['url']); ?>"><i class="<?php echo htmlentities($vo['icon']); ?>"></i><?php echo htmlentities(__($vo['desc'])); ?></a> </li>
         <?php endforeach; ?>
        <!--li class="list-group-item "> <a href="/user/contribution"><i class="fa fa-user-circle fa-fw"></i> <?php echo __('Contribution zone'); ?></a> </li>
        <li class="list-group-item "> <a href="/user/index"><i class="fa fa-user-circle fa-fw"></i> <?php echo __('Membership Center'); ?></a> </li>
        <li class="list-group-item "> <a href="/signin"><i class="fa fa-user-circle fa-fw"></i> <?php echo __('My sign in'); ?></a> </li>
        <li class="list-group-item "> <a href="/user/profile"><i class="fa fa-user-o fa-fw"></i> <?php echo __('personal data'); ?></a> </li>
        <li class="list-group-item "> <a href="/chats"><i class="fa fa-user-o fa-fw"></i> <?php echo __('Message zone'); ?></a> </li>
        <li class="list-group-item "> <a href="/user/changepwd"><i class="fa fa-key fa-fw"></i> <?php echo __('Change Password'); ?></a> </li>
        <li class="list-group-item "> <a href="/game/lottery"><i class="fa fa-key fa-fw"></i> <?php echo __('Lottery turntable'); ?></a> </li>
        <li class="list-group-item "> <a href="/user/logout" onclick="return confirm('确认要安全退出？');"><i class="fa fa-sign-out fa-fw"></i> <?php echo __('Log out'); ?></a> </li-->
    </ul>
</div>
              <!--未退出登录更新连续登录和最大连续登录/时间-->
              <?php echo htmlentities($days); ?>
              <!--未退出登录更新连续登录和最大连续登录/时间-->
        </div>
        <div class="col-md-9">
            <div class="panel panel-default ">
                <div class="panel-body">
               <h2 class="page-header">
                     <?php echo $user['id']==1 ? '<a href="/admin/index" target="_blank">Member Center</a>'  :  'Member Center'; ?>&nbsp;
                     <span style="font-size:8px;" id="myTime"></span><span style="font-size:8px;">
                    &nbsp;在线&nbsp;<?php  echo maktimes(floor($list['line_time'])); ?> <a ew-event="message" data-url="/user/message" title="消息">
                    <i class="layui-icon layui-icon-notice"></i>
                    <?php if($notice > 0): ?>
                    <span class="layui-badge-dot"></span><!--小红点-->
                    <?php endif; ?>
                </a></span>
                  
                        <a href="/signin" class="btn btn-success pull-right <?php echo !empty($signin) ? 'disabled' : ''; ?> "><i class="fa fa-pencil"></i>
                            <?php echo !empty($signin) ? __('Signed in')  :  __('No sign in'); ?></a>
                    </h2>
                    <div class="row user-baseinfo">
                        <div class="col-md-3 col-sm-3 col-xs-2 text-center user-center">
                            <a href="/user/profile" title="<?php echo __('head portrait'); ?>">
                                <span class="avatar-img"><img src="<?php echo htmlentities($userInfo['avatar']); ?>" alt=""></span>
                            </a>
                        </div>
                        <?php if($userInfo['email'] == ""): ?>
                    <script>window.alert('<?php echo __('Please go to personal data binding mailbox to retrieve the password!'); ?>');</script>
                      
                       <?php endif; ?>
                        <div class="col-md-9 col-sm-9 col-xs-10">
                            <!-- Content -->
                            <div class="ui-content">
                                <!-- Heading -->
                                <h4><a href="#"><?php echo htmlentities($userInfo['username']); ?></a></h4>
                                <!-- Paragraph -->
                                    <div class="row">
                                        
                                        <div class="col-xs-8 col-md-4">
                                         <a href="/signin"><?php echo __('Insist on signing in, surprise'); ?></a>
                                        </div>
                                        
                                    
                                    </div>

                                <!-- Success -->
                                <div class="basicinfo">
                                    <div class="row">
                                        
                                        <div class="col-xs-4 col-md-2"><?php echo __('QQ quick login'); ?></div>
                                        <div class="col-xs-8 col-md-4">
                                            <?php if($userInfo['openid']): ?><span style="color: #fff;background-color: #009688;border-radius:5px;font-size: 10px;padding: 4px 6px;"><?php echo __('Bound'); ?></span> <a href="/qqlogin"><i class="layui-icon layui-icon-login-qq">  <?php echo __('Change the binding'); ?></i></a><?php else: ?><span style="color: #fff;background-color: #FF5722;border-radius:5px;font-size: 10px;padding: 4px 6px;"><?php echo __('Unbound'); ?></span> <a href="/qqlogin"><i class="layui-icon layui-icon-login-qq"><?php echo __('binding'); ?></i></a><?php endif; ?>

                                        </div>
                                        <div class="col-xs-4 col-md-2"><?php echo __('Grade'); ?></div>
                                        <div class="col-xs-8 col-md-4">
                                            <a href="javascript:;" class="viewmoney"><?php echo htmlentities($userInfo['level']); ?></a> <?php echo __('level'); ?>

                                        </div>
                                        </div>
                                        <div class="row">
                                        
                                        <div class="col-xs-4 col-md-2"><?php echo __('balance'); ?></div>
                                        <div class="col-xs-8 col-md-4">
                                            <a href="javascript:;" class="viewmoney"><?php echo htmlentities($userInfo['money']); ?></a> <?php echo __('element'); ?>
                                        </div>
                                        <div class="col-xs-4 col-md-2"><?php echo __('integral'); ?></div>
                                        <div class="col-xs-8 col-md-4">
                                            <a href="javascript:;" class="viewscore"><?php echo htmlentities($userInfo['score']); ?></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-4 col-md-2"><?php echo __('Continuous login days'); ?></div>
                                        <div class="col-xs-8 col-md-4"><?php echo htmlentities($userInfo['successions']); ?> <?php echo __('day'); ?></div>
                                        <div class="col-xs-4 col-md-2"><?php echo __('Maximum login days'); ?></div>
                                        <div class="col-xs-8 col-md-4"><?php echo htmlentities($userInfo['maxsuccessions']); ?> <?php echo __('day'); ?>（连续）</div>
                                    </div>
                                    <div class="row">  
                                   
                                        <div class="col-xs-4 col-md-2"><?php echo __('login time'); ?></div>
                                        <div class="col-xs-8 col-md-4"><?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($logintime)? strtotime($logintime) : $logintime)); ?></div>
                                        <div class="col-xs-4 col-md-2"><?php echo __('Remaining login time'); ?></div>
                                        <div class="col-xs-8 col-md-4"><i style="color:red"><span id="hideD"><strong id="RemainD"></strong>天</span> <span id="hideH"><strong id="RemainH"></strong>小时</span><span id="hideM"> <strong id="RemainM"></strong>分钟</span> <span id="hideS"><strong id="RemainS"></strong>秒</span></i></div>
                                 
                                    </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- 加载动画 -->
<div class="page-loading">
    <div class="ball-loader">
        <span></span><span></span><span></span><span></span>
    </div>
</div>

<!-- js部分 -->
<script type="text/javascript" src="/static/hqui/libs/layui/layui.js"></script>
<script type="text/javascript" src="/static/hqui/js/common.js"></script>
<script>


    layui.use(['index'], function () {
        var $ = layui.jquery;
        var index = layui.index;

        // 默认加载主页
        index.loadHome({
            menuPath: '/user/index',
            menuName: '<i class="layui-icon layui-icon-home"> </i>'
        });
        $('.layui-body>.layui-tab[lay-filter="admin-pagetabs"]').attr('lay-autoRefresh', 'true');
        //开启轮询
        setInterval("test()",20000);
    });
    //查询通知
    function test() {
        layui.use(['notice'], function () {
            var $ = layui.jquery;
            $.ajax({
                url: "<?php echo url('user/get_notice'); ?>",
                async:true,
                type: 'get',
                success: function (res) {
                    console.log(res.data);
                    if (res.data > 0){
                        var notice = layui.notice;
                        notice.warning({
                            title: '消息通知',
                            message: '你今天有'+res.data+'条新的提醒待处理,请及时处理!',
                            audio:'5',
                            position:'bottomRight',
                            balloon:true,
                        });
                    }
                }
            })
        });
    }
</script>
<script language="JavaScript">
    var runtimes = 0;
    function GetRTime(){
        var nMS = <?php echo $overtime; ?>*1000-runtimes*1000;
 
        if (nMS>=0){
            var nD=Math.floor(nMS/(1000*60*60*24))%24;
            var nH=Math.floor(nMS/(1000*60*60))%24;
            var nM=Math.floor(nMS/(1000*60)) % 60;
            var nS=Math.floor(nMS/1000) % 60;
            document.getElementById("RemainD").innerHTML=nD < 10 ? "0" + nD : nD;
            document.getElementById("RemainH").innerHTML=nH < 10 ? "0" + nH : nH;
            document.getElementById("RemainM").innerHTML=nM < 10 ? "0" + nM : nM;
            document.getElementById("RemainS").innerHTML=nS < 10 ? "0" + nS : nS;
            runtimes++;
            if(nD==0){
                //天数0 隐藏天数
                document.getElementById("hideD").style.display="none";
                if(nH==0){
                    //数0 隐藏天数
                    document.getElementById("hideH").style.display="none";
                    if(nM==0){
                        document.getElementById("hideM").style.display="none";
                        if(nS==0){
                            alert("倒计时完毕");
                        }
                    }
                }
            }
            setTimeout("GetRTime()",1000);
        }
    }
    window.onload = function() {
        GetRTime();
    }
</script>
<!--网站时间-->
<script>
function getCurDate()  
{  
 var d = new Date();  
 var week;  
 switch (d.getDay()){  
 case 1: week="星期一"; break;  
 case 2: week="星期二"; break;  
 case 3: week="星期三"; break;  
 case 4: week="星期四"; break;  
 case 5: week="星期五"; break;  
 case 6: week="星期六"; break;  
 default: week="星期天";  
 }  
 var years = d.getFullYear();  
 var month = add_zero(d.getMonth()+1);  
 var days = add_zero(d.getDate());  
 var hours = add_zero(d.getHours());  
 var minutes = add_zero(d.getMinutes());  
 var seconds=add_zero(d.getSeconds());  
 var ndate = years+"年"+month+"月"+days+"日 "+hours+":"+minutes+":"+seconds+" "+week;  
 myTime.innerHTML = ndate;  
}  
  
function add_zero(temp)  
{  
 if(temp<10) return "0"+temp;  
 else return temp;  
}  
  
setInterval("getCurDate()", 100);  
</script>
<footer>
    <div class="container-fluid" id="footer">
        <div class="container">
            <div class="row footer-inner">
                <div class="col-md-3 col-sm-3">
                    <div class="footer-logo"> 
                    <?php $arr=array(10,20); $rand=array_rand($arr);if($rand == 0): ?>
            
                       <img src="<?php echo seo('image'); ?>" width="120" height="40" alt="">
         <?php else: ?>
            
                       <img src="<?php echo seo('logo'); ?>" width="120" height="40" alt="">
          <?php endif; ?>   
                    </div>  
                    <p class="copyright"> <?php
$pageendtime = microtime();
$starttime = explode(" ",$pagestartime);
$endtime = explode(" ",$pageendtime);
$totaltime = $endtime[0]-$starttime[0]+$endtime[1]-$starttime[1];
$timecost = sprintf("%s",$totaltime);
echo "页面运行时间: $timecost 秒";
?> 
                        <small><br>本站已安全运行：<span id="momk"></span><br><?php echo seo('copyright'); ?><br>备案信息：<a href="https://beian.miit.gov.cn/"><?php echo seo('beian'); ?></a></small>
                   
                    </p>
                </div>
            </div>
        </div>
        
    </div>
<script type="text/javascript">
function NewDate(str) {
str = str.split('-');
var date = new Date();
date.setUTCFullYear(str[0], str[1] - 1, str[2]);
date.setUTCHours(0, 0, 0, 0);
return date;
}
function momxc() {
var birthDay =NewDate("2016-5-6");
var today=new Date();
var timeold=today.getTime()-birthDay.getTime();
var sectimeold=timeold/1000
var secondsold=Math.floor(sectimeold);
var msPerDay=24*60*60*1000; 
var e_daysold=timeold/msPerDay;
var daysold=add_zero(Math.floor(e_daysold));
var e_hrsold=(daysold-e_daysold)*-24;
var hrsold=add_zero(Math.floor(e_hrsold));
var e_minsold=(hrsold-e_hrsold)*-60;
var minsold=add_zero(Math.floor((hrsold-e_hrsold)*-60)); 
var seconds=add_zero(Math.floor((minsold-e_minsold)*-60).toString());
document.getElementById("momk").innerHTML = +daysold+"天"+hrsold+"小时"+minsold+"分"+seconds+"秒"; 
function add_zero(temp)  
{  
 if(temp<10) return "0"+temp;  
 else return temp;  
}  
   
setTimeout(momxc, 1000);
}momxc();
</script>  
<style>
#momk{animation:change 10s infinite;font-weight:800; }
@keyframes change{0%{color:#5cb85c;}25%{color:#556bd8;}50%{color:#66e616;}75%{color:#66e616;}100% {color:#67bd31;}}
</style>
</footer>
<div id="floatbtn">
    <!-- S 浮动按钮-->

    <a class="hover" href="/user/contribution" target="_blank">
        <i class="iconfont icon-pencil"></i>
        <em>立即<br>投稿</em>
    </a>

    <a id="back-to-top" class="hover" href="javascript:;">
        <i class="iconfont icon-backtotop"></i>
        <em>返回<br>顶部</em>
    </a>
    <!-- E 浮动按钮 -->
</div>

</body>
<script type="text/javascript" src="/static/behand/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/behand/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/behand/js/layer.js"></script>
<script type="text/javascript" src="/static/behand/js/template-native.js"></script>
<script type="text/javascript" src="/static/behand/js/bootstrap-typeahead.min.js"></script>
<script type="text/javascript" src="/static/behand/js/swiper.min.js"></script>
<script type="text/javascript" src="/static/behand/js/cms.js"></script>
<script type="text/javascript" src="/static/behand/js/common.js"></script>

<script src="http://siteapp.baidu.com/static/webappservice/uaredirect.js" type="text/javascript"></script>
<script type="text/javascript">uaredirect("http://m.ztuc.cn","http://ztuc.cn");</script>

</html>