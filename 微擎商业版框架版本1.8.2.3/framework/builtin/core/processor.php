<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class CoreModuleProcessor extends WeModuleProcessor {

	public function respond() {

		$reply_type = $this->reply_type;
		$key = array_rand($reply_type);
		$type = $reply_type[$key];
		switch($type) {
			case 'basic':
				$result = $this->basic_respond();
				return $this->respText($result);
				break;
			case 'images':
				$result = $this->image_respond();
				return $this->respImage($result);
				break;
			case 'music':
				$result = $this->music_respond();
				return $this->respMusic(array(
						'Title'	=> $result['title'],
						'Description' => $result['description'],
						'MusicUrl' => $result['url'],
						'HQMusicUrl' => $result['hqurl'],
					));
				break;
			case 'news':
				$result = $this->news_respond();
				return $this->respNews($result);
				break;
			case 'voice':
				$result = $this->voice_respond();
				return $this->respVoice($result);
				break;
			case 'video':
				$result = $this->video_respond();
				return $this->respVideo(array(
						'MediaId' => $result['mediaid'],
						'Title' => $result['title'],
						'Description' => $result['description']
					));
				break;
		}
	}

	private function basic_respond() {
		$sql = "SELECT * FROM " . tablename('basic_reply') . " WHERE `rid` IN ({$this->rule})  ORDER BY RAND() LIMIT 1";
		$reply = pdo_fetch($sql);
		if (empty($reply)) {
			return false;
		}
		$reply['content'] = htmlspecialchars_decode($reply['content']);
				$reply['content'] = str_replace(array('<br>', '&nbsp;'), array("\n", ' '), $reply['content']);
		$reply['content'] = strip_tags($reply['content'], '<a>');
		return $reply['content'];
	}

	private function image_respond() {
		global $_W;
		$rid = $this->rule;
		$sql = "SELECT `mediaid` FROM " . tablename('images_reply') . " WHERE `rid`=:rid ORDER BY RAND()";
		$mediaid = pdo_fetchcolumn($sql, array(':rid' => $rid));
		if (empty($mediaid)) {
			return false;
		}
		return $mediaid;
	}

	private function music_respond() {
		global $_W;
		$rid = $this->rule;
		$sql = "SELECT * FROM " . tablename('music_reply') . " WHERE `rid`=:rid ORDER BY RAND()";
		$item = pdo_fetch($sql, array(':rid' => $rid));
		if (empty($item['id'])) {
			return false;
		}
		return $item;
	}

	private function news_respond() {
		global $_W;
		load()->model('material');
		$rid = $this->rule;
		$sql = "SELECT * FROM " . tablename('news_reply') . " WHERE rid = :id AND parent_id = -1 ORDER BY displayorder DESC, id ASC LIMIT 8";
		$commends = pdo_fetchall($sql, array(':id' => $rid));
		if (empty($commends)) {
						$sql = "SELECT * FROM " . tablename('news_reply') . " WHERE rid = :id AND parent_id = 0 ORDER BY RAND()";
			$main = pdo_fetch($sql, array(':id' => $rid));
			if(empty($main['id'])) {
				return false;
			}
			$sql = "SELECT * FROM " . tablename('news_reply') . " WHERE id = :id OR parent_id = :parent_id ORDER BY displayorder ASC, id ASC LIMIT 8";
			$commends = pdo_fetchall($sql, array(':id'=>$main['id'], ':parent_id'=>$main['id']));
		}
		if(empty($commends)) {
			return false;
		}
		$news = array();
		if (!empty($commends[0]['media_id'])) {
			$news = material_build_reply($commends[0]['media_id']);
		}
		foreach($commends as $key => $commend) {
			$row = array();
			if (!empty($commend['media_id'])) {
				if (empty($news[$key]['url'])) {
					$news[$key]['url'] = $this->createMobileUrl('detail', array('id' => $commend['id']));
				}
			} else {
				$row['title'] = $commend['title'];
				$row['description'] = $commend['description'];
				!empty($commend['thumb']) && $row['picurl'] = tomedia($commend['thumb']);
				$row['url'] = empty($commend['url']) ? $this->createMobileUrl('detail', array('id' => $commend['id'])) : $commend['url'];
				$news[] = $row;
			}
		}
		return $news;
	}

	private function voice_respond() {
		global $_W;
		$rid = $this->rule;
		$sql = "SELECT `mediaid` FROM " . tablename('voice_reply') . " WHERE `rid`=:rid ORDER BY RAND()";
		$mediaid = pdo_fetchcolumn($sql, array(':rid' => $rid));
		if (empty($mediaid)) {
			return false;
		}
		return $mediaid;
	}

	private function video_respond() {
		global $_W;
		$rid = $this->rule;
		$sql = "SELECT * FROM " . tablename('video_reply') . " WHERE `rid`=:rid ORDER BY RAND()";
		$item = pdo_fetch($sql, array(':rid' => $rid));
		if (empty($item)) {
			return false;
		}
		return $item;
	}
}
