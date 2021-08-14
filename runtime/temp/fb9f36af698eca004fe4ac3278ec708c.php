<?php /*a:4:{s:57:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\index\login.html";i:1614254586;s:57:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\head.html";i:1614254586;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\header.html";i:1614885714;s:59:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\index\common\script.html";i:1615793640;}*/ ?>
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

<link href="/static/behand/css/user.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/static/login.css">
   <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <script src="/static/layui/layui.js" charset="utf-8"></script>
   


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

              
<div class="login-wrapper">
    <form id="login_form" class="layui-form" action="<?php echo url('user/auth'); ?>" method="post">
        <h2><?php echo __('User login'); ?><a href="/user/register">&emsp;&emsp;&emsp;<i class="layui-btn layui-btn-fluid" style="width:120px;"><?php echo __('User registration'); ?></i></a></h2>
        <div class="layui-form-item layui-input-icon-group">
            <i class="layui-icon layui-icon-username"></i>
            <input class="layui-input" name="username" id="username" placeholder="<?php echo __('Please input user name / email / mobile number'); ?>" autocomplete="off"
                   lay-verType="tips" lay-verify="required" required/>
        </div>
        <div class="layui-form-item layui-input-icon-group">
            <i class="layui-icon layui-icon-password"></i>
            <input class="layui-input" name="password" id="password" placeholder="<?php echo __('Please enter the login password'); ?>" type="password"
                   lay-verType="tips" lay-verify="required" required/>
        </div>
        <?php if(seo('useryzm')=='1'): ?>
                <div class="layui-form-item layui-input-icon-group login-captcha-group">
            <i class="layui-icon layui-icon-auz"></i>
            <input class="layui-input" name="captcha" id="captcha" placeholder="<?php echo __('Please enter the verification code'); ?>" autocomplete="off"
                   lay-verType="tips" lay-verify="required" required/>
            <img src="<?php echo captcha_src(); ?>" onclick="this.src='<?php echo captcha_src(); ?>?rand='+Math.random()" class="login-captcha" />
        </div>
       <?php endif; ?>
            <div class="layui-form-item">
      <?php if(seo('authentication')=='1'): ?>
             <input type="radio" name="authentication" id="authentication" value="1" title="<?php echo __('Authentication enabled'); ?>" lay-skin="primary" checked>
             
       <?php else: ?>
             
             <input type="checkbox" name="keeplogin" id="keeplogin" value="1" title="<?php echo __('Trust current device, no need to verify within 7 days'); ?>" lay-skin="primary" checked readonly="readonly"/>
            
       <?php endif; ?>
            <a href="/user/ems" id="login" class="layui-link pull-right"><?php echo __('Forget the password'); ?></a>
        </div>
        <div class="layui-form-item">
            <input type="submit" class="layui-btn-fluid" id='btn' lay-filter="save" lay-submit disabled="disabled" value="<?php echo __('Sign in now'); ?>">
        </div>
        <div class="layui-form-item login-oauth-group text-center">
             <a href="/qqlogin"><i class="layui-icon layui-icon-login-qq" style="color:#3492ed;"></i></a>&emsp;
        </div>
    </form>
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

   $("input").on("input",function(){
             var getUsername = $("#username").val();
             var getPassword = $("#password").val();
             var getCaptcha = $("#captcha").val();
 
             $(this).css("color","#232323");
 
             if(getUsername !== '' && getPassword !== '' && getCaptcha !== ''){
             $('#btn').attr('disabled', false).css('background','#009688').css('border','none').css('color','#fff');
               }else{ 
             $('#btn').attr('disabled', true).css('background-color','rgba(0,0,0,0.2)').css('border','1px solid #fff').css('color','#232323');
    
           }
       });
     
    </script>
<script>
      layui.use(['layer', 'form', 'jquery'], function(){
        var layer = layui.layer,
            form  = layui.form,
            $     = layui.jquery;
        //表单提交
         form.on('submit(save)', function (data) {
    var index = layer.msg('<i><?php echo __('Login, please wait'); ?></i>', {
        icon: 16,
        time: false,
        shade: 0.3,
        anim: 1
    });

    $.ajax({
        url: data.form.action,
        type: data.form.method,
        dataType: 'json',
        data: $(data.form).serialize(),
        success: function (result) {
            if (result.code === 0) {
                setTimeout(function () {
                        location.href = result.url;
                    //parent.location.reload();
                }, 1000);
           
            layer.close(index);
            layer.msg(result.msg, {icon: 1});
            }else{
                
            layer.close(index);
            layer.msg(result.msg, {icon: 2});
            }
        },
    });
    return false;
});
});
</script>
</html>