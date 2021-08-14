<?php /*a:1:{s:57:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\admin\admin\login.html";i:1614254586;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理员登录</title>
    <link rel="stylesheet" type="text/css" href="/static/login.css">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <script src="/static/layui/jquery.js" charset="utf-8"></script>
    <script src="/static/jquery.min.js" charset="utf-8"></script>

</head>

<body>


<div class="login-wrapper" id="app">
    <form class="layui-form" action="<?php echo url('admin/check'); ?>" method="post"> 
    <div class="logo" style="text-align: center;">
      <?php $arr=array(10,20); $rand=array_rand($arr);if($rand == 0): ?>
            <img src="<?php echo seo('image'); ?>" width="80%" height="60">
         <?php else: ?>
            <img src="<?php echo seo('logo'); ?>" width="80%" height="60">
          <?php endif; ?>   
        <h4><?php echo __('Administrator login'); ?></h4>

        <div class="logo" style="margin-bottom: 8px;"></div>
         </div>
        
        <div class="layui-form-item layui-input-icon-group">
            <i class="layui-icon layui-icon-username"></i>
            <input class="layui-input" name="username" id='username' placeholder="<?php echo __('Please input user name / email / mobile number'); ?>" autocomplete="off"
                   lay-verType="tips" lay-verify="required" required/>
        </div>
        <div class="layui-form-item layui-input-icon-group">
            <i class="layui-icon layui-icon-password"></i>
            <input class="layui-input" name="password" id='password' placeholder="<?php echo __('Please enter the login password'); ?>" type="password"
                   lay-verType="tips" lay-verify="required" required/>
        </div>
        <?php if(seo('adminyzm')=='1'): ?>
                <div class="layui-form-item layui-input-icon-group login-captcha-group">
            <i class="layui-icon layui-icon-auz"></i>
            <input class="layui-input" name="captcha" id='captcha' placeholder="<?php echo __('Please enter the verification code'); ?>" autocomplete="off"
                   lay-verType="tips" lay-verify="required" required/>
            <img src="<?php echo captcha_src(); ?>" onclick="this.src='<?php echo captcha_src(); ?>?rand='+Math.random()" class="login-captcha" />
        </div>
        <?php endif; ?>
          <div class="layui-form-item">
      <?php if(seo('adminauth')=='1'): ?>
             <input type="radio" name="adminauth" id="adminauth" value="1" title="<?php echo __('Authentication enabled'); ?>" lay-skin="primary" checked>
             
       <?php else: ?>
             
             <input type="checkbox" name="keeplogin" id="keeplogin" value="1" title="<?php echo __('Trust current device, no need to verify within 7 days'); ?>" lay-skin="primary" checked readonly="readonly"/>
            
       <?php endif; ?>
        </div>     
        <div class="layui-form-item">
            <button class="layui-btn-fluid" id='btn' lay-filter="save" lay-submit disabled="disabled"><?php echo __('Sign in now'); ?></button>
        </div>
    </form>
</div> 
</body>
<script src="/static/layui/layui.js" charset="utf-8"></script>
<!--script charset="utf-8" type="text/javascript" src="/static/layui/mobile/jquery.js" ></script>
<script charset="utf-8" type="text/javascript" src="/static/layui/mobile/layer.js" ></script-->

    <script>

   $("input").on("input",function(){
             var getUsername = $("#username").val();
             var getPassword = $("#password").val();
             var getCaptcha = $("#captcha").val();
 
             $(this).css("color","#232323");
 
             if(getUsername != '' && getPassword != '' && getCaptcha != ''){
              $('#btn').attr('disabled', false).css('background','#009688').css('border','none').css('color','#fff');
               }else{ 
             $('#btn').attr('disabled', true).css('background','rgba(0,0,0,0.2)').css('border','1px solid #fff').css('color','#232323'); 
    
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