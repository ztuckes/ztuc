<?php /*a:6:{s:58:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\signin\index.html";i:1614254586;s:57:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\head.html";i:1614254586;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\header.html";i:1614885714;s:60:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\sidenav.html";i:1614254586;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\footer.html";i:1614885790;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\script.html";i:1615793640;}*/ ?>
<!DOCTYPE html>
<html>
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
<style>
    .calendar {
        color: #444;
        width: 100%;
        table-layout: fixed;
    }

    .calendar-title th {
        font-size: 14px;
        font-weight: bold;
        padding: 15px;
        text-align: center;
        text-transform: uppercase;
    }

    .calendar-header th {
        padding: 10px;
        text-align: center;
    }

    .calendar-title th {
        font-weight: normal;
    }

    .calendar-title th span {
        margin: 0 5px;
        color: #666;
    }

    .calendar-title th a {
        margin: 0 5px;
        color: #666;
    }

    .calendar tbody tr td {
        text-align: center;
        vertical-align: middle;
        width: 14.28%;
        height: 60px;
        line-height: 30px;
    }

    .calendar tbody tr td.pad {
        background: rgba(255, 255, 255, 0.1);
    }

    .calendar tbody tr td.day {
    }

    .calendar tbody tr td.day div:first-child {
        display: block;
        width: 30px;
        margin: 0 auto;
        cursor: pointer;
    }

    .calendar tbody tr td.signed div:first-child {
        background: #f7b82e;
        color: #fff;
        border-radius: 30px;
    }

    .calendar tbody tr td.today {
        background: rgba(0, 0, 0, 0.1);
    }

    .signin-rank-table > tbody > tr > td {
        vertical-align: middle;
    }
</style>
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
        </div>
        <div class="col-md-9">
            <div class="panel panel-default panel-page">
                <div class="panel-heading">
                    <h2>My sign in 
                        <a class="btn btn-success pull-right btn-signin <?php echo !empty($signin) ? 'disabled' : ''; ?> " href="javascript:;">
                            <i class="fa fa-location-arrow"></i> <span><?php echo !empty($signin) ? __('Signed in')  :  __('Sign in'); ?></span>
                        </a>

                        <a href="javascript:;" class="btn btn-default pull-right btn-rule" style="margin-right:5px;">
                            <i class="fa fa-question-circle"></i>
                            <?php echo __('Sign in points rule'); ?>
                        </a>

                        <a href="javascript:;" class="btn btn-default pull-right btn-rank" style="margin-right:5px;">
                            <i class="fa fa-trophy"></i>
                            <?php echo __('Ranking List'); ?>
                        </a>
                    </h2>
                </div>
                <div class="panel-body" style="padding:0;">
                    <div class="alert alert-warning-light">
                        <?php if($signin): ?>
                        
                        <?php echo str_replace(array('%a', '%b'), array('<b style="color: #ff0000;">' . $successions . '</b>', '<b style="color: #ff0000;">' . $score . '</b>'), __('Continue to sign in')); else: ?>
                        <?php echo str_replace('%a', '<b style="color: #ff0000;">' . $score . '</b>', __('Check in today')); ?>
                        <?php endif; ?>
                    </div>
                    <div class="calendar calendar3"></div>
                    <?php echo $calendar->draw($date); ?>
                </div>
            </div>
        </div>
    </div>
</div>

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

<script>
    // 签到
    $(document).on('click', ".btn-signin,.today", function () {
       var index = layer.msg('<i><?php echo __('Please wait while we sign in'); ?></i>', {
        icon: 16,
        time: false,
        shade: 0.3,
        anim: 1
    });
        CMS.api.ajax({
            url: "/dosign",
            data: {}
        }, function (data, ret) {
            if (ret.code == 1) {
                setTimeout(function () {
                    location.reload();
                }, 1500)
            }
        });
    })
    // 补签
    $(document).on('click', ".expired[data-date]:not(.today):not(.signed)", function () {
        var that = this;
        layer.confirm("<?php echo __('Confirm the date of supplementary signature'); ?>：" + $(this).data("date") + "？<br><?php echo __('Additional signature will consume'); ?>" + <?php echo htmlentities($fillupscore); ?> + "<?php echo __('integral'); ?>", function () { var index = layer.msg('<i><?php echo __('Re signing, please wait'); ?></i>', {
        icon: 16,
        time: false,
        shade: 0.3,
        anim: 1
    });
            CMS.api.ajax({
                url: "/signature",
                data: {date: $(that).data("date")}
            }, function (data, ret) {
                if (ret.code == 1) {
                    setTimeout(function () {
                        location.reload();
                    }, 1500)
                }
            });
        })

    })
    // 签到积分规则
    $(document).on("click", ".btn-rule", function () {
        layer.open({
            title: '<?php echo __('Sign in points rule'); ?>',
            area: ['30%', '60%'],
            id: 'layui-id' ,//设定一个id，防止重复弹出,
            content: '`' +
                '<table class="table table-striped" style="margin-bottom:0;">\n' +
                '        <thead>\n' +
                '        <tr>\n' +
                '            <th><?php echo __('Continuous check in days'); ?></th>\n' +
                '            <th><?php echo __('Get points'); ?></th>\n' +
                '        </tr>\n' +
                '        </thead>\n' +
                '        <tbody>\n' +
                '        <?php if(is_array($signinscore) || $signinscore instanceof \think\Collection || $signinscore instanceof \think\Paginator): $i = 0; $__LIST__ = $signinscore;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>\n' +
                '        <tr>\n' +
                '            <th scope="row">第<?php echo htmlentities(str_replace('s','',$key)); ?>天</th>\n' +
                '            <td>+<?php echo htmlentities($item); ?></td>\n' +
                '        </tr>\n' +
                '        <?php endforeach; endif; else: echo "" ;endif; ?>\n' +
                '        </tbody>\n' +
                '    </table>`',
            btn: []
        });
        return false;
    });

    // 排行
    $(document).on("click", ".btn-rank", function () {
        layer.open({
            title: '<?php echo __('Ranking List'); ?>',
            area: ['30%', '60%'],
            id: 'layui-ids' ,//设定一个id，防止重复弹出,
            content: '`' +
                '  <div style="padding:20px;min-height:300px;">\n' +
                '        <table class="table table-striped table-hover signin-rank-table">\n' +
                '            <thead>\n' +
                '            <tr>\n' +
                '                <th><?php echo __('head portrait'); ?></th>\n' +
                '                <th width="50%"><?php echo __('Nickname?'); ?></th>\n' +
                '                <th class="text-center"><?php echo __('Continuous attendance'); ?></th>\n' +
                '            </tr>\n' +
                '            </thead>\n' +
                '            <tbody>\n' +
                '            <?php foreach($rank as $vo): ?>\n' +
                '            <tr>\n' +
                '                <td><a href="#"><img src="<?php echo htmlentities($vo['avatar']); ?>" height="30" width="30" alt="" class="img-circle"/></a></td>\n' +
                '                <td><a href="#"><?php echo htmlentities($vo['username']); ?></a></td>\n' +
                '                <td class="text-center"> <?php echo htmlentities($vo['days']); ?>天</td>\n' +
                '            </tr>\n' +
                '            <?php endforeach; ?>\n' +
                '            </tbody>\n' +
                '        </table>\n' +
                '    </div>`',
            btn: []
        });
        return false;
    });


</script>
</body>
</html>