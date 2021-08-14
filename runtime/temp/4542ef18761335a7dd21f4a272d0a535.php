<?php /*a:6:{s:63:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\column\column_one.html";i:1628377798;s:57:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\head.html";i:1614254586;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\header.html";i:1614885714;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\banner.html";i:1614254586;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\footer.html";i:1614885790;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\script.html";i:1615793640;}*/ ?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class=""> <!--<![endif]-->
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
<body class="group-page">

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

<div class="container" id="content-container">

    <div class="row">

        <main class="col-xs-12">

            <div class="panel panel-default article-content">


                <div class="panel-body">
                    <!--banner-->
                  <div class="row">
    <div class="col-xs-12">
        <div id="product-focus" class="carousel slide carousel-focus" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php foreach($banner as $vo): ?>
                <li data-target="#product-focus" data-slide-to="<?php echo htmlentities($vo['id']); ?>" class="<?php if($vo['id']==1): ?> active <?php endif; ?>"></li>
                <?php endforeach; ?>
            </ol>
            <div class="carousel-inner" role="listbox">
                <?php foreach($banner as $vo): ?>
                <div class="item <?php if($vo['id']==1): ?> active <?php endif; ?>">
                    <a href="<?php echo htmlentities($vo['url']); ?>">
                        <div class="carousel-img"
                             style="background-image:url(<?php echo htmlentities($vo['image']); ?>);"></div>
                        <div class="carousel-caption hidden-xs">
                            <h3><?php echo htmlentities($vo['desc']); ?></h3>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <a class="left carousel-control" href="#product-focus" role="button" data-slide="prev">
                <span class="icon-prev fa fa-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#product-focus" role="button" data-slide="next">
                <span class="icon-next fa fa-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

</div>
                    <!--banner-->
                    <!--column-->
                    <div class="special-headline">
                        <blockquote>
                            <h3>文章阅读__
                            
       <?php echo base64_decode($_GET['ZcT']?:'') == 1 ? '笑话故事' : (base64_decode($_GET['ZcT']?:'') == 2 ? '人生折理' : (base64_decode($_GET['ZcT']?:'') == 3 ? '励志文章' :  (base64_decode($_GET['ZcT']?:'') == 4 ? '经典语句' :   (base64_decode($_GET['ZcT']?:'') == 5 ? '心情随笔' : (base64_decode($_GET['ZcT']?:'') == 6 ? '散文精选' :   (base64_decode($_GET['ZcT']?:'') == 7 ? '杂文小记' : (base64_decode($_GET['ZcT']?:'') == 9 ? '爱情文章' : (base64_decode($_GET['ZcT']?:'') == 15 ? '经典文章' : (base64_decode($_GET['ZcT']?:'') == 11 ? '校园文章' : (base64_decode($_GET['ZcT']?:'') == 10 ? '亲情文章' : (base64_decode($_GET['ZcT']?:'') == 12 ? '友情文章' : (base64_decode($_GET['ZcT']?:'') == 14 ? '英语文章' : '经典游戏'))))))))))));?>
       </h3>
                        </blockquote>
                    </div>
                    <!--column-->
                    <div class="special-body">
                        <div class="article-list">

                            <!-- S 专题文章列表 -->
                          
                            <?php foreach($article as $vo): ?>
                            <article class="article-item">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="/detail?Art=<?php echo base64_encode($vo['id']);?>&ZcT=<?php echo htmlentities($_GET['ZcT']); ?>">
                                            <div class="embed-responsive embed-responsive-4by3 img-zoom">
                                                <img src="<?php echo htmlentities($vo['image']); ?>" style="border-radius:10px;padding:none;">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h3 class="article-title">
                                            <a href="/detail?Art=<?php echo base64_encode($vo['id']);?>&ZcT=<?php echo htmlentities($_GET['ZcT']); ?>"><?php echo html_entity_decode($vo['title']); ?></a>
                                        </h3>
                                        <div class="article-intro hidden-xs">
                                            <?php echo html_entity_decode($vo['content']); ?>
                                        </div>
                                        <div class="article-tag">
                                            <a href="#" class="tag tag-primary"><?php echo htmlentities($vo['flag']); ?></a><?php echo $vo['weigh']==1 ? '<span style="color :  #fff;background-color: #ff0000;border-radius:5px;font-size: 10px;padding: 4px 6px;">置顶</span>' : ''; ?>
                                            <span itemprop="date"><?php echo htmlentities(time_trans($vo['createtime'])); ?></span>
                                            <span itemprop="likes" title="点赞次数"><i
                                                    class="fa fa-thumbs-up"></i> <?php echo htmlentities($vo['click']); ?> 点赞</span>
                                            <span itemprop="comments"><a href="#" target="_blank"
                                                                         title="评论数"><i
                                                    class="fa fa-comments"></i><?php echo !empty($vo['count']) ? htmlentities($vo['count']) : 0; ?></a> 评论</span>
                                            <span itemprop="views" title="浏览次数"><i class="fa fa-eye"></i> <?php echo htmlentities($vo['view']); ?> 浏览</span>
                                        </div>
                                    </div>
                                </div>

                            </article> 
                            <?php endforeach; ?>
                            <!-- S 专题文章列表 -->

                            <!-- E 专题文章列表 -->

                            <div class="text-center">
                                <!--分页-->
                                <?php echo $article; ?>

<!--
                                <a href="/column?page=2" data-page="1" class="btn btn-default my-4 px-4 btn-loadmore">加载更多</a>
-->
                            </div>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

        </main>
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

</body>
</html>