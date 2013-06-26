CREATE TABLE `ts_anti_user` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID' ,
`userid`  int(11) NOT NULL DEFAULT 0 COMMENT '用户ID' ,
`addtime`  datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ,
PRIMARY KEY (`id`),
UNIQUE INDEX `userid` (`userid`) USING BTREE 
)
--------------------
ALTER TABLE `ts_user` MODIFY COLUMN `email`  char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户email' AFTER `salt`;
--------------------
ALTER TABLE `ts_user_info` MODIFY COLUMN `email`  char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `username`;
--------------------
ALTER TABLE `ts_user_info` ADD COLUMN `comefrom`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '注册来自0web1手机客户端' AFTER `address`;
--------------------
ALTER TABLE  `ts_user` ADD  `code` CHAR( 32 ) NOT NULL DEFAULT  '' COMMENT  '邮箱验证码' AFTER  `resetpwd`