DROP TABLE IF EXISTS card {;}

CREATE TABLE `card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card_type` int(10) unsigned NOT NULL,
  `cardno` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `checkcode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `from_type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sale_time` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci{;}

insert into card (id,card_type,cardno,checkcode,type,from_type,status,sale_time,created_at,updated_at) values ( '6','2','XaJSPtbeqK7kjQNZo+4+fMxOZJeVQM8','DfEHOoGBrf/kkQNZ','0','0','1','0000-00-00 00:00:00','2015-06-24 11:53:20','2015-06-24 11:54:18' ) {;}

insert into card (id,card_type,cardno,checkcode,type,from_type,status,sale_time,created_at,updated_at) values ( '7','0','XfBWadfQqfjk','XfBWadfQqfjk','0','0','2','0000-00-00 00:00:00','2015-06-26 10:49:48','2015-06-26 10:49:48' ) {;}

DROP TABLE IF EXISTS card_bind {;}

CREATE TABLE `card_bind` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cutomer_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `flag` tinyint(4) NOT NULL,
  `opt_type` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci{;}

DROP TABLE IF EXISTS card_log {;}

CREATE TABLE `card_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cardid` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `card_type` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci{;}

insert into card_log (id,uid,cardid,type,card_type,created_at,updated_at) values ( '1','1','6','1','1','2015-06-26 14:40:21','0000-00-00 00:00:00' ) {;}

DROP TABLE IF EXISTS customer {;}

CREATE TABLE `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `openid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `idcard` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `cardid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `system` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL,
  `note` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `from_type` tinyint(4) NOT NULL,
  `picture` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci{;}

insert into customer (id,username,openid,mobile,idcard,address,latitude,longitude,cardid,status,system,version,type,note,from_type,picture,created_at,updated_at) values ( '1','111','11','111','1111','1111','11','11','6','11','1','1','1','11','0','111','0000-00-00 00:00:00','0000-00-00 00:00:00' ) {;}

insert into customer (id,username,openid,mobile,idcard,address,latitude,longitude,cardid,status,system,version,type,note,from_type,picture,created_at,updated_at) values ( '2','222','2221','11','1','11','11','11','6','0','','','0','','0','','0000-00-00 00:00:00','0000-00-00 00:00:00' ) {;}

DROP TABLE IF EXISTS log {;}

