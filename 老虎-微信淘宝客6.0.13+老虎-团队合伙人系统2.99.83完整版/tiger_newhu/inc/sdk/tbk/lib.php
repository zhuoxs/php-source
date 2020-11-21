<?php
class Utilities
{
	static function sl_read_file($file, $callback ,$parameterArray=array(),&$quoteArray=NULL ,$fromlines=0) 
	{
		if(!$fp = fopen($file, 'r')) {
		 return false;
		}
		$cursor = 0;
		while (false !== ($line = fgets($fp)))
		{
			if($cursor<$fromlines)
			{
				$cursor++;
				continue;
			}
			$continue =	$callback(
									array_merge(
													array('fp'=>$fp,'cursor'=>$cursor,'text'=>$line),
													$parameterArray
												),
									$quoteArray
								  );
			if($continue===false) break; 
			$cursor++;
		}
		fclose($fp);
	}
	
	static function callback_len_sort($a,$b)
	{
		if(strlen($a)==strlen($b)) return 0;
		else if(strlen($a)<strlen($b)) return 1;
		else return -1;
	}

	static function arrayND_to_D($arr)
	{
		$returnArr = array();
		foreach($arr as $v)
		{
			if(is_array($v))
			{
				$returnArr = array_merge($returnArr,self::arrayND_to_D($v));
			}
			else
			{
				$returnArr[] = $v;
			}
		}
		return array_unique($returnArr);
	}	
	function selectFromArray($data,$default='')   	
	{	
		$return = '';
	
		foreach($data as $key=>$value)
	
		{
	
			if($default==$key) $checked = " selected ";
	
			else $checked = '';
	
			$return.= '<option'.$checked.' value="'.$key.'">'.$value.'</option>'."\n";
	
		}
	
		return $return;	
	}
	

	
	static function stringToNumber($str,$start,$end) 
	{
		$max = strlen($str)*255;
		$stringCalc = self::stringCalc($str);
		return round((float)(($end-$start)*$stringCalc/$max)+$start);
	}
	
	
	static function inputEncode($input) {
	
		# rawurlencode() does almost everything so start with that
		$input = rawurlencode($input);
	
		# Periods are not encoded and PHP doesn't accept them in incoming
		# variable names so encode them too
		$input = str_replace('.', '%2E', $input);
	
		# [] can be used to create an array so preserve them
		$input = str_replace('%5B', '[', $input);
		$input = str_replace('%5D', ']', $input);
	
		# And return changed
		return $input;
	}
	
	# And the complementary decode
	static function inputDecode($input) {
		return rawurldecode($input);
	}
	
	static function stringCalc($str,$format=1)
	{
		switch($format)
		{
			case 1:
				$num = 0;
				for($i=0;$i<strlen($str);$i++) 
				{
					$num+=ord($str[$i]);
				}
			break;
			case 2:
				$num = 1;
				for($i=0;$i<strlen($str);$i++)
				{
					$num*=ord($str[$i]);
				}
			break;
		}
		return $num;
	}
	
	static function _createDir($fullpath='') 
	{ 
	  if   (!is_dir($fullpath))
	  { 
		$temp   =   explode( '/',$fullpath); 
		$cur_dir   =   ''; 
		for($i   =   0;$i   <   count($temp);$i++)
		{ 
		  $cur_dir   .=   $temp[$i]. '/'; 
		  if   (!is_dir($cur_dir))
		  { 
			  @mkdir($cur_dir,0777); 
			  @chmod($cur_dir,0777); 
		  } 
		} 
	  } 
	}
	
	static function sl_file_get_contents($file)
	{
		self::_createDir(dirname($file));
		if(!file_exists($file))
		{
			touch($file);
			return '';
		}
		else
		{
			return file_get_contents($file);
		}
	}
	
	#字符串驼峰化
	static function stringHumpFormat($string) //匹配首字母、空格后面的字母、-后面的字母
	{
		
		return preg_replace_callback("/((\s|-)+|^)([a-z])/",function($matches){return $matches[1].strtoupper($matches[3]);},strtolower($string));
	}
	
	static function sl_http_build_query($array)
	{
		$output = http_build_query($array);
		foreach($array as $k=>$v)
		{
			if(is_array($v))
			{
				if(!strstr($k,'[]'))
				{
					$output = preg_replace("/$k%5B\d+%5D/i",$k,$output);
				}
			}
		}
		return $output;
	}

	static function searchClosestContainer($content,$start,$end,$search ,$return='find',$replace='')//$replace 仅当$return=from时有效
	{
		
		$success = true;
		$searchPos = strpos($content,$search);
		if($searchPos===false)
		{
			$success=false;
		}
		else
		{
			$searchFromStr = substr($content,$searchPos);
			if(($tmp=strpos($searchFromStr,$end))===false)
			{
				$success=false;
			}
			else
			{
				$endPos = $searchPos+$tmp+strlen($end);
				$searchToStr = substr($content,0,$searchPos);
				if(($tmp=strpos(strrev($searchToStr),strrev($start)))===false)
				{
					$success=false;
				}
				else
				{
					$startPos = strlen($searchToStr)-$tmp- strlen($start);
				}
			}
		}
		if($return=='find')		
		{
			if($success)
				return substr($content,$startPos,$endPos-$startPos);
			else
				return '';
		}
		else if($return=='from') 
		{
			if($success)
				return substr_replace($content,$replace,$startPos,$endPos-$startPos);
			else
				return $content;
		}
	}
	
