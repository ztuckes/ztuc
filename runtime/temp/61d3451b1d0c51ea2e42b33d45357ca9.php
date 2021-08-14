<?php /*a:2:{s:55:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\admin\user\list.html";i:1614416928;s:44:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\base.html";i:1627903400;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>OA后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/hqui/libs/layui/css/layui.css"/>
    <link rel="stylesheet" href="/static/hqui/module/admin.css"/>
    <link rel="stylesheet" href="/static/css/fonts.css">
    <link rel="stylesheet" href="/static/css/base.css">
    <!-- 风格 -->
    <link rel="stylesheet" href="/static/hqui/css/theme.css"/>
    
</head>
<body>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
             
<div class="layui-card">
        <div class="layui-form toolbar">
            <div class="layui-form-item">
                <form action="<?php echo request()->url(); ?>" class="layui-form" method="get">
            
                <div class="layui-inline">
                    <label class="layui-form-label w-auto">状态：</label>
                    <div class="layui-input-inline mr0">
                    
                        </select> <input type="text" id="subscribe" name="subscribe" placeholder="输入字段数据" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-inline">
                    <label class="layui-form-label w-auto">黑名单：</label>
                    <div class="layui-input-inline mr0">
                        <select name="status">
                            <option value="">请选择</option>
                            <option value="0" <?php if(isset($data) and input('status') == '0'): ?>selected="selected"<?php endif; ?>>已锁定</option>
                            <option value="1" <?php if(isset($data) and input('status') == '1'): ?>selected="selected"<?php endif; ?>>未锁定</option>
                        </select>
                    </div>
                </div>

                <div class="layui-inline" style="padding-left: 20px;">
                    <button class="layui-btn layui-btn-primary ajax-search"><i class="fa fa-search"></i> 搜索</button>
                </div>
                </form>
            </div>
        </div>
    
    <table id="tableList" lay-filter="tableList"></table>

<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm" lay-event="delete"><?php echo __('Multiple choice deletion'); ?></button>
        <button class="layui-btn layui-btn-sm" lay-event="refresh"><?php echo __('Refresh'); ?></button>
    </div>
</script>

    <!-- 表格操作列 -->
    <script type="text/html" id="tableTBTrack">
        <a href="<?php echo url('user/edit'); ?>?id={{d.id}}" class="layui-btn layui-btn-sm ajax-iframe" data-width="410px" data-height="310px"><?php echo __('modify'); ?></a>
        <a href="<?php echo url('user/del'); ?>?id={{d.id}}" class="layui-btn layui-btn-danger layui-btn-sm ajax-delete"><?php echo __('delete'); ?></a>
    </script>
 
<script type="text/html" id="group_id">
            <input type="checkbox" name="group_id" lay-text="管理员|未分配" lay-skin="switch" lay-filter="*"  data-url="<?php echo url('user/edit'); ?>?id={{d.id}}" {{d.group_id==1?'checked':(d.group_id==2?'checked':(d.group_id==3?'checked':(d.group_id==4?'checked':'')))}}>
    </script>
<script type="text/html" id="status">
        <input type="checkbox" name="status" lay-skin="switch" lay-filter="*" lay-text="<?php echo __('normal'); ?>|<?php echo __('locking'); ?>" data-url="<?php echo url('user/edit'); ?>?id={{d.id}}" {{d.status==1?'checked':''}}>
    </script>
    
    <script type="text/html" id="img">

    <div><img src="{{ d.image }}" class="layui-upload-img layui-circle" style="width: 30px; height: 30px;"></div>
</script>

</div>

        </div>
    </div>
<!-- Pace.js – 超赞的页面加载进度自动指示和 Ajax 导航效果 -->
<!--link href="/static/pace/pace.css" rel="stylesheet">
<script type="text/javascript" src="/static/pace/pace.js"></script-->

    <script type="text/javascript" src="/static/hqui/libs/layui/layui.all.js"></script>
    <script type="text/javascript" src="/static/hqui/js/common.js"></script>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/hq.base.js"></script>
    
<script>
    layui.use(['layer', 'form', 'table', 'util', 'dropdown'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        var util = layui.util;
        var admin = layui.admin;
        var dropdown = layui.dropdown;
        // 渲染回访表格
        table.render({
            elem: '#tableList',
            toolbar: '#toolbarDemo',  //开启头部工具栏，并为其绑定左侧模板
            url: "<?php echo url('user/index_json',['status'=>input('status'),'subscribe'=>input('subscribe')]); ?>",
            page: true,
            cellMinWidth: 100,
            limit:'15',
            limits:['15','30','50','100','200','500'],
            size:'lg',even:true,
            cols: [[
               {type: 'checkbox', fixed: 'left'},
               {field: 'id', title: 'ID', width: 70, align: 'center', fixed: 'left'}
                , {field: 'image', title: '会员头像', width: 80, align: 'center', templet:'#img'}
                , {field: 'group_id', title: '是否管理员', align: 'center', width: 100, templet: '#group_id'}
                , {field: 'username', title: '用户名', align: 'center', width: 100, style:'background-color: #eee; color: #000;'}
                , {field: 'openid', title: '绑定QQ', align: 'center', width: 100, templet: function(d){
        return d.openid !== ''  ? '<span style="color: #fff;background-color: #009688;border-radius:50px;font-size: 10px;padding: 4px 8px;">已绑定</span>' : '<span style="color: #fff;background-color: #FF5722;border-radius:50px;font-size: 10px;padding: 4px 8px;">未绑定</span>';
                    }}               
                , {field: 'qq', title: 'QQ', align: 'center', width: 110, style:'background-color: #eee; color: #000;'}
                , {field: 'mobile', title: '手机号', align: 'center', width: 120}
                , {field: 'email', title: '邮箱', align: 'center', width: 120}
                , {field: 'line_time', title: '在线时间', align: 'center', width:  160, templet:function(d){
                   return d.line_time ?formatSeconds(d.line_time): '0秒'; 
                   }}
                , {field: 'logintime', title: '最后登录时间', align: 'center', width:  160, templet:"<div>{{layui.util.toDateString(d.logintime*1000, 'yyyy-MM-dd HH:mm:ss')}}</div>"
                   }
                , {field: 'createtime', title: '创建时间', align: 'center', width: 160},
               {align: 'center', sort: true, title: '状态',templet:'#status',width:90},
               {align: 'center', toolbar: '#tableTBTrack', title: '操作', minWidth: 140}
            ]],
            parseData: function(res){ //res 即为原始返回的数据
                return {
                  "code": res.code, //解析接口状态
                  "msg": res.msg, //解析提示文本
                  "count": res.data.total, //解析数据长度
                  "data": res.data.data //解析数据列表
                };
            }
        });

    });
  //头工具栏事件
        table.on('toolbar(tableList)', function (obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            switch (obj.event) {
                case 'delete':
             
                    var data = checkStatus.data;
                    var ids = [];
                    data.forEach(item => {
                        ids.push(item.id);
                    });
                    if (ids <= 0) {
                        return layer.msg('<?php echo __('Please select a line'); ?>', {icon: 0});
                    }
                 var index = layer.msg('<?php echo __('Submitting, please wait'); ?>', {
                   icon: 16,
                   time: false,
                   shade: 0.3
                 });
                  $.post('/Tourist/del', {id: ids}, function (res) {
                        if (res.code == 0) {
                            layer.msg(res.msg, {icon: 1});
                            setTimeout(function () {
                                location.reload();  // 页面刷新
                            }, 1500)
                        } else {
                            layer.msg(res.msg, {icon: 0});
                        }
                    }, 'json');
                    break;
                case 'refresh':
                    location.reload();
                    break;
            }
        });

// 在线时间
function formatSeconds(value) { 
 var theTime = parseInt(value);// 需要转换的时间秒 
 var theTime1 = 0;// 分 
 var theTime2 = 0;// 小时 
 var theTime3 = 0;// 天
 if(theTime > 60) { 
  theTime1 = parseInt(theTime/60); 
  theTime = parseInt(theTime%60); 
  if(theTime1 > 60) { 
   theTime2 = parseInt(theTime1/60); 
   theTime1 = parseInt(theTime1%60); 
   if(theTime2 > 24){
    //大于24小时
    theTime3 = parseInt(theTime2/24);
    theTime2 = parseInt(theTime2%24);
   }
  } 
 } 
 var result = '';
 if(theTime > 0){
  result = ""+parseInt(theTime)+"秒";
 }
 if(theTime1 > 0) { 
  result = ""+parseInt(theTime1)+"分"+result; 
 } 
 if(theTime2 > 0) { 
  result = ""+parseInt(theTime2)+"小时"+result; 
 } 
 if(theTime3 > 0) { 
  result = ""+parseInt(theTime3)+"天"+result; 
 }
 return result; 
} 
</script>

</body>
</html>