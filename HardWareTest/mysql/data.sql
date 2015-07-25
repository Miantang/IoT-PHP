create table  if not exists `devices` (
        `id` int(11) NOT NULL AUTO_INCREMENT primary key,
        `type` tinytext not null,
        `name` tinytext not null,
        `value` tinytext not null,
        `description` tinytext not null
)DEFAULT CHARSET=utf8;

insert into `devices` (`id`, `type`, `name`, `value`, `description`) values
(1, 'switch', 'led1', '0', '照明灯'),
(2, 'switch', 'curtain', '0', '窗帘'),
(3, 'switch', 'screen', '0', '幕布'),
(4, 'switch', 'tap_water', '0', '自来水'),
(5, 'switch', 'projector', '0', '投影仪'),
(6, 'step', 'camara', '0', '摄像机'),
(7, 'step', 'led2', '{"switch":0,"controller":"0"}', 'LED灯带'),
(8, 'step', 'air', '{"switch":0,"controller":"0"}', '空调'),
(9, 'step', 'tv', '{"switch":0,"controller":"0"}', '电视'),
(10, 'step', 'access', '{"switch":0,"controller":"0"}', '门禁'),
(11, 'step', 'gas', '{"switch":0,"controller":"0"}', '燃气监控'),
(12, 'step', 'volume', '{"switch":0,"controller":"0"}', '音量控制');
/* 
create table  if not exists genericdevices
	(
        `id` int unsigned not null auto_increment primary key,
        timestamp   not null,
        `switch` int not null,
        sound_value not null,
        channel_value 

	);

insert into `genericdevices` (`id`, `name`, ``switch``, `controller`) values
*/
create table  if not exists userlists
	(
        `userid` int(255) not null  auto_increment primary key,
        `username` char(255) not null,
        `password` char(255) not null,
        `realname` tinytext not null,
        `qq` tinytext not null,
        `email` tinytext not null
	)DEFAULT CHARSET=utf8;
insert into `userlists` (`userid`, `username`, `password`, `realname`, `qq`, `email`) values
(1, 'admin', 'admin', 'da', '10000', 'a@a.com');

create table  if not exists feedBackCode
(
	`id` int(255) not null  auto_increment primary key,
	`name` char(255) not null,
	`code` int not null
);
insert into `feedBackCode` (`id`, `name`, `code`) values
(1, 'led1', 1),
(2, 'curtain', 1),
(3, 'screen', 1),
(4, 'tap_water', 1),
(5, 'projector', 1),
(6, 'camara', 1),
(7, 'led2', 1),
(8, 'air', 1),
(9, 'tv', 1),
(10, 'access', 1),
(11, 'gas', 1),
(12, 'volume', 1);