	static function getFormInputs($content,$search)
	{
		  $formObj = array();
		  $inputArray = array();
		  $formContent = self::searchClosestContainer($content,'<form','</form>',$search);
		  preg_match('/<form[\s\S]+?action=[\'"](.*?)[\'"]/i',$formContent,$actionMatch);
		  $formObj['action'] = $actionMatch[1];
		  preg_match_all('/<input [^>]*?name=["\']([^>]*?)["\'][^>]*?value=["\']([^>]*?)["\'][^>]*?>/i',$formContent,$matches1);
		  foreach($matches1[0] as $k=>$v)
		  {
			  if(!isset($inputArray[$matches1[1][$k]]))
			  {
				 $inputArray[$matches1[1][$k]] = $matches1[2][$k]; 
			  }
			  else if(!is_array($inputArray[$matches1[1][$k]]))
			  {
				  $inputArray[$matches1[1][$k]] = array($inputArray[$matches1[1][$k]],$matches1[2][$k]);
			  }
			  else
			  {
				   $inputArray[$matches1[1][$k]][] = $matches1[2][$k];
			  }
		  }
		  preg_match_all('/<input [^>]*?value="([^>]*?)"[^>]*?name="([^>]*?)"[^>]*?>/i',$formContent,$matches2);
		  foreach($matches2[0] as $k=>$v)
		  {		  
			  if(!isset($inputArray[$matches2[2][$k]]))
			  {
				 $inputArray[$matches2[2][$k]] = $matches2[1][$k]; 
			  }
			  else if(!is_array($inputArray[$matches2[2][$k]]))
			  {
				  $inputArray[$matches2[2][$k]] = array($inputArray[$matches2[2][$k]],$matches2[1][$k]);
			  }
			  else
			  {
				   $inputArray[$matches2[2][$k]][] = $matches2[1][$k];
			  }
			  
		  }
		  $formObj['input'] = $inputArray;
		  return $formObj;
	}
	
	static	function sl_ob_end_flush()
	{
			for($i=0;$i<4960;$i++) echo " ";
			@ob_flush();
			@ob_end_flush();
	}
	
	static function getCountryCodeFromContent($str)
	{
		$array = explode(',',strtolower($str));
		foreach($array as $item)
		{
			if($code=self::getCountryCode($item)) return $code;
		}
		return false;
	}
	
