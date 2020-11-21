<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class CoreModule extends WeModule {
	public $modules = array('basic', 'news', 'image', 'music', 'voice', 'video', 'wxcard', 'keyword', 'module');
	public $tablename = array(
		'basic' => 'basic_reply',
		'news' => 'news_reply',
		'image' => 'images_reply',
		'music' => 'music_reply',
		'voice' => 'voice_reply',
		'video' => 'video_reply',
		'wxcard' => 'wxcard_reply',
		'keyword' => 'basic_reply'
	);
		private $options = array(
		'basic' => true,
		'news' => true,
		'image' => true,
		'music' => true,
		'voice' => true,
		'video' => true,
		'wxcard' => true,
		'keyword' => true,
		'module' => true,
	);
	private $replies = array();

	public function fieldsFormDisplay($rid = 0, $option = array()) {
		global $_GPC, $_W, $setting_keyword;
		load()->model('material');
		load()->model('reply');
		$replies = array();
		switch($_GPC['a']) {
			case 'mass':
				if (!empty($rid) && $rid > 0) {
					$isexists = pdo_get('mc_mass_record', array('id' => $rid), array('media_id', 'msgtype'));
				}
				if (!empty($isexists['media_id']) && !empty($isexists['msgtype'])) {
					$wechat_attachment = material_get($isexists['media_id']);
					switch ($isexists['msgtype']) {
						case 'news':
							if(!empty($wechat_attachment['news'])) {
								foreach ($wechat_attachment['news'] as &$item) {
									$item['thumb_url'] = tomedia($item['thumb_url']);
									$item['media_id'] = $isexists['media_id'];
									$item['attach_id'] = $item['attach_id'];
									$item['perm'] = $wechat_attachment['model'];
								}
								unset($item);
							}
							$replies['news'] = $wechat_attachment['news'];
							break;
						case 'image':
							$replies['image'][0]['img_url'] = tomedia($wechat_attachment['attachment'], true);
							$replies['image'][0]['mediaid'] = $isexists['media_id'];
							break;
						case 'voice':
							$replies['voice'][0]['title'] = $wechat_attachment['filename'];
							$replies['voice'][0]['mediaid'] = $isexists['media_id'];
							break;
						case 'video':
							$replies['video'][0] = iunserializer($wechat_attachment['tag']);
							$replies['video'][0]['mediaid'] = $isexists['media_id'];
							break;
					}
				}
				break;
						default:
				if (!empty($rid)) {
					$rule_rid = $rid;
					if (in_array($_GPC['m'], array('welcome', 'default'))) {
						$rule_rid = pdo_getcolumn('rule_keyword', array('rid' => $rid), 'rid');
					}
					$isexists = reply_single($rule_rid);
				}
				if ($_GPC['m'] == 'special') {
					$default_setting = uni_setting_load('default_message', $_W['uniacid']);
					$default_setting = $default_setting['default_message'] ? $default_setting['default_message'] : array();
					$reply_type = $default_setting[$_GPC['type']]['type'];
					if (empty($reply_type)) {
						if (!empty($default_setting[$_GPC['type']]['keyword'])) {
							$reply_type = 'keyword';
						}
						if (!empty($default_setting[$_GPC['type']]['module'])) {
							$reply_type = 'module';
						}
						if (empty($reply_type)) {
							break;
						}
					}
					if ($reply_type == 'module') {
						$replies['module'][0]['name'] = $default_setting[$_GPC['type']]['module'];
						$module_info = pdo_get('modules', array('name' => $default_setting[$_GPC['type']]['module']));
						$replies['module'][0]['title'] = $module_info['title'];
						if (file_exists(IA_ROOT. "/addons/". $module_info['name']. "/custom-icon.jpg")) {
							$replies['module'][0]['icon'] = "../addons/". $module_info['name']. "/custom-icon.jgp";
						} else {
							$replies['module'][0]['icon'] = "../addons/". $module_info['name']. "/icon.jpg";
						}
					} else {
						$replies['keyword'][0]['name'] = $isexists['name'];
						$replies['keyword'][0]['content'] = $setting_keyword;
						$replies['keyword'][0]['rid'] = $rid;
					}
					break;
				}
				if (!empty($isexists)) {
					$module = $isexists['module'];
					$module = $module == 'images' ? 'image' : $module;

										if ($_GPC['a'] == 'reply' && (!empty($_GPC['m']) && $_GPC['m'] == 'keyword')) {
						foreach ($this->tablename as $key => $tablename) {
							if ($key != 'keyword') {
								$replies[$key] = pdo_fetchall("SELECT * FROM ".tablename($tablename)." WHERE rid = :rid ORDER BY `id`", array(':rid' => $rid));
								switch ($key) {
									case 'image':
										foreach ($replies[$key] as &$img_value) {
											$img = pdo_get('wechat_attachment', array('media_id' => $img_value['mediaid']), array('attachment'));
											$img_value['img_url'] = tomedia($img['attachment'], true);
										}
										unset($img_value);
										break;
									case 'news' :
										foreach ($replies[$key] as &$news_value) {
											if (!empty($news_value) && !empty($news_value['media_id'])) {
												$news_material = material_get($news_value['media_id']);
												if (!is_error($news_material)) {
													$news_value['attach_id'] = $news_material['id'];
													$news_value['model'] = $news_material['model'];
													$news_value['description'] = $news_material['news'][0]['digest'];
													$news_value['thumb'] = tomedia($news_material['news'][0]['thumb_url']);
												}
											} else {
												$news_value['thumb'] = tomedia($news_value['thumb']);
											}
										}
										unset($news_value);
										break;
									case 'video' :
										foreach ($replies[$key] as &$video_value) {
											$video_material = material_get($video_value['mediaid']);
											$video_value['filename'] = $video_material['filename'];
										}
										unset($video_value);
										break;
										
								}
							}
						}
										} else {
						$replies['keyword'][0]['name'] = $isexists['name'];
						$replies['keyword'][0]['rid'] = $rid;
						$replies['keyword'][0]['content'] = $setting_keyword;
					}
				}
				break;
		}
		if(!is_array($option)) {
			$option = array();
		}
		$options = array_merge($this->options, $option);
		include $this->template('display');
	}

	public function fieldsFormValidate($rid = 0) {
		global $_GPC;
				$ifEmpty = 1;
		$reply = '';
		foreach ($this->modules as $key => $value) {
			if(trim($_GPC['reply']['reply_'.$value]) != '') {
				$ifEmpty = 0;
			}
			if( ($value == 'music' || $value == 'video' || $value == 'wxcard' || $value == 'news') && !empty($_GPC['reply']['reply_'.$value])) {
				$reply = ltrim($_GPC['reply']['reply_'.$value], '{');
				$reply = rtrim($reply, '}');
				$reply = explode('},{', $reply);
				foreach ($reply as &$val) {
					$val = htmlspecialchars_decode('{'.$val.'}');
				}
				$this->replies[$value] = $reply;
			}else {
				$this->replies[$value] = htmlspecialchars_decode($_GPC['reply']['reply_'.$value], ENT_QUOTES);
			}
		}
		if($ifEmpty) {
			return error(1, '必须填写有效的回复内容.');
		}
		return '';
	}

	public function fieldsFormSubmit($rid = 0) {
		global $_GPC, $_W;
		$delsql = '';
		foreach ($this->modules as $k => $val) {
			$tablename = $this->tablename[$val];
			if (!empty($tablename)) {
				pdo_delete($tablename, array('rid' => $rid));
			}
		}

		foreach ($this->modules as $val) {
			$replies = array();

			$tablename = $this->tablename[$val];
			if($this->replies[$val]) {
				if(is_array($this->replies[$val])) {
					foreach ($this->replies[$val] as $value) {
						$replies[] = json_decode($value, true);
					}
				}else {
					$replies = explode(',', $this->replies[$val]);
					foreach ($replies as  &$v) {
						$v = json_decode($v);
					}
				}
			}
			switch ($val) {
				case 'basic':
					if(!empty($replies)) {
						foreach($replies as $reply) {
							pdo_insert($tablename, array('rid' => $rid, 'content' => $reply));
						}
					}
					break;
				case 'news':
					if(!empty($replies)) {
						$parent_id = 0;
						$attach_id = 0;
						foreach ($replies as $k=>$reply) {
							if (!empty($attach_id) && $reply['attach_id'] == $attach_id) {
								$reply['parent_id'] = $parent_id;
							}
														if ($reply['model'] == 'local') {
								$reply['mediaid'] = $reply['attach_id'];
							}
							pdo_insert ($tablename, array ('rid' => $rid, 'parent_id' => $reply['parent_id'], 'title' => $reply['title'], 'thumb' => tomedia($reply['thumb']), 'createtime' => $reply['createtime'], 'media_id' => $reply['mediaid'], 'displayorder' => $reply['displayorder'], 'description' => $reply['description'], 'url' => $reply['url']));
							if (empty($attach_id) || $reply['attach_id'] != $attach_id) {
								$parent_id = pdo_insertid();
							}
							$attach_id = $reply['attach_id'] ? $reply['attach_id'] : 0;
						}
					}
					break;
				case 'image':
					if(!empty($replies)) {
						foreach ($replies as $reply) {
							pdo_insert($tablename, array('rid' => $rid, 'mediaid' => $reply, 'createtime' => time()));
						}
					}
					break;
				case 'music':
					if(!empty($replies)) {
						foreach ($replies as $reply) {
							pdo_insert($tablename, array('rid' => $rid, 'title' => $reply['title'], 'url' => $reply['url'], 'hqurl' => $reply['hqurl'], 'description' => $reply['description']));
						}
					}
					break;
				case 'voice':
					if(!empty($replies)) {
						foreach ($replies as $reply) {
							pdo_insert($tablename, array('rid' => $rid, 'mediaid' => $reply, 'createtime' => time()));
						}
					}
					break;
				case 'video':
					if(!empty($replies)) {
						foreach ($replies as $reply) {
							pdo_insert($tablename, array('rid' => $rid, 'mediaid' => $reply['mediaid'], 'title' => $reply['title'], 'description' => $reply['description'], 'createtime' => time()));
						}
					}
					break;
				case 'wxcard':
					if(!empty($replies)) {
						foreach ($replies as $reply) {
							pdo_insert($tablename, array('rid' => $rid, 'title' => $reply['title'], 'card_id' => $reply['mediaid'], 'cid' => $reply['cid'], 'brand_name' => $reply['brandname'], 'logo_url' => $reply['logo_url'], 'success' => $reply['success'], 'error' => $reply['error']));
						}
					}
					break;
			}
		}
		return true;
	}

	public function ruleDeleted($rid = 0) {
		$reply_modules = array("basic", "news", "music", "images", "voice", "video", "wxcard");
		foreach($this->tablename as $tablename) {
			pdo_delete($tablename, array('rid' => $rid));
		}
	}
}