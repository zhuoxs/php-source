<?php
 $this->getsq();
		global $_W, $_GPC;
        $weid=$_W['uniacid'];
        $set = pdo_fetch ( 'select * from ' . tablename ( $this->modulename . "_set" ) . " where weid='{$weid}'" );
        if(empty($set)){
           if (checksubmit('submit')){  
                $indata=array(
                    'weid'=>$_W['uniacid'],
										'tztype'=>$_GPC['tztype'],
                    'dlbl1'=>$_GPC['dlbl1'],
                    'dlbl1t2'=>$_GPC['dlbl1t2'],
                    'dlbl1t3'=>$_GPC['dlbl1t3'],
                    'dlbl2'=>$_GPC['dlbl2'],
                    'dlbl2t3'=>$_GPC['dlbl2t3'],
                    'dlbl3'=>$_GPC['dlbl3'],
                    'dlfftype'=>$_GPC['dlfftype'],
                    'dlffprice'=>$_GPC['dlffprice'],
                    'fxtype'=>$_GPC['fxtype'],
                    'ddtype'=>$_GPC['ddtype'],
                    'level1'=>$_GPC['level1'],
                    'level2'=>$_GPC['level2'],
                    'level3'=>$_GPC['level3'],
                    'glevel1'=>$_GPC['glevel1'],
                    'glevel2'=>$_GPC['glevel2'],
                    'glevel3'=>$_GPC['glevel3'],
                    'fzname'=>$_GPC['fzname'],
                    'seartype'=>$_GPC['seartype'],
                     'dlkcbl'=>$_GPC['dlkcbl'],
                    'dlfxtype'=>$_GPC['dlfxtype'],
                    'dlzbtype'=>$_GPC['dlzbtype'],
                    'dlyjfltype'=>$_GPC['dlyjfltype'],
                    'zfmsg0'=>$_GPC['zfmsg0'],
                    'zfmsg1'=>$_GPC['zfmsg1'],
                    'zfmsg2'=>$_GPC['zfmsg2'],
                    'zfmsg3'=>$_GPC['zfmsg3'],
                );
            //echo '<pre>';
            //print_r($indata);
            //exit;
                $result=pdo_insert($this->modulename."_set",$indata);
                if(empty($result)){
                  message ( '添加失败' );
                }else{
                  message ( '添加成功!' );
                }    
           }
        }else{
         if (checksubmit('submit')){
           $id = intval($_GPC['id']);
           $updata=array(              
					          'tztype'=>$_GPC['tztype'],
                    'dlbl1'=>$_GPC['dlbl1'],
                    'dlbl1t2'=>$_GPC['dlbl1t2'],
                    'dlbl1t3'=>$_GPC['dlbl1t3'],
                    'dlbl2'=>$_GPC['dlbl2'],
                    'dlbl2t3'=>$_GPC['dlbl2t3'],
                    'dlbl3'=>$_GPC['dlbl3'],
               'dltype'=>$_GPC['dltype'],
               'dlname1'=>$_GPC['dlname1'],
               'dlname2'=>$_GPC['dlname2'],
               'dlname3'=>$_GPC['dlname3'],
               'dlfftype'=>$_GPC['dlfftype'],
                    'dlffprice'=>$_GPC['dlffprice'],
               'fxtype'=>$_GPC['fxtype'],
               'ddtype'=>$_GPC['ddtype'],
               'level1'=>$_GPC['level1'],
                    'level2'=>$_GPC['level2'],
                    'level3'=>$_GPC['level3'],
                    'glevel1'=>$_GPC['glevel1'],
                    'glevel2'=>$_GPC['glevel2'],
                    'glevel3'=>$_GPC['glevel3'],
                'fzname'=>$_GPC['fzname'],
                    'seartype'=>$_GPC['seartype'],
               'dlkcbl'=>$_GPC['dlkcbl'],
               'dlfxtype'=>$_GPC['dlfxtype'],
               'dlzbtype'=>$_GPC['dlzbtype'],
               'dlyjfltype'=>$_GPC['dlyjfltype'],
               'zfmsg0'=>$_GPC['zfmsg0'],
                    'zfmsg1'=>$_GPC['zfmsg1'],
                    'zfmsg2'=>$_GPC['zfmsg2'],
                    'zfmsg3'=>$_GPC['zfmsg3'],
                );
           if(pdo_update($this->modulename."_set",$updata,array('id'=>$id)) === false){
                  message ( '更新失败' );
                }else{
                  message ( '更新成功!' );
                }
          }
        }

		include $this->template ( 'dlset' );
?>