	static function getCountryCode($str)
	{
		$str = strtolower(trim($str));
		$country = array('af'=>'afghanistan','al'=>'albania','dz'=>'algeria','as'=>'american samoa','ad'=>'andorra','ao'=>'angola','ai'=>'anguilla','aq'=>'antarctica','ag'=>'antigua and barbuda','ar'=>'argentina','am'=>'armenia','aw'=>'aruba','ac'=>'ascension island','au'=>'australia','at'=>'austria','az'=>'azerbaijan','bs'=>'bahamas','bh'=>'bahrain','bd'=>'bangladesh','bb'=>'barbados','by'=>'belarus','be'=>'belgium','bz'=>'belize','bj'=>'benin','bm'=>'bermuda','bt'=>'bhutan','bo'=>'bolivia','ba'=>'bosnia and herzegovina','bw'=>'botswana','bv'=>'bouvet island','br'=>'brazil','io'=>'british indian ocean territory','bn'=>'brunei darussalam','bg'=>'bulgaria','bf'=>'burkina faso','bi'=>'burundi','kh'=>'cambodia','cm'=>'cameroon','ca'=>'canada','cv'=>'cape verde islands','ky'=>'cayman islands','cf'=>'central african republic','td'=>'chad','cl'=>'chile','cn'=>'china','cx'=>'christmas island','cc'=>'cocos (keeling) islands','co'=>'colombia','km'=>'comoros','cd'=>'congo, democratic republic of','cg'=>'congo, republic of','ck'=>'cook islands','cr'=>'costa rica','ci'=>'cote d\'ivoire','hr'=>'croatia/hrvatska','cw'=>'curacao','cy'=>'cyprus','cz'=>'czech republic','dk'=>'denmark','dj'=>'djibouti','dm'=>'dominica','do'=>'dominican republic','tp'=>'east timor','ec'=>'ecuador','eg'=>'egypt','sv'=>'el salvador','gq'=>'equatorial guinea','er'=>'eritrea','ee'=>'estonia','et'=>'ethiopia','fk'=>'falkland islands','fo'=>'faroe islands','fj'=>'fiji','fi'=>'finland','fr'=>'france','gf'=>'french guiana','pf'=>'french polynesia','tf'=>'french southern territories','ga'=>'gabon','gm'=>'gambia','ge'=>'georgia','de'=>'germany','gh'=>'ghana','gi'=>'gibraltar','gr'=>'greece','gl'=>'greenland','gd'=>'grenada','gp'=>'guadeloupe','gu'=>'guam','gt'=>'guatemala','gg'=>'guernsey','gn'=>'guinea','gw'=>'guinea-bissau','gy'=>'guyana','ht'=>'haiti','hm'=>'heard and mcdonald islands','hn'=>'honduras','hk'=>'hong kong','hu'=>'hungary','is'=>'iceland','in'=>'india','id'=>'indonesia','iq'=>'iraq','ie'=>'ireland','im'=>'isle of man','il'=>'israel','it'=>'italy','jm'=>'jamaica','jp'=>'japan','je'=>'jersey','jo'=>'jordan','kz'=>'kazakhstan','ke'=>'kenya','ki'=>'kiribati','kr'=>'korea, republic of (south korea)','kv'=>'kosovo','kw'=>'kuwait','kg'=>'kyrgyzstan','la'=>'laos','lv'=>'latvia','lb'=>'lebanon','ls'=>'lesotho','lr'=>'liberia','ly'=>'libya','li'=>'liechtenstein','lt'=>'lithuania','lu'=>'luxembourg','mo'=>'macau','mk'=>'macedonia','mg'=>'madagascar','mw'=>'malawi','my'=>'malaysia','mv'=>'maldives','ml'=>'mali','mt'=>'malta','mh'=>'marshall islands','mq'=>'martinique','mr'=>'mauritania','mu'=>'mauritius','yt'=>'mayotte island','mx'=>'mexico','fm'=>'micronesia','md'=>'moldova','mc'=>'monaco','mn'=>'mongolia','me'=>'montenegro','ms'=>'montserrat','ma'=>'morocco','mz'=>'mozambique','mm'=>'myanmar','na'=>'namibia','nr'=>'nauru','np'=>'nepal','nl'=>'netherlands','nc'=>'new caledonia','nz'=>'new zealand','ni'=>'nicaragua','ne'=>'niger','ng'=>'nigeria','nu'=>'niue','nf'=>'norfolk island','mp'=>'northern mariana islands','no'=>'norway','om'=>'oman','pk'=>'pakistan','pw'=>'palau','ps'=>'palestinian territories','pa'=>'panama','pg'=>'papua new guinea','py'=>'paraguay','pe'=>'peru','ph'=>'philippines','pn'=>'pitcairn island','pl'=>'poland','pt'=>'portugal','pr'=>'puerto rico','qa'=>'qatar','re'=>'reunion island','ro'=>'romania','ru'=>'russian federation','rw'=>'rwanda','sh'=>'saint helena','kn'=>'saint kitts and nevis','lc'=>'saint lucia','pm'=>'saint pierre and miquelon','vc'=>'saint vincent and the grenadines','sm'=>'san marino','st'=>'sao tome and principe','sa'=>'saudi arabia','sn'=>'senegal','rs'=>'serbia','sc'=>'seychelles','sl'=>'sierra leone','sg'=>'singapore','sx'=>'sint maarten','sk'=>'slovak republic','si'=>'slovenia','sb'=>'solomon islands','so'=>'somalia','za'=>'south africa','gs'=>'south georgia and south sandwich islands','es'=>'spain','lk'=>'sri lanka','sr'=>'suriname','sj'=>'svalbard and jan mayen islands','sz'=>'swaziland','se'=>'sweden','ch'=>'switzerland','tw'=>'taiwan','tj'=>'tajikistan','tz'=>'tanzania','th'=>'thailand','tl'=>'timor-leste','tg'=>'togo','tk'
=>'tokelau','to'=>'tonga islands','tt'=>'trinidad and tobago','tn'=>'tunisia','tr'=>'turkey','tm'=>'turkmenistan','tc'=>'turks and caicos islands','tv'=>'tuvalu','ug'=>'uganda','ua'=>'ukraine','ae'=>'united arab emirates','uk'=>'united kingdom','us'=>'united states','uy'=>'uruguay','um'=>'us minor outlying islands','uz'=>'uzbekistan','vu'=>'vanuatu','va'=>'vatican city','ve'=>'venezuela','vn'=>'vietnam','vg'=>'virgin islands (british)','vi'=>'virgin islands (usa)','wf'=>'wallis and futuna islands','eh'=>'western sahara','ws'=>'western samoa','ye'=>'yemen','zm'=>'zambia','zw'=>'zimbabwe');
	$usStats = array("Alabama"=>"Alabama","Alaska"=>"Alaska","American Samoa"=>"American Samoa","Arizona"=>"Arizona","Arkansas"=>"Arkansas","Armed Forces America"=>"Armed Forces America","Armed Forces Other Areas"=>"Armed Forces Other Areas","Armed Forces Pacific"=>"Armed Forces Pacific","California"=>"California","Colorado"=>"Colorado","Connecticut"=>"Connecticut","Delaware"=>"Delaware","District of Columbia"=>"District of Columbia","Federated States of Micronesia"=>"Federated States of Micronesia","Florida"=>"Florida","Georgia"=>"Georgia","Guam"=>"Guam","Hawaii"=>"Hawaii","Idaho"=>"Idaho","Illinois"=>"Illinois","Indiana"=>"Indiana","Iowa"=>"Iowa","Kansas"=>"Kansas","Kentucky"=>"Kentucky","Louisiana"=>"Louisiana","Maine"=>"Maine","Marshall Islands"=>"Marshall Islands","Maryland"=>"Maryland","Massachusetts"=>"Massachusetts","Michigan"=>"Michigan","Minnesota"=>"Minnesota","Mississippi"=>"Mississippi","Missouri"=>"Missouri","Montana"=>"Montana","Nebraska"=>"Nebraska","Nevada"=>"Nevada","New Hampshire"=>"New Hampshire","New Jersey"=>"New Jersey","New Mexico"=>"New Mexico","New York"=>"New York","North Carolina"=>"North Carolina","North Dakota"=>"North Dakota","Northern Mariana Islands"=>"Northern Mariana Islands","Ohio"=>"Ohio","Oklahoma"=>"Oklahoma","Oregon"=>"Oregon","Palau"=>"Palau","Pennsylvania"=>"Pennsylvania","Puerto Rico"=>"Puerto Rico","Rhode Island"=>"Rhode Island","South Carolina"=>"South Carolina","South Dakota"=>"South Dakota","Tennessee"=>"Tennessee","Texas"=>"Texas","U.S. Virgin Islands"=>"U.S. Virgin Islands","Utah"=>"Utah","Vermont"=>"Vermont","Virginia"=>"Virginia","Washington"=>"Washington","West Virginia"=>"West Virginia","Wisconsin"=>"Wisconsin","Wyoming"=>"Wyoming");
		if($code = array_search($str,$country)) return $code;
		else if(isset($country[$str])) return $str;
		else return false;
	}
	
