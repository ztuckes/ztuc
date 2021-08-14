-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost:3306
-- 生成日期： 2021-08-14 17:35:08
-- 服务器版本： 5.6.44-log
-- PHP 版本： 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `m_ztuc_cn`
--

-- --------------------------------------------------------

--
-- 表的结构 `group_admin`
--

CREATE TABLE `group_admin` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `groups_id` int(10) NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(30) NOT NULL DEFAULT '' COMMENT '密码盐',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `loginip` varchar(30) DEFAULT NULL COMMENT '登录IP',
  `loginfailure` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '失败次数',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `mobilelogintime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `logintime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `prevtime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `token` varchar(59) NOT NULL DEFAULT '' COMMENT 'Session标识',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `group_admin`
--

INSERT INTO `group_admin` (`id`, `groups_id`, `username`, `nickname`, `password`, `salt`, `email`, `loginip`, `loginfailure`, `createtime`, `updatetime`, `mobilelogintime`, `logintime`, `prevtime`, `token`, `status`) VALUES
(1, 1, 'admin', 'admin', '898b287ae5d4e7597e8f46bb762d1c28', 'a957af35aa', '991902906@qq.com', '117.177.13.158', 136, 1584241473, 1628912893, 1628587029, 1628912893, 1628412008, '079b40a8cf1f549bad6ba71f6aac9034602426e4', 1),
(2, 3, 'ztucke', 'ztucke', '68f9ddc243da89cff59010ee5c4fc197', '293f758095', '8142355@qq.com', '117.177.13.158', 3, 1604890990, 1628923513, 0, 1628923513, 1617243301, '38459807793660a4b4b396b3c88c1871d3184b25', 1),
(3, 2, '九月', '九月', '192e14601ab5b90a688d7cfb1b02ab6b', '931b410557', '201858601@qq.com', '111.9.84.143', 0, 1607833434, 1621291221, 1621291221, 0, 1619615651, 'b0792e6de5ae4ec14d9b21baded5418f5f76d7c5', 1),
(4, 4, '2114', '2114', '685c441df94de3c59c21c06aff31a6d3', '0a80d766c2', '211460977@qq.com', '', 0, 1609123408, 1619097391, 0, 0, 0, '24479258e1d1059761ff4bdce6263f9d05ff2b71', 1),
(5, 2, 'moli4', 'moli4', 'c0ec8322f25d0d33266ab5c74e9642fe', 'c525768383', '124242@1111.com', '', 0, 1613379616, 1616848450, 0, 0, 0, 'a3a0846200b5bab0b6faa0aae4bdde347f018ff7', 1),
(6, 2, '3333', '3333', '4f2a75d4aebdc7aeeb41f9478cbc1818', 'f8818a5517', 'z3turcke@ztuc.cn', '', 0, 1613492633, 1614087306, 0, 0, 0, '9b05586a8aec13eee72b799d936f29b0914d5f89', 1),
(7, 2, '21143', '21143', 'f27e7d60d822b7460316fb63ed6834bf', '15eeceadd0', '124242@111.com', '', 0, 1613492659, 1616121107, 0, 0, 0, 'fc82e1b906f6373fd7a58f309c92c16168efb047', 1),
(8, 0, 'wwwww', '', '40a07c2758b8ea922ddd76fa52c4d23a', 'da8923efec', '9919029906@qq.com', '', 0, 1613535960, 1613537799, 0, 0, 0, 'ee9bab63f523b86a5733e7eb15a4102dc5aac4f4', 1),
(9, 4, '5555', '5555', '529392b082da80369eee8fbe6e0a0ba0', '6023bc6602', '1242452@1111.com', '', 0, 1613545273, 1614087329, 0, 0, 0, 'c8370d5f14c6a3ebdeded1a048e3734a9c7f0d24', 1),
(10, 0, 'ztuckew', 'ztuckew', '80a0c4825b47e4f57b1c126657a3a8f0', '49c99e2ffe', 'zturcke@ztuc.cn', '', 0, 1613550009, 1614087366, 0, 0, 0, '29e6e55828cbdc12dc0ce9ff3320218d6c462af0', 1),
(11, 0, '2018', '', 'aa7e7dd98aac7589cd8345ddf0c1edbf', 'f06ac0ef07', '201858601@qq.com', '', 0, 1614389758, 1615223511, 0, 0, 0, '2e0c7efc6a68a08c8d8735ac2d6f16e8fd18f84c', 1),
(12, 0, 'ztucke0', '', '4e8f5d17bd8083f7760e0d64c7055953', 'd39b44ada4', '81428355@qq.com', '', 0, 1615629312, 1617702634, 0, 0, 0, '0b2f116de943f9797ef0fd6bf4d33c955420095e', 1);

-- --------------------------------------------------------

--
-- 表的结构 `group_admin_log`
--

CREATE TABLE `group_admin_log` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `admin_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员名字',
  `url` varchar(1500) NOT NULL DEFAULT '' COMMENT '操作页面',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '日志标题',
  `content` text NOT NULL COMMENT '内容',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'IP',
  `useragent` varchar(255) NOT NULL DEFAULT '' COMMENT 'User-Agent',
  `createtime` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员日志表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_article`
--

CREATE TABLE `group_article` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
  `cat_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目id',
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '标题',
  `desc` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL COMMENT '内容',
  `types` tinyint(1) DEFAULT '1' COMMENT '类型：1=文章',
  `flag` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '标志:1=最新，2=热门，3=推荐',
  `view` int(11) UNSIGNED DEFAULT '0' COMMENT '浏览量',
  `click` int(11) UNSIGNED DEFAULT '0' COMMENT '点赞数',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `weigh` int(11) UNSIGNED DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态：1=正常，0=禁用',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章';

