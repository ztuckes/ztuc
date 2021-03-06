<?php /*a:2:{s:56:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\admin\admin\home.html";i:1628931510;s:44:"D:\phpstudy_pro\WWW\a.ztuc.cn\view\base.html";i:1627903400;}*/ ?>
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
    
<script src="/static/hqui/libs/echarts/echarts.min.js"></script>
<script src="/static/hqui/libs/echarts/echartsTheme.js"></script>
<style>
        /** 统计快捷方式样式 */
        .console-link-block {
            display: block;
            position: relative;
            color: #fff;
            font-size: 18px;
            padding: 25px 20px;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0px 3px 5px rgba(0, 0, 0, .1);
            background-color: rgb(155, 197, 57);
        }

        .console-link-block .console-link-block-num {
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .console-link-block .console-link-block-icon {
            height: 70px;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .console-link-block .console-link-block-band {
            background-color: rgb(227, 42, 22);
            font-size: 14px;
            position: absolute;
            width: 80px;
            padding: 0px 0;
            text-align: center;
            transform: rotate(45deg);
            right: -21px;
            top: 8px;
            color: rgba(255, 255, 255, .9);
            z-index: 1;
        }

        /** //统计快捷方式样式end */

        /** 小屏幕下样式 */
        @media screen and (max-width: 992px) {
            .console-link-block {
                font-size: 14px;
                padding: 15px 10px;
            }

            .console-link-block .console-link-block-num {
                font-size: 28px;
                margin-bottom: 0px;
            }

            .console-link-block .console-link-block-icon {
                height: 45px;
                right: 10px;
            }

            .console-link-block .console-link-block-band {
                font-size: 12px;
                right: -25px;
                top: 8px;
            }

        }

        /** 设置每个快捷块的颜色 */
        #consoleLink > div:first-child .console-link-block {
            background-color: rgb(155, 197, 57);
        }

        #consoleLink > div:nth-child(2) .console-link-block {
            background-color: rgb(85, 165, 234);
        }

        #consoleLink > div:nth-child(3) .console-link-block {
            background-color: rgb(157, 175, 291);
        }

        #consoleLink > div:nth-child(4) .console-link-block {
            background-color: rgb(245, 145, 162);
        }

        #consoleLink > div:nth-child(5) .console-link-block {
            background-color: rgb(254, 170, 79);
        }

        #consoleLink > div:last-child .console-link-block {
            background-color: rgb(64, 212, 176);
        }

        /** //设置每个快捷块的颜色end */
    </style>


</head>
<body>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            
  <?php
   
    if(isMobile()){
    if (time()<=$model['mobilelogintime']+3600*24*7){
        $overtime = floor((3600*24*7) - (time()-$model['mobilelogintime'])); //实际剩下的时间（单位/秒）
      }else{

        $overtime=0;
      }
    
    }else{

    if (time()<=$model['logintime']+3600*24*7){

        $overtime = floor((3600*24*7) - (time()-$model['logintime'])); //实际剩下的时间（单位/秒）
        }else{
        $overtime=0;
      }
    }
?> 
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
<!--网页内容 start-->
<!--网页内容 end-->
<!-- 正文开始 -->
<div class="layui-fluid"> <fieldset class="layui-elem-field layui-field-title">
    <legend><i>当前时间：<span id="myTime"></span></i><i>___PHP版本：<?php  echo PHP_VERSION; ?>___剩余时间： <span id="hideD"><strong id="RemainD"></strong>天</span> <span id="hideH"><strong id="RemainH"></strong>小时</span><span id="hideM"> <strong id="RemainM"></strong>分钟</span> <span id="hideS"><strong id="RemainS"></strong>秒</span></i></legend>
  <hr class="layui-bg-green">
    <!-- 快捷方式 -->
    <div id="consoleLink" class="layui-row layui-col-space15">
        <div class="layui-col-lg4 layui-col-md4 layui-col-sm4 layui-col-xs6">
            <div class="console-link-block" ew-href="<?php echo url('article/list'); ?>" ew-title="浏览记录">
                <div class="console-link-block-num"><?php echo htmlentities($view); ?></div>
                <div class="console-link-block-text">总浏览</div>
                <img class="console-link-block-icon" src="/static/hqui/images/homepic1.png">
            </div>
        </div>
        <div class="layui-col-lg4 layui-col-md4 layui-col-sm4 layui-col-xs6">
            <div class="console-link-block" ew-href="<?php echo url('clicklog/list'); ?>" ew-title="点赞记录">
                <div class="console-link-block-num"><?php echo htmlentities($click); ?></div>
                <div class="console-link-block-text">总点赞</div>
                <img class="console-link-block-icon" src="/static/hqui/images/homepic2.png">
            </div>
        </div>
        <div class="layui-col-lg4 layui-col-md4 layui-col-sm4 layui-col-xs6">
            <div class="console-link-block" ew-href="<?php echo url('backup/database'); ?>" ew-title="数据库备份">
                <img class="console-link-block-icon" src="/static/hqui/images/homepic3.png">
                <div class="console-link-block-num"><?php echo htmlentities($cat); ?></div>
                <div class="console-link-block-text">总发贴</div>
            </div>
        </div>
       
    </div>
   <!-- 统计图表 -->
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md4 layui-col-sm6 layui-col-xs12">
            <div class="layui-card">
                <div class="layui-card-header">日统计</div>
                <div class="layui-card-body">
                    <div style="height: 300px;position: relative;">
                        <div id="tjDivDay" style="height: 100%;"></div>
                        <span id="btnShowDetail"
                              style="color: #1AB4E8;font-size: 18px;position: absolute;bottom: 75px;left: 50%;transform: translateX(-50%);cursor: pointer;">
                            签到明细<i class="layui-icon layui-icon-right" style="font-size: 16px;"></i>
                        </span>
                    </div>
                    <div class="layui-row text-center">
                        <div class="layui-col-xs6">
                            <div id="tv1Num1" style="color: #28a6d6;font-size: 22px;"><?php echo htmlentities($count-$signin); ?></div>
                            <div style="font-size: 18px;padding: 10px 0 15px 0;">未签到</div>
                        </div>
                        <div class="layui-col-xs6">
                            <div id="tv1Num2" style="color: #28a6d6;font-size: 22px;"><?php echo htmlentities($signin); ?></div>
                            <div style="font-size: 18px;padding: 10px 0 15px 0;">已签到</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md4 layui-col-sm6 layui-col-xs12">
            <div class="layui-card">
                <div class="layui-card-header">周统计</div>
                <div class="layui-card-body">
                    <div id="tjDivWeek" style="height: 373px;"></div>
                </div>
            </div>
        </div>
        <div class="layui-col-md4 layui-col-sm6 layui-col-xs12">
            <div class="layui-card">
                <div class="layui-card-header">月统计</div>
                <div class="layui-card-body">
                    <div id="tjDivMonth" style="height: 373px;"></div>
                </div>
            </div>
        </div>
    </div>
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
    