	static function escape($string, $in_encoding = 'UTF-8',$out_encoding = 'UCS-2') { 
		$return = ''; 
		if (function_exists('mb_get_info')) { 
			for($x = 0; $x < mb_strlen ( $string, $in_encoding ); $x ++) { 
				$str = mb_substr ( $string, $x, 1, $in_encoding ); 
				if (strlen ( $str ) > 1) { // 多字节字符 
					$return .= '%u' . strtoupper ( bin2hex ( mb_convert_encoding ( $str, $out_encoding, $in_encoding ) ) ); 
				} else { 
					$return .= '%' . strtoupper ( bin2hex ( $str ) ); 
				} 
			} 
		} 
		return $return; 
	}
}













class slNeter
{
		var $proxy,$urlproxy,$cookieFile,$webProxyList;
		function __construct()
		{
			$this->proxy='';
			$this->urlproxy='';
			$this->cookieFile = '';
			$this->webProxyList = array(
										'http://buqd.xyz/includes/process.php?action=update'=>'u',
										'http://afww.xyz/includes/process.php?action=update'=>'u',
										'http://charlieproxy.ml/includes/process.php?action=update'=>'u',
										'http://www.ooproxy.pw/includes/process.php?action=update'=>'u',
										'http://appleleaf.cf/includes/process.php?action=update'=>'u',
										'http://dailyproxy.info/includes/process.php?action=update'=>'u',
										'http://dacd.win/includes/process.php?action=update'=>'u',
										'http://pzou.win/includes/process.php?action=update'=>'u',
										'http://8proxy.space/includes/process.php?action=update'=>'u',
										'http://pouf.win/includes/process.php?action=update'=>'u',
										'http://odsh.win/includes/process.php?action=update'=>'u',
										'http://gethide.net/index.php'=>'q',
										'http://456proxy.ml/includes/process.php?action=update'=>'u',
										'http://webproxyserver.info/includes/process.php?action=update'=>'u',
										'http://proxyfree.website/includes/process.php?action=update'=>'u',
										'http://www.gbqr.xyz/includes/process.php?action=update'=>'u',
										'http://superproxy.win/index.php'=>'q',
										'http://time2hide.one/index.php'=>'q',
										'http://unblockwebsites.net/includes/process.php?action=update'=>'u',
										'http://accessproxy.science/includes/process.php?action=update'=>'u',
										'http://proxyfree.space/includes/process.php?action=update'=>'u',
										'http://supervpn.top/index.php'=>'q',
										'http://pr0web.work/index.php'=>'q',
										'http://freesite.work/index.php'=>'q',
										'http://0proxy.space/includes/process.php?action=update'=>'u',
										'http://www.proxyzan.info/includes/process.php?action=update'=>'u',
										'http://3proxy.space/includes/process.php?action=update'=>'u',
										'http://topwebproxy.com/includes/process.php?action=update'=>'u',
										'http://proxyfree.party/includes/process.php?action=update'=>'u',
										'http://newip.win/index.php'=>'q',
										'http://helloproxy.science/includes/process.php?action=update'=>'u',
										'http://bestfreessl.top/index.php'=>'q',
										'http://newidentity.win/index.php'=>'q',
										'http://mainproxy.pw/includes/process.php?action=update'=>'u',
										'http://proxyfree.asia/includes/process.php?action=update'=>'u',
										'http://678proxy.ml/includes/process.php?action=update'=>'u',
										'http://5proxy.space/includes/process.php?action=update'=>'u',
										'http://bestproxy.top/index.php'=>'q',
										'http://proo88.com/index.php'=>'q',
										'http://takomakovpn.top/index.php'=>'q',
										'http://www.yxorproxy.com/includes/process.php?action=update'=>'u',
										'http://access4all.top/index.php'=>'q',
										'http://www.cromcast.net/includes/process.php?action=update'=>'u',
										'http://hideyoufree.cf/includes/process.php?action=update'=>'u',
										'http://xtcsoul.net/includes/process.php?action=update'=>'u',
										'http://arrestoo.cf/index.php'=>'q',
										'http://lighitspeedproxy.top/index.php'=>'q',
										'http://openwebsite.work/index.php'=>'q',
										'http://ibringostation.top/index.php'=>'q',
										'http://uk-proxy.us/includes/process.php?action=update'=>'u',
										'http://softvpn.ml/index.php'=>'q',
										'http://imtheone.top/index.php'=>'q',
										'http://webrowserfree.top/index.php'=>'q',
										'http://phonepiwman.top/index.php'=>'q',
										'http://www.predecessor.info/includes/process.php?action=update'=>'u',
										'http://www.districtnewyork.com/includes/process.php?action=update'=>'u',
										'http://facetubeproxy.ga/index.php'=>'q',
										'http://bestproxy4u.ml/includes/process.php?action=update'=>'u',
										'http://www.surfingonmyown.com/includes/process.php?action=update'=>'u',
										'http://bsake.com/includes/process.php?action=update'=>'u',
										'http://worka.work/index.php'=>'q',
										'http://konchap.com/includes/process.php?action=update'=>'u',
										'http://booklof.cf/index.php'=>'q',
										'http://bestproxyserver.info/includes/process.php?action=update'=>'u',
										'http://securebypassproxy.gq/includes/process.php?action=update'=>'u',
										'http://www.web-site.review/index.php'=>'q',
										'http://dontblameme.ga/includes/process.php?action=update'=>'u',
										'http://netherlandsproxyserver.club/includes/process.php?action=update'=>'u',
										'http://www.simpleproxy.us/includes/process.php?action=update'=>'u',
										'http://secretproxy.org/includes/process.php?action=update'=>'u',
										'http://trucool.ml/index.php'=>'q',
										'http://euproxy.org/includes/process.php?action=update'=>'u',
										'http://proxyforeu.org/includes/process.php?action=update'=>'u',
										'http://accessproxy.org/includes/process.php?action=update'=>'u',
										'http://nocookie.gq/index.php'=>'q',
										'http://www.freewebproxyserver.pw/index.php'=>'q',
										'http://vpndaily.com/includes/process.php?action=update'=>'u',
										'http://tomatoproxy.eu/includes/process.php?action=update'=>'u',
										'http://9proxy.space/includes/process.php?action=update'=>'u',
										'http://androidnicheman.info/index.php'=>'q',
										'http://www.potatoproxy.eu/includes/process.php?action=update'=>'u',
										'http://franceproxy.pw/includes/process.php?action=update'=>'u',
										'http://www.befreeproxy.com/includes/process.php?action=update'=>'u',
										'http://www.shinyproxy.eu/includes/process.php?action=update'=>'u',
										'http://applepieproxy.xyz/includes/process.php?action=update'=>'u',
										'http://buka.link/includes/process.php?action=update'=>'u',
										'http://proxyeuro.pw/includes/process.php?action=update'=>'u',
										'http://invisiblesurf.review/index.php'=>'q',
										'http://www.myfastproxy.eu/includes/process.php?action=update'=>'u',
										'http://fermatfibonacci.info/index.php'=>'q',
										'http://www.shinyproxy.com/includes/process.php?action=update'=>'u',
										'http://proxyfrance.fr/index.php'=>'q',
										'http://showvision.info/index.php'=>'q',
										'http://bvpn.win/includes/process.php?action=update'=>'u',
										'http://www.popupfreeproxy.eu/includes/process.php?action=update'=>'u',
										'http://www.ghostproxy.eu/includes/process.php?action=update'=>'u',
										'http://phproxy.work/index.php'=>'q',
										'http://www.chocolateproxy.eu/includes/process.php?action=update'=>'u',
										'http://www.superproxy.eu/includes/process.php?action=update'=>'u',
										'http://proxyisp.com/includes/process.php?action=update'=>'u',
										'http://345proxy.ml/includes/process.php?action=update'=>'u',
										'http://www.hollandproxy.eu/includes/process.php?action=update'=>'u',
										'http://www.bananaproxy.eu/includes/process.php?action=update'=>'u',
										'http://cijq.xyz/includes/process.php?action=update'=>'u',
										'http://avpn.win/includes/process.php?action=update'=>'u',
										'http://abuomarlive.net/index.php'=>'q',
										'http://yavz.xyz/includes/process.php?action=update'=>'u',
										'http://freeserverproyx.ml/index.php'=>'q',
										'http://sokrat.ml/index.php'=>'q',
										'http://www.popunderfreeproxy.eu/includes/process.php?action=update'=>'u',
										'http://europroxy.pw/includes/process.php?action=update'=>'u',
										'http://www.stealthproxy.eu/includes/process.php?action=update'=>'u',
										'http://otlp.xyz/includes/process.php?action=update'=>'u',
										'http://voslokj.ml/index.php'=>'q',
										'http://pxfm.xyz/includes/process.php?action=update'=>'u',
										'http://openall.ml/index.php'=>'q',
										'http://zqal.xyz/includes/process.php?action=update'=>'u',
										'http://www.proxyforeurope.eu/includes/process.php?action=update'=>'u',
										'http://fakeip.cf/index.php'=>'q',
										'http://topproxy.ml/includes/process.php?action=update'=>'u',
										'http://88proxy.xyz/includes/process.php?action=update'=>'u',
										'http://pikoslol.ml/index.php'=>'q',
										'http://securesurf.ml/index.php'=>'q',
										'http://www.webprotect.pw/index.php'=>'q',
										'http://www.notblock.racing/index.php'=>'q',
										'http://www.hidesurfproxy.ml//includes/process.php?action=update'=>'u',
										'http://unlockus.ga/includes/process.php?action=update'=>'u',
										'http://www.netfeed.pw/index.php'=>'q',
										'http://www.myproxy.bid/index.php'=>'q',
										'http://vpnn.win/includes/process.php?action=update'=>'u',
										'http://www.fancyproxy.eu/includes/process.php?action=update'=>'u',
										'http://www.proxy-browser-online.net/index.php'=>'q',
										'http://www.proxygratis.net/index.php'=>'q',
										'http://www.proxygratis.es/index.php'=>'q',
										'http://hiddenbypass.gq/includes/process.php?action=update'=>'u',
										'http://brokenleg.cf/includes/process.php?action=update'=>'u',
										'http://www.proproxy.me/index.php'=>'q',
										'http://oneone.gq/index.php'=>'q',
										'http://kifkifgo.ml/index.php'=>'q',
										'http://faridy.ga/index.php'=>'q'
									);
		}
		function webProxyRequest($urlObj)
		{
			$pAction = array_rand($this->webProxyList);
			$anchor = $this->webProxyList[$pAction];
			if(!is_array($urlObj)) $urlObj = array('url'=>$urlObj);
			$urlObj['postArray'] = array(
										 	$anchor=>$urlObj['url'],
											'allowCookies'=>'on',
											'hl[accept_cookies]'=>'on',
											'hl[show_images]'=>'on',
										 );
			$urlObj['url'] = $pAction;
			$content = $this->request($urlObj);
			$regex = '/[\"\'][^"\']+?\?'.$anchor.'=([^"\']+?)(&[^"\']+?)?[\"\']/';
			$content = preg_replace_callback($regex ,function ($match){return '"'.urldecode($match[1]).'"';},$content);
			return $content;
		}
		function setProxy($set=true)
		{
			if($set)
				$this->proxy = $set;
			else
				$this->proxy='';
			return $this->proxy;
		}
		function setUrlProxy($set=true)
		{
			if($set)
			{
				$this->urlproxy = $set;
			}
			else
				$this->urlproxy='';
			return $this->urlproxy;
		}
		function  setCookieFile($cookie='cookie.tmp')
		{
			if($cookie===false) $this->cookieFile = '';
			else $this->cookieFile = $this->cookieFullPath($cookie);
			
		}
		function delCookieFile()
		{
			if($this->cookieFile && file_exists($this->cookieFile)) unlink($this->cookieFile);
		}
		
