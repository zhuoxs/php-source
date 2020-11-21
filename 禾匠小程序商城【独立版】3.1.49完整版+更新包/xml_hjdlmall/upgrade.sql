
AlTER TABLE hjmallind_yy_goods ADD video_url varchar(255) DEFAULT NULL COMMENT '视频url';
AlTER TABLE hjmallind_pt_goods ADD video_url varchar(255) DEFAULT NULL COMMENT '视频url';

CREATE TABLE `hjmallind_task`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` varchar(128) NOT NULL,
  `delay_seconds` int(11) NOT NULL COMMENT '多少秒后执行',
  `is_executed` int(1) NOT NULL DEFAULT 0 COMMENT '是否已执行：0=未执行，1=已执行',
  `class` varchar(255) NOT NULL,
  `params` longtext NULL,
  `addtime` int(11) NOT NULL DEFAULT 0,
  `is_delete` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
)  DEFAULT CHARSET=utf8 COMMENT = '定时任务' ROW_FORMAT = Dynamic;
