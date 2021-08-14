<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

/**
 * 说明
 * --------------------------------------------------------------------------------------+
 * 1. middleware('check') 后台登录验证中间件
 * 2. middleware('auth') 前台登录验证中间件
 * --------------------------------------------------------------------------------------+
 */

/**
 * 不需要验证登录路由+--------------------------------------------------------------------+
 */
    Route::group(function () {
    Route::get('search_json', 'admin.article/search_json');    // 列表
    Route::any('admin/tourist', 'admin.admin/tourist');   // 后台登录
    Route::any('admin/login', 'admin.admin/login');   // 后台登录
    Route::any('admin/authentication', 'admin.admin/authentication');   // 身份验证
    Route::any('admin/authenticationcheck', 'admin.admin/authenticationcheck');   // 身份验证
    Route::any('user/authentication', 'index.user/authentication');   // 身份验证
    Route::any('user/authenticationcheck', 'index.user/authenticationcheck');   // 身份验证
    Route::post('click', 'index.detail/click');   // 点赞
    Route::post('admin/check', 'admin.admin/check');   // 登录检查
    Route::rule('/', 'index.index/index');   // 前台首页

    Route::get('column', 'index.column/index');  // 首页栏目
    Route::get('detail', 'index.detail/index');   // 文章详情

    Route::get('user/login', 'index.index/login');   // 前台登录页面
    Route::post('user/auth', 'index.user/auth');   // 前台登录检查点赞

    Route::get('user/ems', 'index.index/ems');   // 邮箱找回密码
    Route::post('user/retrievepwd', 'index.user/retrievePwd');   // 邮箱找回密码
    Route::post('user/emailcheck', 'index.user/emailcheck');   // 邮箱找回密码

    Route::get('user/sms', 'index.index/sms');  // 手机找回密码
    Route::post('user/smspwd', 'index.user/smsPwd');   // 手机找回密码
    Route::post('user/mobilecheck', 'index.user/mobilecheck');   // 手机找回密码


    Route::get('user/register', 'index.index/register');   // 前台注册
    Route::post('user/add', 'admin.user/add');   // 前台注册验证

    Route::get('qqlogin', 'admin.qqlogin/qqlogin');   // qq登录
    Route::get('qq', 'index.index/binding');  // 前台binding
    Route::post('qq/auth', 'admin.qqlogin/auth');   // qqbinding

    Route::post('contribution/add', 'admin.article/add');     // 数据路由
    Route::any('contribution/uploadImage', 'admin.article/uploadImage');     // 数据路由
    Route::get('user/contribution', 'index.index/contribution'); // / 投稿

    Route::get('game/lottery', 'index.game/lottery');   // 圈小猫游戏
    Route::get('game/cat', 'index.game/cat');   // 圈小猫游戏
    Route::get('game/chat', 'index.game/chat');   // 圈小猫游戏

});

/**
 * 前台路由+------------------------------------------------------------------------+
 * 需验证登录
 **/
Route::group(function () {
    Route::any('user/unread', 'admin.notice/unread');     // 已读
    Route::any('user/read', 'admin.notice/read');     // 未读
    Route::post('notice/edit', 'admin.notice/edit');     // 编辑
    Route::any('notice/del', 'admin.notice/del');     // 删除
    Route::any('user/detail_json', 'admin.notice/detail_json');    // 列表
    Route::any('user/detail', 'admin.notice/detail');    // 列表
    Route::any('user/message', 'admin.notice/message');    // 列表
    Route::any('user/get_notice', 'admin.notice/get_notice');    // 列表
    Route::post('user/email', 'index.user/email');   // 修改邮箱
    Route::post('user/changeemail', 'index.user/changeemail');   // 修改邮箱验证

    Route::post('user/mobile', 'index.user/mobile');   // 修改手机
    Route::post('user/changemobile', 'index.user/changemobile');   // 修改手机验证

    Route::get('user/index', 'index.user/index'); // 用户中心
    Route::post('user/change', 'index.user/change');   // 修改密码
    Route::get('user/changepwd', 'index.user/changePwd');   // 修改密码页面
    Route::get('user/logout', 'index.user/logout');   // 退出登录

    Route::post('profile/edit', 'admin.user/edit');     // 编辑
    Route::post('profile/uploadImage', 'admin.user/uploadImage'); //图片上传
    Route::get('user/profile', 'index.user/profile');   // 个人资料页面

    Route::post('notices', 'index.detail/notices');   // 提交评论
    
    Route::any('chatzone', 'index.detail/chatzone');     // 数据路由
    Route::get('chats', 'index.index/chat');   // 聊天留言

    Route::get('signin', 'index.signin/index');   // 签到
    Route::post('dosign', 'index.signin/doSign');   // 签到加积分
    Route::post('signature', 'index.signin/signature');   // 签到补签
})->middleware('auth');

