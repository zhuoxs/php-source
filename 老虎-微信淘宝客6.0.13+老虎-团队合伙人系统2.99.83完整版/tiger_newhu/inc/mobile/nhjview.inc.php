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
          $pic="https://img.alicdn.com/tfs/TB1Lnwrz4TpK1RjSZFGXXcHqFXa-440-180.jpg";
          $title="2019天猫年货合家-主会场（带超级红包）";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3DgXFSl9omEmccQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMS6kS8yTp6kRAYPhC%2B%2FgaE8zuTGl041QAqD5kstin37fU2%2FAEepMzfHGq4iT%2BDv5w0JUXBtwD3jmeK6AyaN9cNFkkwrO4VzIZmsFOLhERZOUamkFHdIFxeOp%2B9oXPRnHb8s%2Fhc73tO6KVYo%2BqyT%2FBa1NrKwvDJNPXsxESlRLQlPP&cpsrc=tiger_tiger&&pid=";
          break;
        case 2:
          $pic="https://gw.alicdn.com/tfs/TB1KsD6z9zqK1RjSZFpXXakSXXa-440-180.jpg";
          $title="2019天猫年货合家-万券齐发";

		$url="https://s.click.taobao.com/t?e=m%3D2%26s%3DDkrzbrXB860cQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMftPYotcg%2BhJG%2FN6Jx5YutMzuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXN%2BztHRPn0aqs2jrT2jN9cy5QTiLg9tPpjJLz3bXOrh%2Fso8XDDaee4V%2B%2BYoUZoLK2yV%2BdYQa3JD4INGWG%2FIQnGlIOpO1P7UsSxOVPhIvNgOIFPYzjbX4AGBO9%2BWHj%2BGqPxJHLN0lUT5kw%3D%3D&cpsrc=tiger_tiger&&pid=";
          break;
        case 3:
          $pic="https://gw.alicdn.com/tfs/TB1Bc_4z5rpK1RjSZFhXXXSdXXa-440-180.jpg";
          $title="2019天猫年货合家-砍价会场";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3DDNsYHiMgdsIcQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMYcgt1L2AxV4o5VSCmutSbQzuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXN%2BztHRPn0aqs2jrT2jN9cyaeNmVpjiNWtbJRt9SGY9oK7RS9A9L6SYefZpbDTKrseARSsFUugDjBQYn0gVgOGmfwcfO2O6L7iOTe7uzUz56b4H8lVVAG5MwmwBo7yXhWInqo%2FvJyccNQ%3D%3D&cpsrc=tiger_tiger&pid=";
          break;
        case 4:
          $pic="https://gw.alicdn.com/tfs/TB1rLQsz4naK1RjSZFtXXbC2VXa-440-180.jpg";
          $title="2019天猫年货合家-买就返";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3DXqurWEK9H4scQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMbngKRewMl4JEmSL9pJEyt0zuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXN%2BztHRPn0aqs2jrT2jN9cy5QTiLg9tPpjJLz3bXOrh%2FgRzrUA8Vi3w%2B%2BYoUZoLK2yV%2BdYQa3JD4INGWG%2FIQnGlIOpO1P7UsSxOVPhIvNgOIFPYzjbX4AGBO9%2BWHj%2BGqPxJHLN0lUT5kw%3D%3D&cpsrc=tiger_tiger&pid=";
          break;
          case 5:
          $pic="https://gw.alicdn.com/tfs/TB19yAbz9rqK1RjSZK9XXXyypXa-440-180.png";
          $title="2019天猫年货合家欢—天猫超市主会场";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3Dht5z4%2FAW94YcQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMTZTVBntYLi2KaFSJePRPq4GZ%2FstJHrpqJWl9ELVPsYNiBqx4AoGTRzZ%2FNxlvga2vCtsek%2FePtZfEJJtuXHKcdLd7FpR7c%2FQTV3wJxNY12LjR4xbtjOSG4QBtV09odYR1D9uXXHqMLtkSSJhu0qqIo4NRWExQ%2FDM6dlzz9t17MBD4gqXglJHiXPLQPEJLPAWAV3WV7X8X8sdwNiiDF8y6S8%3D&cpsrc=tiger_tiger&pid=";
          break;
        case 6:
          $pic="https://img.alicdn.com/tfs/TB1rHDVzPTpK1RjSZKPXXa3UpXa-440-180.jpg";
          $title="2019天猫年货合家欢-聚划算.主会场";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3DrvNPHy6EdyscQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMb6KF%2BIYMHWNo5VSCmutSbQzuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXN%2BztHRPn0aqs2jrT2jN9cyaeNmVpjiNWvyWRLzV9N2n67RS9A9L6SYefZpbDTKrseARSsFUugDjBQYn0gVgOGmfwcfO2O6L7iOTe7uzUz56b4H8lVVAG5MwmwBo7yXhWInqo%2FvJyccNQ%3D%3D&cpsrc=tiger_tiger&pid=";
          break;
        case 7:
          $pic="https://gw.alicdn.com/tfs/TB1ks7RzBLoK1RjSZFuXXXn0XXa-440-180.jpg";
          $title="2019天猫年货合家欢——服饰主会场";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3Dus40DNiya4scQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMZq3%2BU0unwryKaFSJePRPq4zuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXO4VIgbQtTSez0YclpbFqAY%2F02y2F2t47bn0HGWXMroQxejeefvXL19AFeBK6%2FtK%2Fsq2x4KkidPL%2BReR15rySBjKYFnllaKQ3uiZ%2BQMlGz6FQ%3D%3D&cpsrc=tiger_tiger&pid=";
          break;
        case 8:
          $pic="https://img.alicdn.com/tfs/TB1sbBMzCzqK1RjSZPcXXbTepXa-440-180.jpg";
          $title="2019天猫年货合家欢——电器主会场";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3DsdTMQdQzSM0cQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMT%2BKaBLwgucNAYPhC%2B%2FgaE8zuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXO4VIgbQtTSez0YclpbFqAY%2F02y2F2t47bn0HGWXMroQ1SFK9ogIDW8AFeBK6%2FtK%2Fsq2x4KkidPL%2BReR15rySBjKYFnllaKQ3uiZ%2BQMlGz6FQ%3D%3D&cpsrc=tiger_tiger&pid=";
          break;
        case 9:
          $pic="https://img.alicdn.com/tfs/TB1BOnVzrvpK1RjSZFqXXcXUVXa-440-180.jpg";
          $title="2019天猫年货合家欢——品质生鲜";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3Ddfs7GTMKcnkcQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMSKw5bkcG8w7KaFSJePRPq4zuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXO4VIgbQtTSez0YclpbFqAY%2F02y2F2t47bn0HGWXMroQyIfEnuBcFmXAFeBK6%2FtK%2Fsq2x4KkidPL%2BReR15rySBjKYFnllaKQ3uiZ%2BQMlGz6FQ%3D%3D&cpsrc=tiger_tiger&pid=";
          break;
        case 10:
          $pic="https://gw.alicdn.com/tfs/TB1MIr5zAvoK1RjSZFDXXXY3pXa-440-180.jpg";
          $title="2019天猫年货合家欢——休闲零食";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3D56Kxhi0t3fEcQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMdEwb%2BqaBa6v6oVw0fmJ46szuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXO4VIgbQtTSez0YclpbFqAY%2F02y2F2t47bn0HGWXMroQxNp3jFCbZpKAFeBK6%2FtK%2Fsq2x4KkidPL%2BReR15rySBjKYFnllaKQ3uiZ%2BQMlGz6FQ%3D%3D&cpsrc=tiger_tiger&pid=";
          break;
        case 11:
          $pic="https://img.alicdn.com/tfs/TB1dQyyyVzqK1RjSZFoXXbfcXXa-440-180.png";
          $title="2019天猫年货合家欢——进口年货街";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3D18MlDbBEtVYcQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMeC1550tdTgCLNtGcKAVN3IzuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXO4VIgbQtTSez0YclpbFqAY%2F02y2F2t47bn0HGWXMroQ57Je1WrI4ADAFeBK6%2FtK%2Fsq2x4KkidPL%2BReR15rySBjKYFnllaKQ3uiZ%2BQMlGz6FQ%3D%3D&cpsrc=tiger_tiger&pid=";
          break;
        case 12:
          $pic="https://img.alicdn.com/tfs/TB1Pmewy4TpK1RjSZFKXXa2wXXa-440-180.png";
          $title="2019天猫年货合家欢——天猫全球精选";
          $url="https://s.click.taobao.com/t?e=m%3D2%26s%3DBz8oe4yLedscQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMT%2BiI4uKDIFuhUr3ztDeup8zuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXO4VIgbQtTSez0YclpbFqAY%2F02y2F2t47bn0HGWXMroQwOMIP0qmIkLAFeBK6%2FtK%2Fsq2x4KkidPL%2BReR15rySBjKYFnllaKQ3uiZ%2BQMlGz6FQ%3D%3D&cpsrc=tiger_tiger&pid=";
          break;  
		case 13:
			$pic="https://img.alicdn.com/tfs/TB18hLnzH2pK1RjSZFsXXaNlXXa-440-180.jpg";
			$title="2019天猫年货合家欢——母婴主会场";
			$url="https://s.click.taobao.com/t?e=m%3D2%26s%3DKzXq6c0qGl0cQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMdT4oNuCuS6QEmSL9pJEyt0zuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXO4VIgbQtTSez0YclpbFqAY%2F02y2F2t47bn0HGWXMroQyBsTx2yP7aYAFeBK6%2FtK%2Fsq2x4KkidPL%2BReR15rySBjKYFnllaKQ3uiZ%2BQMlGz6FQ%3D%3D&cpsrc=tiger_tiger&pid=";
			break;  
		case 14:
			$pic="https://img.alicdn.com/tfs/TB1PZDKyMHqK1RjSZFEXXcGMXXa-440-180.png";
			$title="2019天猫年货合家欢——手机会场";
			$url="https://s.click.taobao.com/t?e=m%3D2%26s%3DGxpvPixbXfEcQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMdPpTEcweAtfA8hgolRGHkczuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXO4VIgbQtTSez0YclpbFqAY%2F02y2F2t47bn0HGWXMroQ8H7eh%2FEW9NIAFeBK6%2FtK%2Fsq2x4KkidPL%2BReR15rySBjKYFnllaKQ3uiZ%2BQMlGz6FQ%3D%3D&cpsrc=tiger_tiger&pid=";
			break;  
		case 15:
			$pic="https://img.alicdn.com/tfs/TB1dfyhzrvpK1RjSZPiXXbmwXXa-440-180.jpg";
			$title="2019天猫年货合家欢——生活个护会场";
			$url="https://s.click.taobao.com/t?e=m%3D2%26s%3D9%2Ba508qxEN8cQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMcBQMGc8aT%2FcLNtGcKAVN3IzuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXO4VIgbQtTSez0YclpbFqAY%2F02y2F2t47bn0HGWXMroQ1U2wKrocS%2FCAFeBK6%2FtK%2Fsq2x4KkidPL%2BReR15rySBjKYFnllaKQ3uiZ%2BQMlGz6FQ%3D%3D&cpsrc=tiger_tiger&pid=";
			break;  
		case 16:
			$pic="https://img.alicdn.com/tfs/TB1ZDSAy7PoK1RjSZKbXXX1IXXa-440-180.png";
			$title="2019天猫年货合家欢——进口美妆";
			$url="https://s.click.taobao.com/t?e=m%3D2%26s%3DSW2s670S6BocQipKwQzePCperVdZeJviK7Vc7tFgwiFRAdhuF14FMY%2BxuT6rSRwk6oVw0fmJ46szuTGl041QArZl6wCRgzZSsd%2B%2Ff4Fhw9b%2BScqIfI2efLAHkyFZtBihXB4NrBKTIXO4VIgbQtTSez0YclpbFqAY%2F02y2F2t47bn0HGWXMroQ6MGfl5BPiUZAFeBK6%2FtK%2Fsq2x4KkidPL%2BReR15rySBjKYFnllaKQ3uiZ%2BQMlGz6FQ%3D%3D&cpsrc=tiger_tiger&pid=";
			break;  
		
        default:
          $pic="https://img.alicdn.com/tfs/TB1Lnwrz4TpK1RjSZFGXXcHqFXa-440-180.jpg";
          $title="2019天猫年货合家-主会场（带超级红包）";
					$url="https://s.click.taobao.com/t?e=m%3D2%26s%3DoZvsyP0EiVAcQipKwQzePCperVdZeJvipRe%2F8jaAHci5VBFTL4hn2eEemHBxLPcL7OAh7L92kxqR4ypTBJBwtP%2FCccdPzIn0dSuwsRkNflCHWWrZt0BFT5BOig4Q%2Bt4xKQlzryg1l8c7Ys%2FxssswngCwY0sGA6bJQRpqMC8XMCeo3hZJMLROOvQxQIubt7ug1mm%2Fu84HLdF8T4fSBsLQqtsPU7N2SHNyvDovBBh%2F%2FUnpllOKvXKGpb2YnZ7gs%2Faz&cpsrc=tiger_tiger&&pid=";
        }

        //$pic=$_W['siteroot']."addons/tiger_newhu/template/mobile/tbgoods/style99/imgs/c1111/c1111.jpg";

        $rhyurl=$url.$pid;

        $tkl=$this->tkl($rhyurl,$pic,"2019天猫年货合家");
 
      
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

       include $this->template ( 'tbgoods/style99/nhjview' );
?>