CREATE TABLE `log` (
  `user_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `result` tinyint(4) NOT NULL,
  `id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci{;}

insert into log (user_id,type,ip,content,time,result,id) values ( '7','2','1','11111111','2015-06-17 09:37:37','1','1' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','1','1111','2015-06-30 16:40:21','2','2' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-16 11:50:50','1','3' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：1','2015-06-16 11:53:04','1','4' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：1','2015-06-16 11:53:25','1','5' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete','删除菜单：1','2015-06-16 11:53:43','1','6' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/role/add','新增角色：1','2015-06-16 11:55:07','1','7' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/role/authority/13','更新角色1 的权限','2015-06-16 11:56:50','1','8' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/role/status','修改角色1 的状态','2015-06-16 11:57:09','1','9' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/role/update','修改角色：1','2015-06-16 11:57:35','1','10' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/role/delete','删除角色','2015-06-16 11:57:51','1','11' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/department/add','新增部门 1 ','2015-06-16 11:59:30','1','12' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/department/status','修改部门 1 的状态','2015-06-16 11:59:58','1','13' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/department/update','修改部门 1','2015-06-16 12:00:04','1','14' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/department/delete','删除部门 1','2015-06-16 12:00:19','1','15' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/user/add','新增用户 11','2015-06-16 12:01:31','1','16' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/user/status','修改用户 11 的状态','2015-06-16 12:01:40','1','17' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/user/update','修改用户:admin','2015-06-16 12:04:37','1','18' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/user/update','修改用户:admin','2015-06-16 12:05:34','1','19' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/user/delete','删除用户:1','2015-06-16 12:06:32','1','20' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/user/add','新增用户:111','2015-06-16 12:08:53','1','21' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/user/delete-batch','批量删除用户','2015-06-16 12:09:04','1','22' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：卡类型管理','2015-06-16 15:28:36','1','23' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-16 17:47:42','1','24' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-16 17:54:24','1','25' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-17 09:01:54','1','26' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-17 10:11:05','1','27' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-17 10:11:34','1','28' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/card/add','增加卡：1','2015-06-17 10:25:23','1','29' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/card/update','更新卡：1','2015-06-17 11:15:09','1','30' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/card/update','更新卡：1','2015-06-17 11:15:27','1','31' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/card/update','更新卡：12222','2015-06-17 11:15:53','1','32' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/card/add','增加卡：1','2015-06-17 11:27:45','1','33' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：客户管理','2015-06-17 11:53:36','1','34' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-17 14:06:49','1','35' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/card/update','更新卡：12222','2015-06-17 14:07:20','1','36' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/card/type-add','新增卡类型：2','2015-06-17 14:07:38','1','37' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/card/update','更新卡：12222','2015-06-17 14:07:57','1','38' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：虚拟卡发码','2015-06-17 14:12:11','1','39' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：商家信息','2015-06-17 14:12:50','1','40' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：行业','2015-06-17 14:13:24','1','41' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：商圈','2015-06-17 14:13:43','1','42' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：商户','2015-06-17 14:14:02','1','43' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：活动','2015-06-17 14:14:22','1','44' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：优惠券','2015-06-17 14:15:02','1','45' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/card/type-update','修改卡类型：1','2015-06-17 14:22:39','1','46' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：卡池管理','2015-06-17 14:23:25','1','47' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：1','2015-06-17 14:36:38','1','48' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete','删除菜单：1','2015-06-17 14:36:49','1','49' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/role/authority/11','更新角色管理员 的权限','2015-06-17 14:46:02','1','50' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/role/authority/11','更新角色管理员 的权限','2015-06-17 14:46:22','1','51' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/card/type-delete','删除卡类型：1','2015-06-17 14:48:42','1','52' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/card/type-update','修改卡类型：2222','2015-06-17 15:03:31','1','53' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：内容管理','2015-06-17 17:41:54','1','54' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：公司简介','2015-06-17 17:42:34','1','55' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：帮助信息','2015-06-17 17:42:52','1','56' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：新闻公告','2015-06-17 17:43:10','1','57' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：广告管理','2015-06-17 17:43:27','1','58' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：首页轮播广告','2015-06-17 17:44:01','1','59' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：ETC和旅游页广告','2015-06-17 17:44:18','1','60' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：内容类型管理','2015-06-17 17:44:43','1','61' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：发布平台管理','2015-06-17 17:45:02','1','62' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete-batch','批量删除菜单','2015-06-17 17:46:00','1','63' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete','删除菜单：发布平台管理','2015-06-17 17:46:35','1','64' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：帮助信息','2015-06-17 17:46:55','1','65' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：首页轮播广告','2015-06-17 17:49:13','1','66' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：ETC和旅游页广告','2015-06-17 17:49:31','1','67' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：内容类型管理','2015-06-17 17:49:57','1','68' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：发布平台管理','2015-06-17 17:51:57','1','69' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：微信自定义菜单','2015-06-17 17:52:19','1','70' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：微信素材管理','2015-06-17 17:52:44','1','71' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：卡产品介绍','2015-06-17 17:53:04','1','72' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：微信素材管理','2015-06-17 17:53:47','1','73' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete','删除菜单：微信素材管理','2015-06-17 17:56:23','1','74' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：卡产品介绍','2015-06-17 18:02:33','1','75' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-23 08:59:38','1','76' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/card/type-update','修改卡类型：ETC','2015-06-23 09:28:11','1','77' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/card/add','增加卡：111','2015-06-23 09:35:37','1','78' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-23 13:56:46','1','79' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/card/add','增加卡：1','2015-06-23 14:30:06','1','80' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-24 09:16:53','1','81' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/card/type-add','新增卡类型：ETC','2015-06-24 10:59:23','1','82' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/card/delete','删除卡：XfBWadfQqfjk','2015-06-24 11:52:17','1','83' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/card/delete','删除卡：XfBWadfQqfjk','2015-06-24 11:52:22','1','84' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/card/delete','删除卡：XfBWadfQqfjk','2015-06-24 11:52:26','1','85' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/card/delete','删除卡：XfBWadfQqfjk','2015-06-24 11:52:31','1','86' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/card/delete','删除卡：XfBWadfQqfjk','2015-06-24 11:52:35','1','87' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/card/type-delete','删除卡类型：ETC','2015-06-24 11:52:49','1','88' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/card/update','更新卡：2.2222222222222','2015-06-24 11:54:18','1','89' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-25 09:01:15','1','90' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-25 10:32:36','1','91' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/card/update','更新卡：2.2222222222222','2015-06-25 14:39:32','1','92' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-25 15:23:19','1','93' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-26 09:10:12','1','94' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-26 10:34:09','1','95' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-26 13:49:14','1','96' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-26 13:49:47','1','97' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/card/type-add','新增卡类型：11','2015-06-26 17:26:37','1','98' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-29 09:06:36','1','99' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：虚拟卡发码','2015-06-29 10:30:10','1','100' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-29 11:22:59','1','101' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-30 09:04:20','1','102' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-30 09:08:28','1','103' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-06-30 17:03:30','1','104' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-01 09:58:28','1','105' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-01 12:01:18','1','106' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-01 14:35:36','1','107' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/department/add','新增部门:1 ','2015-07-01 14:55:57','1','108' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/department/add','新增部门:2 ','2015-07-01 14:56:18','1','109' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-02 09:21:06','1','110' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-02 14:04:02','1','111' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-02 15:09:13','1','112' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-02 15:09:13','1','113' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-03 09:07:44','1','114' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-03 09:19:35','1','115' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-03 14:14:04','1','116' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-06 09:02:29','1','117' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-06 13:56:01','1','118' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-07 09:17:02','1','119' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-07 10:27:25','1','120' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-07 14:21:29','1','121' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-08 09:06:57','1','122' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete','删除菜单：活动','2015-07-08 11:03:47','1','123' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete','删除菜单：优惠券','2015-07-08 11:03:58','1','124' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：行业管理','2015-07-08 11:04:17','1','125' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：商圈管理','2015-07-08 11:04:26','1','126' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：商圈管理','2015-07-08 11:04:31','1','127' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：商户管理','2015-07-08 11:04:40','1','128' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：活动管理','2015-07-08 11:16:54','1','129' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：优惠券','2015-07-08 11:17:56','1','130' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：优惠券','2015-07-08 11:17:56','1','131' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete','删除菜单：优惠券','2015-07-08 11:18:35','1','132' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：优惠券管理','2015-07-08 11:18:59','1','133' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-08 14:18:57','1','134' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-08 16:02:56','1','135' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete-batch','批量删除菜单','2015-07-08 17:54:08','1','136' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-09 09:05:31','1','137' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-09 09:49:25','1','138' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：帮助信息','2015-07-09 15:20:27','1','139' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：卡产品介绍','2015-07-09 15:39:09','1','140' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-09 17:11:18','1','141' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-10 09:05:19','1','142' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/product/add','新增产品介绍：1','2015-07-10 10:08:13','1','143' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/product/add','新增产品介绍：1111','2015-07-10 10:23:37','1','144' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/product/delete','删除产品介绍：1111','2015-07-10 10:26:43','1','145' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/product/add','新增产品介绍：1111111','2015-07-10 10:27:19','1','146' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/product/update','修改产品介绍：1111111','2015-07-10 10:38:52','1','147' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/product/update','修改产品介绍：1111111','2015-07-10 10:41:58','1','148' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/product/update','修改产品介绍：1111111','2015-07-10 10:42:36','1','149' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/product/update','修改产品介绍：1111111','2015-07-10 10:42:50','1','150' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/product/update','修改产品介绍：1111111','2015-07-10 10:46:19','1','151' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/product/update','修改产品介绍：1111111','2015-07-10 10:47:16','1','152' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：内容类型管理','2015-07-10 10:52:36','1','153' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-10 14:20:00','1','154' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-10 14:20:00','1','155' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/contentType/add','新增内容类型:111','2015-07-10 14:50:08','1','156' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/contentType/add','新增内容类型:一卡通','2015-07-10 14:51:21','1','157' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/contentType/add','新增内容类型:请求','2015-07-10 14:53:21','1','158' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/contentType/delete','删除内容类型:一卡通','2015-07-10 14:57:45','1','159' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/contentType/update','修改内容类型:111','2015-07-10 15:04:47','1','160' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-13 09:14:03','1','161' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：首页轮播广告','2015-07-13 09:28:48','1','162' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：ETC和旅游页广告','2015-07-13 09:29:17','1','163' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/carousel/add','新增首页轮播图:1','2015-07-13 10:37:48','1','164' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/carousel/delete','删除轮播图：data/1436754953_a709805494c1374fd7e9dc2d592826fb.png','2015-07-13 11:12:20','1','165' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/carousel/add','新增首页轮播图:2','2015-07-13 11:12:51','1','166' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/carousel/add','新增首页轮播图:3','2015-07-13 11:27:20','1','167' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/carousel/update','修改首页轮播图:3','2015-07-13 11:35:28','1','168' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/carousel/update','修改首页轮播图:2','2015-07-13 11:36:40','1','169' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/carousel/update','修改首页轮播图:3','2015-07-13 11:40:45','1','170' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/carousel/update','修改首页轮播图:3','2015-07-13 11:41:27','1','171' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-13 14:05:05','1','172' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：ETC和旅游页广告','2015-07-13 14:05:52','1','173' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/carousel/add','新增首页轮播图:4','2015-07-13 14:14:42','1','174' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/carousel/delete','删除轮播图：data/1436768078_a4826fabdfd5a908843d432dea509147.png','2015-07-13 14:24:12','1','175' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/carousel/update','修改首页轮播图:3','2015-07-13 14:29:52','1','176' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/carousel/update','修改ETC轮播图:3','2015-07-13 14:31:38','1','177' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/carousel/add','新增旅游轮播图:5','2015-07-13 14:33:17','1','178' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/carousel/add','新增ETC轮播图:6','2015-07-13 14:54:19','1','179' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/carousel/add','新增ETC轮播图:7','2015-07-13 14:56:41','1','180' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/carousel/update','修改ETC轮播图:3','2015-07-13 14:57:53','1','181' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-14 09:10:18','1','182' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-14 09:10:18','1','183' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-14 14:16:16','1','184' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：公司简介','2015-07-14 14:42:26','1','185' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：公司简介','2015-07-14 14:43:34','1','186' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-15 09:01:40','1','187' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：新闻公告','2015-07-15 09:41:42','1','188' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-15 11:26:39','1','189' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：活动','2015-07-15 12:04:39','1','190' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：优惠券','2015-07-15 12:04:58','1','191' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete-batch','批量删除菜单','2015-07-15 12:07:50','1','192' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete','删除菜单：广告管理','2015-07-15 15:41:42','1','193' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','2','http://127.0.0.1/menu/delete','删除菜单：发布平台管理','2015-07-15 15:42:00','1','194' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：网点管理','2015-07-15 17:03:57','1','195' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：站点管理','2015-07-15 17:04:20','1','196' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：交易管理','2015-07-15 17:04:39','1','197' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：缴费管理','2015-07-15 17:04:51','1','198' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/contentType/update','修改内容类型:公司简介','2015-07-15 17:06:16','1','199' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-16 11:19:22','1','200' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-17 09:14:02','1','201' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：微信自定义菜单','2015-07-17 09:38:44','1','202' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-17 14:16:00','1','203' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-20 09:01:44','1','204' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-20 10:00:12','1','205' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-20 16:25:42','1','206' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：微信素材管理','2015-07-20 16:37:10','1','207' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-21 09:11:04','1','208' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-21 14:07:23','1','209' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-22 09:05:56','1','210' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：网点设置','2015-07-22 14:37:39','1','211' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-23 09:08:12','1','212' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-23 09:10:09','1','213' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-23 09:41:32','1','214' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-23 10:39:03','1','215' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：站点信息','2015-07-23 11:49:14','1','216' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-23 14:20:12','1','217' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-23 14:20:13','1','218' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：合作网站','2015-07-23 17:54:49','1','219' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：客服管理','2015-07-23 17:55:18','1','220' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-24 09:05:56','1','221' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-24 09:05:56','1','222' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-24 09:05:57','1','223' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：数据备份','2015-07-24 11:38:34','1','224' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','1','http://127.0.0.1/menu/add','新增菜单：App发布','2015-07-24 11:38:58','1','225' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-24 13:55:23','1','226' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-24 14:26:02','1','227' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-27 09:16:41','1','228' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','3','http://127.0.0.1/menu/update','修改菜单：数据备份','2015-07-27 10:43:31','1','229' ) {;}

insert into log (user_id,type,ip,content,time,result,id) values ( '6','4','http://127.0.0.1/main/log-in','登录','2015-07-27 16:14:49','1','230' ) {;}

DROP TABLE IF EXISTS pay_code {;}

CREATE TABLE `pay_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cardid` int(11) NOT NULL,
  `orderid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `from_type` tinyint(4) NOT NULL,
  `expire` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=556 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci{;}

insert into pay_code (id,uid,cardid,orderid,token,from_type,expire,created_at) values ( '1','1','6','1','111','0','0000-00-00 00:00:00','0000-00-00 00:00:00' ) {;}

insert into pay_code (id,uid,cardid,orderid,token,from_type,expire,created_at) values ( '2','1','7','1','111','0','0000-00-00 00:00:00','0000-00-00 00:00:00' ) {;}

insert into pay_code (id,uid,cardid,orderid,token,from_type,expire,created_at) values ( '555','1','7','1','111','0','0000-00-00 00:00:00','0000-00-00 00:00:00' ) {;}

