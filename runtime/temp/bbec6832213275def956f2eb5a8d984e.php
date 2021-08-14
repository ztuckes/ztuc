<?php /*a:3:{s:57:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\admin\admin\index.html";i:1614254586;s:58:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\common\header-menu.html";i:1621503076;s:51:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\common\menu.html";i:1615870910;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>后台管理 - OA后台管理</title>
    <link rel="stylesheet" href="/static/hqui/libs/layui/css/layui.css"/>
    <link rel="stylesheet" href="/static/hqui/module/admin.css?v=317"/>
    <!-- 风格 -->
    <link rel="stylesheet" href="/static/hqui/css/theme.css"/>

      
</head>
<body class="layui-layout-body" id="btn">
<div class="layui-layout layui-layout-admin">
    <!-- 头部 -->
    <div class="layui-header">
        <div class="layui-logo">
            <?php $arr=array(10,20); $rand=array_rand($arr);?>
       <cite>
         <?php if($rand == 0): ?>
            <span><img src="<?php echo seo('logo'); ?>" width="120" height="60"></span>
         <?php else: ?>
            <span><img src="<?php echo seo('image'); ?>" width="120" height="60"></span>
          <?php endif; ?>   
       </cite>
        </div>
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item" lay-unselect>
                <a ew-event="flexible" title="侧边伸缩"><i class="layui-icon layui-icon-shrink-right"></i></a>
            </li>
            <li class="layui-nav-item" lay-unselect>
                <a ew-event="refresh" title="刷新"><i class="layui-icon layui-icon-refresh-3"></i></a>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item" lay-unselect>
                <a href="/" target="_blank" title="网站首页"><?php  echo \think\facade\App::version(); ?> <i class="layui-icon layui-icon-home"></i> 网站首页</a>
            </li>
            <li class="layui-nav-item layui-hide-xs" lay-unselect>
                <a ew-event="fullScreen" title="全屏"><i class="layui-icon layui-icon-screen-full"></i> 全屏显示</a>
            </li>
            <li class="layui-nav-item" lay-unselect style="margin-right: 25px;">
                <a>
                    <i class="layui-icon layui-icon-user"></i>
                    <cite><?php echo htmlentities($admin['username']); ?></cite>
                </a>
                <dl class="layui-nav-child">
                    <dd lay-unselect>
                        <a ew-href="<?php echo url('admin/editPassword'); ?>?id=<?php echo htmlentities($admin['id']); ?>">修改密码</a>
                    </dd>
                    <dd lay-unselect>
                        <a ew-href="<?php echo url('admin/clear'); ?>">清除缓存</a>
                    </dd>
                    <hr>
                    <dd lay-unselect>
                        <a ew-event="logout" data-url="<?php echo url('admin/logout'); ?>">退出</a>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item" lay-unselect>
                <i class="layui-icon layui-icon-more-vertical"></i>
            </li>

        </ul>
    </div>

    <!-- 侧边栏 -->
    
<div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          
            <ul class="layui-nav layui-nav-tree arrow2" lay-shrink="all" lay-filter="admin-side-nav" lay-accordion="true"> 
            <li class="layui-nav-item">
                    <a lay-href="/admin/home"><i class="layui-icon layui-icon-home"></i>&emsp;<cite>控制台</cite></a>
                </li>
               <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li class="layui-nav-item">
                    <a <?php if(isset($vo['children'])): ?>href="javascript:;"<?php else: ?>lay-href="<?php echo url($vo['url']); ?>"<?php endif; ?>><i class="layui-icon <?php echo htmlentities($vo['icon']); ?>"></i>&emsp;<cite><?php echo htmlentities($vo['name']); ?></cite></a>
                    <?php if(isset($vo['children'])): ?>
                    <dl class="layui-nav-child">
                       <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <dd>
                            <a lay-href="<?php echo url($v['url']); ?>"><?php echo htmlentities($v['name']); ?></a>
                            
                           
                        </dd>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                    <?php endif; ?>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>

<!-- Pace style -->
<link href="/static/pace/pace.min.css" rel="stylesheet">
<script type="text/javascript" src="/static/pace/pace.min.js"></script>
<!-- //重新加载动画 -->
<script>
// 获得【重新加载】按钮
var btn=document.getElementById('btn');
// 点击按钮，重新加载页面，进度条也会重新加载
btn.onclick=function(){
    Pace.restart();
}
</script>  
    <div class="layui-body"></div>
    <!-- 底部 -->
    <div class="layui-footer">
       <a href="http://ztuc.cn" target="_blank"><?php echo seo('copyright'); ?></a>
        <span class="pull-right">客服热线:15284956838</span>
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
            menuPath: '/admin/home',
            menuName: '<i class="layui-icon layui-icon-home"> </i>'
        });
        $('.layui-body>.layui-tab[lay-filter="admin-pagetabs"]').attr('lay-autoRefresh', 'true');
    });
    
</script>

</body>
</html>