-- --------------------------------------------------------

--
-- 表的结构 `group_article_log`
--

CREATE TABLE `group_article_log` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `article_id` int(11) NOT NULL COMMENT '文章id',
  `url` varchar(1500) DEFAULT NULL COMMENT 'URL',
  `view` int(10) NOT NULL DEFAULT '0' COMMENT '浏览数量',
  `agent` varchar(255) DEFAULT NULL COMMENT '用户代理',
  `ip` varchar(15) DEFAULT NULL COMMENT 'IP',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='点赞记录';

-- --------------------------------------------------------

--
-- 表的结构 `group_auth_group`
--

CREATE TABLE `group_auth_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父组别',
  `group_name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `description` varchar(255) NOT NULL DEFAULT '0' COMMENT '描述',
  `rules` text NOT NULL COMMENT '规则ID',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分组表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_auth_group_access`
--

CREATE TABLE `group_auth_group_access` (
  `id` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL COMMENT '级别ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限分组表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_auth_rule`
--

CREATE TABLE `group_auth_rule` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` char(4) NOT NULL DEFAULT '' COMMENT 'nav,authmenu为菜单,file为权限节点',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父ID',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '规则名称',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '规则名称',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标',
  `condition` varchar(255) DEFAULT '' COMMENT '条件',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `ismenu` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否为菜单1=显示菜单，0=隐藏',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='节点表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_banner`
--

CREATE TABLE `group_banner` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `url` varchar(255) NOT NULL DEFAULT '#' COMMENT '跳转链接',
  `desc` varchar(255) NOT NULL COMMENT '描述',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态1=正常2=禁用',
  `weigh` int(10) DEFAULT '0' COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='轮播图';

-- --------------------------------------------------------

--
-- 表的结构 `group_category`
--

CREATE TABLE `group_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父ID',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '栏目类型1=首页2=热门3=推荐',
  `cat_name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',
  `column` tinyint(1) DEFAULT '1' COMMENT '模板1=瀑布，2=宫格',
  `nickname` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_click_log`
--

CREATE TABLE `group_click_log` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `article_id` int(11) NOT NULL COMMENT '文章id',
  `ip` varchar(15) DEFAULT NULL COMMENT 'IP',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='点赞记录';

-- --------------------------------------------------------

--
-- 表的结构 `group_ems`
--

CREATE TABLE `group_ems` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `event` varchar(30) NOT NULL DEFAULT '' COMMENT '事件',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `code` varchar(10) NOT NULL DEFAULT '' COMMENT '验证码',
  `times` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '验证次数',
  `ip` varchar(30) NOT NULL DEFAULT '' COMMENT 'IP',
  `exptime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '过期时间',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态：1=正常，0=禁用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='邮箱验证码表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_images`