<script src="/static/hqui/libs/echarts/echarts.min.js"></script>
<script src="/static/hqui/libs/echarts/echartsTheme.js"></script>
<script>
    layui.use(['layer', 'table', 'admin'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var table = layui.table;
        var admin = layui.admin;

        // 渲染日签到图表
        var myCharts1 = echarts.init(document.getElementById('tjDivDay'), myEchartsTheme);
        var options1 = {
            title: {
                show: true,
                x: 'center',
                y: '33%',
                text: '签到人数/应到人数',
                textStyle: {
                    fontSize: 20,
                    color: '#333'
                },
                subtextStyle: {
                    fontSize: 50,
                    lineHeight: 100,
                    color: '#28a6d6'
                }
            },
            color: ['#18B4E7', '#ddd'],
            tooltip: {
                trigger: 'item'
            },
            series: [
                {
                    name: '人数',
                    type: 'pie',
                    radius: ['75%', '80%'],
                    label: {
                        normal: {
                            show: false
                        }
                    }
                }
            ]
        };
        myCharts1.setOption(options1);
         // 搜索
        var res1 = JSON.parse('<?php echo html_entity_decode($datajson); ?>');
        var mSignList = res1.signList;
        myCharts1.setOption({
            title: {
                subtext: res1.signNum + "/" + res1.allNum
            },
            series: [
                {
                    data: [
                        {name: "已签到", value: res1.signNum},
                        {name: "未签到", value: res1.allNum - res1.signNum}
                    ]
                }
            ]
        });
        // 签到明细
        $('#btnShowDetail').click(function () {
            admin.open({
                type: 1,
                area: '500px',
                offset: '80px',
                title: '签到明细',
                content: '<table id="signDetailTable" lay-filter="signDetailTable"></table>',
                success: function (layero, dIndex) {
                    // 渲染表格
                    table.render({
                        elem: '#signDetailTable',
                        data: mSignList,
                        page: false,
                        height: 280,
                        cellMinWidth: 100,
                        cols: [[
                            {type: 'numbers', title: '#'},
                            {field: 'number', title: '工号'},
                            {field: 'name', title: '姓名'},
                            {field: 'time', title: '签到时间'},
                        ]],
                        done: function () {
                            $(layero).find('.layui-table-view').css('margin', '0');
                        }
                    });
                    // end
                }
            });
        });

        // ------------------------------------------------------------------------
        // 渲染周签到图表
        var myCharts2 = echarts.init(document.getElementById('tjDivWeek'), myEchartsTheme);
        var options2 = {
            tooltip: {
                trigger: "axis",
                axisPointer: {
                    lineStyle: {
                        color: '#E0E0E0'
                    }
                }
            },
            color: ['#10B4E8', '#FFA800'],
            legend: {
                orient: 'vertical',
                right: '0px',
                top: '25px',
                data: ['已签到', '未签到']
            },
            grid: {
                top: '120px',
                left: '35px',
                right: '55px'
            },
            xAxis: {
                name: '星期',
                nameTextStyle: {
                    color: '#333'
                },
                type: 'category',
                data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
                axisLine: {
                    lineStyle: {
                        color: '#E0E0E0'
                    },
                    symbol: ['none', 'arrow'],
                    symbolOffset: [0, 10]
                },
                axisLabel: {
                    color: '#9A9A9A'
                }
            },
            yAxis: {
                name: '人数',
                nameTextStyle: {
                    color: '#333'
                },
                type: 'value',
                boundaryGap: ['0', '20%'],
                axisTick: {
                    show: false
                },
                axisLine: {
                    lineStyle: {
                        color: '#E0E0E0'
                    },
                    symbol: ['none', 'arrow'],
                    symbolOffset: [0, 10]
                },
                axisLabel: {
                    color: '#9A9A9A'
                },
                splitLine: {
                    show: false
                },
                splitArea: {
                    show: false
                },
                minInterval: 1
            },
            series: [
                {
                    name: '已签到',
                    type: 'bar',
                    stack: "one",
                    barMaxWidth: '30px',
                    data: [0, 0, 0, 0, 0, 0, 0],
                    label: {
                        normal: {
                            show: true,
                            position: 'inside',
                            formatter: function (params) {
                                if (params.value > 0) {
                                    return params.value;
                                } else {
                                    return '';
                                }
                            }
                        }
                    }
                },
                {
                    name: '未签到',
                    type: 'bar',
                    stack: "one",
                    barMaxWidth: '30px',
                    data: [0, 0, 0, 0, 0, 0, 0],
                    label: {
                        normal: {
                            show: true,
                            position: 'inside'
                        }
                    }
                }
            ]
        };
        myCharts2.setOption(options2);
        // 获取数据
        var res2 = JSON.parse('<?php echo html_entity_decode($datajsonlist); ?>');
        var dateList = [], signNums = [], unSignNums = [];
        for (var i = 0; i < res2.data.length; i++) {
            var one = res2.data[i];
            dateList.push(one.date);
            signNums.push(one.signNum);
            unSignNums.push(one.unSignNum);
        }
        myCharts2.setOption({
            series: [{data: signNums}, {data: unSignNums}]
        });

        // -------------------------------------------------------------------------
        // 渲染月签到图表
        var myCharts3 = echarts.init(document.getElementById('tjDivMonth'), myEchartsTheme);
        var options3 = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    lineStyle: {
                        color: '#E0E0E0'
                    }
                },
                formatter: '{b}号<br/><span style="display:inline-block;margin-right:5px;border-radius:10px;width:10px;height:10px;background-color:#10B4E8;"></span>{a0}: {c0}<br/><span style="display:inline-block;margin-right:5px;border-radius:10px;width:10px;height:10px;background-color:#FFA800;"></span>{a1}: {c1}'
            },
            color: ['#10B4E8', '#FFA800'],
            legend: {
                orient: 'vertical',
                right: '0px',
                top: '25px',
                data: ['已签到', '未签到']
            },
            grid: {
                top: '120px',
                left: '35px',
                right: '55px'
            },
            xAxis: {
                name: '日期',
                nameTextStyle: {
                    color: '#333'
                },
                type: 'category',
                data: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
                axisLine: {
                    lineStyle: {
                        color: '#E0E0E0'
                    },
                    symbol: ['none', 'arrow'],
                    symbolOffset: [0, 10]
                },
                axisLabel: {
                    color: '#9A9A9A',
                    interval: function (index, value) {
                        if (index == 0 || ((index + 1) % 5 == 0)) {
                            return true;
                        }
                        return false;
                    }
                }
            },
            yAxis: {
                name: '人数',
                nameTextStyle: {
                    color: '#333'
                },
                type: 'value',
                boundaryGap: ['0', '20%'],
                axisTick: {
                    show: false
                },
                axisLine: {
                    lineStyle: {
                        color: '#E0E0E0'
                    },
                    symbol: ['none', 'arrow'],
                    symbolOffset: [0, 10]
                },
                axisLabel: {
                    color: '#9A9A9A'
                },
                splitLine: {
                    show: false
                },
                splitArea: {
                    show: false
                },
                minInterval: 1
            },
            series: [
                {
                    name: '已签到',
                    type: 'line',
                    smooth: false,
                    data: []
                },
                {
                    name: '未签到',
                    type: 'line',
                    smooth: false,
                    data: []
                }
            ]
        };
        myCharts3.setOption(options3);
        // 获取数据
        var res3 = JSON.parse('<?php echo html_entity_decode($datajsonlist2); ?>');
        var dateList = [], signNums = [], unSignNums = [];
        for (var i = 0; i < res3.data.length; i++) {
            var one = res3.data[i];
            dateList.push(i + 1);
            signNums.push(one.signNum);
            unSignNums.push(one.unSignNum);
        }
        myCharts3.setOption({
            xAxis: {data: dateList},
            series: [{data: signNums}, {data: unSignNums}]
        });
        // -------------------------------------------------------------------------

        // 窗口大小改变事件
        window.onresize = function () {
            myCharts1.resize();
            myCharts2.resize();
            myCharts3.resize();
        };

    });

//网站时间
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

</body>
</html>