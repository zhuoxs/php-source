<?php
       global $_W, $_GPC;
       $cfg = $this->module['config'];
       $type=$_GPC['type'];
       $pid=$_GPC['pid'];
		if($_GPC['uid']){
	    	$uid=$_GPC['uid'];
	    }else{
	    	$fans=$this->islogin();
	        if(empty($fans['tkuid'])){
	        	$fans = mc_oauth_userinfo();	        
	        }
	    }
	    
	    //PID绑定
		if(!empty($dluid)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
        }else{
          //$fans=mc_oauth_userinfo();
          $openid=$fans['openid'];
          if(empty($uid)){
          	$zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
          }else{
          	$zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
          }
          
        }
        if($zxshare['dltype']==1){
            if(!empty($zxshare['dlptpid'])){
               $cfg['ptpid']=$zxshare['dlptpid'];
               $cfg['qqpid']=$zxshare['dlqqpid'];
            }
            
        }else{
           if(!empty($zxshare['helpid'])){//查询有没有上级
                 $sjshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and id='{$zxshare['helpid']}'");           
            }
        }
        

        if(!empty($sjshare['dlptpid'])){
            if(!empty($sjshare['dlptpid'])){
              $cfg['ptpid']=$sjshare['dlptpid'];
              $cfg['qqpid']=$sjshare['dlqqpid'];
            }   
        }else{
           if($share['dlptpid']){
               if(!empty($share['dlptpid'])){
                 $cfg['ptpid']=$share['dlptpid'];
                 $cfg['qqpid']=$share['dlqqpid'];
               }       
            }
        }
       
		$pid=$cfg['ptpid'];
		


       switch ($type)
        {
        case 1:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/000.jpg";
          $title="2018淘宝1212主会场";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3D0bXTuw%2BHaVgcQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMYQEcGjmqXa%2BnsuZCKOWWOszuTGl041QAgJ7VDhL86oTJPwiig1bxLNyU3PkLHqE2Kn72hc9Gcdvyz%2BFzve07opVij6rJP8FrU2srC8Mk09ezERKVEtCU88%3D&cpsrc=tiger_tiger&&pid=";
          break;
        case 2:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/2.jpg";
          $title="2018淘宝1212美食分会场";

		$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DjHPv%2BV2rcZ0cQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMeHLjl6lAHEpsGGkYWrXX3xH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91SD34%2FaMbhWLwFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&&pid=";
          break;
        case 3:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/3.jpg";
          $title="2018淘宝1212户外运动分会场";
          $url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DuWMdutZDXNkcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMeHLjl6lAHEpsGGkYWrXX3xH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91TVhrwR2VIabQFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
          break;
        case 4:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/4.png";
          $title="2018淘宝1212装修定制分会场";
          $url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DJbNUw2sR1uUcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMZvC%2FoyYXlolFXyq8ODlIZ1H1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91TAt8E0YBPOwAFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
          break;
          case 5:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/5.jpg";
          $title="2018淘宝1212精品手机分会场";
          $url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DGl%2FOJAUAcUscQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMcB%2Fwr8zZ2osjnvs3ugiPp1H1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91QE496h7rrcjwFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
          break;
        case 6:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/6.jpg";
          $title="2018淘宝1212童装玩具分会场";
          $url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DYWUUVLI7Fq8cQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMeHLjl6lAHEpsGGkYWrXX3xH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91S9WNjKXgP%2B%2FwFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
          break;
        case 7:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/7.jpg";
          $title="2018淘宝1212真二次元分会场";
          $url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3Dn3xyrxgvwMUcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMd4SzZhmhdLl3S4HV%2Fh9OEdH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91Qvw4dC%2FHK12AFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
          break;
        case 8:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/8.png";
          $title="2018淘宝1212品质男鞋分会场";
          $url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DmQKylUlupSkcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMeHLjl6lAHEpsGGkYWrXX3xH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91Ria9hp3Nu4dgFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
          break;
        case 9:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/9.jpg";
          $title="2018淘宝1212潮流男装分会场";
          $url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3D%2F42yZPxfYrgcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMd4SzZhmhdLl3S4HV%2Fh9OEdH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91RwanPI1M7xErHVFdvzICOCyGV3mNuE4oA1zANuoYN5TYn%2Bbkz0bjjMyCbLYKwrt2O904KRWeNd57soSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
          break;
        case 10:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/10.png";
          $title="2018淘宝1212生活百货分会场";
          $url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DaR7TfOq8aPQcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMd4SzZhmhdLl3S4HV%2Fh9OEdH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91Q2DBT1bDOwJQFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
          break;
        case 11:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/11.png";
          $title="2018淘宝1212珠宝配饰分会场";
          $url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DYgCfvpeUYuMcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMeHLjl6lAHEpsGGkYWrXX3xH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91Tx0KDX%2BUKI8gFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
          break;
        case 12:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/12.jpg";
          $title="2018淘宝1212灯源光饰分会场";
          $url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3D5BjDBRuyPTYcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMd4SzZhmhdLl3S4HV%2Fh9OEdH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91QPHWmvXht2kAFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
          break;  
		case 13:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/13.jpg";
			$title="2018淘宝1212潮流美妆分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3D2I2KVF6XROUcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMcB%2Fwr8zZ2osjnvs3ugiPp1H1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91Thtf1kKm6iZgFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 14:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/14.jpg";
			$title="2018淘宝1212潮流数码分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DasROkFvEKcIcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMcB%2Fwr8zZ2osjnvs3ugiPp1H1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91RMlyjhp6GjGAFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 15:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/14.jpg";
			$title="2018淘宝1212母婴用品分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3Dk%2FDa4f8pMoIcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMcB%2Fwr8zZ2osjnvs3ugiPp1H1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91St5D8bIu2LwwFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 16:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/14.jpg";
			$title="2018淘宝1212时尚箱包分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3D%2BHovx1QwgFgcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMd4SzZhmhdLl3S4HV%2Fh9OEdH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91QWowR7Io79CAFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 17:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/14.jpg";
			$title="2018淘宝1212文教乐器分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DpDG7v%2FNencgcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMd4SzZhmhdLl3S4HV%2Fh9OEdH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91QVCq5%2B8F1spbHVFdvzICOCyGV3mNuE4oA1zANuoYN5TYn%2Bbkz0bjjMyCbLYKwrt2O904KRWeNd57soSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 18:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/14.jpg";
			$title="2018淘宝1212家装建材分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3Dh6%2BXJ8GhCP0cQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMd4SzZhmhdLl3S4HV%2Fh9OEdH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91RjejQ1IPjG9wFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 19:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/14.jpg";
			$title="2018淘宝1212家纺家饰分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DxIX4IMgHSlccQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMcB%2Fwr8zZ2osjnvs3ugiPp1H1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91TfJmEmIe1o%2FwFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 20:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/14.jpg";
			$title="2018淘宝1212宠物鲜花分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DVTw8J7pTLxYcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMcB%2Fwr8zZ2osjnvs3ugiPp1H1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91StFnqPob%2FSBgFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 21:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/14.jpg";
			$title="2018淘宝1212潮流女鞋分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DAnzDgzh7%2BX8cQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMd4SzZhmhdLl3S4HV%2Fh9OEdH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91SqtuZvH8oV%2BrHVFdvzICOCyGV3mNuE4oA1zANuoYN5TYn%2Bbkz0bjjMyCbLYKwrt2O904KRWeNd57soSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 22:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/14.jpg";
			$title="2018淘宝1212潮流女装分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DftRi8CxcCwIcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMd4SzZhmhdLl3S4HV%2Fh9OEdH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91SgwyhVuC9R%2F7HVFdvzICOCyGV3mNuE4oA1zANuoYN5TYn%2Bbkz0bjjMyCbLYKwrt2O904KRWeNd57soSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 23:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/14.jpg";
			$title="2018淘宝1212商务办公分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3Dv9rJh2fOzYscQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMeHLjl6lAHEpsGGkYWrXX3xH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91TE5Sb%2BL6STWgFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 24:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/14.jpg";
			$title="2018淘宝1212品质家电分会场";
			$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DLkmnTcIGEcYcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMcB%2Fwr8zZ2osjnvs3ugiPp1H1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzHuhd8jCPAXkq6%2Brq6P1HDRV5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91RL1c2IynWrOQFUccLqWf0%2Bf5cyCxZZppXiZzYv%2B6HfITXMA26hg3lN%2Fw9iftcE9iIymKYt%2BB9sursoSXpvjOTqCIUD%2BWG7He0x0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&pid=";
			break;  
		case 99:
			$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/00.jpg";
			$title="2018淘宝1212主会场(超级红包主会场)";
			$url="https://s.click.taobao.com/t?e=m%3D2%26s%3DUG0j2iRGFe4cQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMa%2BBXMvWjcmMhUr3ztDeup8zuTGl041QAtWo9%2BfWyX%2Bwcj5d26O5JTnBV7GfGbfBR9AZlFuvbqggNpyJFUMGL0Fht000UE9EUpRmBdFTgfJpJgwhXEHlmzaZgpzmWTJ4Xh7IxJyjErQUbyj%2BdwL9qV7rcxJkzondtEgIPsEFBJAtlfnWEGtyQ%2BCaRdzUmyH11XommvuH%2FO6x8VKPbP%2BXoVXGdwn1H%2FBXVrZjQSnNfcm%2BBGP2gdM5%2Fl7rZoYCQrS5nZc1lFm5zaDqF9XYaIWXi1HIzZXLoxXImrn%2BhqhHHmZI&cpsrc=tiger_tiger&pid=";
			break;  
        default:
          $pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/1a.jpg";
          $title="2018淘宝1212主会场";
					$url="https://s.click.taobao.com/t?spm=0.0.0.0.0_0.0.0.0&e=m%3D2%26s%3DxQUARwxSanIcQipKwQzePCperVdZeJviLKpWJ%2Bin0XJRAdhuF14FMeHLjl6lAHEpsGGkYWrXX3xH1FV9SWFQHLTSIEPYjAs7593%2FvzUBNj98isIqg9litAZn%2By0keumo8hwxGexMdF%2BPlDBN6u9C2Xc2YtLxzzi8WzMbuZimEd%2Bznk86mCZFzGtIGCDBZ60sBm98njDq375V5ZdVN%2FS%2FHTXMA26hg3lNW1U6bzKi91SZgpzmWTJ4Xh7IxJyjErQUbyj%2BdwL9qV6H1STacL6F7zY7CE6dYYybFZ8zVBsKeTx59mlsNMqux7HVFdvzICOCyGV3mNuE4oAx0Lp2py6sVCGFCzYOOqAQ&cpsrc=tiger_tiger&&pid=";
        }

        //$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/c1111.jpg";

        $rhyurl=$url.$pid;

        $tkl=$this->tkl($rhyurl,$pic,"2018淘宝1212主会场");
 
      
       $userAgent = $_SERVER['HTTP_USER_AGENT'];
		if (!strpos($userAgent, 'MicroMessenger')) {
			Header("Location:".$tzurl); 
		}
       
		
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
		    $sjlx=1;
		}else{
		   $sjlx=2;
		}


       //echo $tkl;

       include $this->template ( 'tbgoods/style99/c11view' );
?>