		function cookieFullPath($cookie)
		{
			$cookieFile = dirname(__FILE__).'/cookies_dir/'.$cookie;
			Utilities::_createDir(dirname($cookieFile));
			return $cookieFile;
		}
		function formatHeader($headArray)
		{
			$returnArray = array();
			foreach($headArray as $k=>$v)
			{
				$returnArray[] = "$k: $v";
			}
			return $returnArray;
		}
		function batRequest($urlObjArrays)
		{
			$returnArray = array();
			$num = sizeof($urlObjArrays);
			$res = array();
			$ch = array();
			$mh = curl_multi_init();
			#for($i=0;$i<$num;$i++) 
			$i = 0;
			foreach($urlObjArrays as $ch_i=>$urlObj)
			{
				$ch[$ch_i] = curl_init(); 
				
				
				if(!is_array($urlObjArrays[$ch_i])) $urlObjArrays[$ch_i] = array('url'=>$urlObjArrays[$ch_i]);
				
				$url = strstr($urlObjArrays[$ch_i]['url'],'?')?($urlObjArrays[$ch_i]['url'].'&'.$i):($urlObjArrays[$ch_i]['url'].'?'.$i);
				

				if(isset($urlObjArrays[$ch_i]['interface'])&& $urlObjArrays[$ch_i]['interface']) 
				{
					curl_setopt($ch[$ch_i], CURLOPT_INTERFACE,$urlObjArrays[$ch_i]['interface']);
				}
				else if(isset($urlObjArrays[$ch_i]['interface_auto'])&& $urlObjArrays[$ch_i]['interface_auto']) 
				{
					
				}
				else
				{
					curl_setopt($ch[$ch_i], CURLOPT_INTERFACE,$_SERVER['SERVER_ADDR']);
				}

				if(isset($urlObjArrays[$ch_i]['proxy'])&& $urlObjArrays[$ch_i]['proxy']) 
				{
					curl_setopt($ch[$ch_i], CURLOPT_PROXY,$urlObjArrays[$ch_i]['proxy']);
				}
				else if ($this->proxy)  
				{
					curl_setopt($ch[$ch_i], CURLOPT_PROXY, $this->proxy);
				}
				

				

				
				if(isset($urlObjArrays[$ch_i]['header'])&&$urlObjArrays[$ch_i]['header'])
				{
					curl_setopt($ch[$ch_i], CURLOPT_HEADER, true);
				}
				else
				{
					curl_setopt($ch[$ch_i], CURLOPT_HEADER, false);
				}
				curl_setopt($ch[$ch_i], CURLOPT_URL, $url);
				curl_setopt($ch[$ch_i], CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch[$ch_i], CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch[$ch_i], CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($ch[$ch_i], CURLOPT_FOLLOWLOCATION, TRUE);
				if(isset($urlObjArrays[$ch_i]['referer'])&&$urlObjArrays[$ch_i]['referer'])
				{
					curl_setopt($ch[$ch_i], CURLOPT_REFERER, $urlObjArrays[$ch_i]['referer']);
				}
				if(isset($urlObjArrays[$ch_i]['postArray'])&&$urlObjArrays[$ch_i]['postArray'])
				{
					curl_setopt($ch[$ch_i], CURLOPT_POST, true);
					if(is_array($urlObjArrays[$ch_i]['postArray'])) 
						$urlObjArrays[$ch_i]['postArray'] = Utilities::sl_http_build_query($urlObjArrays[$ch_i]['postArray']);
					curl_setopt($ch[$ch_i], CURLOPT_POSTFIELDS,$urlObjArrays[$ch_i]['postArray'] );
				}
				if(isset($urlObjArrays[$ch_i]['timeout'])&&$urlObjArrays[$ch_i]['timeout'])
				{
					curl_setopt($ch[$ch_i], CURLOPT_TIMEOUT,  $urlObjArrays[$ch_i]['timeout']);
					curl_setopt($ch[$ch_i], CURLOPT_CONNECTTIMEOUT,  $urlObjArrays[$ch_i]['timeout']);
				}
				else
				{
					curl_setopt($ch[$ch_i], CURLOPT_TIMEOUT, 30);//10秒超时
				}
				if(isset($urlObjArrays[$ch_i]['customrequest'])&&$urlObjArrays[$ch_i]['customrequest'])
				{
					curl_setopt($ch[$ch_i], CURLOPT_CUSTOMREQUEST,  $urlObjArrays[$ch_i]['customrequest']);
				}
				
				if(isset($urlObjArrays[$ch_i]['file'])&&$urlObjArrays[$ch_i]['file'])
				{
					curl_setopt($ch[$ch_i], CURLOPT_HEADER, false);
					Utilities::_createDir(dirname($urlObjArrays[$ch_i]['file']));
					$fp = fopen($urlObjArrays[$ch_i]['file'],'w');
					curl_setopt($ch[$ch_i], CURLOPT_FILE,  $fp );
				}


				if(isset($urlObjArrays[$ch_i]['disableCookie']))
				{
				}
				else if(isset($urlObjArrays[$ch_i]['cookieString'])&&$urlObjArrays[$ch_i]['cookieString'])
				{
					curl_setopt($ch[$ch_i], CURLOPT_COOKIE,$urlObjArrays[$ch_i]['cookieString']);
				}
				else if(isset($urlObjArrays[$ch_i]['cookieFile']))
				{
					curl_setopt($ch[$ch_i], CURLOPT_COOKIEJAR,$this->cookieFullPath($urlObjArrays[$ch_i]['cookieFile']));
					curl_setopt($ch[$ch_i], CURLOPT_COOKIEFILE,$this->cookieFullPath($urlObjArrays[$ch_i]['cookieFile']));
				}
				else if($this->cookieFile)
				{
					curl_setopt($ch[$ch_i], CURLOPT_COOKIEJAR,$this->cookieFile);
					curl_setopt($ch[$ch_i], CURLOPT_COOKIEFILE,$this->cookieFile);
				}



				$httpheaderArray = array(
									'Connection'=>'keep-alive',
									//'Origin'=>'https://www.google.com',
									'User-Agent'=>'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.134 Safari/537.36',
									'Content-Type'=>'application/x-www-form-urlencoded;charset=UTF-8',
									'Accept'=>'*/*',
									'Accept-Encoding'=>'deflate',
									'Accept-Language'=>'en-US,en;q=0.8'

								 );
				
				$hha = array();
				foreach($httpheaderArray as $k=>$v)
				{
					$hha[Utilities::stringHumpFormat($k)] = $v;
				}
				if(isset($urlObjArrays[$ch_i]['headerArray'])&&$urlObjArrays[$ch_i]['headerArray'])
				{
					foreach($urlObjArrays[$ch_i]['headerArray'] as $k=>$v)
					{
						$hha[Utilities::stringHumpFormat($k)] = $v;
					}
				}
				
				curl_setopt($ch[$ch_i], CURLOPT_HTTPHEADER, $this->formatHeader($hha));
				
			}
			foreach($urlObjArrays as $ch_i=>$urlObj)
			{
				curl_multi_add_handle($mh, $ch[$ch_i]); 
			}
			do 
			{
				$mrc = curl_multi_exec($mh, $running);
				curl_multi_select($mh);
			} while($running > 0);
			foreach($urlObjArrays as $ch_i=>$urlObj)
			{
				$code = curl_multi_getcontent($ch[$ch_i]);
				$returnArray[$ch_i] = $code;
			}
			foreach($urlObjArrays as $ch_i=>$urlObj)
			{
				curl_multi_remove_handle($mh, $ch[$ch_i]);
			}
			curl_multi_close($mh);
			return $returnArray;
		} 
		
		function request($urlObj)
		{
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,  true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,  true); 
			curl_setopt($ch, CURLOPT_HEADER,true);

			if(!is_array($urlObj)) $urlObj = array('url'=>$urlObj);
			
			$url = $urlObj['url'];
			
			if(isset($urlObj['interface'])&& $urlObj['interface']) 
			{
				curl_setopt($ch, CURLOPT_INTERFACE,$urlObj['interface']);
			}
			else if(isset($urlObj['interface_auto'])&& $urlObj['interface_auto']) 
			{
				
			}
			else
			{
				curl_setopt($ch, CURLOPT_INTERFACE,$_SERVER['SERVER_ADDR']);
			}
			
			
			if(isset($urlObj['proxy'])&& $urlObj['proxy']) 
			{
				curl_setopt($ch, CURLOPT_PROXY,$urlObj['proxy']);
			}
			else if ($this->proxy)  
			{
				curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
			}
			
			if(isset($urlObj['urlproxy'])) 
			{
				if($urlObj['urlproxy'])
				{
					$url = $urlObj['urlproxy'].urlencode($url);
				}
			}
			else if($this->urlproxy) 
			{
				$url = $this->urlproxy.urlencode($url);
			}
			
			
			curl_setopt($ch, CURLOPT_URL, $url);
			
			if(isset($urlObj['headerfunction'])&&$urlObj['headerfunction'])
			{
				curl_setopt($ch, CURLOPT_HEADERFUNCTION, $urlObj['headerfunction']);
			}
			if(isset($urlObj['writefunction'])&&$urlObj['writefunction'])
			{
				curl_setopt($ch, CURLOPT_WRITEFUNCTION, $urlObj['writefunction']);
			}			
			
			if(isset($urlObj['customrequest'])&&$urlObj['customrequest'])
			{
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  $urlObj['customrequest']);
			}	
			
