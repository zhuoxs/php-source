<?php
defined('IN_IA') or exit('Access Denied');

class Plugins{
	
	static function getPlugins($type = 3){
		$styles = Util::traversingFiles(PATH_PLUGIN);
		$pluginsset = array();
		
		foreach ($styles as $key => $value) {
			
			$config = self::ext_plugin_config($value);
			if(!empty($config) && is_array($config)) {
				unset($config['menus']);
				if($type == 1 && $config['setting']['agent'] == 'true'){
					$pluginsset[$value] = $config;
				}elseif($type == 2 && $config['setting']['system'] == 'true'){
					$pluginsset[$value] = $config;
				}elseif($type == 3){
					$pluginsset[$value] = $config;
				}
			}
		}
		return $pluginsset;
	}
	
	static function getCategory(){
		return array(
			'market'  => array('name' => '营销工具'),
			'help' => array('name' => '辅助工具')
		);
	}
	
	static function ext_plugin_config($plugin) {
		$filename = PATH_PLUGIN . $plugin . '/config.xml';
		if (!file_exists($filename)) {
			return array();
		}
		$manifest = self::ext_plugin_config_parse(file_get_contents($filename));
		if (empty($manifest['name']) || $manifest['ident'] != $plugin) {
			return array();
		}
		return $manifest;
	}
	
	static function ext_plugin_config_parse($xml) {
		if (!strexists($xml, '<manifest')) {
			$xml = base64_decode($xml);
		}
		if (empty($xml)) {
			return array();
		}
		$dom = new DOMDocument();
		$dom->loadXML($xml);
		$root = $dom->getElementsByTagName('manifest')->item(0);
		if (empty($root)) {
			return array();
		}
		
		$application = $root->getElementsByTagName('application')->item(0);
		if (empty($application)) {
			return array();
		}
		$manifest = array(
			'name' => trim($application->getElementsByTagName('name')->item(0)->textContent),
			'ident' => trim($application->getElementsByTagName('identifie')->item(0)->textContent),
			'version' => trim($application->getElementsByTagName('version')->item(0)->textContent),
			'category' => trim($application->getElementsByTagName('type')->item(0)->textContent),
			'des' => trim($application->getElementsByTagName('description')->item(0)->textContent),
			'author' => trim($application->getElementsByTagName('author')->item(0)->textContent),
			'url' => trim($application->getElementsByTagName('url')->item(0)->textContent),
		);
		
		$manifest['setting']['agent'] = 'false';
		$manifest['setting']['system'] = 'false';
		$manifest['setting']['task'] = 'false';
		$setting = $root->getElementsByTagName('setting')->item(0);
		if (!empty($setting)) {
			$agent = $setting->getElementsByTagName('agent')->item(0);
			if (!empty($agent) && $agent->getAttribute('embed') == 'true') {
				$manifest['setting']['agent'] = 'true';
			}
			$system = $setting->getElementsByTagName('system')->item(0);
			if (!empty($system) && $system->getAttribute('embed') == 'true') {
				$manifest['setting']['system'] = 'true';
			}
			$task = $setting->getElementsByTagName('task')->item(0);
			if (!empty($task) && $task->getAttribute('embed') == 'true') {
				$manifest['setting']['task'] = 'true';
			}
		}
		
		if (defined('IN_WEB') && $manifest['setting']['agent']) {
			$elm = $root->getElementsByTagName('agentmenu')->item(0);
		}else{
			$elm = $root->getElementsByTagName('systemmenu')->item(0);
		}
		$manifest['menus'] = self::ext_plugin_config_entries($elm,$manifest);
		
		return $manifest;
	}
	
	static function ext_plugin_config_entries($elm,&$manifest) {
		$frames = array();
		$frames['application']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 管理应用';
		$frames['application']['items'] = array();
		$frames['application']['items']['list']['url'] = web_url('app/plugins');
		$frames['application']['items']['list']['title'] = '所有应用';
		$frames['application']['items']['list']['actions'] = array();
		$frames['application']['items']['list']['active'] = '';
		$frames['application']['items']['list']['append']['url'] = web_url('app/plugins');
		$frames['application']['items']['list']['append']['title'] = '<i class="fa fa-plus"></i>';
		
		$menus = $elm->getElementsByTagName('menu');
		foreach ($menus as $i => $cmenu) {
			$frames[$manifest['ident'].$i]['title'] = '<i class="fa '.$cmenu->getAttribute('font').'"></i>&nbsp;&nbsp; '.$cmenu->getAttribute('title');
			$entries = $cmenu->getElementsByTagName('entry');
			for ($j = 0; $j < $entries->length; $j++) {
				$entry = $entries->item($j);
				$ac = $entry->getAttribute('ac');
				$do = $entry->getAttribute('do');
				$iscover = $entry->getAttribute('iscover');
				$actions = json_decode($entry->getAttribute('actions'));
				$actions = !empty($actions)?$actions:array('ac',$ac,'do',$do);
				$row = array(
					'url' => web_url($manifest['ident'].'/'.$ac.'/'.$do),
					'title' => $entry->getAttribute('title'),
					'actions' => $actions,
					'active' => ''
				);
				if($iscover == 'true'){
					$manifest['cover'] = $row['url'];
				}
				if (!empty($row['title']) && !empty($row['url'])) {
					$frames[$manifest['ident'].$i]['items'][$do] = $row;
				}
			}
		}
		return $frames;
	}
}