--

CREATE TABLE `group_images` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
  `table_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '表id',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '图片路径',
  `types` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '图片类型:1=banner图片，2=admin图片，3=user图片，4=article图',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1=正常，0=禁用',
  `createtime` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图片表';

-- --------------------------------------------------------

--
-- 表的结构 `group_lottery`
--

CREATE TABLE `group_lottery` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `gift_id` int(10) UNSIGNED NOT NULL COMMENT '奖品id',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `ip` varchar(15) DEFAULT NULL COMMENT 'IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抽奖记录';

-- --------------------------------------------------------

--
-- 表的结构 `group_lottery_activity`
--

CREATE TABLE `group_lottery_activity` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id',
  `title` varchar(128) NOT NULL COMMENT '活动标题',
  `day_num` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '每人每天抽奖次数',
  `score_num` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '每次抽奖消耗积分',
  `rate` int(10) UNSIGNED DEFAULT '100' COMMENT '抽奖概率',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态:1=正常0=禁用',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抽奖活动';

-- --------------------------------------------------------

--
-- 表的结构 `group_lottery_gift`
--

CREATE TABLE `group_lottery_gift` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id',
  `activity_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '抽奖活动id',
  `title` varchar(128) NOT NULL COMMENT '奖品标题',
  `val` int(10) NOT NULL DEFAULT '0' COMMENT '奖励值',
  `desc` varchar(255) NOT NULL COMMENT '奖品明细',
  `rate` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '单个奖品中奖概率',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态:1=正常0=禁用',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='奖品表';

-- --------------------------------------------------------

--
-- 表的结构 `group_notice`
--

CREATE TABLE `group_notice` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
  `article_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '回复ID',
  `pid` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'fuID',
  `pid_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'lt聊天id',
  `ip` varchar(15) DEFAULT '0' COMMENT 'ip地址',
  `content` varchar(300) NOT NULL DEFAULT '' COMMENT '评论内容',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `datetime` varchar(10) NOT NULL DEFAULT '0' COMMENT '日期',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(5) DEFAULT '1' COMMENT '状态 1待办 0已办'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论表';

-- --------------------------------------------------------

--
-- 表的结构 `group_sensitive_words`
--

CREATE TABLE `group_sensitive_words` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `word` varchar(255) NOT NULL DEFAULT '' COMMENT '敏感词',
  `type` int(10) NOT NULL DEFAULT '0',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) UNSIGNED DEFAULT '1' COMMENT '状态:1=正常,2=禁用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='敏感词表';

-- --------------------------------------------------------

--
-- 表的结构 `group_sidebar`
--

CREATE TABLE `group_sidebar` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `url` varchar(255) NOT NULL DEFAULT '#' COMMENT '跳转链接',
  `desc` varchar(255) NOT NULL COMMENT '描述',
  `icon` varchar(50) NOT NULL COMMENT '图标',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态1=正常2=禁用',
  `weigh` int(10) DEFAULT '0' COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='侧边栏';

-- --------------------------------------------------------

--
-- 表的结构 `group_signin`
--

CREATE TABLE `group_signin` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'id',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `ip` varchar(15) NOT NULL COMMENT 'IP',
  `successions` int(11) DEFAULT NULL COMMENT '连续签到天数',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `types` enum('normal','fillup') NOT NULL DEFAULT 'normal' COMMENT '签到类型:normal签到，fillup补签',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态-1正常，状态-0禁用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='签到表';

-- --------------------------------------------------------

--
-- 表的结构 `group_sms`
--

CREATE TABLE `group_sms` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `event` varchar(30) NOT NULL DEFAULT '' COMMENT '事件',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `code` varchar(10) NOT NULL DEFAULT '' COMMENT '验证码',
  `times` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '验证次数',
  `ip` varchar(30) NOT NULL DEFAULT '' COMMENT 'IP',
  `exptime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '过期时间',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信验证码表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_system`
--