/**
 * 后台路由+------------------------------------------------------------------------+
 * 需验证登录
 */
// 管理员路由组
Route::group('admin', function (){
    Route::any('editPassword', 'admin.admin/editPassword');   // 修改密码
    Route::get('logout', 'admin.admin/logout');   // 退出登录
    Route::any('upload', 'admin.admin/upload');   // 图片上传
    Route::get('index', 'admin.admin/index'); // 控制台-后台首页
    Route::get('list', 'admin.admin/lists');    // 列表
    Route::get('home', 'admin.admin/home');    // 列表
    Route::post('add', 'admin.admin/add');    // 新增
    Route::post('del', 'admin.admin/del');    // 删除
    Route::any('clear', 'admin.admin/clearTempLog');    // 清除缓存
    Route::post('edit', 'admin.admin/edit');    // 编辑
    Route::get('info', 'admin.admin/info');   // 管理员数据路由
})->middleware('check');


// 数据库备份
Route::group('backup', function (){
    Route::any('database', 'admin.database/database');   // 数据库备份
    Route::any('restore', 'admin.database/restore');   // 数据库还原
    Route::any('backup', 'admin.database/backup');   // 备份
    Route::any('optimize', 'admin.database/optimize');   // 优化
    Route::any('repair', 'admin.database/repair');   // 恢复
    Route::any('import', 'admin.database/import');   // 还原
    Route::any('downFile', 'admin.database/downFile');   // 下载
    Route::any('del', 'admin.database/del');   // 删除
})->middleware('check');
// 短信模板路由组
Route::group('system', function () {
    Route::any('sina', 'admin.system/sina');    // 列表
    Route::any('list126', 'admin.system/list126');     // 数据路由
    Route::any('listqq', 'admin.system/listqq');     // 编辑
    Route::any('listsms', 'admin.system/listsms');     // 删除
    Route::any('sitting', 'admin.system/sitting');     // 删除
    Route::any('upload', 'admin.system/upload');   // 图片上传
    Route::any('uploads', 'admin.system/uploadImage');   // 图片上传
})->middleware('check');
// 栏目路由组
Route::group('setting', function () {
    Route::get('list', 'admin.setting/lists');    // 列表
    Route::post('add', 'admin.setting/add');     // 数据路由
    Route::post('edit', 'admin.setting/edit');     // 编辑
    Route::any('upload', 'admin.setting/upload');   // 图片上传
})->middleware('check');

// 栏目路由组
Route::group('category', function () {
    Route::get('list', 'admin.category/lists');    // 列表
    Route::get('info', 'admin.category/info');     // 数据路由
    Route::post('add', 'admin.category/add');     // 数据路由
    Route::post('edit', 'admin.category/edit');     // 编辑
    Route::post('del', 'admin.category/del');     // 删除
})->middleware('check');

// 文章路由组
Route::group('article', function () {
    Route::get('list', 'admin.article/lists');    // 列表
    Route::any('index_json', 'admin.article/index_json');    // 新列表
    Route::any('add', 'admin.article/add');     // 数据路由
    Route::any('upload', 'admin.article/upload');     // 数据路由
    Route::any('edit', 'admin.article/edit');     // 编辑
    Route::any('del', 'admin.article/del');     // 数据路由
})->middleware('check');

// 轮播图路由组
Route::group('banner', function () {
    Route::get('list', 'admin.banner/lists');    // 列表
    Route::any('upload', 'admin.banner/upload');   // 图片上传
    Route::get('info', 'admin.banner/info');     // 数据路由
    Route::post('add', 'admin.banner/add');     // 数据路由
    Route::post('edit', 'admin.banner/edit');     // 编辑
    Route::post('del', 'admin.banner/del');     // 数据路由
})->middleware('check');
// comment路由组
Route::group('notice', function () {
    Route::get('list', 'admin.notice/lists');    // 列表
    Route::get('info', 'admin.notice/info');     // 数据路由
    Route::any('noticeedit', 'admin.notice/edit');     // 编辑
    Route::any('noticedel', 'admin.notice/del');     // 数据路由
})->middleware('check');