			if(isset($urlObj['disableCookie']))
			{
			}
			else if(isset($urlObj['cookieString'])&&$urlObj['cookieString'])
			{
				curl_setopt($ch, CURLOPT_COOKIE,$urlObj['cookieString']);
			}
			else if(isset($urlObj['cookieFile']))
			{
				curl_setopt($ch, CURLOPT_COOKIEJAR,$this->cookieFullPath($urlObj['cookieFile']));
				curl_setopt($ch, CURLOPT_COOKIEFILE,$this->cookieFullPath($urlObj['cookieFile']));
			}
			else if($this->cookieFile)
			{
				curl_setopt($ch, CURLOPT_COOKIEJAR,$this->cookieFile);
				curl_setopt($ch, CURLOPT_COOKIEFILE,$this->cookieFile);
			}
	
			if(isset($urlObj['json'])&&$urlObj['json'])
			{
				$httpheaderArray = array(
													"Content-type'=>'application/json;charset='utf-8'",
													"Accept'=>'application/json",
													"Cache-Control'=>'no-cache",
													"Pragma'=>'no-cache",
												 );
			}
			else
			{
				$httpheaderArray = array(
													'Connection'=>'keep-alive',
													//'Origin'=>'https://www.google.com',
													'User-Agent'=>'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.134 Safari/537.36',
													'Content-Type'=>'application/x-www-form-urlencoded;charset=UTF-8',
													'Accept'=>'*/*',
													'Accept-Encoding'=>'deflate',
													'Accept-Language'=>'en-US,en;q=0.8'
	
												 );
			}
			
