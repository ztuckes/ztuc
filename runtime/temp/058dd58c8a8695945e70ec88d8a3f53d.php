<?php /*a:5:{s:58:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\index\detail.html";i:1628346332;s:57:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\head.html";i:1614254586;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\header.html";i:1614885714;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\footer.html";i:1614885790;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\script.html";i:1615793640;}*/ ?>
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


<style>
    .swiper-container {
        width: 100%;
        height: 300px;
        margin-left: auto;
        margin-right: auto;
    }

    .swiper-slide {
        background-size: cover;
        background-position: center;
    }

    .gallery-top {
        height: 80%;
        width: 100%;
    }

    .gallery-thumbs {
        height: 20%;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .gallery-thumbs .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
    }

    .gallery-thumbs .swiper-slide-thumb-active {
        opacity: 1;
    }

    .article-image {
        height: 820px;
    }

    @media (max-width: 767px) {

        .article-image {
            height: 400px;
        }
    }

</style>
<div class="container" id="content-container">

    <div class="row">

        <main class="col-xs-12">
  <!--判断是否有子级或高亮当前栏目-->
            
      
            <div class="panel panel-default article-content">
                <div class="panel-heading">
                    <ol class="breadcrumb">
                        <!-- S 面包屑导航 -->
                       <?php if(is_numeric($_GET['ZcT'])){
           
           // 加密
        $_GET['ZcT'] = base64_encode($_GET['ZcT']);
         }else{
          
          $_GET['ZcT'] = $_GET['ZcT'];
      
      }
      ?>
                        <li><a href="/"><?php echo __('home page'); ?></a></li>
                        <li> <a href="/column?ZcT=<?php echo htmlentities($_GET['ZcT']); ?>"><?php echo $article['cat_id']==1 ? '笑话故事'  :  ($article['cat_id'] == 2 ? '人生折理' : ($article['cat_id'] == 3 ? '励志文章' :  ($article['cat_id'] == 4 ? '经典语句' :   ($article['cat_id'] == 5 ? '心情随笔' : ($article['cat_id'] == 6 ? '散文精选' :   ($article['cat_id'] == 7 ? '杂文小记' : ($article['cat_id'] == 9 ? '爱情文章' : ($article['cat_id'] == 15 ? '经典文章' : ($article['cat_id'] == 11 ? '校园文章' : ($article['cat_id'] == 10 ? '亲情文章' : ($article['cat_id'] == 12 ? '友情文章' : ($article['cat_id'] == 14 ? '英语文章' : '经典游戏')))))))))))); ?></a></li>
                        <!-- E 面包屑导航 -->
                    </ol>
                </div>
                <div class="panel-body">
                    <div class="article-metas">
                        <h1 class="metas-title">
                            <?php echo html_entity_decode($article['title']); ?></h1>
                        <!-- S 统计信息 -->
                        <div class="metas-body">
                            <span class="views-num">
                                <i class="fa fa-eye"></i> <?php echo htmlentities($article['view']); ?> <?php echo __('read'); ?>
                            </span>
                            <span class="comment-num">
                                <i class="fa fa-comments"></i> <?php echo htmlentities($count); ?> <?php echo __('comment'); ?>
                            </span>
                            <span class="like-num">
                                <i class="fa fa-thumbs-o-up"></i>
                                <span class="js-like-num"> <?php echo htmlentities($article['click']); ?> <?php echo __('give the thumbs-up'); ?>
                                </span>
                            </span>
                        </div>
                        <!-- E 统计信息 -->
                    </div>
                  <style>
                  .w3cschool{letter-spacing:3px;line-height:18px;}
                   </style>
                    <div class="article-text w3cschool">
                        
                        <!-- S 正文 -->
                    
                       <?php echo html_entity_decode($article['content']); ?>
                      
                        
                        <!-- E 正文 -->
                   
                     </div>
                     <!-- S 付费阅读 -->
                    <!-- E 付费阅读 -->
                        <div class="article-donate">
                    
                       <a href="javascript:" class="btn btn-primary btn-likes btn-lg <?php echo !empty($clickLog) ? 'disabled' : ''; ?> " data-action="vote"
                           data-type="like" data-id="<?php echo htmlentities($article['id']); ?>" data-tag="archives">
                          <i class="fa fa-thumbs-up"></i><?php echo !empty($clickLog) ? __('Yes').'(<span>'.$article['click'].'</span>) <i>还有 <span id="hideD"><strong id="RemainD"></strong></span><span id="hideH"><strong id="RemainH"></strong><b> : </b></span><span id="hideM"><strong id="RemainM"></strong><b> : </b></span><span id="hideS"><strong id="RemainS"></strong></span>秒可点赞</i>' : __('give the thumbs-up').'(<span>'.$article['click'].'</span>)'; ?></a>
                          
                        <!--<a href="javascript:" class="btn btn-outline-primary btn-donate btn-lg" data-action="donate" data-id="36"><i class="fa fa-cny"></i> 打赏</a>-->
                    </div>
                     <ul>
                            <!-- S 归档 -->
                            <!--li>本文标签：
                                <?php
                                $word = explode('，',$article['keyword']);
                                foreach($word as $val){
                                ?>
                                <a href="javascript:" class="tag" rel="tag"><?php echo $val;?></a>
                                <?php } ?>
                            </li-->
                            <li>浏览次数：<span><?php echo htmlentities($article['view']); ?></span> 次浏览</li>
                            <li>发布日期：<?php echo htmlentities(time_trans($article['createtime'])); ?></li>
                            <li>
                                 <?php if($article['id'] == $max): ?>
                                <?php echo __('Last'); ?>:暂无数据<br>
                                <?php if(isset($mins['id'])): ?>
                                <?php echo __('Next'); ?>:<a href="/detail?Art=<?php echo base64_encode($mins['id']?:'');?>&ZcT=<?php echo htmlentities($_GET['ZcT']); ?>"><?php echo htmlentities($mins['title']); ?></a>
                                <?php else: ?>
                                   <?php echo __('Next'); ?>:暂无数据<br>
                                <?php endif; elseif($article['id']== $min): ?>

                                <?php echo __('Last'); ?>:<a href="/detail?Art=<?php echo base64_encode($maxs['id']?:'');?>&ZcT=<?php echo htmlentities($_GET['ZcT']); ?>"><?php echo htmlentities($maxs['title']); ?></a> 
                                <?php echo __('Next'); ?>:暂无数据<br>
                                <?php else: ?>
                                <?php echo __('Last'); ?>:<a href="/detail?Art=<?php echo base64_encode($maxs['id']?:'');?>&ZcT=<?php echo htmlentities($_GET['ZcT']); ?>"><?php echo htmlentities($maxs['title']); ?></a><br>
                                 <?php echo __('Next'); ?>:<a href="/detail?Art=<?php echo base64_encode($mins['id']?:'');?>&ZcT=<?php echo htmlentities($_GET['ZcT']); ?>"><?php echo htmlentities($mins['title']); ?></a>
                                <?php endif; ?>
                                 </li>
                            </li>
                            <!-- S 归档 -->
                        </ul>

                    </div>

                    <div class="article-action-btn">
                        <div class="pull-left">
                            <!-- S 收藏 -->
                            <a class="product-favorite addbookbark mr-2" href="javascript:;">
                                <i class="fa fa-heart"></i> 收藏 </a>
                            <!-- E 收藏 -->
                            <!-- S 分享 -->
                            <span class="bdsharebuttonbox share-box bdshare-button-style0-16">
                            <a class="bds_more share-box-a" data-cmd="more">
                                <i class="fa fa-share"></i> 分享                            </a>
                        </span>
                            <!-- E 分享 -->
                        </div>
                        <div class="pull-right">
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <!--<div class="related-article">
                        <div class="row">
                            &lt;!&ndash; S 相关文章 &ndash;&gt;

                            &lt;!&ndash; E 相关文章 &ndash;&gt;
                        </div>
                    </div>-->

                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="panel panel-default" id="comments">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo __('Comment list'); ?>
                        <small><?php echo str_replace('%a', '<b style="color: #ff0000;">' . $count . '</b>', __('Total chat comments')); ?></small>
                    </h3>
                </div>
                <div class="panel-body">
                    <div id="comment-container">
                        <!-- S 评论列表 -->
                        <div id="commentlist">
                           <?php foreach($comment as $vo): ?>
                            <dl>
                                <dt><a href="#" target="_blank"><img src='<?php echo htmlentities($vo['avatar']); ?>'/></a></dt>
                                <dd>
                                    <div class="parent">
                                        <cite><a href="/user/index"><?php echo !empty($vo['username']) ? htmlentities($vo['username']) : '游客'; ?></a></cite>
                                        <?php echo htmlentities(time_trans($vo['createtime'])); if(isset($user['id'])): if($vo['user_id'] == $user['id']): else: ?>
                                       <small> <a href="javascript:;" uid="<?php echo htmlentities($vo['user_id']); ?>" pid="<?php echo htmlentities($vo['id']); ?>" title="你好！<?php echo htmlentities($vo['username']); ?>！" class="reply">回复TA</a></small>
                                       <?php endif; else: ?>
                                       <small> <a href="javascript:;" pid="<?php echo htmlentities($vo['id']); ?>" title="登录后再发表评论" class="reply">回复TA</a></small>
                                <?php endif; ?>
                                          
                                        <p><i style="color:#ff0000;">主题：</i><?php echo html_entity_decode($vo['content']); ?></p>
                                       </div> 
                        <hr class="layui-bg-green">
                                        <?php if((!empty($reply))): foreach($reply as $key => $val): if(($vo['id'] == $val['pid'])): ?>
                                    <div class="parent"> 
                                    <p>&emsp;&emsp;<a href="/user/index"><?php echo htmlentities($val['username']); ?></a>: <?php echo html_entity_decode($val['content']); ?>&emsp;<?php echo htmlentities(time_trans($val['createtime'])); if(isset($user['id'])): if($user['id'] == $val['user_id']): else: ?>
                                     <small> <a href="javascript:;" uid="<?php echo htmlentities($val['user_id']); ?>" pid="<?php echo htmlentities($vo['id']); ?>" title="你好！<?php echo htmlentities($val['username']); ?>！" class="reply">回复TA</a></small>
                                     <?php endif; else: ?>
                                     <small> <a href="javascript:;" pid="<?php echo htmlentities($vo['id']); ?>" title="登录后再发表评论" class="reply">回复TA</a></small>
                                     <?php endif; ?> 
                                     </p>
                                    </div> 
                  
                                        <?php endif; ?>
                                     <?php endforeach; ?>
                                        <?php endif; ?>
                                </dd>
                                <div class="clearfix"></div>
                            </dl>
                            <?php endforeach; ?>
                        </div>

                       
                        <!-- E 评论列表 -->

                        <!-- S 评论分页 -->
                        <div id="commentpager" class="text-center">
                            <?php echo $comment; ?>
                        </div>
                        <!-- E 评论分页 -->

                        <!-- S 发表评论 -->
                        <div id="postcomment">
                            <h3>发表评论 <a href="javascript:;">
                                <small>取消回复</small>
                            </a></h3>
                            <form action="" method="post" id="postform" <?php if($user): ?> onclick="return false"<?php endif; ?> />
                                <input type="hidden" name="article_id" id="article_id" value="<?php echo htmlentities($article['id']); ?>"/>

                                <input type="hidden" name="pid" id="pid" value=""/>
                                <input type="hidden" name="pid_id" id="pid_id" value=""/>
                                <input type="hidden" name="uid" id="uid" value=""/>
                                <div class="form-group">
                                    <textarea name="content" maxlength="199" id="commentcontent" cols="6" rows="5" class="form-control" <?php if(!$user): ?> placeholder='登录后再发表评论' disabled <?php else: ?> placeholder='发表评论' <?php endif; ?>></textarea>
                                </div>
                                <?php if($user): ?>
                                <div class="form-group">
                                    <button href="javascript:;" class="btn btn-primary" id="btn-notice" disabled="disabled"><?php echo __('determine'); ?></button>
                                    <button type="reset" class="btn btn-outline-primary" onclick="ClearTextArea()"><?php echo __('Refill'); ?></button>
                                </div>
                                <?php else: ?>
                                <div class="form-group">
                                    <a href="/user/login" class="btn btn-primary"><?php echo __('Sign in now'); ?></a>
                                    <a href="/user/register" class="btn btn-outline-primary"><?php echo __('Register now'); ?></a>
                                </div>
                                <?php endif; ?>
                            </form>
                        </div>
                        <!-- E 发表评论 -->
                    </div>
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

  <script>

   $("textarea").on("input",function(){
             var getContent = $("#commentcontent").val();
 
             $(this).css("color","#232323");
 
             if(getContent != ''){
               $('#btn-notice').attr('disabled', false).css('background','#009688').css('border','none').css('color','#fff');
               }else{ 
             $('#btn-notice').attr('disabled', true).css('background','rgba(0,0,0,0.2)').css('border','1px solid #fff').css('color','#232323');
    
           }
       });
     
    </script>