CREATE TABLE `group_system` (
  `id` int(3) UNSIGNED NOT NULL COMMENT 'ID',
  `key` varchar(100) DEFAULT NULL COMMENT '配置字段',
  `name` varchar(100) DEFAULT NULL COMMENT '配置名称',
  `jdata` text COMMENT '配置参数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置表' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `group_tourist`
--

CREATE TABLE `group_tourist` (
  `id` int(10) UNSIGNED NOT NULL,
  `tourist_name` varchar(20) NOT NULL COMMENT '用户名',
  `ip` varchar(30) NOT NULL COMMENT 'ip',
  `agent` varchar(255) DEFAULT NULL COMMENT '用户代理',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `exptime` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '拉黑时间',
  `locks` tinyint(10) NOT NULL DEFAULT '1' COMMENT '状态：1=正常，0=锁定	',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1=正常，0=禁用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='黑白名单表';

-- --------------------------------------------------------

--
-- 表的结构 `group_user`
--

CREATE TABLE `group_user` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `group_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '组别ID',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `qq` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'qq',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(30) NOT NULL DEFAULT '' COMMENT '密码盐',
  `openid` varchar(32) DEFAULT '' COMMENT 'QQ绑定',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `level` int(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '等级',
  `gender` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '性别',
  `bio` varchar(100) NOT NULL DEFAULT '' COMMENT '格言',
  `money` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00' COMMENT '余额',
  `score` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '积分',
  `successions` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '连续登录天数',
  `maxsuccessions` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '最大连续登录天数',
  `prevtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `logintime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '登录时间',
  `mobilelogintime` int(10) UNSIGNED DEFAULT '0' COMMENT '手机登录时间',
  `mobileprevtime` int(10) UNSIGNED DEFAULT '0' COMMENT '手机上次登录时间',
  `loginip` varchar(50) NOT NULL DEFAULT '' COMMENT '登录IP',
  `loginfailure` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '失败次数',
  `joinip` varchar(50) NOT NULL DEFAULT '' COMMENT '加入IP',
  `jointime` int(10) UNSIGNED DEFAULT '0' COMMENT '加入时间',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `token` varchar(50) NOT NULL DEFAULT '' COMMENT 'Token',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `verification` varchar(255) NOT NULL DEFAULT '' COMMENT '验证',
  `line_time` varchar(100) NOT NULL DEFAULT '0' COMMENT '在线时长',
  `login_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '登录时间',
  `exptime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '总在线时长'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_user_group`
--

CREATE TABLE `group_user_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) DEFAULT '' COMMENT '组名',
  `rules` text COMMENT '权限节点',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员组表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_user_rule`
--

CREATE TABLE `group_user_rule` (
  `id` int(10) UNSIGNED NOT NULL,
  `pid` int(10) DEFAULT NULL COMMENT '父ID',
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `title` varchar(50) DEFAULT '' COMMENT '标题',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  `ismenu` tinyint(1) DEFAULT NULL COMMENT '是否菜单',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `weigh` int(10) DEFAULT '0' COMMENT '权重',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员规则表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_user_score_log`
--

CREATE TABLE `group_user_score_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '会员ID',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '变更积分',
  `before` int(10) NOT NULL DEFAULT '0' COMMENT '变更前积分',
  `after` int(10) NOT NULL DEFAULT '0' COMMENT '变更后积分',
  `memo` varchar(255) NOT NULL DEFAULT '0' COMMENT '备注',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员积分变动表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_user_token`
--

CREATE TABLE `group_user_token` (
  `token` varchar(50) NOT NULL COMMENT 'Token',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '会员ID',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `expiretime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '过期时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员Token表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `group_version`
--

CREATE TABLE `group_version` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `oldversion` varchar(30) NOT NULL DEFAULT '' COMMENT '旧版本号',
  `newversion` varchar(30) NOT NULL DEFAULT '' COMMENT '新版本号',
  `packagesize` varchar(30) NOT NULL DEFAULT '' COMMENT '包大小',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '升级内容',
  `downloadurl` varchar(255) NOT NULL DEFAULT '' COMMENT '下载地址',
  `enforce` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '强制更新,1=是0=否',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='版本表' ROW_FORMAT=COMPACT;

--
-- 转储表的索引
--

--
-- 表的索引 `group_admin`
--
ALTER TABLE `group_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- 表的索引 `group_admin_log`
--
ALTER TABLE `group_admin_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`username`);

--
-- 表的索引 `group_article`
--
ALTER TABLE `group_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`) USING BTREE,
  ADD KEY `idx_status` (`status`,`cat_id`) USING BTREE;

--
-- 表的索引 `group_article_log`
--
ALTER TABLE `group_article_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `click_force` (`article_id`,`ip`,`createtime`) USING BTREE;

--
-- 表的索引 `group_auth_group`
--
ALTER TABLE `group_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_auth_group_access`
--
ALTER TABLE `group_auth_group_access`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_auth_rule`
--
ALTER TABLE `group_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rules` (`ismenu`,`status`) USING BTREE;

--
-- 表的索引 `group_banner`
--
ALTER TABLE `group_banner`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_category`
--
ALTER TABLE `group_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`),
  ADD KEY `status` (`status`) USING BTREE;

--
-- 表的索引 `group_click_log`
--
ALTER TABLE `group_click_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `click_force` (`article_id`,`ip`,`createtime`) USING BTREE;

--
-- 表的索引 `group_ems`
--
ALTER TABLE `group_ems`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `group_images`
--
ALTER TABLE `group_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images` (`table_id`,`types`) USING BTREE;

--
-- 表的索引 `group_lottery`
--
ALTER TABLE `group_lottery`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_lottery_activity`
--
ALTER TABLE `group_lottery_activity`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_lottery_gift`
--
ALTER TABLE `group_lottery_gift`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_notice`
--
ALTER TABLE `group_notice`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_sensitive_words`
--
ALTER TABLE `group_sensitive_words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `word` (`word`) USING BTREE;

--
-- 表的索引 `group_sidebar`
--
ALTER TABLE `group_sidebar`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_signin`
--
ALTER TABLE `group_signin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_sms`
--
ALTER TABLE `group_sms`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_system`
--
ALTER TABLE `group_system`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `group_tourist`
--
ALTER TABLE `group_tourist`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_user`
--
ALTER TABLE `group_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `mobile` (`mobile`);

--
-- 表的索引 `group_user_group`
--
ALTER TABLE `group_user_group`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_user_rule`
--
ALTER TABLE `group_user_rule`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_user_score_log`
--
ALTER TABLE `group_user_score_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `group_user_token`
--
ALTER TABLE `group_user_token`
  ADD PRIMARY KEY (`token`);

--
-- 表的索引 `group_version`
--
ALTER TABLE `group_version`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `group_admin`
--
ALTER TABLE `group_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `group_admin_log`
--
ALTER TABLE `group_admin_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `group_article`
--
ALTER TABLE `group_article`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用表AUTO_INCREMENT `group_article_log`
--
ALTER TABLE `group_article_log`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `group_auth_group`
--
ALTER TABLE `group_auth_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `group_auth_group_access`
--
ALTER TABLE `group_auth_group_access`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `group_auth_rule`
--
ALTER TABLE `group_auth_rule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `group_banner`
--
ALTER TABLE `group_banner`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `group_category`
--
ALTER TABLE `group_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `group_click_log`
--
ALTER TABLE `group_click_log`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `group_ems`
--
ALTER TABLE `group_ems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `group_images`
--
ALTER TABLE `group_images`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用表AUTO_INCREMENT `group_lottery`
--
ALTER TABLE `group_lottery`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用表AUTO_INCREMENT `group_lottery_activity`
--
ALTER TABLE `group_lottery_activity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用表AUTO_INCREMENT `group_lottery_gift`
--
ALTER TABLE `group_lottery_gift`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用表AUTO_INCREMENT `group_notice`
--
ALTER TABLE `group_notice`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用表AUTO_INCREMENT `group_sensitive_words`
--
ALTER TABLE `group_sensitive_words`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `group_sidebar`
--
ALTER TABLE `group_sidebar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `group_signin`
--
ALTER TABLE `group_signin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用表AUTO_INCREMENT `group_sms`
--
ALTER TABLE `group_sms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `group_system`
--
ALTER TABLE `group_system`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `group_tourist`
--
ALTER TABLE `group_tourist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `group_user`
--
ALTER TABLE `group_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `group_user_group`
--
ALTER TABLE `group_user_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `group_user_rule`
--
ALTER TABLE `group_user_rule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `group_user_score_log`
--
ALTER TABLE `group_user_score_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `group_version`
--
ALTER TABLE `group_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