			$hha = array();
			foreach($httpheaderArray as $k=>$v)
			{
				$hha[Utilities::stringHumpFormat($k)] = $v;
			}
			if(isset($urlObj['headerArray'])&&$urlObj['headerArray'])
			{
				foreach($urlObj['headerArray'] as $k=>$v)
				{
					$hha[Utilities::stringHumpFormat($k)] = $v;
				}
			}
/*			if(isset($urlObj['headerArray'])&&$urlObj['headerArray'])
			{
				$httpheaderArray = array_merge($httpheaderArray,$urlObj['headerArray']);
			}*/
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeader($hha));
			
			if(isset($urlObj['timeout'])&&$urlObj['timeout'])
			{
				curl_setopt($ch, CURLOPT_TIMEOUT,  $urlObj['timeout']);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,  $urlObj['timeout']);
			}
			else
			{
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);//10秒超时
			}
			if(isset($urlObj['referer'])&&$urlObj['referer'])
			{
				curl_setopt($ch, CURLOPT_REFERER, $urlObj['referer']);
			}
			
			if(isset($urlObj['file'])&&$urlObj['file'])
			{
				curl_setopt($ch, CURLOPT_HEADER,false);
				Utilities::_createDir(dirname($urlObj['file']));
				$fp = fopen($urlObj['file'],'w');
				curl_setopt($ch, CURLOPT_FILE, $fp);
			}		
			
			if(isset($urlObj['postArray'])&&$urlObj['postArray'])
			{
				curl_setopt($ch, CURLOPT_POST,  true);
				if(is_array($urlObj['postArray'])) $urlObj['postArray'] = Utilities::sl_http_build_query($urlObj['postArray']);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $urlObj['postArray']);		
			}
			else if(isset($urlObj['uploadArray'])&&$urlObj['uploadArray'])
			{
				curl_setopt($ch, CURLOPT_POST,  true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $urlObj['uploadArray']);		
			}
			//curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2; .NET4.0C; .NET4.0E)');
			$code = curl_exec($ch);

			if(!isset($urlObj['header'])||!$urlObj['header'])
			{
				$headerSize = strlen($code) - curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
				$code = substr($code, $headerSize);
				
			}
			curl_close($ch);
			return $code;
		}
}