<script>
    //重置
    function ClearTextArea()
       {
        document.getElementById("commentcontent").value="";
       }
    // 点赞
    $(document).on("click", ".btn-likes", function () {
                
       var index = layer.msg('<i><?php echo __('Submitting, please wait'); ?></i>', {
        icon: 16,
        time: false,
        shade: 0.3,
        anim: 4
    });
        var that = this;
        CMS.api.ajax({
            url: "/click",
            data: {id: $(that).data("id")}
        }, function (data, ret) {
         if (ret.code==1){
                setTimeout(function () {
                    location.reload();
                },1500)
            }
        });
    });
    // 评论
    $(document).on("click", "#btn-notice", function () {
               
       var index = layer.msg('<i><?php echo __('Submitting, please wait'); ?></i>', {
        icon: 16,
        time: false,
        shade: 0.3,
        anim: 1
    });
        var article_id = document.getElementById("article_id").value;
        var content = document.getElementById("commentcontent").value;
        var pid = document.getElementById("pid").value;
        var uid = document.getElementById("uid").value;
        var pid_id = document.getElementById("pid_id").value;
        CMS.api.ajax({
            url: "/notices",
          dataType: "json",
            data: {article_id:article_id,content:content,pid:pid,uid:uid,pid_id:pid_id}
        }, function (data, ret) {
            if (ret.code==1){
                setTimeout(function () {
       
                     if(isNaN(parseInt($("#btn-notice").html()))){  
                    
                        var origText  = 5;
                        var interval = setInterval(function(){
                            var time = --origText;
                            if(time <= 0) {
                                clearInterval(interval);
                               location.reload();
                            }else{
                                $('#btn-notice').html(time+'<?php echo __('second'); ?>').css('border','none').css('color','#616161').css('background','buttonface').attr("disabled","true");
                            
                        }
                        }, 1000);
                         }

                    //location.reload();
                },1500)
            }
        });
    });

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
            document.getElementById("RemainD").innerHTML=nD;
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
                            //alert("倒计时完毕");
                    location.reload();
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
</body>
</html>