// 附件路由组
Route::group('image', function () {
    Route::get('list', 'admin.image/lists');    // 列表
    Route::get('info', 'admin.image/info');     // 数据路由
    Route::post('del', 'admin.image/del');     // 删除
   // Route::post('edit', 'admin.image/edit');     // 编辑
})->middleware('check');

// 日志路由组
Route::group('adminlog', function () {
    Route::get('list', 'admin.adminLog/lists');    // 列表
    Route::get('info', 'admin.adminLog/info');     // 数据路由
    Route::post('del', 'admin.adminLog/del');     // 删除
})->middleware('check');

// 签到路由组
Route::group('sign', function () {
    Route::any('list', 'admin.signin/lists');    // 列表
    Route::any('index_json', 'admin.signin/index_json');     // 数据路由
    Route::any('del', 'admin.signin/del'); 
    Route::any('edit', 'admin.signin/edit');     // 删除
})->middleware('check');

// 奖路由组
Route::group('sidebar', function () {
    Route::any('index_json', 'admin.sidebar/index_json');    // 列表
    Route::any('list', 'admin.sidebar/lists');    // 列表
    Route::any('edit', 'admin.sidebar/edit');     // 编辑
    Route::any('del', 'admin.sidebar/del');     // 删除
    Route::any('add', 'admin.sidebar/add');     // 数据路由
})->middleware('check');


// 奖路由组
Route::group('tourist', function () {
    Route::any('index_json', 'admin.tourist/index_json');    // 列表
    Route::any('list', 'admin.tourist/lists');    // 列表
    Route::any('info', 'admin.tourist/info');     // 数据路由
    Route::any('edit', 'admin.tourist/edit');     // 编辑
    Route::any('del', 'admin.tourist/del');     // 删除
    Route::any('add', 'admin.tourist/add');     // 数据路由
})->middleware('check');

// 奖路由组
Route::group('gift', function () {
    Route::get('list', 'admin.lotteryGift/lists');    // 列表
    Route::get('info', 'admin.lotteryGift/info');     // 数据路由
    Route::post('edit', 'admin.lotteryGift/edit');     // 编辑
    Route::post('del', 'admin.lotteryGift/del');     // 删除
    Route::post('add', 'admin.lotteryGift/add');     // 数据路由
})->middleware('check');
// 抽奖路由组
Route::group('lottery', function () {
    Route::get('list', 'admin.lottery/lists');    // 列表
    Route::get('index_json', 'admin.lottery/index_json');     // 数据路由
    Route::post('del', 'admin.lottery/del');     // 删除
})->middleware('check');

// 奖路由组
Route::group('activity', function () {
    Route::get('list', 'admin.lotteryActivity/lists');    // 列表
    Route::get('info', 'admin.lotteryActivity/info');     // 数据路由
    Route::post('edit', 'admin.lotteryActivity/edit');     // 编辑
    Route::post('del', 'admin.lotteryActivity/del');     // 删除
    Route::post('add', 'admin.lotteryActivity/add');     // 数据路由
})->middleware('check');

// 点赞日志路由组
Route::group('articlelog', function () {
    Route::get('list', 'admin.articleLog/lists');    // 列表
    Route::get('info', 'admin.articleLog/info');     // 数据路由
    Route::post('del', 'admin.articleLog/del');     // 删除
})->middleware('check');

// 点赞日志路由组
Route::group('clicklog', function () {
    Route::get('list', 'admin.clickLog/lists');    // 列表
    Route::get('info', 'admin.clickLog/info');     // 数据路由
    Route::post('del', 'admin.clickLog/del');     // 删除
})->middleware('check');

// 角色组路由组
Route::group('group', function () {
    Route::any('group', 'admin.authRule/group');     // 数据路由
    Route::any('group_json', 'admin.authRule/group_json');     // 数据路由
    Route::any('editGroup', 'admin.authRule/editGroup');     // 数据编辑
    Route::any('addGroup', 'admin.authRule/addGroup');     // 数据新增
    Route::any('delGroup', 'admin.authRule/delGroup');     // 数据删除
    Route::get('list', 'admin.authGroup/lists');    // 列表
    Route::get('tree', 'admin.authGroup/rule');    // 树
    Route::get('editTree', 'admin.authGroup/editTree');    // 编辑树
    Route::get('info', 'admin.authGroup/info');     // 数据路由
    Route::post('add', 'admin.authGroup/add');     // 数据路由
    Route::post('edit', 'admin.authGroup/edit');     // 编辑
    Route::post('del', 'admin.authGroup/del');     // 数据路由
})->middleware('check');

// 权限路由组
Route::group('mongo', function () {
    Route::get('list', 'admin.mongodb/lists');    // 列表
    Route::get('info', 'admin.mongodb/info');     // 数据路由
    Route::post('del', 'admin.mongodb/del');     // 数据路由
})->middleware('check');

// 权限路由组
Route::group('rule', function () {
    Route::any('group', 'admin.authRule/group');    // 列表
    Route::any('rule_json', 'admin.authRule/rule_json');     // 数据路由
    Route::any('rule', 'admin.authRule/rule');     // 数据路由
    Route::any('editRule', 'admin.authRule/editRule');     // 编辑
    Route::any('addrule', 'admin.authRule/addrule');     // 数据路由
    Route::any('delRule', 'admin.authRule/delRule');     // 数据路由
})->middleware('check');

// 版本路由组
Route::group('version', function () {
    Route::get('list', 'admin.version/lists');    // 列表
    Route::get('info', 'admin.version/info');     // 数据路由
    Route::post('add', 'admin.version/add');     // 新增
    Route::post('edit', 'admin.version/edit');     // 编辑
    Route::post('del', 'admin.version/del');     // 数据路由
})->middleware('check');


// usertoken路由组
Route::group('usertoken', function () {
    Route::get('list', 'admin.userToken/lists');    // 列表
    Route::get('info', 'admin.userToken/info');     // 数据路由
    Route::post('edit', 'admin.userToken/edit');     // 编辑
    Route::post('del', 'admin.userToken/del');     // 数据路由
})->middleware('check');

// userscorelog路由组
Route::group('userscorelog', function () {
    Route::get('list', 'admin.userScoreLog/lists');    // 列表
    Route::get('info', 'admin.userScoreLog/info');     // 数据路由
    Route::post('edit', 'admin.userScoreLog/edit');     // 编辑
    Route::post('del', 'admin.userScoreLog/del');     // 数据路由
})->middleware('check');

// ems路由组
Route::group('ems', function () {
    Route::get('index_json', 'admin.ems/index_json');    // 列表
    Route::get('list', 'admin.ems/lists');    // 列表
    Route::get('info', 'admin.ems/info');     // 数据路由
    Route::any('edit', 'admin.ems/edit');     // 编辑
    Route::any('del', 'admin.ems/del');     // 删除
})->middleware('check');
// 短信路由组
Route::group('sms', function () {
    Route::get('list', 'admin.sms/lists');    // 列表
    Route::get('info', 'admin.sms/info');     // 数据路由
    Route::post('edit', 'admin.sms/edit');     // 编辑
    Route::post('del', 'admin.sms/del');     // 删除
})->middleware('check');

// 短信模板路由组
Route::group('smsmoban', function () {
    Route::get('list', 'admin.smsMoban/lists');    // 列表
    Route::get('info', 'admin.smsMoban/info');     // 数据路由
    Route::post('edit', 'admin.smsMoban/edit');     // 编辑
    Route::post('del', 'admin.smsMoban/del');     // 删除
    Route::post('add', 'admin.smsMoban/add');     // 新增
})->middleware('check');
// 用户路由组
Route::group('user', function () {
    Route::any('index_json', 'admin.user/index_json');    // 列表
    Route::get('list', 'admin.user/lists');    // 列表
    Route::post('uploadImage', 'admin.user/uploadImage'); //图片上传
    Route::any('del', 'admin.user/del');    // 删除
    Route::any('edit', 'admin.user/edit');     // 编辑
})->middleware('check');

// 敏感词屏蔽
Route::group('sensitive', function () {
    Route::get('list', 'admin.sensitiveWords/lists');    // 列表
    Route::get('info', 'admin.sensitiveWords/info');     // 数据路由
    Route::post('add', 'admin.sensitiveWords/add');    // 新增
    Route::post('edit', 'admin.sensitiveWords/edit');    // 编辑
    Route::post('del', 'admin.sensitiveWords/del');    // 删除
})->middleware('check');


// 屏蔽恶意请求路由
Route::miss(function (){
    return redirect('/404.html');
});