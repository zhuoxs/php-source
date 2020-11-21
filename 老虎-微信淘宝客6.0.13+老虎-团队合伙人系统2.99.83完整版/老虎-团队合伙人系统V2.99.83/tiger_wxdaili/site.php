<?php

require_once IA_ROOT . '/addons/tiger_newhu/inc/sdk/tbk/TopSdk.php';
class Tiger_wxdailiModuleSite extends WeModuleSite
{
/*     public function __construct()
    {
        goto jppQH;
        mLd_T:
        if (!($do != 'login' and $do != 'bdlogin' and $do != 'tupian')) {
            goto xJ3Mg;
        }
        goto yGNPo;
        l2DDq:
        if (!($c == 'entry')) {
            goto d7V58;
        }
        goto UoMS6;
        uzo_L:
        exit;
        goto i7rAy;
        qrPZs:
        qmWzf:
        goto ialgc;
        N3vDW:
        $arr = @json_decode($aa, true);
        goto dCkaB;
        c2mY_:
        echo $arr['msg'];
        goto uzo_L;
        o3Tam:
        $cfg = $this->module['config'];
        goto z1bOc;
        gHx9q:
        fUaAr:
        goto J8Hkg;
        EG93U:
        $tbuid = $cfg['tbuid'];
        goto M2h5F;
        z1bOc:
        $host = $_SERVER['HTTP_HOST'];
        goto bPCbl;
        cP5rP:
        $tktzurl = $_W['siteurl'];
        goto ujKJD;
        SdcMe:
        $aa = $this->curl_request($url);
        goto N3vDW;
        i7rAy:
        mrIio:
        goto S4Qvo;
        dCkaB:
        if (!($arr['error'] == 2)) {
            goto mrIio;
        }
        goto c2mY_;
        H1_Lm:
        d7V58:
        goto gHx9q;
        yR80G:
        $c = $_GPC['c'];
        goto o3Tam;
        S4Qvo:
        if (empty($cfg['tknewurl'])) {
            goto fUaAr;
        }
        goto l2DDq;
        bY2Ry:
        if (!empty($_SESSION['tkuid'])) {
            goto qmWzf;
        }
        goto cP5rP;
        JFLSp:
        exit;
        goto w9XXT;
        ialgc:
        smpU4:
        goto crdzv;
        w9XXT:
        xJ3Mg:
        goto qrPZs;
        V12Iv:
        $tkip = $this->get_server_ip();
        goto BDWkK;
        ujKJD:
        $loginurl = $_W['siteroot'] . str_replace('./', 'app/', $this->createMobileurl('login')) . '&m=tiger_newhu' . '&tzurl=' . urlencode($tktzurl);
        goto mLd_T;
        aYI_4:
        if (!($cfg['logintype'] == 1)) {
            goto smpU4;
        }
        goto bY2Ry;
        J8Hkg:
        if (!($c == 'entry')) {
            goto TPciz;
        }
        goto aYI_4;
        M2h5F:
        $tkurl1 = urlencode($host);
        goto pr8MR;
        pr8MR:
        $tkurl2 = urlencode($_W['setting']['site']['url']);
        goto V12Iv;
        yGNPo:
        header('Location: ' . $loginurl);
        goto JFLSp;
        BDWkK:
        $url = 'http://api1.laohucms.com/sqnew.php?tbuid=' . $tbuid . '&tkurl=' . $tkurl1 . '&tkurl2=' . $tkurl2 . '&tkip=' . $tkip . '&sign=' . md5($tkip . 'tig');
        goto SdcMe;
        crdzv:
        TPciz:
        goto oPtRx;
        UoMS6:
        $_W['siteroot'] = $cfg['tknewurl'];
        goto H1_Lm;
        jppQH:
        global $_W, $_GPC;
        goto yR80G;
        bPCbl:
        $host = strtolower($host);
        goto EG93U;
        oPtRx:
    } */
    public function dlzdsh($uid, $share, $guanliopenid = "", $cfg = "")
    {
        goto LtLHD;
        KTbR5:
        $res = pdo_update('tiger_newhu_share', array("tgwid" => 11111), array("id" => $uid, "weid" => $_W['uniacid']));
        goto Pm4HH;
        BUmWl:
        if (!empty($jdpidres)) {
            goto sUw9G;
        }
        goto Wq0b2;
        xK8os:
        if (!empty($pddpidres)) {
            goto y4jWm;
        }
        goto jgRow;
        Vi3dz:
        $res = pdo_update('tiger_newhu_share', array("jdpid" => $jdpidres['pid'], "dltype" => 1), array("id" => $uid, "weid" => $_W['uniacid']));
        goto F44xr;
        MW2sV:
        BF15Y:
        goto DX2q5;
        jgRow:
        if (empty($guanliopenid)) {
            goto dMDfy;
        }
        goto JMOqs;
        nct2L:
        $res = pdo_update('tiger_wxdaili_jdpid', array("type" => 1, "uid" => $share['id'], "nickname" => $share['nickname']), array("id" => $jdpidres['id']));
        goto D796W;
        D796W:
        nszDs:
        goto mvIot;
        jQ0ok:
        if (empty($res)) {
            goto BF15Y;
        }
        goto I3WDG;
        oItxd:
        if (empty($jdpidres['pid'])) {
            goto ne5Hi;
        }
        goto Vi3dz;
        DX2q5:
        x6Xbf:
        goto ye_RB;
        EZdnK:
        $jdpidres = pdo_fetch('select * from ' . tablename('tiger_wxdaili_jdpid') . " where weid='{$_W['uniacid']}' and type=0 order by id desc ");
        goto BUmWl;
        RT7MT:
        $dlmsg = '<a href=\'' . $tturl . '\'>进入合伙人中心</a>
重点：进入合伙人中心，复制口令，打开淘♂寳APP完成渠道授权，未授权不能跟单结算佣金！';
        goto LSGXA;
        I3WDG:
        $res = pdo_update('tiger_wxdaili_pddpid', array("type" => 1, "uid" => $share['id'], "nickname" => $share['nickname']), array("id" => $pddpidres['id']));
        goto MW2sV;
        LSGXA:
        $this->postText($share['from_user'], $dlmsg);
        goto gYuKW;
        Pm4HH:
        QtJJr:
        goto EZdnK;
        mvIot:
        ne5Hi:
        goto mZYA8;
        F44xr:
        if (empty($res)) {
            goto nszDs;
        }
        goto nct2L;
        LtLHD:
        global $_W;
        goto RK0FO;
        k_RaH:
        y4jWm:
        goto oItxd;
        u6cR1:
        sUw9G:
        goto h6Djr;
        h6Djr:
        $pddpidres = pdo_fetch('select * from ' . tablename('tiger_wxdaili_pddpid') . " where weid='{$_W['uniacid']}' and type=0 order by id desc ");
        goto xK8os;
        RK0FO:
        if (!empty($share['tgwid'])) {
            goto QtJJr;
        }
        goto KTbR5;
        efG6r:
        $res = pdo_update('tiger_newhu_share', array("pddpid" => $pddpidres['pid'], "dltype" => 1), array("id" => $uid, "weid" => $_W['uniacid']));
        goto jQ0ok;
        Wq0b2:
        if (empty($guanliopenid)) {
            goto jhqZe;
        }
        goto svelY;
        mZYA8:
        if (empty($pddpidres['pid'])) {
            goto x6Xbf;
        }
        goto efG6r;
        svelY:
        jhqZe:
        goto u6cR1;
        JMOqs:
        dMDfy:
        goto k_RaH;
        ye_RB:
        $tturl = $cfg['tknewurl'] . str_replace('./', 'app/', $this->createMobileurl('newmember'));
        goto RT7MT;
        gYuKW:
    }
    public function get_server_ip()
    {
        goto yHT4d;
        yD1JN:
        $server_ip = getenv('SERVER_ADDR');
        goto SykE2;
        nUgT9:
        goto CcrvD;
        goto Go04Q;
        uqAch:
        if ($_SERVER['SERVER_ADDR']) {
            goto JV6Dp;
        }
        goto maq6c;
        OgA58:
        HtD_0:
        goto m9vbt;
        m9vbt:
        return $server_ip;
        goto MaWYi;
        srgjJ:
        $server_ip = $_SERVER['SERVER_ADDR'];
        goto Y6hpi;
        Go04Q:
        JV6Dp:
        goto srgjJ;
        Y6hpi:
        CcrvD:
        goto OgA58;
        yHT4d:
        if (isset($_SERVER)) {
            goto KoGQb;
        }
        goto yD1JN;
        bORVh:
        KoGQb:
        goto uqAch;
        SykE2:
        goto HtD_0;
        goto bORVh;
        maq6c:
        $server_ip = $_SERVER['LOCAL_ADDR'];
        goto nUgT9;
        MaWYi:
    }
    public function getmember($fans, $wqid, $helpid)
    {
        goto CVvTN;
        YH0_0:
        c_Ie_:
        goto ZXgkm;
        sT7pK:
        return $share;
        goto lJEPO;
        nSsGR:
        sBG5W:
        goto eXa5W;
        i99r_:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        goto mxGH2;
        eXa5W:
        if (!empty($fans['unionid'])) {
            goto kZBJE;
        }
        goto i99r_;
        ZyuiP:
        c39Ux:
        goto rqPDA;
        Not6W:
        f1H1a:
        goto srwz2;
        mxGH2:
        if (!empty($share['id'])) {
            goto dnDGq;
        }
        goto svEYq;
        yBLQE:
        if (!empty($fans['openid'])) {
            goto sBG5W;
        }
        goto IjubV;
        suntj:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        goto kI4S9;
        jn2d4:
        pdo_insert('tiger_newhu_share', array("openid" => $wqid, "nickname" => $fans['nickname'], "avatar" => $fans['avatar'], "unionid" => $fans['unionid'], "pid" => "", "updatetime" => time(), "createtime" => time(), "parentid" => 0, "weid" => $_W['uniacid'], "helpid" => $helpid, "score" => "", "cscore" => "", "pscore" => "", "from_user" => $fans['openid'], "follow" => 1));
        goto hNB32;
        Tt0UK:
        a923F:
        goto Not6W;
        bI2WU:
        goto zNuUw;
        goto ogA37;
        JUEvD:
        goto f1H1a;
        goto MGTUb;
        Q6HW3:
        if (!empty($share['id'])) {
            goto Dvs8f;
        }
        goto JVbXs;
        CRXZy:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and unionid='{$fans['unionid']}'");
        goto Q6HW3;
        lJEPO:
        goto c_Ie_;
        goto bnuEX;
        IjubV:
        return '';
        goto nSsGR;
        zMx3m:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$share['id']}'");
        goto RMSxX;
        bnuEX:
        g8vTv:
        goto izRPc;
        gBmP3:
        return $share;
        goto i9O8g;
        ZXgkm:
        zNuUw:
        goto JUEvD;
        GmzI5:
        Dvs8f:
        goto f63kE;
        JFwf2:
        pdo_update('tiger_newhu_share', $updata, array("unionid" => $fans['unionid'], "weid" => $_W['uniacid']));
        goto dVTUX;
        rqPDA:
        $updata = array("unionid" => $fans['unionid'], "openid" => $wqid);
        goto k5lUS;
        izRPc:
        $updata = array("unionid" => $fans['unionid'], "openid" => $wqid);
        goto F8VCO;
        ogA37:
        dnDGq:
        goto VaQOX;
        oZILU:
        return '';
        goto xwMTT;
        i9O8g:
        bstS_:
        goto bI2WU;
        JVbXs:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        goto E0LVV;
        hNB32:
        $share['id'] = pdo_insertid();
        goto O4xPe;
        lKI5m:
        SbXVy:
        goto j3lHA;
        F9PDg:
        pdo_insert('tiger_newhu_share', array("openid" => $wqid, "nickname" => $fans['nickname'], "avatar" => $fans['avatar'], "unionid" => $fans['unionid'], "pid" => "", "updatetime" => time(), "createtime" => time(), "parentid" => 0, "weid" => $_W['uniacid'], "helpid" => $helpid, "score" => "", "cscore" => "", "pscore" => "", "from_user" => $fans['openid'], "follow" => 1));
        goto il2fC;
        k5lUS:
        pdo_update('tiger_newhu_share', $updata, array("from_user" => $fans['openid'], "weid" => $_W['uniacid']));
        goto ieUqv;
        kI4S9:
        return $share;
        goto YH0_0;
        VaQOX:
        if (!empty($fans['unionid'])) {
            goto g8vTv;
        }
        goto sT7pK;
        yNYKr:
        goto SbXVy;
        goto ZyuiP;
        OgOHL:
        sxTdo:
        goto jn2d4;
        j3lHA:
        goto a923F;
        goto GmzI5;
        F8VCO:
        pdo_update('tiger_newhu_share', $updata, array("from_user" => $fans['openid'], "weid" => $_W['uniacid']));
        goto suntj;
        dVTUX:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and unionid='{$fans['unionid']}'");
        goto K2yIW;
        xwMTT:
        goto bstS_;
        goto OgOHL;
        il2fC:
        $share['id'] = pdo_insertid();
        goto zMx3m;
        RMSxX:
        return $share;
        goto yNYKr;
        MGTUb:
        kZBJE:
        goto CRXZy;
        f63kE:
        $updata = array("from_user" => $fans['openid'], "openid" => $wqid);
        goto JFwf2;
        E0LVV:
        if (!empty($share['id'])) {
            goto c39Ux;
        }
        goto F9PDg;
        M_S3v:
        return $share;
        goto lKI5m;
        CVvTN:
        global $_W;
        goto yBLQE;
        K2yIW:
        return $share;
        goto Tt0UK;
        O4xPe:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        goto gBmP3;
        ieUqv:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        goto M_S3v;
        svEYq:
        if (!empty($fans['openid'])) {
            goto sxTdo;
        }
        goto oZILU;
        srwz2:
    }
    public function mc_jl($uid, $type, $typelx, $num, $remark, $orderid)
    {
        goto F0ZVY;
        FnsYh:
        Ryhb_:
        goto t3L_D;
        cXmXV:
        KZSeX:
        goto mcx_3;
        XWMOB:
        wHl3W:
        goto wFmYv;
        t3L_D:
        $res = pdo_update('tiger_newhu_share', array("credit2" => $credit2), array("id" => $uid));
        goto ckvsV;
        HwZ87:
        $res = pdo_update('tiger_newhu_share', array("credit1" => $credit1), array("id" => $uid));
        goto ElysQ;
        ElysQ:
        if ($res === false) {
            goto aSdmT;
        }
        goto bMrWg;
        ckvsV:
        if ($res === false) {
            goto Go2gp;
        }
        goto m7P3J;
        mcx_3:
        $credit2 = $share['credit2'] + $num;
        goto jB_Es;
        cI1ez:
        return array("error" => 0, "data" => "余额不足");
        goto FnsYh;
        jOP5_:
        VeNim:
        goto HwZ87;
        jB_Es:
        if (!($credit2 < 0)) {
            goto Ryhb_;
        }
        goto cI1ez;
        k2tcA:
        return array("error" => 0, "data" => "积分不足");
        goto jOP5_;
        wFmYv:
        goto DbR70;
        goto Fdc6J;
        kCSu3:
        $share = pdo_fetch('SELECT credit1,credit2 FROM ' . tablename('tiger_newhu_share') . " WHERE id='{$uid}' and weid='{$_W['uniacid']}' ");
        goto LwW6Y;
        PPY1j:
        DbR70:
        goto bJ1Ux;
        xAIvn:
        return array("error" => 1, "data" => "积分更新成功");
        goto U3IHM;
        LwW6Y:
        if ($type == 1) {
            goto KZSeX;
        }
        goto Lw1ig;
        bMrWg:
        $inst = pdo_insert('tiger_newhu_jl', $data);
        goto H0DY4;
        HZS5J:
        goto xHL25;
        goto cXmXV;
        Lw1ig:
        if ($type == 0) {
            goto HQSIr;
        }
        goto HZS5J;
        EsQ1L:
        $data = array("uid" => $uid, "weid" => $_W['uniacid'], "type" => $type, "typelx" => $typelx, "num" => $num, "remark" => $remark, "orderid" => $orderid, "createtime" => time());
        goto kCSu3;
        u3PJy:
        return array("error" => 0, "data" => "积分更新失败");
        goto PPY1j;
        Fdc6J:
        aSdmT:
        goto u3PJy;
        QTWOV:
        return array("error" => 0, "data" => "积分更新失败");
        goto XWMOB;
        bJ1Ux:
        xHL25:
        goto Ii0Ig;
        w4bXO:
        fgOXZ:
        goto OUeVc;
        C_Z7b:
        return array("error" => 0, "data" => "余额更新失败");
        goto w4bXO;
        IvOCz:
        if (!($credit1 < 0)) {
            goto VeNim;
        }
        goto k2tcA;
        OPjCS:
        LYy_l:
        goto PRp81;
        SpwM7:
        HQSIr:
        goto A34K_;
        PRp81:
        goto fgOXZ;
        goto ZuGZ_;
        A34K_:
        $credit1 = $share['credit1'] + $num;
        goto IvOCz;
        SRDKW:
        l4Ilr:
        goto EsQ1L;
        ZuGZ_:
        Go2gp:
        goto C_Z7b;
        U3IHM:
        goto wHl3W;
        goto S78y3;
        w8CK9:
        if ($inst === false) {
            goto phuoL;
        }
        goto nsAre;
        OUeVc:
        goto xHL25;
        goto SpwM7;
        m7P3J:
        $inst = pdo_insert('tiger_newhu_jl', $data);
        goto w8CK9;
        EWH1H:
        if (!empty($uid)) {
            goto l4Ilr;
        }
        goto Y6TZx;
        nsAre:
        return array("error" => 1, "data" => "余额更新成功");
        goto vgXbu;
        Y6TZx:
        return;
        goto SRDKW;
        F0ZVY:
        global $_W;
        goto EWH1H;
        H0DY4:
        if ($inst === false) {
            goto bs7zV;
        }
        goto xAIvn;
        S78y3:
        bs7zV:
        goto QTWOV;
        vgXbu:
        goto LYy_l;
        goto PBC_X;
        r6A5H:
        return array("error" => 0, "data" => "余额更新失败");
        goto OPjCS;
        PBC_X:
        phuoL:
        goto r6A5H;
        Ii0Ig:
    }
    public function islogin()
    {
        goto uqdwi;
        NC_Q_:
        $fans['openid'] = $_SESSION['openid'];
        goto sQNf_;
        Guffc:
        $mc = mc_fetch($fans['openid']);
        goto UvLkT;
        BpXeF:
        return $fans;
        goto wR6QN;
        XQNph:
        YbGF8:
        goto Guffc;
        UvLkT:
        $fans = array("id" => $_SESSION['tkuid'], "tkuid" => $_SESSION['tkuid'], "wquid" => $mc['uid'], "credit1" => $share['credit1'], "credit2" => $share['credit2'], "nickname" => $share['nickname'], "avatar" => $share['avatar'], "helpid" => $share['helpid'], "dlptpid" => $share['dlptpid'], "unionid" => $share['unionid'], "from_user" => $share['from_user'], "openid" => $share['from_user'], "createtime" => $share['createtime'], "tgwid" => $share['tgwid'], "cqtype" => $share['cqtype'], "dltype" => $share['dltype'], "status" => $share['status']);
        goto BpXeF;
        uqdwi:
        global $_W;
        goto tcaOo;
        sQNf_:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$_SESSION['tkuid']}'");
        goto XQNph;
        tcaOo:
        if (empty($_SESSION['openid'])) {
            goto YbGF8;
        }
        goto NC_Q_;
        wR6QN:
    }
    public function getfc($string, $len = 2)
    {
        goto HXiIZ;
        wyjKA:
        $strlen = mb_strlen($string);
        goto ELcGF;
        UUXE9:
        $string = mb_substr($string, $len, $strlen, 'utf8');
        goto wyjKA;
        ELcGF:
        goto VQQFy;
        goto dEgU3;
        dEgU3:
        w_Cge:
        goto VxaVX;
        KHmvC:
        $array[] = mb_substr($string, $start, $len, 'utf8');
        goto UUXE9;
        mj6cJ:
        $strlen = mb_strlen($string);
        goto bBRo0;
        kL_eY:
        $start = 0;
        goto mj6cJ;
        HXiIZ:
        $string = str_replace(' ', '', $string);
        goto kL_eY;
        bBRo0:
        VQQFy:
        goto qGuYt;
        VxaVX:
        return $array;
        goto dyTdg;
        qGuYt:
        if (!$strlen) {
            goto w_Cge;
        }
        goto KHmvC;
        dyTdg:
    }
    public function tjsum($id, $weid)
    {
        goto jNH4M;
        IVzzR:
        return $total;
        goto ldOWD;
        ldOWD:
        goto wyms2;
        goto k6saD;
        fMAr9:
        wyms2:
        goto Iqxt1;
        qsa2r:
        if (empty($total)) {
            goto IFbKY;
        }
        goto IVzzR;
        ATq5R:
        return 0;
        goto fMAr9;
        k6saD:
        IFbKY:
        goto ATq5R;
        jNH4M:
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->modulename . '_qunmember') . " where weid='{$weid}' and qunid='{$id}'");
        goto qsa2r;
        Iqxt1:
    }
    public function gettaopic($numid)
    {
        goto xxXus;
        IxXVO:
        $req->setNumIids($numid);
        goto Kipmx;
        KwK23:
        $pic = $resp->results->n_tbk_item->pict_url;
        goto m5bSI;
        Mvrm5:
        $c->appkey = $cfg['tkAppKey'];
        goto vAHai;
        xxXus:
        $cfg = $this->module['config'];
        goto J1rhK;
        hgmTE:
        $req->setFields('pict_url');
        goto niLmU;
        Kipmx:
        $resp = $c->execute($req);
        goto KwK23;
        J1rhK:
        $c = new TopClient();
        goto Mvrm5;
        m5bSI:
        settype($pic, 'string');
        goto l_xxV;
        l_xxV:
        return $pic;
        goto nYfVf;
        vAHai:
        $c->secretKey = $cfg['tksecretKey'];
        goto qY8KR;
        qY8KR:
        $req = new TbkItemInfoGetRequest();
        goto hgmTE;
        niLmU:
        $req->setPlatform('1');
        goto IxXVO;
        nYfVf:
    }
    public function jyze($share, $begin_time, $end_time, $type, $bl)
    {
        goto KNuD_;
        KxN3s:
        $jy = pdo_fetchcolumn('SELECT sum(fkprice) FROM ' . tablename('tiger_newhu_tkorder') . " where weid='{$_W['uniacid']}' and (tgwid={$share['tgwid']} || relation_id='{$share['qdid']}'} and orderzt<>'订单失效' {$where}");
        goto t8Kr0;
        wxuTN:
        if (empty($begin_time)) {
            goto WZMvN;
        }
        goto zwFlc;
        grE0Z:
        tHdzP:
        goto nmyKE;
        KNuD_:
        global $_W;
        goto X51me;
        X51me:
        if (empty($end_time)) {
            goto xZsTW;
        }
        goto wxuTN;
        Dda9q:
        iWhj7:
        goto mMRsV;
        zi0cW:
        if (empty($begin_time)) {
            goto Wb2tN;
        }
        goto ASNWf;
        ARxbt:
        y0336:
        goto ReyzO;
        VMYWn:
        xZsTW:
        goto zi0cW;
        tJT6o:
        goto iWhj7;
        goto VMYWn;
        ASNWf:
        $where = "and addtime>{$begin_time}";
        goto QwSPo;
        mMRsV:
        if (!($type == 1)) {
            goto tHdzP;
        }
        goto EVL65;
        zwFlc:
        $where = "and addtime>{$begin_time} and addtime<{$end_time}";
        goto ey6XX;
        EVL65:
        if (empty($share['qdid'])) {
            goto y0336;
        }
        goto KxN3s;
        t8Kr0:
        goto aAy9J;
        goto ARxbt;
        PBbp_:
        aAy9J:
        goto grE0Z;
        ey6XX:
        WZMvN:
        goto tJT6o;
        ReyzO:
        $jy = pdo_fetchcolumn('SELECT sum(fkprice) FROM ' . tablename('tiger_newhu_tkorder') . " where weid='{$_W['uniacid']}' and tgwid={$share['tgwid']} and orderzt<>'订单失效' {$where}");
        goto PBbp_;
        nmyKE:
        return $jy;
        goto JFZ2r;
        QwSPo:
        Wb2tN:
        goto Dda9q;
        JFZ2r:
    }
    public function tqbl($share, $bl, $cfg)
    {
        goto SFhkp;
        pw0N2:
        if (!empty($wsysjyj)) {
            goto DFYr7;
        }
        goto L6h6P;
        VZnTK:
        if ($bl['dltype'] == 2) {
            goto niar0;
        }
        goto X5yXt;
        L6h6P:
        $wsysjyj = '0.00';
        goto qa5Pw;
        hDIqM:
        BfXBG:
        goto QtOI4;
        pTpM_:
        $sjfkyj = number_format($rsjfkyj['yj3'], 2, '.', '');
        goto yrZcX;
        J2f3N:
        if (!empty($syzyj)) {
            goto yeidL;
        }
        goto sKfjR;
        DF17M:
        $wsyzyj = $wsyygsum + $wsyrjyj + $wsysjyj;
        goto dgabb;
        nL3I8:
        $wsysjyj = number_format($wsyrsjyj['yj3'], 2, '.', '');
        goto DF17M;
        H5rSE:
        if (!empty($jryj)) {
            goto UzH_0;
        }
        goto CRQ4S;
        VR037:
        if (!empty($jrygsum)) {
            goto bPRF1;
        }
        goto xSGTQ;
        UMTnC:
        $jrzyj = '0.00';
        goto lK_ml;
        YxdQZ:
        if (!empty($brzfkyj)) {
            goto f12OZ;
        }
        goto juxZ6;
        YGB9i:
        return $array;
        goto Jg1NT;
        CNiSJ:
        $zrrjyj = number_format($zrrsjyj['yj2'] * $bl['dlbl1t2'] / 100, 2, '.', '');
        goto ZwkSF;
        QkJ66:
        goto hcDx1;
        goto jpq6z;
        ODPpv:
        $syrjyj = number_format($syrsjyj['yj2'] * $bl['dlbl2t3'] / 100, 2, '.', '');
        goto M2IxQ;
        QAlun:
        x0j7s:
        goto Hf33h;
        JEihP:
        $wsyrjyj = number_format($wsyrsjyj['yj2'], 2, '.', '');
        goto nL3I8;
        HL5yV:
        if ($bl['dltype'] == 3) {
            goto y1LSA;
        }
        goto W4KF8;
        Vl96I:
        LNT2q:
        goto Kx8QU;
        rOXeG:
        $rjfkyj = number_format($rsjfkyj['yj2'], 2, '.', '');
        goto pTpM_;
        w00mS:
        if (!empty($wsyygsum)) {
            goto RWqw3;
        }
        goto lvH7C;
        x5t3o:
        $wsyrjyj = number_format($wsyrsjyj['yj2'] * $bl['dlbl1t2'] / 100, 2);
        goto TF_r4;
        hYMZk:
        $daytime = strtotime(date('Y-m-d 00:00:00'));
        goto KbOxs;
        Roef8:
        $jryj = number_format($jrjyj['yj2'] * $bl['dlbl2t3'] / 100, 2, '.', '');
        goto C8Ej_;
        Ir274:
        huCsY:
        goto Roef8;
        jsVjN:
        $sysjyj = number_format($syrsjyj['yj3'], 2, '.', '');
        goto GK9NU;
        v0wCs:
        $jryj = number_format($jrjyj['yj2'], 2, '.', '');
        goto BrC55;
        zyqNc:
        if ($bl['dltype'] == 2) {
            goto WP9xq;
        }
        goto HL5yV;
        lOef5:
        $byfksum = $this->bryj($share, $bbegin_time, $bend_time, 2, $bl, $cfg);
        goto zJFrI;
        X95OM:
        $syzyj = $syygsum + $syrjyj + $sysjyj;
        goto N9JR9;
        vWYje:
        $jrsjyj = '0.00';
        goto yn3Dj;
        KUQ5T:
        if ($bl['dltype'] == 3) {
            goto NEbra;
        }
        goto efThw;
        j6Y2s:
        if ($bl['fxtype'] == 1) {
            goto lcZhV;
        }
        goto alCyN;
        Gt0Uk:
        $zjrzyj = '0.00';
        goto ASuWS;
        KGKkC:
        $rsjyj = $this->bydlyj($share, $bbegin_time, $bend_time, 1, $bl, $cfg, 1);
        goto LBDhC;
        i5CGz:
        JvEJe:
        goto YpwTi;
        Ozhgs:
        hcDx1:
        goto Gu9_S;
        WkgYw:
        $wsyzyj = '0.00';
        goto XBKfy;
        Iz5yW:
        QESJQ:
        goto v0wCs;
        lOi_U:
        if (!empty($wsyrjyj)) {
            goto kV7X3;
        }
        goto zP6Sq;
        Y5nDU:
        $zrzyj = '0.00';
        goto mWhaQ;
        Kx8QU:
        if (!empty($byygsum)) {
            goto IKEHB;
        }
        goto Qoz3N;
        N9JR9:
        goto T6znI;
        goto QAlun;
        b678K:
        if (!empty($brzyj)) {
            goto cPtwt;
        }
        goto aJPlY;
        TYhGK:
        goto QIZPb;
        goto i5CGz;
        VZdC_:
        T6znI:
        goto QHxcV;
        Qh38l:
        $zrygsum = number_format($zrygsum, 2, '.', '');
        goto BmPL1;
        vN8wo:
        $wsyrjyj = number_format($wsyrsjyj['yj2'] * $bl['dlbl2t3'] / 100, 2);
        goto F1m9d;
        ftd0K:
        if (!empty($sjyj)) {
            goto SsBGX;
        }
        goto lldj9;
        M2IxQ:
        $sysjyj = number_format($syrsjyj['yj3'] * $bl['dlbl1t3'] / 100, 2, '.', '');
        goto AAjEX;
        vfO2i:
        niar0:
        goto x5t3o;
        lK_ml:
        fUDqY:
        goto VR037;
        thW3j:
        $syrjyj = '0.00';
        goto YiqtP;
        foAPF:
        xnNDa:
        goto LDVQQ;
        lahot:
        $brzfkyj = $byfksum + $rjfkyj + $sjfkyj;
        goto itJV0;
        HspEz:
        $zrrjyj = '0.00';
        goto NxO9H;
        qOupF:
        $syygsum = number_format($syygsum, 2, '.', '');
        goto ipX6h;
        NVa18:
        BTet_:
        goto ODPpv;
        AAjEX:
        FRHuG:
        goto X95OM;
        IJo9b:
        $array = array("zong" => $zjrzyj, "s1" => $syzyj, "s2" => $syygsum, "s3" => $syrjyj, "s4" => $sysjyj, "s5" => $wsyzyj, "s6" => $wsyygsum, "s7" => $wsyrjyj, "s8" => $wsysjyj, "b1" => $brzyj, "b2" => $byygsum, "b3" => $rjyj, "b4" => $sjyj, "d1" => $brzfkyj, "d2" => $byfksum, "d3" => $rjfkyj, "d4" => $sjfkyj, "z1" => $zrzyj, "z2" => $zrygsum, "z3" => $zrrjyj, "z4" => $zrsjyj, "j1" => $jrzyj, "j2" => $jrygsum, "j3" => $jryj, "j4" => $jrsjyj);
        goto YGB9i;
        yrZcX:
        $brzfkyj = $byfksum + $rjfkyj + $sjfkyj;
        goto y8Zky;
        HdVOF:
        goto HU181;
        goto Iz5yW;
        JREE2:
        if ($bl['dltype'] == 2) {
            goto xnNDa;
        }
        goto p6SQb;
        dSF2g:
        if (!empty($wsyzyj)) {
            goto h8s5e;
        }
        goto WkgYw;
        Vuiel:
        $zrzyj = $zrygsum + $zrrjyj + $zrsjyj;
        goto aEhjT;
        AXalo:
        $jryj = number_format($jrjyj['yj2'] * $bl['dlbl1t2'] / 100, 2, '.', '');
        goto OgHza;
        fJFZ5:
        JN33A:
        goto m8bdT;
        fYhLn:
        CG0oz:
        goto dSF2g;
        pMAW6:
        $rsjfkyj = $this->bydlyj($share, $bbegin_time, $bend_time, 2, $bl, $cfg);
        goto j6Y2s;
        tV8pV:
        RWqw3:
        goto lOi_U;
        s6SOb:
        $sjfkyj = '0.00';
        goto CTAsh;
        l8Z8Q:
        $rjyj = number_format($rsjyj['yj2'] * $bl['dlbl2t3'] / 100, 2, '.', '');
        goto U8r0q;
        phXRm:
        if ($bl['fxtype'] == 1) {
            goto GzKQ4;
        }
        goto VZnTK;
        RYBy4:
        mMY0Z:
        goto nehLe;
        xMqdG:
        $syygsum = '0.00';
        goto hDIqM;
        tPaSg:
        if ($bl['dltype'] == 2) {
            goto KW0qp;
        }
        goto iA4OY;
        YiqtP:
        hpmrV:
        goto XOJLI;
        UKfXF:
        $jrygsum = number_format($jrygsum, 2, '.', '');
        goto e5ufB;
        mqhCL:
        FaJM7:
        goto TJlSm;
        XBKfy:
        h8s5e:
        goto w00mS;
        cFWWU:
        if (!empty($zrrjyj)) {
            goto f9GmB;
        }
        goto HspEz;
        ASuWS:
        s01Fe:
        goto J2f3N;
        u8XYL:
        VRg3O:
        goto LJgmX;
        QcKJg:
        if (empty($share['qdid'])) {
            goto FaJM7;
        }
        goto bwczB;
        axzEY:
        NEbra:
        goto BsP0U;
        Qoz3N:
        $byygsum = '0.00';
        goto U7VSA;
        kLLzg:
        goto FRHuG;
        goto NVa18;
        vf5nG:
        goto JlIxk;
        goto zEB10;
        zfaf3:
        $zrrjyj = number_format($zrrsjyj['yj2'] * $bl['dlbl2t3'] / 100, 2, '.', '');
        goto WUR8o;
        qhxJw:
        O7SNo:
        goto Q_Su1;
        jlpsF:
        if (!empty($jrzyj)) {
            goto fUDqY;
        }
        goto UMTnC;
        BsP0U:
        $rjfkyj = number_format($rsjfkyj['yj2'] * $bl['dlbl2t3'] / 100, 2, '.', '');
        goto T8kQM;
        sKfjR:
        $syzyj = '0.00';
        goto JLlpv;
        ZM6VH:
        $syzyj = '0.00';
        goto ZCQNl;
        kFu7R:
        XJ9e2:
        goto ftd0K;
        AW61q:
        $cj = $fs['cj'];
        goto Mcpbs;
        Jkfbe:
        HU181:
        goto qtdiB;
        LBDhC:
        if ($bl['fxtype'] == 1) {
            goto HVZi4;
        }
        goto wLKFk;
        KbOxs:
        $zttime = strtotime(date('Y-m-d 00:00:00', strtotime('-1 day')));
        goto DdihY;
        Tiaxm:
        f12OZ:
        goto ohqFf;
        tgMGD:
        WP9xq:
        goto CNiSJ;
        i46LJ:
        if (!empty($zrsjyj)) {
            goto PB5W0;
        }
        goto CCq2s;
        QHxdS:
        $wsyygsum = $this->bryj($share, $sbegin_time, $send_time, 2, $bl, $cfg);
        goto wuMq9;
        zP6Sq:
        $wsyrjyj = '0.00';
        goto Cy_q2;
        X2_no:
        O1AxC:
        goto l8Z8Q;
        oxKcE:
        SsBGX:
        goto jlpsF;
        MYfD3:
        $wsyzyj = $wsyygsum + $wsyrjyj + $wsysjyj;
        goto o53SH;
        Q7COj:
        if ($bl['fxtype'] == 1) {
            goto JvEJe;
        }
        goto zyqNc;
        dWitf:
        $byygsum = number_format($byygsum, 2, '.', '');
        goto KGKkC;
        aEhjT:
        QIZPb:
        goto PXN_Q;
        GxU8h:
        $sjyj = '0.00';
        goto FSgs3;
        e5ufB:
        $jrjyj = $this->bydlyj($share, $daytime, '', 3, $bl, $cfg);
        goto Rxd_z;
        gSvyw:
        $rjyj = '0.00';
        goto kFu7R;
        ipX6h:
        $syrsjyj = $this->bydlyj($share, $sbegin_time, $send_time, 1, $bl, $cfg, 1);
        goto amZTf;
        GK9NU:
        $syzyj = $syygsum + $syrjyj + $sysjyj;
        goto VZdC_;
        lf6kA:
        if (!empty($jrsjyj)) {
            goto eF8M_;
        }
        goto vWYje;
        wuMq9:
        $wsyygsum = number_format($wsyygsum, 2, '.', '');
        goto nNHqb;
        FSgs3:
        goto O7SNo;
        goto X2_no;
        C8Ej_:
        $jrsjyj = number_format($jrjyj['yj3'] * $bl['dlbl1t3'] / 100, 2, '.', '');
        goto YKMzW;
        ohqFf:
        $syygsum = $this->bryj($share, $sbegin_time, $send_time, 1, $bl, $cfg, 1);
        goto qOupF;
        dgabb:
        v4omQ:
        goto tv9t6;
        RWXFW:
        $byygsum = $this->bryj($share, $bbegin_time, $bend_time, 1, $bl, $cfg, 1);
        goto dWitf;
        lldj9:
        $sjyj = '0.00';
        goto oxKcE;
        Q_Su1:
        $brzyj = $byygsum + $rjyj + $sjyj;
        goto z3Wf1;
        Cy_q2:
        kV7X3:
        goto pw0N2;
        BFuUD:
        goto JN33A;
        goto mqhCL;
        NxO9H:
        f9GmB:
        goto i46LJ;
        LJgmX:
        $rjyj = number_format($rsjyj['yj2'] * $bl['dlbl1t2'] / 100, 2, '.', '');
        goto GxU8h;
        zJFrI:
        $byfksum = number_format($byfksum, 2, '.', '');
        goto pMAW6;
        p6SQb:
        if ($bl['dltype'] == 3) {
            goto BTet_;
        }
        goto RDseB;
        juxZ6:
        $brzfkyj = '0.00';
        goto Tiaxm;
        amZTf:
        if ($bl['fxtype'] == 1) {
            goto x0j7s;
        }
        goto JREE2;
        efThw:
        goto stLrZ;
        goto RYBy4;
        zEB10:
        KW0qp:
        goto AXalo;
        GEQek:
        $brzyj = $byygsum + $rjyj + $sjyj;
        goto RyrpN;
        TJlSm:
        $where = " and tgwid='{$share['tgwid']}'";
        goto fJFZ5;
        Hf33h:
        $syrjyj = number_format($syrsjyj['yj2'], 2, '.', '');
        goto jsVjN;
        PyGsR:
        u09uV:
        goto vN8wo;
        POeDV:
        stLrZ:
        goto lahot;
        o53SH:
        goto v4omQ;
        goto teuIz;
        hKIDj:
        $brzyj = '0.00';
        goto Vl96I;
        R2m7m:
        if (!empty($syygsum)) {
            goto BfXBG;
        }
        goto xMqdG;
        vrSmq:
        PB5W0:
        goto IJo9b;
        P4CZs:
        bPRF1:
        goto H5rSE;
        XOJLI:
        if (!empty($sysjyj)) {
            goto CG0oz;
        }
        goto P1QFC;
        RyrpN:
        Q3HRt:
        goto b678K;
        iA4OY:
        if ($bl['dltype'] == 3) {
            goto huCsY;
        }
        goto vf5nG;
        nNHqb:
        $wsyrsjyj = $this->bydlyj($share, $sbegin_time, $send_time, 2, $bl, $cfg);
        goto phXRm;
        xSGTQ:
        $jrygsum = '0.00';
        goto P4CZs;
        NJI1e:
        $jrzyj = $jrygsum + $jryj + $jrsjyj;
        goto Jkfbe;
        OgHza:
        goto JlIxk;
        goto Ir274;
        tv9t6:
        if (!empty($zjrzyj)) {
            goto s01Fe;
        }
        goto Gt0Uk;
        FAwpX:
        HVZi4:
        goto nuBvF;
        LDVQQ:
        $syrjyj = number_format($syrsjyj['yj2'] * $bl['dlbl1t2'] / 100, 2, '.', '');
        goto kLLzg;
        DVRPt:
        $bend_time = strtotime(date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('t'), date('Y'))));
        goto YiiSX;
        YiiSX:
        $sbegin_time = strtotime(date('Y-m-d', mktime(0, 0, 0, date('m') - 1, 1, date('Y'))));
        goto atI4g;
        qtdiB:
        if (!empty($jrzyj)) {
            goto Spz39;
        }
        goto ZA1Ej;
        U8r0q:
        $sjyj = number_format($rsjyj['yj3'] * $bl['dlbl1t3'] / 100, 2, '.', '');
        goto qhxJw;
        QtOI4:
        if (!empty($syrjyj)) {
            goto hpmrV;
        }
        goto thW3j;
        jLm8i:
        if (!empty($rjyj)) {
            goto XJ9e2;
        }
        goto gSvyw;
        jpq6z:
        y1LSA:
        goto zfaf3;
        CTAsh:
        goto stLrZ;
        goto axzEY;
        cM3Ky:
        cPtwt:
        goto lOef5;
        X5yXt:
        if ($bl['dltype'] == 3) {
            goto u09uV;
        }
        goto O7h9h;
        m8bdT:
        $fs = $this->jcbl($share, $bl);
        goto AW61q;
        lvH7C:
        $wsyygsum = '0.00';
        goto tV8pV;
        D2JLO:
        $jrzyj = $jrygsum + $jryj + $jrsjyj;
        goto HdVOF;
        atI4g:
        $send_time = strtotime(date('Y-m-d 23:59:59', strtotime(-date('d') . 'day')));
        goto WmkDj;
        Mcpbs:
        $jrygsum = $this->bryj($share, $daytime, '', 3, $bl, $cfg);
        goto UKfXF;
        Ifjud:
        lcZhV:
        goto rOXeG;
        wLKFk:
        if ($bl['dltype'] == 2) {
            goto VRg3O;
        }
        goto Jeqlh;
        WUR8o:
        $zrsjyj = number_format($zrrsjyj['yj3'] * $bl['dlbl1t3'] / 100, 2, '.', '');
        goto Ozhgs;
        ZwkSF:
        $zrsjyj = '0.00';
        goto QkJ66;
        kQCgr:
        $zrsjyj = number_format($zrrsjyj['yj3'], 2, '.', '');
        goto Vuiel;
        Rxd_z:
        if ($bl['fxtype'] == 1) {
            goto QESJQ;
        }
        goto tPaSg;
        itJV0:
        goto Q8I2t;
        goto Ifjud;
        yn3Dj:
        eF8M_:
        goto cFWWU;
        zCGW0:
        s2GAh:
        goto MYfD3;
        ZIB_m:
        if (!empty($brzyj)) {
            goto LNT2q;
        }
        goto hKIDj;
        W4KF8:
        goto hcDx1;
        goto tgMGD;
        BmPL1:
        $zrrsjyj = $this->bydlyj($share, $zttime, $daytime, 3, $bl, $cfg);
        goto Q7COj;
        YKMzW:
        JlIxk:
        goto D2JLO;
        xWXSC:
        goto O7SNo;
        goto u8XYL;
        Jeqlh:
        if ($bl['dltype'] == 3) {
            goto O1AxC;
        }
        goto xWXSC;
        SFhkp:
        global $_W;
        goto hYMZk;
        nuBvF:
        $rjyj = number_format($rsjyj['yj2'], 2, '.', '');
        goto MqX8A;
        P1QFC:
        $sysjyj = '0.00';
        goto fYhLn;
        RDseB:
        goto FRHuG;
        goto foAPF;
        Gu9_S:
        $zrzyj = $zrygsum + $zrrjyj + $zrsjyj;
        goto TYhGK;
        y8Zky:
        Q8I2t:
        goto YxdQZ;
        nehLe:
        $rjfkyj = number_format($rsjfkyj['yj2'] * $bl['dlbl1t2'] / 100, 2, '.', '');
        goto s6SOb;
        O7h9h:
        goto s2GAh;
        goto vfO2i;
        CCq2s:
        $zrsjyj = '0.00';
        goto vrSmq;
        alCyN:
        if ($bl['dltype'] == 2) {
            goto mMY0Z;
        }
        goto KUQ5T;
        MqX8A:
        $sjyj = number_format($rsjyj['yj3'], 2, '.', '');
        goto GEQek;
        DdihY:
        $bbegin_time = strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), 1, date('Y'))));
        goto DVRPt;
        qQW1A:
        Spz39:
        goto zm9ku;
        BrC55:
        $jrsjyj = number_format($jrjyj['yj3'], 2, '.', '');
        goto NJI1e;
        YpwTi:
        $zrrjyj = number_format($zrrsjyj['yj2'], 2, '.', '');
        goto kQCgr;
        jVyxv:
        UzH_0:
        goto lf6kA;
        WmkDj:
        $where = '';
        goto QcKJg;
        z3Wf1:
        goto Q3HRt;
        goto FAwpX;
        teuIz:
        GzKQ4:
        goto JEihP;
        U7VSA:
        IKEHB:
        goto jLm8i;
        ZA1Ej:
        $jrzyj = '0.00';
        goto qQW1A;
        T8kQM:
        $sjfkyj = number_format($rsjfkyj['yj3'] * $bl['dlbl1t3'] / 100, 2, '.', '');
        goto POeDV;
        JLlpv:
        yeidL:
        goto R2m7m;
        CRQ4S:
        $jryj = '0.00';
        goto jVyxv;
        aJPlY:
        $brzyj = '0.00';
        goto cM3Ky;
        bwczB:
        $where = " and  (tgwid='{$share['tgwid']}' || relation_id='{$share['qdid']}') ";
        goto BFuUD;
        mWhaQ:
        XtEKU:
        goto RWXFW;
        F1m9d:
        $wsysjyj = number_format($wsyrsjyj['yj3'] * $bl['dlbl1t3'] / 100, 2);
        goto zCGW0;
        ZCQNl:
        vmRK0:
        goto QHxdS;
        PXN_Q:
        if (!empty($zrzyj)) {
            goto XtEKU;
        }
        goto Y5nDU;
        TF_r4:
        goto s2GAh;
        goto PyGsR;
        QHxcV:
        if (!empty($syzyj)) {
            goto vmRK0;
        }
        goto ZM6VH;
        zm9ku:
        $zrygsum = $this->bryj($share, $zttime, $daytime, 3, $bl, $cfg);
        goto Qh38l;
        qa5Pw:
        DFYr7:
        goto ZIB_m;
        Jg1NT:
    }
    public function pddtqbl($share, $bl, $cfg)
    {
        goto YJOvN;
        EUfyF:
        BkbNo:
        goto h9ixG;
        OlUcD:
        Ukmk4:
        goto Cs0XZ;
        zKM2W:
        $zrsjyj = number_format($zrrsjyj['yj3'] * $bl['dlbl1t3'] / 100, 2, '.', '');
        goto L5fYM;
        qbOVb:
        $wsyrjyj = '0.00';
        goto NYULU;
        LVoz5:
        GunTJ:
        goto T_jea;
        Rr43v:
        T_VzH:
        goto TeOdN;
        cLhcX:
        $jryj = '0.00';
        goto IkPVs;
        NZH5h:
        if (!empty($syzyj)) {
            goto CCDcW;
        }
        goto FwF1V;
        omnAA:
        $jryj = number_format($jrjyj['yj2'] * $bl['dlbl2t3'] / 100, 2, '.', '');
        goto QoR0y;
        CTOLs:
        $send_time = strtotime(date('Y-m-d 23:59:59', strtotime(-date('d') . 'day')));
        goto sPAK3;
        Zg8vN:
        goto cMci3;
        goto eay36;
        QkDfv:
        $syzyj = '0.00';
        goto ivjZy;
        E2tgB:
        if (!empty($zrzyj)) {
            goto oZ5zl;
        }
        goto yuXtj;
        L5fYM:
        cMci3:
        goto P0UVx;
        u02xn:
        $wsyygsum = $this->pddbryj($share, $sbegin_time, $send_time, 1, $bl, $cfg);
        goto rw4Tb;
        NYULU:
        lyzGu:
        goto iE3Az;
        lcDhj:
        GW6_u:
        goto KT5SW;
        NkfDP:
        if ($bl['fxtype'] == 1) {
            goto oOxtL;
        }
        goto DO2cq;
        Aa86L:
        if ($bl['dltype'] == 3) {
            goto aKppD;
        }
        goto xMePN;
        p4uo9:
        $syrjyj = number_format($syrsjyj['yj2'] * $bl['dlbl2t3'] / 100, 2, '.', '');
        goto xJ8Pl;
        f3DxE:
        $brzyj = $byygsum + $rjyj + $sjyj;
        goto ujX2k;
        ujX2k:
        y0MQ3:
        goto zYZcb;
        qh4Vg:
        if ($bl['dltype'] == 2) {
            goto CCk9n;
        }
        goto zm1_Q;
        J_SbQ:
        AQxNj:
        goto cJ1NW;
        BlKp_:
        $jrygsum = $this->pddbryj($share, $daytime, '', 1, $bl, $cfg);
        goto lfg8C;
        WArgY:
        $byygsum = '0.00';
        goto l9rIN;
        Nm0vB:
        $bbegin_time = strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), 1, date('Y'))));
        goto xMFNo;
        ALlk0:
        $sjfkyj = number_format($rsjfkyj['yj3'], 2, '.', '');
        goto y4TZu;
        B0ZPK:
        CD5PX:
        goto E2tgB;
        b4C8I:
        $syrjyj = number_format($syrsjyj['yj2'] * $bl['dlbl1t2'] / 100, 2, '.', '');
        goto q8jAq;
        xJ8Pl:
        $sysjyj = number_format($syrsjyj['yj3'] * $bl['dlbl1t3'] / 100, 2, '.', '');
        goto N0xbt;
        ccUmL:
        if ($bl['dltype'] == 3) {
            goto XNgSF;
        }
        goto Zg8vN;
        TZOmY:
        goto fx61M;
        goto JA6U3;
        iKm3I:
        $wsyrjyj = number_format($wsyrsjyj['yj2'] * $bl['dlbl1t2'] / 100, 2);
        goto Wg52Q;
        KT5SW:
        $syygsum = $this->pddbryj($share, $sbegin_time, $send_time, 2, $bl, $cfg, 1);
        goto QnxGA;
        nNstC:
        YCwKZ:
        goto fTvkr;
        xqGQ1:
        tIc3V:
        goto owiqL;
        aAb1G:
        mgm7p:
        goto jaB71;
        da6dO:
        $syygsum = '0.00';
        goto OlUcD;
        ehmYs:
        if (!empty($brzyj)) {
            goto weqEz;
        }
        goto PaPjp;
        wkwP4:
        goto YVJ4l;
        goto wWfCk;
        a1ZSV:
        goto S67Z1;
        goto EUPO3;
        TXshF:
        $brzfkyj = $byfksum + $rjfkyj + $sjfkyj;
        goto MeVkq;
        WFXVQ:
        goto LSHLO;
        goto P4OF4;
        y4TZu:
        $brzfkyj = $byfksum + $rjfkyj + $sjfkyj;
        goto ZlqqG;
        ivjZy:
        n53fp:
        goto BmEE0;
        Cv1fX:
        LSHLO:
        goto wUDMz;
        CmhwW:
        $zrsjyj = '0.00';
        goto NTtOl;
        MYaJM:
        if (!empty($zjrzyj)) {
            goto wKd4Z;
        }
        goto dDTLH;
        pRusQ:
        if ($bl['dltype'] == 2) {
            goto Vs3Bd;
        }
        goto Aa86L;
        L5Ipc:
        $sjfkyj = number_format($rsjfkyj['yj3'] * $bl['dlbl1t3'] / 100, 2, '.', '');
        goto aQIYe;
        IkPVs:
        GGLlr:
        goto jNapi;
        D9AnR:
        goto CD5PX;
        goto nSGGD;
        WrjRT:
        Vs3Bd:
        goto lZo4k;
        tD_G7:
        $brzyj = '0.00';
        goto NhFe1;
        YJOvN:
        global $_W;
        goto ELByl;
        zm1_Q:
        if ($bl['dltype'] == 3) {
            goto Plx0n;
        }
        goto GlBgA;
        PaPjp:
        $brzyj = '0.00';
        goto cc_r4;
        JSSFo:
        $zrrjyj = number_format($zrrsjyj['yj2'] * $bl['dlbl2t3'] / 100, 2, '.', '');
        goto zKM2W;
        S4f9w:
        CCk9n:
        goto b4C8I;
        rw4Tb:
        $wsyygsum = number_format($wsyygsum, 2, '.', '');
        goto zZQQc;
        q8jAq:
        goto paSy_;
        goto Pa5rN;
        YOaZw:
        $syzyj = $syygsum + $syrjyj + $sysjyj;
        goto kMEHM;
        amQd0:
        $brzfkyj = '0.00';
        goto lcDhj;
        PWR54:
        UB1iA:
        goto XqORh;
        lyrmr:
        $zrzyj = $zrygsum + $zrrjyj + $zrsjyj;
        goto B0ZPK;
        xEzo1:
        $byfksum = $this->pddbryj($share, $bbegin_time, $bend_time, 1, $bl, $cfg);
        goto liOeN;
        yuXtj:
        $zrzyj = '0.00';
        goto Ih5yY;
        xDr3e:
        XhIvc:
        goto Dqx7Y;
        Pa5rN:
        Plx0n:
        goto p4uo9;
        BbHDq:
        if ($bl['dltype'] == 3) {
            goto XhIvc;
        }
        goto wkwP4;
        ZwZaJ:
        $jrsjyj = '0.00';
        goto LVoz5;
        ylgDa:
        if (!empty($sjyj)) {
            goto tIc3V;
        }
        goto V5X8I;
        xyOAi:
        $rsjfkyj = $this->pddbydlyj($share, $bbegin_time, $bend_time, 1, $bl, $cfg);
        goto SqKOj;
        Lzy2K:
        fx61M:
        goto MYaJM;
        uQK1O:
        $cj = $fs['cj'];
        goto BlKp_;
        Ty82v:
        $syzyj = $syygsum + $syrjyj + $sysjyj;
        goto HlCX4;
        Sx3Vx:
        if ($bl['dltype'] == 3) {
            goto Q6q02;
        }
        goto UwCZ3;
        WukdY:
        GgT92:
        goto nRMGJ;
        Wg52Q:
        goto YVJ4l;
        goto xDr3e;
        NhFe1:
        j168b:
        goto xEzo1;
        cnDQz:
        if (!empty($byygsum)) {
            goto gUKiT;
        }
        goto WArgY;
        y0IEh:
        $wsysjyj = '0.00';
        goto HROat;
        FIBoN:
        $jrjyj = $this->pddbydlyj($share, $daytime, '', 1, $bl, $cfg);
        goto NkfDP;
        Rb3Qj:
        $syrjyj = number_format($syrsjyj['yj2'], 2, '.', '');
        goto kwshH;
        hzwPw:
        if (!empty($brzfkyj)) {
            goto GW6_u;
        }
        goto amQd0;
        GlBgA:
        goto paSy_;
        goto S4f9w;
        pJZ4m:
        $byygsum = $this->pddbryj($share, $bbegin_time, $bend_time, 2, $bl, $cfg);
        goto lnS7b;
        OyDs1:
        $zrrjyj = number_format($zrrsjyj['yj2'], 2, '.', '');
        goto g1yNT;
        jNapi:
        if (!empty($jrsjyj)) {
            goto GunTJ;
        }
        goto ZwZaJ;
        Md3o8:
        $jrygsum = '0.00';
        goto JJljv;
        UwCZ3:
        goto adwtG;
        goto BkhFJ;
        HYEwV:
        if ($bl['fxtype'] == 1) {
            goto f0Vau;
        }
        goto Dmv3c;
        Dqx7Y:
        $wsyrjyj = number_format($wsyrsjyj['yj2'] * $bl['dlbl2t3'] / 100, 2);
        goto bqm6Y;
        sPAK3:
        $fs = $this->jcbl($share, $bl);
        goto uQK1O;
        xMFNo:
        $bend_time = strtotime(date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('t'), date('Y'))));
        goto LcL8G;
        tuJeJ:
        $syrsjyj = $this->pddbydlyj($share, $sbegin_time, $send_time, 2, $bl, $cfg, 1);
        goto fjC0A;
        EUPO3:
        aKppD:
        goto LfyrH;
        ZlqqG:
        zPEQI:
        goto hzwPw;
        NTtOl:
        goto cMci3;
        goto aKHvR;
        xRARp:
        if (!empty($jrzyj)) {
            goto nNC8C;
        }
        goto gk_Ps;
        Rh5TS:
        $sjfkyj = '0.00';
        goto a1ZSV;
        l9rIN:
        gUKiT:
        goto cH5Sg;
        Hit_0:
        return $array;
        goto z3zX0;
        kMXnl:
        $syrjyj = '0.00';
        goto Rr43v;
        Qw99C:
        $zrrjyj = '0.00';
        goto WukdY;
        nRMGJ:
        if (!empty($zrsjyj)) {
            goto YLUVa;
        }
        goto oswQ6;
        sMDnG:
        if ($bl['dltype'] == 2) {
            goto WdMa4;
        }
        goto BbHDq;
        lnS7b:
        $byygsum = number_format($byygsum, 2, '.', '');
        goto K3R68;
        ELByl:
        $daytime = strtotime(date('Y-m-d 00:00:00'));
        goto m1E7q;
        LvyKc:
        $jrzyj = $jrygsum + $jryj + $jrsjyj;
        goto iy6Ri;
        K3R68:
        $rsjyj = $this->pddbydlyj($share, $bbegin_time, $bend_time, 2, $bl, $cfg);
        goto N6aCm;
        Q3ctT:
        $jryj = number_format($jrjyj['yj2'], 2, '.', '');
        goto MHgFW;
        swEGb:
        $sjyj = number_format($rsjyj['yj3'], 2, '.', '');
        goto f3DxE;
        owiqL:
        if (!empty($jrzyj)) {
            goto AQxNj;
        }
        goto p526R;
        lfg8C:
        $jrygsum = number_format($jrygsum, 2, '.', '');
        goto FIBoN;
        jaB71:
        if (!empty($wsyzyj)) {
            goto i1zqc;
        }
        goto kUeHi;
        XqORh:
        if (!empty($wsyrjyj)) {
            goto lyzGu;
        }
        goto qbOVb;
        oHCNo:
        $sjyj = '0.00';
        goto WFXVQ;
        HlCX4:
        w_0V0:
        goto NZH5h;
        fU31d:
        AS2nq:
        goto Rb3Qj;
        MGRM1:
        nNC8C:
        goto X5gJU;
        h3tW3:
        if (!empty($syzyj)) {
            goto n53fp;
        }
        goto QkDfv;
        eay36:
        Yi_Qz:
        goto iP0Mr;
        SqKOj:
        if ($bl['fxtype'] == 1) {
            goto YCwKZ;
        }
        goto pRusQ;
        FwF1V:
        $syzyj = '0.00';
        goto P6S9Y;
        iE3Az:
        if (!empty($wsysjyj)) {
            goto rf7zp;
        }
        goto y0IEh;
        rQcro:
        $zrygsum = number_format($zrygsum, 2, '.', '');
        goto DY7tL;
        kUeHi:
        $wsyzyj = '0.00';
        goto An3Qj;
        l34RG:
        $rjyj = number_format($rsjyj['yj2'] * $bl['dlbl2t3'] / 100, 2, '.', '');
        goto dR26E;
        fTs5b:
        oOxtL:
        goto Q3ctT;
        P4OF4:
        QkaKu:
        goto l34RG;
        jfk3H:
        wKd4Z:
        goto h3tW3;
        XhVFv:
        harHM:
        goto xRARp;
        cJ1NW:
        if (!empty($jrygsum)) {
            goto iaX5G;
        }
        goto Md3o8;
        Dmv3c:
        if ($bl['dltype'] == 2) {
            goto Yi_Qz;
        }
        goto ccUmL;
        wUDMz:
        $brzyj = $byygsum + $rjyj + $sjyj;
        goto EQbd3;
        m1E7q:
        $zttime = strtotime(date('Y-m-d 00:00:00', strtotime('-1 day')));
        goto Nm0vB;
        iP0Mr:
        $zrrjyj = number_format($zrrsjyj['yj2'] * $bl['dlbl1t2'] / 100, 2, '.', '');
        goto CmhwW;
        SoYIA:
        $wsyygsum = '0.00';
        goto PWR54;
        Ih5yY:
        oZ5zl:
        goto pJZ4m;
        YjFO4:
        $rjyj = '0.00';
        goto RJFrt;
        T_jea:
        if (!empty($zrrjyj)) {
            goto GgT92;
        }
        goto Qw99C;
        HFgei:
        if ($bl['dltype'] == 2) {
            goto F5fFi;
        }
        goto rsWi4;
        fjC0A:
        if ($bl['fxtype'] == 1) {
            goto AS2nq;
        }
        goto qh4Vg;
        QoR0y:
        $jrsjyj = number_format($jrjyj['yj3'] * $bl['dlbl1t3'] / 100, 2, '.', '');
        goto JBazb;
        HROat:
        rf7zp:
        goto ehmYs;
        kMEHM:
        goto w_0V0;
        goto fU31d;
        JBazb:
        adwtG:
        goto LvyKc;
        lZo4k:
        $rjfkyj = number_format($rsjfkyj['yj2'] * $bl['dlbl1t2'] / 100, 2, '.', '');
        goto Rh5TS;
        dDTLH:
        $zjrzyj = '0.00';
        goto jfk3H;
        P6S9Y:
        CCDcW:
        goto u02xn;
        TeOdN:
        if (!empty($sysjyj)) {
            goto mgm7p;
        }
        goto r2dkk;
        gLFma:
        goto LSHLO;
        goto YT03R;
        liOeN:
        $byfksum = number_format($byfksum, 2, '.', '');
        goto xyOAi;
        fTvkr:
        $rjfkyj = number_format($rsjfkyj['yj2'], 2, '.', '');
        goto ALlk0;
        rsWi4:
        if ($bl['dltype'] == 3) {
            goto QkaKu;
        }
        goto gLFma;
        Cs0XZ:
        if (!empty($syrjyj)) {
            goto T_VzH;
        }
        goto kMXnl;
        kpHhK:
        if ($bl['fxtype'] == 1) {
            goto qECDH;
        }
        goto sMDnG;
        r2dkk:
        $sysjyj = '0.00';
        goto aAb1G;
        UGHiq:
        $wsyrjyj = number_format($wsyrsjyj['yj2'], 2, '.', '');
        goto r37SJ;
        EQbd3:
        goto y0MQ3;
        goto EUfyF;
        bqm6Y:
        $wsysjyj = number_format($wsyrsjyj['yj3'] * $bl['dlbl1t3'] / 100, 2);
        goto mdKIN;
        iy6Ri:
        goto harHM;
        goto fTs5b;
        MHgFW:
        $jrsjyj = number_format($jrjyj['yj3'], 2, '.', '');
        goto zzHtF;
        CTFWA:
        $array = array("zong" => $zjrzyj, "s1" => $syzyj, "s2" => $syygsum, "s3" => $syrjyj, "s4" => $sysjyj, "s5" => $wsyzyj, "s6" => $wsyygsum, "s7" => $wsyrjyj, "s8" => $wsysjyj, "b1" => $brzyj, "b2" => $byygsum, "b3" => $rjyj, "b4" => $sjyj, "d1" => $brzfkyj, "d2" => $byfksum, "d3" => $rjfkyj, "d4" => $sjfkyj, "z1" => $zrzyj, "z2" => $zrygsum, "z3" => $zrrjyj, "z4" => $zrsjyj, "j1" => $jrzyj, "j2" => $jrygsum, "j3" => $jryj, "j4" => $jrsjyj);
        goto Hit_0;
        BkhFJ:
        cE9pc:
        goto AR9D3;
        An3Qj:
        i1zqc:
        goto CMRDE;
        JA6U3:
        qECDH:
        goto UGHiq;
        MeVkq:
        goto zPEQI;
        goto nNstC;
        g1yNT:
        $zrsjyj = number_format($zrrsjyj['yj3'], 2, '.', '');
        goto lyrmr;
        FLo3y:
        if (!empty($jryj)) {
            goto GGLlr;
        }
        goto cLhcX;
        DY7tL:
        $zrrsjyj = $this->pddbydlyj($share, $zttime, $daytime, 1, $bl, $cfg);
        goto HYEwV;
        LcL8G:
        $sbegin_time = strtotime(date('Y-m-d', mktime(0, 0, 0, date('m') - 1, 1, date('Y'))));
        goto CTOLs;
        JJljv:
        iaX5G:
        goto FLo3y;
        zZQQc:
        $wsyrsjyj = $this->pddbydlyj($share, $sbegin_time, $send_time, 1, $bl, $cfg);
        goto kpHhK;
        wWfCk:
        WdMa4:
        goto iKm3I;
        CMRDE:
        if (!empty($wsyygsum)) {
            goto UB1iA;
        }
        goto SoYIA;
        V5X8I:
        $sjyj = '0.00';
        goto xqGQ1;
        h9ixG:
        $rjyj = number_format($rsjyj['yj2'], 2, '.', '');
        goto swEGb;
        EGDcK:
        $wsyzyj = $wsyygsum + $wsyrjyj + $wsysjyj;
        goto TZOmY;
        Dhj65:
        Q6q02:
        goto omnAA;
        P0UVx:
        $zrzyj = $zrygsum + $zrrjyj + $zrsjyj;
        goto D9AnR;
        X5gJU:
        $zrygsum = $this->pddbryj($share, $zttime, $daytime, 1, $bl, $cfg);
        goto rQcro;
        cDtMD:
        YLUVa:
        goto CTFWA;
        kwshH:
        $sysjyj = number_format($syrsjyj['yj3'], 2, '.', '');
        goto Ty82v;
        nSGGD:
        f0Vau:
        goto OyDs1;
        WiZiS:
        $wsyzyj = $wsyygsum + $wsyrjyj + $wsysjyj;
        goto Lzy2K;
        r37SJ:
        $wsysjyj = number_format($wsyrsjyj['yj3'], 2, '.', '');
        goto WiZiS;
        cH5Sg:
        if (!empty($rjyj)) {
            goto veTdJ;
        }
        goto YjFO4;
        gk_Ps:
        $jrzyj = '0.00';
        goto MGRM1;
        zzHtF:
        $jrzyj = $jrygsum + $jryj + $jrsjyj;
        goto XhVFv;
        dR26E:
        $sjyj = number_format($rsjyj['yj3'] * $bl['dlbl1t3'] / 100, 2, '.', '');
        goto Cv1fX;
        YT03R:
        F5fFi:
        goto y4V9i;
        BmEE0:
        if (!empty($syygsum)) {
            goto Ukmk4;
        }
        goto da6dO;
        AR9D3:
        $jryj = number_format($jrjyj['yj2'] * $bl['dlbl1t2'] / 100, 2, '.', '');
        goto qmLrb;
        aQIYe:
        S67Z1:
        goto TXshF;
        RJFrt:
        veTdJ:
        goto ylgDa;
        cc_r4:
        weqEz:
        goto cnDQz;
        N0xbt:
        paSy_:
        goto YOaZw;
        oswQ6:
        $zrsjyj = '0.00';
        goto cDtMD;
        N6aCm:
        if ($bl['fxtype'] == 1) {
            goto BkbNo;
        }
        goto HFgei;
        mdKIN:
        YVJ4l:
        goto EGDcK;
        y4V9i:
        $rjyj = number_format($rsjyj['yj2'] * $bl['dlbl1t2'] / 100, 2, '.', '');
        goto oHCNo;
        QnxGA:
        $syygsum = number_format($syygsum, 2, '.', '');
        goto tuJeJ;
        xMePN:
        goto S67Z1;
        goto WrjRT;
        aKHvR:
        XNgSF:
        goto JSSFo;
        p526R:
        $jrzyj = '0.00';
        goto J_SbQ;
        zYZcb:
        if (!empty($brzyj)) {
            goto j168b;
        }
        goto tD_G7;
        qmLrb:
        goto adwtG;
        goto Dhj65;
        LfyrH:
        $rjfkyj = number_format($rsjfkyj['yj2'] * $bl['dlbl2t3'] / 100, 2, '.', '');
        goto L5Ipc;
        DO2cq:
        if ($bl['dltype'] == 2) {
            goto cE9pc;
        }
        goto Sx3Vx;
        z3zX0:
    }
    public function pddbydlyj($share = "", $begin_time = "", $end_time = "", $zt = "", $bl = "", $cfg = "", $sd = 0)
    {
        goto wYDtI;
        w8Cb1:
        goto aOUu2;
        goto Bagjf;
        n0778:
        $rjrs = $rjrs * (100 - $bl['dlkcbl']) / 100;
        goto hs9i6;
        TW8Jd:
        $bbegin_time = strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), 1, date('Y'))));
        goto A1ufh;
        hs9i6:
        fVs9S:
        goto pLifm;
        PqvTX:
        $rjrs = '0.00';
        goto UV8OX;
        e5qyv:
        return $array;
        goto TG6Tg;
        jHgRt:
        a4HLy:
        goto SwbHp;
        apcpC:
        $sjrs = '0.00';
        goto dQjdA;
        E4fTD:
        j4uhb:
        goto N4HGL;
        YxvqA:
        aRgds:
        goto nNTVV;
        Csl_g:
        $addtime = 'order_pay_time';
        goto e2EjJ;
        GZgZ1:
        if ($zt == 2) {
            goto ZCfGh;
        }
        goto GswSq;
        t7YKw:
        pYEPU:
        goto TW8Jd;
        W20Gd:
        if ($begin_time == $bbegin_time1 and $end_time == $bend_time1) {
            goto Fhgiw;
        }
        goto Csl_g;
        Y1fw3:
        if (empty($bl['dlkcbl'])) {
            goto fVs9S;
        }
        goto n0778;
        Uq8GP:
        $ddzt = ' and (order_status_desc=\'已成团\' || order_status_desc=\'审核通过\')';
        goto XjzZy;
        CmWIq:
        if (empty($fans1)) {
            goto aRgds;
        }
        goto s8kFt;
        N4HGL:
        $array = array("yj2" => $rjrs * $bl['dlbl2'] / 100, "yj3" => $sjrs * $bl['dlbl3'] / 100);
        goto e5qyv;
        eANNO:
        $bl['dlbl1'] = $share['dlbl'];
        goto GXE3S;
        Ek1aw:
        $sjrs = $sjrs * (100 - $bl['dlkcbl']) / 100;
        goto pOYWI;
        Ipy4S:
        rQZ67:
        goto dtuFj;
        CQUGm:
        $rjrs = '0.00';
        goto TF3wb;
        Wkabg:
        Y5En5:
        goto zvsBY;
        IcQbL:
        if (empty($end_time)) {
            goto g3SMz;
        }
        goto bYFT_;
        cJOM1:
        $r = '';
        goto hgkL2;
        RPWcw:
        goto wIkG1;
        goto LsT21;
        dtuFj:
        if (!($bl['dltype'] == 1)) {
            goto j4uhb;
        }
        goto PqvTX;
        F84hY:
        if (empty($share['dlbl'])) {
            goto HomAm;
        }
        goto eANNO;
        CoLA6:
        $where = "and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
        goto PS2Sq;
        PhUeI:
        $addtime = 'order_pay_time';
        goto XGiKp;
        xZvjI:
        $where = "and order_pay_time>={$begin_time}";
        goto WaHnd;
        xBaPR:
        $rjrs = $r;
        goto Y1fw3;
        DKOSf:
        $addtime = 'order_receive_time';
        goto jHgRt;
        s8kFt:
        $sjrs = pdo_fetchcolumn('SELECT sum(t.promotion_amount) FROM ' . tablename('tiger_newhu_share') . ' s left join ' . tablename('tiger_newhu_pddorder') . " t ON s.pddpid=t.p_id where s.weid='{$_W['uniacid']}'   and s.dltype=1  {$ddzt} and s.helpid in (" . implode(',', array_keys($fans1)) . ") {$where}");
        goto YxvqA;
        XGiKp:
        ToFEu:
        goto Q5PnQ;
        TF3wb:
        Htckk:
        goto cPBo3;
        zcI5k:
        Fhgiw:
        goto GZgZ1;
        E_Wx7:
        oUji3:
        goto qfVUp;
        A79Fr:
        if ($send_time == $end_time) {
            goto DR1ze;
        }
        goto W20Gd;
        Xk4K0:
        if (!($sd == 1)) {
            goto miEyD;
        }
        goto o6YDN;
        GXE3S:
        HomAm:
        goto Roekl;
        dQjdA:
        goto rQZ67;
        goto E_Wx7;
        eWI4p:
        B8vRp:
        goto xBaPR;
        LsT21:
        g3SMz:
        goto llKEs;
        o6YDN:
        $addtime = 'order_receive_time';
        goto pR8Qo;
        pLifm:
        if (!empty($rjrs)) {
            goto Htckk;
        }
        goto CQUGm;
        Bagjf:
        yVLi_:
        goto A79Fr;
        Q5PnQ:
        aOUu2:
        goto Xk4K0;
        KAhAl:
        $sjrs = '0.00';
        goto rztzl;
        BK8dp:
        wIkG1:
        goto gnOfy;
        SwbHp:
        JyqvM:
        goto MOxhV;
        zvsBY:
        $ddzt = ' and (order_status_desc=\'确认收货\' || order_status_desc=\'已结算\')';
        goto t7YKw;
        XmxhC:
        DR1ze:
        goto M7hi4;
        gnOfy:
        if ($zt == 2) {
            goto Y5En5;
        }
        goto Uq8GP;
        XjzZy:
        goto pYEPU;
        goto Wkabg;
        s2tc2:
        ZCfGh:
        goto DKOSf;
        WaHnd:
        L8wNH:
        goto BK8dp;
        GswSq:
        $addtime = 'order_pay_time';
        goto yzs9O;
        Roekl:
        $send_time = strtotime(date('Y-m-d 23:59:59', strtotime(-date('d') . 'day')));
        goto QVbW2;
        PS2Sq:
        MTGoO:
        goto RPWcw;
        qfVUp:
        $fans1 = pdo_fetchall('select id from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and dltype=1 and helpid='{$share['id']}'", array(), 'id');
        goto CmWIq;
        Hw01D:
        goto JyqvM;
        goto zcI5k;
        nNTVV:
        if (empty($bl['dlkcbl'])) {
            goto KBuCu;
        }
        goto Ek1aw;
        A1ufh:
        $rjshare = pdo_fetchall('SELECT id,helpid,pddpid FROM ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and helpid='{$share['id']}' and dltype=1");
        goto cJOM1;
        pOYWI:
        KBuCu:
        goto Ho2qp;
        yzs9O:
        goto a4HLy;
        goto s2tc2;
        cPBo3:
        if ($bl['dltype'] == 3) {
            goto oUji3;
        }
        goto apcpC;
        MOxhV:
        if (!($zt == 1)) {
            goto ToFEu;
        }
        goto PhUeI;
        bYFT_:
        if (empty($begin_time)) {
            goto MTGoO;
        }
        goto CoLA6;
        QVbW2:
        if ($cfg['jsms'] == 1) {
            goto yVLi_;
        }
        goto EwcOS;
        rztzl:
        e4iiq:
        goto Ipy4S;
        wYDtI:
        global $_W;
        goto F84hY;
        llKEs:
        if (empty($begin_time)) {
            goto L8wNH;
        }
        goto xZvjI;
        Ho2qp:
        if (!empty($sjrs)) {
            goto e4iiq;
        }
        goto KAhAl;
        EwcOS:
        $addtime = 'order_pay_time';
        goto w8Cb1;
        M7hi4:
        $addtime = 'order_receive_time';
        goto Hw01D;
        hgkL2:
        foreach ($rjshare as $k => $v) {
            goto WCfJa;
            lO3Zr:
            QKL9q:
            goto yeydH;
            WCfJa:
            $a = pdo_fetchcolumn('SELECT sum(promotion_amount) FROM ' . tablename('tiger_newhu_pddorder') . "  where weid='{$_W['uniacid']}' and p_id='{$v['pddpid']}' {$ddzt} {$where}");
            goto ayO5z;
            ayO5z:
            $r = $r + $a;
            goto lO3Zr;
            yeydH:
        }
        goto eWI4p;
        e2EjJ:
        goto JyqvM;
        goto XmxhC;
        pR8Qo:
        miEyD:
        goto IcQbL;
        UV8OX:
        $sjrs = '0.00';
        goto E4fTD;
        TG6Tg:
    }
    public function pddbryj($share, $begin_time, $end_time, $zt, $bl, $cfg, $sd = 0)
    {
        goto E413Q;
        euct1:
        $where = " and p_id='{$share['pddpid']}'";
        goto G5Wlw;
        D7oVA:
        return $byygsum;
        goto hOeOa;
        bonCC:
        if ($send_time == $end_time) {
            goto NBahc;
        }
        goto TQRtM;
        aMf8i:
        $byygsum = $yj3 - $yj2 - $yj1;
        goto rRUBo;
        KLl1I:
        lRxxN:
        goto URf_X;
        Utit4:
        $byygsum = '0.00';
        goto ZhGHj;
        x2xwl:
        if (empty($end_time)) {
            goto x0sTV;
        }
        goto cb9sR;
        HD1n6:
        if ($zt == 2) {
            goto DGHDy;
        }
        goto yuU_1;
        tZNYP:
        goto R0SrX;
        goto gwtX6;
        xNF21:
        eH_wi:
        goto CQS1W;
        VwALv:
        $sj2 = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$sj['helpid']}'");
        goto QJ83P;
        WRZn2:
        BfiXe:
        goto euct1;
        u3CYc:
        V3qTT:
        goto fr8dr;
        vXUqS:
        if (empty($byygsum)) {
            goto bio8u;
        }
        goto xdRu9;
        HK2o0:
        goto YScFO;
        goto LRHC6;
        ZpixC:
        if ($cfg['jsms'] == 1) {
            goto jhSVl;
        }
        goto leDpb;
        cb9sR:
        if (empty($begin_time)) {
            goto M7ILt;
        }
        goto X9sJA;
        gwtX6:
        bio8u:
        goto Utit4;
        aC4Uq:
        qw9HY:
        goto OZoZS;
        G_qne:
        goto GZkrg;
        goto AQY65;
        jLSs9:
        jhSVl:
        goto bonCC;
        gLusu:
        DGHDy:
        goto pjhyi;
        NZMhX:
        ZF6MI:
        goto tZNYP;
        fr8dr:
        $send_time = strtotime(date('Y-m-d 23:59:59', strtotime(-date('d') . 'day')));
        goto eo_Sl;
        uduZy:
        pdP09:
        goto x2xwl;
        RbHSy:
        goto eH_wi;
        goto gLusu;
        pjhyi:
        $addtime = 'order_receive_time';
        goto xNF21;
        XjlHZ:
        $addtime = 'order_pay_time';
        goto HK2o0;
        cG3e4:
        if (empty($bl['dlkcbl'])) {
            goto orwgt;
        }
        goto eOw5y;
        ZsOhX:
        M7ILt:
        goto G_qne;
        leDpb:
        $addtime = 'order_pay_time';
        goto GLHcN;
        WvmJG:
        goto yN5ws;
        goto QG9Xz;
        OZoZS:
        $yj2 = $byygsum * $bl['dlbl2'] / 100;
        goto ZuuwM;
        eo_Sl:
        $bbegin_time1 = strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), 1, date('Y'))));
        goto es6NF;
        HL1Ya:
        $dj = 1;
        goto WvmJG;
        LRHC6:
        NBahc:
        goto veVJh;
        uD3av:
        yN5ws:
        goto Xr5Xt;
        rDas3:
        $addtime = 'order_receive_time';
        goto uduZy;
        MxKzs:
        $byygsum = $byygsum * $bl['dlbl1'] / 100;
        goto bNBv1;
        ZuuwM:
        $yj1 = $yj2 * $bl['dlbl1t2'] / 100;
        goto glLDs;
        CQS1W:
        YScFO:
        goto rwWxj;
        Xr5Xt:
        m9AiE:
        goto NZMhX;
        fIV1I:
        if ($dj == 2) {
            goto Bqge2;
        }
        goto MxKzs;
        FfKLn:
        $yj1 = $yj3 * $bl['dlbl1t3'] / 100;
        goto aMf8i;
        Zb5Yh:
        $yj2 = $yj3 * $bl['dlbl2t3'] / 100;
        goto FfKLn;
        GlE3V:
        if (empty($share['dlbl'])) {
            goto V3qTT;
        }
        goto Kpgl9;
        AQY65:
        x0sTV:
        goto wr_Ka;
        TXsKS:
        $yj3 = $byygsum * $bl['dlbl3'] / 100;
        goto Zb5Yh;
        x9SZM:
        a4G2i:
        goto yVsBT;
        ctX4B:
        goto yPl1b;
        goto dLSeZ;
        bODCq:
        $byygsum = $byygsum * $bl['dlbl1'] / 100;
        goto LynHV;
        yuU_1:
        $addtime = 'order_pay_time';
        goto RbHSy;
        QgKhN:
        if ($dj == 1) {
            goto qw9HY;
        }
        goto fIV1I;
        IAMbW:
        MudHZ:
        goto VwALv;
        QJ83P:
        if (!($bl['dltype'] == 3)) {
            goto m9AiE;
        }
        goto gK_db;
        qs5N9:
        $ddzt = ' and (order_status_desc=\'确认收货\' || order_status_desc=\'已结算\')';
        goto WRZn2;
        YPvmo:
        goto BfiXe;
        goto pJjFp;
        WBZoA:
        ltm8b:
        goto HD1n6;
        Tjwmo:
        wKIy2:
        goto x9SZM;
        GLHcN:
        goto a4G2i;
        goto jLSs9;
        pJjFp:
        ZB3G6:
        goto qs5N9;
        b98rE:
        orwgt:
        goto vXUqS;
        LynHV:
        yIzek:
        goto D7oVA;
        Kpgl9:
        $bl['dlbl1'] = $share['dlbl'];
        goto u3CYc;
        rRUBo:
        yPl1b:
        goto Yxy0b;
        vgigq:
        if (!($bl['dltype'] == 2)) {
            goto MudHZ;
        }
        goto iLdkG;
        wr_Ka:
        if (empty($begin_time)) {
            goto lRxxN;
        }
        goto Q__Ul;
        yVsBT:
        if (!($sd == 1)) {
            goto pdP09;
        }
        goto rDas3;
        iLdkG:
        $dj = 1;
        goto IAMbW;
        ExjTi:
        if (empty($sj)) {
            goto ZF6MI;
        }
        goto vgigq;
        G5Wlw:
        $byygsum = pdo_fetchcolumn('SELECT sum(promotion_amount) FROM ' . tablename('tiger_newhu_pddorder') . " where weid='{$_W['uniacid']}'  {$ddzt} {$dwhere} {$where}");
        goto cG3e4;
        xdRu9:
        $sj = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");
        goto ExjTi;
        dLSeZ:
        Bqge2:
        goto TXsKS;
        QG9Xz:
        Gn934:
        goto I_aQl;
        glLDs:
        $byygsum = $yj2 - $yj1;
        goto ctX4B;
        es6NF:
        $bend_time1 = strtotime(date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('t'), date('Y'))));
        goto ZpixC;
        X9sJA:
        $dwhere = "and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
        goto ZsOhX;
        veVJh:
        $addtime = 'order_receive_time';
        goto Rzet9;
        Q__Ul:
        $dwhere = "and order_pay_time>={$begin_time}";
        goto KLl1I;
        rwWxj:
        if (!($zt == 1)) {
            goto wKIy2;
        }
        goto JqCL9;
        I_aQl:
        $dj = 2;
        goto uD3av;
        JqCL9:
        $addtime = 'order_pay_time';
        goto Tjwmo;
        URf_X:
        GZkrg:
        goto S_80n;
        ZhGHj:
        R0SrX:
        goto QVBob;
        E413Q:
        global $_W;
        goto GlE3V;
        gK_db:
        if (!empty($sj2)) {
            goto Gn934;
        }
        goto HL1Ya;
        Yxy0b:
        goto yIzek;
        goto JIOc4;
        bNBv1:
        goto yPl1b;
        goto aC4Uq;
        Rzet9:
        goto YScFO;
        goto WBZoA;
        JIOc4:
        ukF3T:
        goto bODCq;
        sUcOS:
        $ddzt = ' and (order_status_desc=\'已成团\' || order_status_desc=\'审核通过\')';
        goto YPvmo;
        QVBob:
        if ($bl['fxtype'] == 1) {
            goto ukF3T;
        }
        goto QgKhN;
        eOw5y:
        $byygsum = $byygsum * (100 - $bl['dlkcbl']) / 100;
        goto b98rE;
        TQRtM:
        if ($begin_time == $bbegin_time1 and $end_time == $bend_time1) {
            goto ltm8b;
        }
        goto XjlHZ;
        S_80n:
        if ($zt == 2) {
            goto ZB3G6;
        }
        goto sUcOS;
        hOeOa:
    }
    public function bryj($share, $begin_time, $end_time, $zt, $bl, $cfg, $sd = 0)
    {
        goto CJb7R;
        Sput1:
        $yj3 = $byygsum * $bl['dlbl3'] / 100;
        goto mj9x4;
        QLh6_:
        if ($begin_time == $bbegin_time1 and $end_time == $bend_time1) {
            goto vYKrt;
        }
        goto rFtYm;
        gOMKF:
        YOm8o:
        goto Hnfp7;
        EqOwG:
        TeYvp:
        goto slT8z;
        NiNN8:
        if (empty($begin_time)) {
            goto MrKTe;
        }
        goto zIwAk;
        f4suc:
        Ab9p9:
        goto xUkbX;
        zIwAk:
        $dwhere = "and addtime>={$begin_time}";
        goto H4Kbc;
        q1tdv:
        if ($dj == 1) {
            goto tvTWc;
        }
        goto b41tv;
        LdooG:
        goto YOm8o;
        goto SbIRF;
        mMrUc:
        uBMjS:
        goto sAsE1;
        d72Zj:
        if (empty($byygsum)) {
            goto HeHYU;
        }
        goto Mykbb;
        LwgaK:
        if (!($bl['dltype'] == 3)) {
            goto ryytu;
        }
        goto yVOCw;
        aiYxX:
        $addtime = 'jstime';
        goto LdooG;
        Elc7r:
        if ($send_time == $end_time) {
            goto qFM1y;
        }
        goto QLh6_;
        w_oq9:
        goto FQ02q;
        goto UFxyq;
        aLV7j:
        $ddzt = ' and orderzt=\'订单付款\'';
        goto inoXT;
        BXH96:
        $bl['dlbl1'] = $share['dlbl'];
        goto f4suc;
        EWw9t:
        goto f0_Wq;
        goto gGyV1;
        OVAbb:
        kFB3P:
        goto d72Zj;
        UFxyq:
        HeHYU:
        goto eiOHn;
        zLCYL:
        $yj1 = $yj2 * $bl['dlbl1t2'] / 100;
        goto FY7xx;
        ht1P4:
        QThWK:
        goto FxP0w;
        ha7dR:
        $byygsum = $yj3 - $yj2 - $yj1;
        goto nVgBc;
        PSCrE:
        $dj = 1;
        goto KTZOW;
        WjkS9:
        $where = " and tgwid='{$share['tgwid']}'";
        goto ldUCg;
        HDsao:
        goto Id5Bq;
        goto fwb7c;
        HCXi_:
        $ddzt = ' and orderzt=\'订单结算\'';
        goto dRoSN;
        jQovz:
        if (!($sd == 1)) {
            goto GRV6Z;
        }
        goto PSg7_;
        gPMVm:
        goto QThWK;
        goto mMrUc;
        mj9x4:
        $yj2 = $yj3 * $bl['dlbl2t3'] / 100;
        goto yhGm7;
        HzjsW:
        goto f0_Wq;
        goto ZMOdK;
        Q1G0f:
        GpPfj:
        goto NiNN8;
        ogLN_:
        min00:
        goto w_oq9;
        F9k_3:
        cxnV2:
        goto la7If;
        dRoSN:
        goto TeYvp;
        goto tY9us;
        JmBdz:
        $bend_time1 = strtotime(date('Y-m-d H:i:s', mktime(23, 59, 59, date('m'), date('t'), date('Y'))));
        goto l3pgF;
        gPf1d:
        J3WkA:
        goto LB26w;
        H4Kbc:
        MrKTe:
        goto Xgyev;
        KknXz:
        $addtime = 'addtime';
        goto HDsao;
        Xgyev:
        IMHg2:
        goto D62Bg;
        j_Cyu:
        goto YOm8o;
        goto cSLpW;
        jXjBI:
        sqbY0:
        goto WjkS9;
        urqg4:
        BzqsW:
        goto jQovz;
        ZMOdK:
        tvTWc:
        goto DfKkc;
        dN5qJ:
        if (empty($bl['dlkcbl'])) {
            goto kFB3P;
        }
        goto dMdEq;
        LB26w:
        ryytu:
        goto ogLN_;
        tY9us:
        riy6M:
        goto aLV7j;
        CJb7R:
        global $_W;
        goto yl9j3;
        fb0LX:
        $ddzt = ' and orderzt<>\'订单失效\'';
        goto EqOwG;
        l3pgF:
        if ($cfg['jsms'] == 1) {
            goto qhuHj;
        }
        goto FrtNi;
        JqOgD:
        qhuHj:
        goto Elc7r;
        HXBWu:
        $dwhere = "and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
        goto F9k_3;
        FY7xx:
        $byygsum = $yj2 - $yj1;
        goto EWw9t;
        N3hTD:
        goto BzqsW;
        goto JqOgD;
        ezZDH:
        if (empty($begin_time)) {
            goto cxnV2;
        }
        goto HXBWu;
        bKC1X:
        if (empty($share['qdid'])) {
            goto sqbY0;
        }
        goto nbL8T;
        slT8z:
        $where = '';
        goto bKC1X;
        ldUCg:
        KpWlO:
        goto xgRrN;
        P4w51:
        $byygsum = $byygsum * $bl['dlbl1'] / 100;
        goto HzjsW;
        FxP0w:
        return $byygsum;
        goto KVFL9;
        yVOCw:
        if (!empty($sj2)) {
            goto uI4Dl;
        }
        goto OzGYL;
        JdK1M:
        $sj2 = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$sj['helpid']}'");
        goto LwgaK;
        rQ1wC:
        if (empty($sj)) {
            goto min00;
        }
        goto FkOvQ;
        DfKkc:
        $yj2 = $byygsum * $bl['dlbl2'] / 100;
        goto zLCYL;
        g090P:
        GRV6Z:
        goto xZ5TW;
        oXG2Y:
        FQ02q:
        goto GGdoI;
        D62Bg:
        if ($zt == 1) {
            goto lkN_J;
        }
        goto s7zNL;
        OzGYL:
        $dj = 1;
        goto sWnKR;
        SbIRF:
        vYKrt:
        goto gUCQ3;
        rFtYm:
        $addtime = 'addtime';
        goto j_Cyu;
        xZ5TW:
        if (empty($end_time)) {
            goto GpPfj;
        }
        goto ezZDH;
        la7If:
        goto IMHg2;
        goto Q1G0f;
        FrtNi:
        $addtime = 'addtime';
        goto N3hTD;
        xUkbX:
        $send_time = strtotime(date('Y-m-d 23:59:59', strtotime(-date('d') . 'day')));
        goto fmL2h;
        sWnKR:
        goto J3WkA;
        goto GKnxd;
        nbL8T:
        $where = " and  (tgwid='{$share['tgwid']}' || relation_id='{$share['qdid']}') ";
        goto kfyhX;
        dMdEq:
        $byygsum = $byygsum * (100 - $bl['dlkcbl']) / 100;
        goto OVAbb;
        Mykbb:
        $sj = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");
        goto rQ1wC;
        yl9j3:
        if (empty($share['dlbl'])) {
            goto Ab9p9;
        }
        goto BXH96;
        lJMaq:
        pu_NT:
        goto fb0LX;
        XZur4:
        $dj = 2;
        goto gPf1d;
        kfyhX:
        goto KpWlO;
        goto jXjBI;
        inoXT:
        goto TeYvp;
        goto lJMaq;
        J3eTu:
        lkN_J:
        goto HCXi_;
        vdyx1:
        $addtime = 'jstime';
        goto cm3vH;
        KTZOW:
        MoaRK:
        goto JdK1M;
        sAsE1:
        $byygsum = $byygsum * $bl['dlbl1'] / 100;
        goto ht1P4;
        fmL2h:
        $bbegin_time1 = strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), 1, date('Y'))));
        goto JmBdz;
        GGdoI:
        if ($bl['fxtype'] == 1) {
            goto uBMjS;
        }
        goto q1tdv;
        PSg7_:
        $addtime = 'jstime';
        goto g090P;
        gGyV1:
        Ob2qZ:
        goto Sput1;
        FRLgJ:
        if ($zt == 3) {
            goto pu_NT;
        }
        goto xemPP;
        FkOvQ:
        if (!($bl['dltype'] == 2)) {
            goto MoaRK;
        }
        goto PSCrE;
        GKnxd:
        uI4Dl:
        goto XZur4;
        gUCQ3:
        if ($zt == 1) {
            goto MuWPF;
        }
        goto KknXz;
        fwb7c:
        MuWPF:
        goto vdyx1;
        cm3vH:
        Id5Bq:
        goto gOMKF;
        e0B4b:
        $addtime = 'addtime';
        goto tmi9V;
        Hnfp7:
        if (!($zt == 2)) {
            goto FrsyD;
        }
        goto e0B4b;
        b41tv:
        if ($dj == 2) {
            goto Ob2qZ;
        }
        goto P4w51;
        tmi9V:
        FrsyD:
        goto urqg4;
        yhGm7:
        $yj1 = $yj3 * $bl['dlbl1t3'] / 100;
        goto ha7dR;
        s7zNL:
        if ($zt == 2) {
            goto riy6M;
        }
        goto FRLgJ;
        xemPP:
        goto TeYvp;
        goto J3eTu;
        cSLpW:
        qFM1y:
        goto aiYxX;
        eiOHn:
        $byygsum = '0.00';
        goto oXG2Y;
        xgRrN:
        $byygsum = pdo_fetchcolumn('SELECT sum(xgyg) FROM ' . tablename('tiger_newhu_tkorder') . " where weid='{$_W['uniacid']}'  {$ddzt} {$dwhere} {$where}");
        goto dN5qJ;
        nVgBc:
        f0_Wq:
        goto gPMVm;
        KVFL9:
    }
    public function seachyj($share, $sbegin_time, $send_time, $zt, $bl, $cfg)
    {
        goto HPWN3;
        q1UZv:
        if ($bl['dltype'] == 3) {
            goto uTzsy;
        }
        goto IyDCt;
        B2mKS:
        goto j_nPD;
        goto W7A6r;
        HPWN3:
        $syygsum = $this->bryj($share, $sbegin_time, $send_time, 1, $bl, $cfg, 1);
        goto DS3xr;
        DS3xr:
        $syygsum = number_format($syygsum, 2, '.', '');
        goto fD1oJ;
        RGKTk:
        goto mC8EA;
        goto KXOa0;
        oepnj:
        j_nPD:
        goto Q9nkl;
        FErt8:
        $syzyj = $syygsum + $syrjyj + $sysjyj;
        goto XHYBa;
        ACXmJ:
        HDIpk:
        goto IrBCY;
        OpiLh:
        if (!empty($syzyj)) {
            goto HDIpk;
        }
        goto pjTO9;
        D1JBd:
        if ($bl['fxtype'] == 1) {
            goto aHtgy;
        }
        goto xRuOR;
        iJtxA:
        $sysjyj = number_format($syrsjyj['yj3'] * $bl['dlbl1t3'] / 100, 2, '.', '');
        goto oepnj;
        z3hCw:
        $syrjyj = number_format($syrsjyj['yj2'] * $bl['dlbl2t3'] / 100, 2, '.', '');
        goto iJtxA;
        TSHlg:
        $sysjyj = number_format($syrsjyj['yj3'], 2, '.', '');
        goto FErt8;
        xRuOR:
        if ($bl['dltype'] == 2) {
            goto RB6Vb;
        }
        goto q1UZv;
        KXOa0:
        aHtgy:
        goto B8Hjr;
        pjTO9:
        $syzyj = '0.00';
        goto ACXmJ;
        Q9nkl:
        $syzyj = $syygsum + $syrjyj + $sysjyj;
        goto RGKTk;
        dctF9:
        RB6Vb:
        goto NVSYU;
        NVSYU:
        $syrjyj = number_format($syrsjyj['yj2'] * $bl['dlbl1t2'] / 100, 2, '.', '');
        goto B2mKS;
        W7A6r:
        uTzsy:
        goto z3hCw;
        fD1oJ:
        $syrsjyj = $this->bydlyj($share, $sbegin_time, $send_time, 1, $bl, $cfg, 1);
        goto D1JBd;
        IrBCY:
        $data = array("s1" => $syzyj, "s2" => $syygsum, "s3" => $syrjyj, "s4" => $sysjyj);
        goto wK2XR;
        B8Hjr:
        $syrjyj = number_format($syrsjyj['yj2'], 2, '.', '');
        goto TSHlg;
        wK2XR:
        return $data;
        goto ueFnS;
        XHYBa:
        mC8EA:
        goto OpiLh;
        IyDCt:
        goto j_nPD;
        goto dctF9;
        ueFnS:
    }
    public function jcbl($share, $bl)
    {
        goto mpOQB;
        pF7ao:
        $cj = 3;
        goto ORGuG;
        XAPmk:
        rSypo:
        goto GioFT;
        ItHNo:
        $tname = $bl['dlname1'];
        goto n6pB3;
        Or25M:
        if ($bl['dltype'] == 3) {
            goto Xp6YR;
        }
        goto uEuxm;
        uEuxm:
        if ($bl['dltype'] == 2) {
            goto vHDzx;
        }
        goto n3JRv;
        zBBrt:
        if (!empty($sj2)) {
            goto z3aEG;
        }
        goto uF9uN;
        UzbG5:
        $tname = $bl['dlname2'];
        goto rADk9;
        lbnGX:
        z3aEG:
        goto eIh52;
        l7sG1:
        qTIwK:
        goto pI9RG;
        qUCOR:
        $djbl = $share['dlbl'];
        goto gsGDH;
        mpOQB:
        global $_W;
        goto qgUAl;
        FMPDk:
        $cj = 2;
        goto BdBrl;
        spFai:
        lz3w_:
        goto HBYgh;
        gsGDH:
        $tname = $bl['dlname1'];
        goto l7sG1;
        n6pB3:
        $cj = 1;
        goto RslxW;
        HCKHZ:
        if (!empty($sj)) {
            goto ar7SM;
        }
        goto E1VEN;
        rADk9:
        $cj = 2;
        goto mUfZ7;
        XHbsD:
        Xp6YR:
        goto HCKHZ;
        psi9k:
        $sj2 = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$sj['helpid']}'");
        goto zBBrt;
        GioFT:
        goto ja1RB;
        goto tgpWZ;
        pI9RG:
        $arr = array("bl" => $djbl, "tname" => $tname, "cj" => $cj);
        goto x2rYA;
        JIigi:
        ja1RB:
        goto FdXKO;
        BE0Ct:
        $cj = 1;
        goto d4j4z;
        BdBrl:
        goto qq9rb;
        goto lbnGX;
        RslxW:
        goto rSypo;
        goto o_k_X;
        n3JRv:
        $djbl = $bl['dlbl1'];
        goto NEerU;
        LoQMu:
        $tname = $bl['dlname1'];
        goto kEJMp;
        x2rYA:
        return $arr;
        goto U833g;
        o_k_X:
        ar7SM:
        goto psi9k;
        eIh52:
        $djbl = $bl['dlbl3'];
        goto MKEOY;
        FdXKO:
        if (empty($share['dlbl'])) {
            goto qTIwK;
        }
        goto qUCOR;
        JPEah:
        goto wEkUC;
        goto spFai;
        tgpWZ:
        vHDzx:
        goto gyvKy;
        WVHW0:
        $djbl = $bl['dlbl1'];
        goto LoQMu;
        d4j4z:
        goto ja1RB;
        goto XHbsD;
        gyvKy:
        if (!empty($sj)) {
            goto lz3w_;
        }
        goto WVHW0;
        qgUAl:
        $sj = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");
        goto Or25M;
        uF9uN:
        $djbl = $bl['dlbl2'];
        goto tSsXB;
        tSsXB:
        $tname = $bl['dlname2'];
        goto FMPDk;
        MKEOY:
        $tname = $bl['dlname3'];
        goto pF7ao;
        NEerU:
        $tname = $bl['dlname1'];
        goto BE0Ct;
        mUfZ7:
        wEkUC:
        goto JIigi;
        ORGuG:
        qq9rb:
        goto XAPmk;
        E1VEN:
        $djbl = $bl['dlbl1'];
        goto ItHNo;
        HBYgh:
        $djbl = $bl['dlbl2'];
        goto UzbG5;
        kEJMp:
        $cj = 1;
        goto JPEah;
        U833g:
    }
    public function bydlyj($share = "", $begin_time = "", $end_time = "", $zt = "", $bl = "", $cfg = "", $sd = 0)
    {
        goto s0mC1;
        j0325:
        ZCq2h:
        goto O82Na;
        Czq3f:
        mh_y4:
        goto t_116;
        t_116:
        if (!empty($sjrs)) {
            goto FdTXk;
        }
        goto Mestk;
        EXt0Q:
        goto A9nEQ;
        goto Xwgbi;
        Cf0G8:
        $rjrs = '0.00';
        goto hTDom;
        DjQY1:
        if (!($bl['dltype'] == 1)) {
            goto gnu65;
        }
        goto Cf0G8;
        oWZ3W:
        ytpuw:
        goto c6kB3;
        DrvWa:
        if (empty($bl['dlkcbl'])) {
            goto mh_y4;
        }
        goto fW_Vk;
        l8Zw2:
        if (empty($begin_time)) {
            goto ZCq2h;
        }
        goto XL7Qw;
        ClJRI:
        if ($zt == 1) {
            goto K2ThP;
        }
        goto KyfMZ;
        awmsR:
        hw99J:
        goto c7c8m;
        NZD1v:
        rAPDN:
        goto P47v3;
        GVNxt:
        goto OOQZU;
        goto awmsR;
        m6nyC:
        X0j9x:
        goto NhjVB;
        ktvMx:
        $rjshare = pdo_fetchall('SELECT id,helpid,tgwid FROM ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and helpid='{$share['id']}' and dltype=1");
        goto ouHhi;
        fj5C6:
        foreach ($rjshare as $k => $v) {
            goto TmXXu;
            VDC9s:
            P07oZ:
            goto g1n8J;
            hBbtT:
            $r = $r + $a;
            goto VDC9s;
            WzQZP:
            $a = pdo_fetchcolumn('SELECT sum(xgyg) FROM ' . tablename('tiger_newhu_tkorder') . "  where weid='{$_W['uniacid']}' and tgwid='{$v['tgwid']}' {$ddzt} {$where}");
            goto MWIHm;
            jgf2y:
            csGnJ:
            goto WzQZP;
            BkoPJ:
            $a = pdo_fetchcolumn('SELECT sum(xgyg) FROM ' . tablename('tiger_newhu_tkorder') . "  where weid='{$_W['uniacid']}' and (tgwid='{$v['tgwid']}' || relation_id='{$v['qdid']}' ) {$ddzt} {$where}");
            goto vs2LV;
            vs2LV:
            goto QHXvI;
            goto jgf2y;
            MWIHm:
            QHXvI:
            goto hBbtT;
            TmXXu:
            if (empty($v['qdid'])) {
                goto csGnJ;
            }
            goto BkoPJ;
            g1n8J:
        }
        goto Ya4Cr;
        H01HB:
        if (empty($share['dlbl'])) {
            goto w8Kp4;
        }
        goto vOzsr;
        fW_Vk:
        $sjrs = $sjrs * (100 - $bl['dlkcbl']) / 100;
        goto Czq3f;
        VDmej:
        gnu65:
        goto rT6x7;
        zJs2T:
        w8Kp4:
        goto MdsuP;
        loGxB:
        $sjrs = pdo_fetchcolumn('SELECT sum(t.xgyg) FROM ' . tablename('tiger_newhu_share') . ' s left join ' . tablename('tiger_newhu_tkorder') . " t ON s.tgwid=t.tgwid where s.weid='{$_W['uniacid']}'   and s.dltype=1  {$ddzt} and s.helpid in (" . implode(',', array_keys($fans1)) . ") {$where}");
        goto Tk4Yi;
        RApf6:
        xTkK7:
        goto ClJRI;
        c7c8m:
        $ddzt = ' and orderzt=\'订单付款\'';
        goto s33rv;
        Gg7rO:
        $fans1 = pdo_fetchall('select id from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and dltype=1 and helpid='{$share['id']}'", array(), 'id');
        goto WpHgz;
        WpHgz:
        if (empty($fans1)) {
            goto B_Gkm;
        }
        goto loGxB;
        ouHhi:
        $r = '';
        goto fj5C6;
        s0mC1:
        global $_W;
        goto H01HB;
        KNOCz:
        K2ThP:
        goto p0srN;
        Mestk:
        $sjrs = '0.00';
        goto BqtMv;
        AElkH:
        Pldig:
        goto jNg1M;
        IVO3u:
        return $array;
        goto Cjf2N;
        Ya4Cr:
        urar_:
        goto ZwlMa;
        iAqhJ:
        Mr_uK:
        goto w8ohy;
        urcTW:
        WdKa6:
        goto DjQY1;
        F16Oh:
        $addtime = 'addtime';
        goto ZoaT1;
        nD9FZ:
        if (empty($bl['dlkcbl'])) {
            goto ytpuw;
        }
        goto G01YV;
        vOzsr:
        $bl['dlbl1'] = $share['dlbl'];
        goto zJs2T;
        ikGF0:
        A9nEQ:
        goto cOE4P;
        r0N0Z:
        $addtime = 'jstime';
        goto NZD1v;
        OM1MX:
        OOQZU:
        goto GqpwG;
        Xnzo7:
        $where = "and addtime>={$begin_time}";
        goto Klp8M;
        cOE4P:
        if (!($sd == 1)) {
            goto X0j9x;
        }
        goto mPRsW;
        hPNBu:
        $sjrs = '0.00';
        goto ObWPG;
        m01rY:
        Ml5lp:
        goto Gg7rO;
        Tk4Yi:
        B_Gkm:
        goto DrvWa;
        w8ohy:
        $ddzt = ' and orderzt<>\'订单失效\'';
        goto OM1MX;
        s33rv:
        goto OOQZU;
        goto iAqhJ;
        hTDom:
        $sjrs = '0.00';
        goto VDmej;
        KyfMZ:
        if ($zt == 2) {
            goto hw99J;
        }
        goto iasGV;
        c6kB3:
        if (!empty($rjrs)) {
            goto Pldig;
        }
        goto N_4Pq;
        TxoZl:
        Pkghp:
        goto r0N0Z;
        cB20g:
        $addtime = 'addtime';
        goto isP6Z;
        O82Na:
        goto xTkK7;
        goto PW2d6;
        isP6Z:
        fOnFa:
        goto ikGF0;
        rxHih:
        if ($send_time == $end_time) {
            goto Pkghp;
        }
        goto F16Oh;
        MdsuP:
        $send_time = strtotime(date('Y-m-d 23:59:59', strtotime(-date('d') . 'day')));
        goto XB0Fb;
        P47v3:
        if (!($zt == 2)) {
            goto fOnFa;
        }
        goto cB20g;
        GqpwG:
        $bbegin_time = strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), 1, date('Y'))));
        goto ktvMx;
        rT6x7:
        $array = array("yj2" => $rjrs * $bl['dlbl2'] / 100, "yj3" => $sjrs * $bl['dlbl3'] / 100);
        goto IVO3u;
        G01YV:
        $rjrs = $rjrs * (100 - $bl['dlkcbl']) / 100;
        goto oWZ3W;
        Klp8M:
        keeU9:
        goto RApf6;
        XB0Fb:
        if ($cfg['jsms'] == 1) {
            goto QvClH;
        }
        goto qeyko;
        qeyko:
        $addtime = 'addtime';
        goto EXt0Q;
        N_4Pq:
        $rjrs = '0.00';
        goto AElkH;
        NhjVB:
        if (empty($end_time)) {
            goto nYN7h;
        }
        goto l8Zw2;
        a4YKU:
        goto OOQZU;
        goto KNOCz;
        iasGV:
        if ($zt == 3) {
            goto Mr_uK;
        }
        goto a4YKU;
        ObWPG:
        goto WdKa6;
        goto m01rY;
        ZwlMa:
        $rjrs = $r;
        goto nD9FZ;
        Va2UZ:
        if (empty($begin_time)) {
            goto keeU9;
        }
        goto Xnzo7;
        Xwgbi:
        QvClH:
        goto rxHih;
        XL7Qw:
        $where = "and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
        goto j0325;
        ZoaT1:
        goto rAPDN;
        goto TxoZl;
        PW2d6:
        nYN7h:
        goto Va2UZ;
        mPRsW:
        $addtime = 'jstime';
        goto m6nyC;
        p0srN:
        $ddzt = ' and orderzt=\'订单结算\'';
        goto GVNxt;
        jNg1M:
        if ($bl['dltype'] == 3) {
            goto Ml5lp;
        }
        goto hPNBu;
        BqtMv:
        FdTXk:
        goto urcTW;
        Cjf2N:
    }
    public function goodlist($key, $pid, $page, $dlbl, $bl)
    {
        goto tcWU1;
        ykn7K:
        foreach ($goods as $k => $v) {
            goto qKlKg;
            sYU4s:
            $xprc = $v['zk_final_price'] - $matches[2][0];
            goto xGNP8;
            f1K2l:
            if (empty($bl['dlkcbl'])) {
                goto Q7emo;
            }
            goto Ja6DS;
            QhsKQ:
            $list[$k]['org_price'] = $v['zk_final_price'];
            goto qb4Qq;
            bw2yN:
            $list[$k]['coupons_end'] = $v['coupon_end_time'];
            goto g9cbw;
            Ca0vr:
            $list[$k]['item_url'] = $v['item_url'];
            goto yZQE9;
            qKlKg:
            $list[$k]['title'] = $v['title'];
            goto ruvlr;
            g9cbw:
            preg_match_all('|满([\\d\\.]+).*元减([\\d\\.]+).*元|ism', $v['coupon_info'], $matches);
            goto QoKri;
            xGNP8:
            $list[$k]['price'] = $xprc;
            goto lKmIf;
            qnnoW:
            $list[$k]['goods_sale'] = $v['volume'];
            goto sYU4s;
            Z551x:
            $list[$k]['dlyj'] = number_format($dlyj * $dlbl / 100, 2);
            goto QhsKQ;
            RNMBA:
            $list[$k]['shop_title'] = $v['shop_title'];
            goto x4jXz;
            Ja6DS:
            $dlyj = $dlyj * (100 - $bl['dlkcbl']) / 100;
            goto Fr2Vj;
            h2J5m:
            $list[$k]['pic_url'] = $v['pict_url'];
            goto yM5fm;
            kfSGZ:
            $list[$k]['num_iid'] = $v['num_iid'];
            goto nLL03;
            nLL03:
            $list[$k]['url'] = $v['coupon_click_url'];
            goto bw2yN;
            iL_F3:
            $list[$k]['coupons_take'] = $v['coupon_remain_count'];
            goto jquLJ;
            QoKri:
            $list[$k]['coupons_price'] = $matches[2][0];
            goto qnnoW;
            qb4Qq:
            $list[$k]['pic_url'] = $v['pict_url'];
            goto RNMBA;
            jquLJ:
            $list[$k]['coupons_total'] = $v['coupon_total_count'];
            goto Ca0vr;
            x4jXz:
            $list[$k]['nick'] = $v['nick'];
            goto iL_F3;
            ruvlr:
            $list[$k]['istmall'] = $v['user_type'];
            goto kfSGZ;
            yM5fm:
            Q8Fg1:
            goto v3f3R;
            yZQE9:
            $list[$k]['small_images'] = $v['small_images']['string'];
            goto h2J5m;
            Fr2Vj:
            Q7emo:
            goto Z551x;
            lKmIf:
            $dlyj = $v['commission_rate'] * $xprc / 100;
            goto f1K2l;
            v3f3R:
        }
        goto mmAap;
        IQ1pY:
        $c->secretKey = $api['secretKey'];
        goto CutyF;
        AA3JP:
        $resp = json_decode(json_encode($resp), TRUE);
        goto ybJmi;
        SYSS5:
        $req->setPlatform('2');
        goto fjGkK;
        PZXo1:
        $api = taobaopp($tiger);
        goto frViv;
        etMGk:
        $req->setPid($pid);
        goto vP1Ru;
        CutyF:
        $req = new TbkItemCouponGetRequest();
        goto SYSS5;
        frViv:
        $c = new TopClient();
        goto XIUhh;
        BNEcc:
        $req->setQ($key);
        goto UNysC;
        vP1Ru:
        $resp = $c->execute($req);
        goto AA3JP;
        ybJmi:
        $goods = $resp['results']['tbk_coupon'];
        goto ykn7K;
        mmAap:
        ldF2o:
        goto BNXey;
        tcWU1:
        require_once IA_ROOT . '/addons/tiger_newhu/inc/sdk/getpic.php';
        goto PZXo1;
        BNXey:
        return $list;
        goto EF4_C;
        UNysC:
        $req->setPageNo($page);
        goto etMGk;
        XIUhh:
        $c->appkey = $api['appkey'];
        goto IQ1pY;
        fjGkK:
        $req->setPageSize('20');
        goto BNEcc;
        EF4_C:
    }
    public function doMobileOpenlink()
    {
        goto oIyrN;
        gcbMz:
        $cfg = $this->module['config'];
        goto az3GW;
        BUirh:
        $url = urldecode($_GPC['link']);
        goto gcbMz;
        oIyrN:
        global $_W, $_GPC;
        goto BUirh;
        az3GW:
        include $this->template('openlink');
        goto S2yd3;
        S2yd3:
    }
    public function dljiangli($endprice, $tkrate, $bl, $share)
    {
        goto khORh;
        t5hud:
        VBC5X:
        goto xtozL;
        DYYuF:
        $dlyj = $endprice * $tkrate / 100;
        goto W4krQ;
        mpNeX:
        if (empty($share['helpid'])) {
            goto jUk7Y;
        }
        goto orGc8;
        W4krQ:
        if (empty($bl['dlkcbl'])) {
            goto EQLCD;
        }
        goto BZ9Yc;
        N1crP:
        jUk7Y:
        goto oNS9T;
        iwMwq:
        goto xCsUd;
        goto H7BP3;
        RDu0A:
        return $dlrate;
        goto pFfFO;
        bTUwQ:
        pw8K0:
        goto iwMwq;
        AuJ3f:
        if ($bl['dltype'] == 2) {
            goto LWRqg;
        }
        goto eVSn0;
        iHLro:
        $dlbl = $fs['bl'];
        goto Jxk8U;
        p5l_Z:
        file_put_contents(IA_ROOT . '/addons/tiger_tkxcx/yj_log.txt', '
' . 'uid:' . $share['id'] . '------' . $yj . '-' . $jryj . '-' . $jrsjyj . '=' . $jrzyj, FILE_APPEND);
        goto XlPa4;
        khORh:
        global $_W;
        goto DYYuF;
        Jxk8U:
        goto VBC5X;
        goto mETOc;
        hl2tP:
        zblbf:
        goto YWmQj;
        m4o2Q:
        $jrsjyj = $yj * $bl['dlbl1t3'] / 100;
        goto t9OUt;
        eVSn0:
        if ($bl['dltype'] == 3) {
            goto xVVDB;
        }
        goto WL2eu;
        oNS9T:
        $jryj = 0;
        goto FLfGG;
        nyLsM:
        if (empty($share['dlbl'])) {
            goto ccE3u;
        }
        goto iHLro;
        zXhu7:
        goto pw8K0;
        goto hl2tP;
        fAUgT:
        PWw7U:
        goto RDu0A;
        bRNHf:
        $dlrate = number_format($dlyj * $dlbl / 100, 2);
        goto fAUgT;
        BkIoB:
        $jryj = $yj * $bl['dlbl1t2'] / 100;
        goto zXhu7;
        HmbwZ:
        $jryj = $yj * $bl['dlbl2t3'] / 100;
        goto zWc5P;
        PQWE4:
        xCsUd:
        goto jC7s5;
        erHN9:
        zvXUl:
        goto rrxXM;
        xtozL:
        if ($bl['fxtype'] == 1) {
            goto MHWaT;
        }
        goto YUxCw;
        uRys_:
        $fs = $this->jcbl($share, $bl);
        goto nyLsM;
        FG71H:
        if (empty($share['helpid'])) {
            goto zblbf;
        }
        goto BkIoB;
        H7BP3:
        xVVDB:
        goto mpNeX;
        FLfGG:
        UxfKf:
        goto PQWE4;
        o2jOF:
        goto UxfKf;
        goto N1crP;
        YWmQj:
        $jryj = 0;
        goto bTUwQ;
        mETOc:
        ccE3u:
        goto OJzKE;
        WL2eu:
        goto xCsUd;
        goto CYMpE;
        YUxCw:
        $yj = number_format($dlyj * $dlbl / 100, 2);
        goto AuJ3f;
        bejEi:
        goto PWw7U;
        goto jdTfZ;
        OJzKE:
        $dlbl = $bl['dlbl1'];
        goto t5hud;
        BZ9Yc:
        $dlyj = $dlyj * (100 - $bl['dlkcbl']) / 100;
        goto Hmyzs;
        t9OUt:
        goto EnJYU;
        goto erHN9;
        jC7s5:
        $jrzyj = $yj - $jryj - $jrsjyj;
        goto p5l_Z;
        orGc8:
        $sjshare = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$share['weid']}'and dltype=1 and id='{$share['helpid']}'");
        goto HmbwZ;
        rrxXM:
        $jrsjyj = 0;
        goto jfgDX;
        jdTfZ:
        MHWaT:
        goto bRNHf;
        Hmyzs:
        EQLCD:
        goto uRys_;
        CYMpE:
        LWRqg:
        goto FG71H;
        zWc5P:
        if (empty($sjshare['helpid'])) {
            goto zvXUl;
        }
        goto m4o2Q;
        XlPa4:
        $dlrate = number_format($jrzyj, 2);
        goto bejEi;
        jfgDX:
        EnJYU:
        goto o2jOF;
        pFfFO:
    }
    public function tkl($url, $img, $tjcontent)
    {
        goto fTU2M;
        Nln87:
        if (!($cfg['tklnewtype'] == 1)) {
            goto yVvLn;
        }
        goto Z7Qgr;
        cfzLz:
        $jsonArray = json_decode($jsonStr, true);
        goto OOveP;
        G6M6D:
        $c->appkey = $appkey;
        goto Mf449;
        fTU2M:
        global $_W, $_GPC;
        goto XZqAi;
        fTrEc:
        $taokou = str_replace('￥', '', $taokou);
        goto LWv4f;
        JPIiY:
        $secret = $cfg['tksecretKey'];
        goto tPi0X;
        XZqAi:
        $weid = $_W['uniacid'];
        goto N_gpc;
        LWv4f:
        $taokou = $zcfg['tklleft'] . $taokou . $zcfg['tklright'];
        goto d9Z9U;
        jfFbX:
        $resp = $c->execute($req);
        goto wzzWD;
        BIB85:
        $req->setText($tjcontent);
        goto jNpwW;
        Z7Qgr:
        $taokou = str_replace('《', '￥', $taokou);
        goto eZC4c;
        wzzWD:
        $jsonStr = json_encode($resp);
        goto cfzLz;
        yxVpp:
        $req->setExt('{}');
        goto jfFbX;
        N_gpc:
        $s = pdo_fetch('select settings from ' . tablename('uni_account_modules') . " where module='tiger_newhu' and uniacid='{$weid}'");
        goto TpcvU;
        GfVaS:
        if (empty($zcfg['tklleft'])) {
            goto pk6wt;
        }
        goto fTrEc;
        d9Z9U:
        pk6wt:
        goto Av5bY;
        jNpwW:
        $req->setUrl($url);
        goto e21JT;
        Mf449:
        $c->secretKey = $secret;
        goto m4OT4;
        eZC4c:
        yVvLn:
        goto GfVaS;
        TpcvU:
        $zcfg = unserialize($s['settings']);
        goto xO164;
        m4OT4:
        $req = new TbkTpwdCreateRequest();
        goto BIB85;
        OOveP:
        $taokou = $jsonArray['data']['model'];
        goto Nln87;
        tPi0X:
        $c = new TopClient();
        goto G6M6D;
        Av5bY:
        return $taokou;
        goto gCHqM;
        e21JT:
        $req->setLogo($img);
        goto yxVpp;
        xO164:
        $cfg = $this->module['config'];
        goto u7_CI;
        u7_CI:
        $appkey = $cfg['tkAppKey'];
        goto JPIiY;
        gCHqM:
    }
    public function dwz($url)
    {
        goto cQkjj;
        Kj8sb:
        $url = urlencode($url);
        goto T4LcC;
        VzPFl:
        goto CAEeR;
        goto iFK56;
        i_KhP:
        $url = $this->sinadwz($turl);
        goto Ey1x1;
        kUDCt:
        $url = $this->wxdwz($turl);
        goto Oek5n;
        a72bh:
        $urlarr = $this->zydwz($turl);
        goto VzPFl;
        T4LcC:
        $turl = $_W['siteroot'] . '/app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=openlink&m=tiger_newhu&link=' . $url;
        goto DA9ya;
        DA9ya:
        if ($cfg['dwzlj'] == 0) {
            goto GyofO;
        }
        goto uLAex;
        Oek5n:
        CAEeR:
        goto WV9nE;
        znVXV:
        $cfg = $this->module['config'];
        goto Kj8sb;
        cQkjj:
        global $_W;
        goto znVXV;
        Bh6qq:
        m_fPE:
        goto kUDCt;
        uLAex:
        if ($cfg['dwzlj'] == 1) {
            goto m_fPE;
        }
        goto a72bh;
        Ey1x1:
        goto CAEeR;
        goto Bh6qq;
        iFK56:
        GyofO:
        goto i_KhP;
        WV9nE:
    }
    public function dwzw($turl)
    {
        goto h08yz;
        BD9_Q:
        goto yU_i2;
        goto qccrh;
        bnQdF:
        if ($cfg['dwzlj'] == 1) {
            goto ZKVE0;
        }
        goto CEiCU;
        Zro4v:
        $url = $this->wxdwz($turl);
        goto KkA1i;
        hUGZ2:
        $url = $this->sinadwz($turl);
        goto BD9_Q;
        lh5zL:
        return $url;
        goto EYxtd;
        h08yz:
        global $_W;
        goto Wg34t;
        CEiCU:
        $url = $this->zydwz($turl);
        goto Z71DA;
        Z71DA:
        goto yU_i2;
        goto GTOvO;
        GTOvO:
        V5o4e:
        goto hUGZ2;
        KkA1i:
        yU_i2:
        goto lh5zL;
        Wg34t:
        $cfg = $this->module['config'];
        goto yOL8L;
        yOL8L:
        if ($cfg['dwzlj'] == 0) {
            goto V5o4e;
        }
        goto bnQdF;
        qccrh:
        ZKVE0:
        goto Zro4v;
        EYxtd:
    }
    public function zydwz($turl)
    {
        goto PLPml;
        BRwzK:
        $id = pdo_insertid();
        goto vNRyO;
        D_jDl:
        pdo_insert('tiger_newhu_dwz', $data);
        goto BRwzK;
        PLPml:
        global $_W;
        goto MflW2;
        MflW2:
        $cfg = $this->module['config'];
        goto sesId;
        pNQ8q:
        return $url;
        goto Hn4dP;
        sesId:
        $data = array("weid" => $_W['uniacid'], "url" => $turl, "createtime" => TIMESTAMP);
        goto D_jDl;
        vNRyO:
        $url = $cfg['zydwz'] . 't.php?d=' . $id;
        goto pNQ8q;
        Hn4dP:
    }
    public function wxdwz($url)
    {
        goto zelDo;
        AKCRp:
        $ret = ihttp_request($url, $result);
        goto iRBrN;
        zelDo:
        $result = '{"action":"long2short","long_url":"' . $url . '"}';
        goto Aqswy;
        iRBrN:
        $content = @json_decode($ret['content'], true);
        goto wSFTZ;
        Aqswy:
        $access_token = $this->getAccessToken();
        goto M60HX;
        M60HX:
        $url = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token={$access_token}";
        goto AKCRp;
        wSFTZ:
        return $content['short_url'];
        goto zi1UQ;
        zi1UQ:
    }
    public function sinadwz($url)
    {
        goto HThd4;
        MiC6B:
        q2JBm:
        goto rjs4N;
        SQBE6:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/log--sina.txt', '
--3' . $url, FILE_APPEND);
        goto oHsK6;
        HThd4:
        global $_W;
        goto q0L01;
        OQ5ne:
        YZ6wF:
        goto dMxPy;
        dMxPy:
        $key = '1549359964';
        goto MiC6B;
        fhwcg:
        $sinaurl = "http://api.t.sina.com.cn/short_url/shorten.json?source={$key}&url_long={$turl2}";
        goto ZLFda;
        JUUxT:
        $json = ihttp_get($sinaurl);
        goto SQBE6;
        q0L01:
        $cfg = $this->module['config'];
        goto DX6CE;
        ZLFda:
        load()->func('communication');
        goto JUUxT;
        oHsK6:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/log--sina.txt', '
--3' . json_encode($json), FILE_APPEND);
        goto gfH4P;
        h_nQ4:
        $key = trim($cfg['sinkey']);
        goto jUQ49;
        gfH4P:
        $result = @json_decode($json['content'], true);
        goto k6htE;
        jUQ49:
        goto q2JBm;
        goto OQ5ne;
        rjs4N:
        $turl2 = urlencode($url);
        goto fhwcg;
        DX6CE:
        if (empty($cfg['sinkey'])) {
            goto YZ6wF;
        }
        goto h_nQ4;
        k6htE:
        return $result[0]['url_short'];
        goto rWjdK;
        rWjdK:
    }
    public function getAccessToken()
    {
        goto F_ZIw;
        qu86Y:
        $acid = $_W['uniacid'];
        goto PxJyH;
        F_ZIw:
        global $_W;
        goto NJoqh;
        HL6RJ:
        $acid = $_W['acid'];
        goto rGzPH;
        NJoqh:
        load()->model('account');
        goto HL6RJ;
        meyab:
        return $token;
        goto PB447;
        rGzPH:
        if (!empty($acid)) {
            goto OA7UY;
        }
        goto qu86Y;
        YVroB:
        include IA_ROOT . '/addons/tiger_wxdaili/wxtoken.php';
        goto meyab;
        PxJyH:
        OA7UY:
        goto YVroB;
        PB447:
    }
    public function mygetID($url)
    {
        goto n3cEI;
        dLN0u:
        goto XRFf0;
        goto C3EGW;
        fhgfV:
        return '';
        goto dLN0u;
        n3cEI:
        if (preg_match('/[\\?&]id=(\\d+)/', $url, $match)) {
            goto dvh58;
        }
        goto fhgfV;
        C3EGW:
        dvh58:
        goto rMjUx;
        bXMz9:
        XRFf0:
        goto ZyoHD;
        rMjUx:
        return $match[1];
        goto bXMz9;
        ZyoHD:
    }
    public function getyouhui2($str)
    {
        preg_match_all('|(￥[^￥]+￥)|ism', $str, $matches);
        return $matches[1][0];
    }
    public function geturl($str)
    {
        goto t_7A8;
        Mff57:
        p8_lu:
        goto V33td;
        m0C0R:
        goto p8_lu;
        goto oOZ5I;
        UrD_3:
        preg_match('/[\\s]/u', $url, $matches, PREG_OFFSET_CAPTURE);
        goto xrX13;
        Wkcva:
        $url = 'http' . trim($exp[1]) . ' ';
        goto UrD_3;
        xrX13:
        $url = substr($url, 0, $matches[0][1]);
        goto Ox8Lg;
        oOZ5I:
        CLxlm:
        goto kMVh_;
        XKKpH:
        return $url;
        goto m0C0R;
        kMVh_:
        return '';
        goto Mff57;
        t_7A8:
        $exp = explode('http', $str);
        goto Wkcva;
        Ox8Lg:
        if ($url == 'http') {
            goto CLxlm;
        }
        goto XKKpH;
        V33td:
    }
    public function myisexists($url)
    {
        goto KUYg9;
        OeEfe:
        return 2;
        goto WpJd9;
        dbt2J:
        goto Bp3X4;
        goto wp1bq;
        WwNJ2:
        HsVPg:
        goto zyr3a;
        XhV2H:
        return 0;
        goto idl0I;
        h2YRY:
        goto Bp3X4;
        goto WwNJ2;
        zyr3a:
        return 2;
        goto dbt2J;
        wp1bq:
        HYdnJ:
        goto OeEfe;
        KUYg9:
        if (stripos($url, 'taobao.com') !== false) {
            goto HsVPg;
        }
        goto bUvdk;
        eSnAH:
        return 2;
        goto q4RV6;
        bUvdk:
        if (stripos($url, 'tmall.com') !== false) {
            goto HYdnJ;
        }
        goto KMaeo;
        FujUR:
        return 1;
        goto h2YRY;
        KMaeo:
        if (stripos($url, 'tmall.hk') !== false) {
            goto RRSJd;
        }
        goto FujUR;
        JFred:
        RRSJd:
        goto eSnAH;
        WpJd9:
        goto Bp3X4;
        goto JFred;
        q4RV6:
        Bp3X4:
        goto XhV2H;
        idl0I:
    }
    public function hqgoodsid($url)
    {
        goto a4mLI;
        nE1TI:
        sOQpq:
        goto chfTb;
        BlPhO:
        if (!empty($goodsid)) {
            goto SGcxf;
        }
        goto vZ3IC;
        a4mLI:
        $str = $this->curl_request($url);
        goto DPh27;
        DDnu3:
        $url = $this->Text_qzj($str, 'url = \'', '\';');
        goto b7JAt;
        TzZAK:
        $goodsid = $this->Text_qzj($str, 'itemId=', '&');
        goto nE1TI;
        b7JAt:
        $goodsid = $this->Text_qzj($str, 'com/i', '.htm');
        goto jvxtV;
        chfTb:
        return $goodsid;
        goto d6U2u;
        jvxtV:
        lwL5_:
        goto oITwl;
        ttuuq:
        PvNWe:
        goto RXdEw;
        RXdEw:
        if (!empty($goodsid)) {
            goto lwL5_;
        }
        goto DDnu3;
        fMbyM:
        $goodsid = $this->Text_qzj($str, '?id=', '&');
        goto BlPhO;
        Ia28U:
        $goodsid = $this->Text_qzj($str, 'itemid=', '&');
        goto BojY9;
        Ch96u:
        SGcxf:
        goto skqDL;
        BojY9:
        VTIyJ:
        goto AMb30;
        DPh27:
        $str = str_replace('"', '', $str);
        goto fMbyM;
        skqDL:
        if (!empty($goodsid)) {
            goto PvNWe;
        }
        goto GU2Vh;
        oITwl:
        if (!empty($goodsid)) {
            goto VTIyJ;
        }
        goto Ia28U;
        AMb30:
        if (!empty($goodsid)) {
            goto sOQpq;
        }
        goto TzZAK;
        GU2Vh:
        $goodsid = $this->Text_qzj($str, 'itemId:', ',');
        goto ttuuq;
        vZ3IC:
        $goodsid = $this->Text_qzj($str, '&id=', '&');
        goto Ch96u;
        d6U2u:
    }
    public function curl_request($url, $post = "", $cookie = "", $returnCookie = 0)
    {
        goto XMvnJ;
        DLmOR:
        if (!curl_errno($curl)) {
            goto wElW4;
        }
        goto oSClZ;
        VDdtY:
        curl_setopt($curl, CURLOPT_POST, 1);
        goto xLoTK;
        XMvnJ:
        $curl = curl_init();
        goto MrSDe;
        CaXuq:
        if (!$post) {
            goto Q05ZL;
        }
        goto VDdtY;
        tPamu:
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        goto DgOrI;
        J5XnG:
        Q05ZL:
        goto uUSyX;
        jV_XI:
        TcYPz:
        goto wHMGz;
        RUt5B:
        wElW4:
        goto wF_5R;
        WCIHg:
        $info['content'] = $body;
        goto MhvwG;
        DeP6A:
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        goto tPamu;
        gudXx:
        Xkxjw:
        goto OCujm;
        L_SFx:
        return $data;
        goto CihHY;
        OCujm:
        list($header, $body) = explode('

', $data, 2);
        goto o8CQP;
        o8CQP:
        preg_match_all('/Set\\-Cookie:([^;]*);/', $header, $matches);
        goto QH9Eb;
        buDld:
        if ($returnCookie) {
            goto Xkxjw;
        }
        goto L_SFx;
        wF_5R:
        curl_close($curl);
        goto buDld;
        oSClZ:
        return curl_error($curl);
        goto RUt5B;
        GTC2r:
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        goto UpN53;
        QH9Eb:
        $info['cookie'] = substr($matches[1][0], 1);
        goto WCIHg;
        UpN53:
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        goto MIWbx;
        MrSDe:
        curl_setopt($curl, CURLOPT_URL, $url);
        goto en4oP;
        CihHY:
        goto t9fR6;
        goto gudXx;
        xLoTK:
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        goto J5XnG;
        en4oP:
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; 	Trident/6.0)');
        goto DeP6A;
        APWLO:
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        goto jV_XI;
        uUSyX:
        if (!$cookie) {
            goto TcYPz;
        }
        goto APWLO;
        MhvwG:
        return $info;
        goto r_T2R;
        r_T2R:
        t9fR6:
        goto Tiy36;
        MIWbx:
        $data = curl_exec($curl);
        goto DLmOR;
        DgOrI:
        curl_setopt($curl, CURLOPT_REFERER, 'http://XXX');
        goto CaXuq;
        wHMGz:
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        goto GTC2r;
        Tiy36:
    }
    public function Text_qzj($Text, $Front, $behind)
    {
        goto V_Uym;
        nGrKB:
        return mb_substr($temp, 0, $t2);
        goto phSk3;
        ADvHw:
        jcyxz:
        goto nGrKB;
        G1rUH:
        $t2 = mb_strpos($temp, $behind);
        goto B11FV;
        ezcYp:
        if ($t1 == FALSE) {
            goto Znzsw;
        }
        goto OeYRY;
        HQqpB:
        $temp = mb_substr($Text, $t1, strlen($Text) - $t1);
        goto G1rUH;
        vjS7I:
        aHpRf:
        goto HQqpB;
        fLozB:
        goto aHpRf;
        goto XYgf2;
        Xzc6U:
        return '';
        goto vjS7I;
        B11FV:
        if (!($t2 == FALSE)) {
            goto jcyxz;
        }
        goto nUneD;
        OeYRY:
        $t1 = $t1 - 1 + strlen($Front);
        goto fLozB;
        nUneD:
        return '';
        goto ADvHw;
        XYgf2:
        Znzsw:
        goto Xzc6U;
        V_Uym:
        $t1 = mb_strpos('.' . $Text, $Front);
        goto ezcYp;
        phSk3:
    }
    public function mbmsg($openid = "", $mb = "", $mbid = "", $url = "", $fans = "", $orderid = "", $cfg = "", $valuedata = "")
    {
        goto k_fN4;
        g6VLa:
        $tplist1['remark'] = array("value" => $mb['remark'], "color" => $mb['remarkcolor']);
        goto vWT0b;
        wN6B5:
        $tp_value1 = str_replace('#代理申请拒绝原因#', $valuedata['dlsqjj'], $tp_value1);
        goto UEJRe;
        Ttf1k:
        mR2iv:
        goto uP12c;
        Dnsgr:
        $tp_value1 = str_replace('#昵称#', $fans['nickname'], $tp_value1);
        goto bTac1;
        Z0gBR:
        $tplist1 = array("first" => array("value" => $mb['first'], "color" => $mb['firstcolor']));
        goto o16dk;
        uP12c:
        $tp_color1 = unserialize($mb['zjcolor']);
        goto bQ17l;
        cqmjk:
        if (empty($valuedata['dlsqjj'])) {
            goto QtmLk;
        }
        goto wN6B5;
        bTac1:
        $tp_value1 = str_replace('#订单号#', $orderid, $tp_value1);
        goto gVvHJ;
        eE0H5:
        $mb['remark'] = str_replace('#昵称#', $fans['nickname'], $mb['remark']);
        goto xhO94;
        xhO94:
        $mb['remark'] = str_replace('#订单号#', $orderid, $mb['remark']);
        goto g6VLa;
        kIOhq:
        $tp_value1 = str_replace('#申请代理理由#', $valuedata['dlmsg'], $tp_value1);
        goto lQsQD;
        PyZee:
        return $msg;
        goto gqUEL;
        bQ17l:
        $mb['first'] = str_replace('#时间#', date('Y-m-d H:i:s', time()), $mb['first']);
        goto u9ea1;
        wZfEI:
        $mb['first'] = str_replace('#订单号#', $orderid, $mb['first']);
        goto Z0gBR;
        u9ea1:
        $mb['first'] = str_replace('#昵称#', $fans['nickname'], $mb['first']);
        goto wZfEI;
        k_fN4:
        global $_W;
        goto ZOrhM;
        UEJRe:
        QtmLk:
        goto Ttf1k;
        vWT0b:
        $msg = $this->sendMsg($openid, $mbid, $tplist1, '', $url);
        goto PyZee;
        TwD84:
        PCPH0:
        goto Y09I4;
        zKfph:
        $tp_value1 = str_replace('#微信号#', $valuedata['weixin'], $tp_value1);
        goto nRhJ_;
        nRhJ_:
        $tp_value1 = str_replace('#手机号#', $valuedata['tel'], $tp_value1);
        goto kIOhq;
        gVvHJ:
        if (empty($valuedata)) {
            goto mR2iv;
        }
        goto tZtAG;
        lQsQD:
        $tp_value1 = str_replace('#代理申请人姓名#', $valuedata['tname'], $tp_value1);
        goto cqmjk;
        ZOrhM:
        $tp_value1 = unserialize($mb['zjvalue']);
        goto LUvh7;
        Y09I4:
        $mb['remark'] = str_replace('#时间#', date('Y-m-d H:i:s', time()), $mb['remark']);
        goto eE0H5;
        o16dk:
        foreach ($tp_value1 as $key => $value) {
            goto uWld8;
            ioACl:
            goto ePUIN;
            goto Asr8_;
            Asr8_:
            nvtXG:
            goto zRAfI;
            uWld8:
            if (!empty($value)) {
                goto nvtXG;
            }
            goto ioACl;
            zRAfI:
            $tplist1['keyword' . $key] = array("value" => $value, "color" => $tp_color1[$key]);
            goto M9bfa;
            M9bfa:
            ePUIN:
            goto SMcrD;
            SMcrD:
        }
        goto TwD84;
        U1nYe:
        $tp_value1 = str_replace('#提现账号#', $valuedata['txzhanghao'], $tp_value1);
        goto zKfph;
        tZtAG:
        $tp_value1 = str_replace('#提现金额#', $valuedata['rmb'], $tp_value1);
        goto U1nYe;
        LUvh7:
        $tp_value1 = str_replace('#时间#', date('Y-m-d H:i:s', time()), $tp_value1);
        goto Dnsgr;
        gqUEL:
    }
    public function sendMsg($openid = "", $tplmsgid = "", $data = array(), $data1 = "", $url = "")
    {
        goto UXMEc;
        Zlp83:
        $cfg = $this->module['config'];
        goto RByB0;
        RByB0:
        include IA_ROOT . '/addons/tiger_wxdaili/wxtoken.php';
        goto vkrKk;
        vkrKk:
        return $account->sendTplNotice($openid, $tplmsgid, $data, $url);
        goto sGGLp;
        UXMEc:
        global $_W;
        goto Zlp83;
        sGGLp:
    }
    public function doMobileGetpay()
    {
        goto Upw7q;
        vu1RF:
        $fee = floatval($bl['dlffprice']);
        goto MEFmS;
        Upw7q:
        global $_GPC, $_W;
        goto LGDIZ;
        oguyw:
        $tel = $_GPC['tel'];
        goto OicE6;
        sb1KD:
        $uid = $_GPC['uid'];
        goto K4AE8;
        tFbGJ:
        $usernames = $_GPC['tname'];
        goto oguyw;
        tJuKG:
        $result = array("errcode" => 1, "errmsg" => "用户信息不存在1");
        goto xTKQ3;
        ClQK_:
        $bl = pdo_fetch('select * from ' . tablename('tiger_wxdaili_set') . " where weid='{$_W['uniacid']}'");
        goto vu1RF;
        xIcfy:
        ZgwJM:
        goto Ql9YN;
        Ql9YN:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$uid}'");
        goto FJYYs;
        VxTGb:
        $dlmsg = $_GPC['dlmsg'];
        goto ALIzN;
        y8xc8:
        $result = array("errcode" => 1, "errmsg" => "用户信息不存在2");
        goto GZo00;
        LGDIZ:
        file_put_contents(IA_ROOT . '/addons/tiger_wxdaili/log1.txt', '
 dddo1ld:' . json_encode($_GPC), FILE_APPEND);
        goto aYccG;
        FJYYs:
        $price = $_GPC['price'];
        goto dJYVE;
        xTKQ3:
        die(json_encode($result));
        goto xIcfy;
        aYccG:
        $cfg = $this->module['config'];
        goto sb1KD;
        ALIzN:
        $desc = $share['nickname'] . $_GPC['tname'] . '代理费用';
        goto ClQK_;
        AEqjA:
        P7VIn:
        goto tFbGJ;
        GZo00:
        die(json_encode($result));
        goto AEqjA;
        gtJBt:
        die(json_encode($result));
        goto WSSDS;
        OicE6:
        $weixin = $_GPC['weixin'];
        goto VxTGb;
        K4AE8:
        if (!empty($uid)) {
            goto ZgwJM;
        }
        goto tJuKG;
        dJYVE:
        if (!empty($share)) {
            goto P7VIn;
        }
        goto y8xc8;
        MEFmS:
        $result = $this->unifiedPay($share, $desc, $fee, '55555555');
        goto gtJBt;
        WSSDS:
    }
    public function doMobileCheckjspayresult()
    {
        goto x4skJ;
        WPgmM:
        $this->dlzdsh($share['id'], $share, $cfg['glyopenid'], $cfg);
        goto L_7b6;
        x4skJ:
        global $_GPC, $_W;
        goto JfXub;
        i_4po:
        file_put_contents(IA_ROOT . '/addons/tiger_wxdaili/log.txt', '
 dddo1ld:' . json_encode($_GPC) . '---' . $share['id'] . '---' . $cfg['glyopenid'], FILE_APPEND);
        goto TbS9W;
        P2xTN:
        $order = pdo_fetch('SELECT orderno FROM ' . tablename($this->modulename . '_order') . " WHERE id = '{$orderid}' ");
        goto EqAkr;
        L_7b6:
        NuXM6:
        goto U2ucN;
        h1Ywa:
        $orderid = $_GPC['orderid'];
        goto P2xTN;
        nunlw:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$_GPC['uid']}'");
        goto i_4po;
        U2ucN:
        die(json_encode($result));
        goto OdvqA;
        JfXub:
        $cfg = $this->module['config'];
        goto nunlw;
        EqAkr:
        $result = $this->dealpayresult($order['orderno'], $_GPC);
        goto M7lj6;
        M7lj6:
        if (!($cfg['zdshtype'] == 1)) {
            goto NuXM6;
        }
        goto WPgmM;
        TbS9W:
        $orderno = $_GPC['orderno'];
        goto h1Ywa;
        OdvqA:
    }
    public function randorder()
    {
        goto uFJ8A;
        SPBIc:
        return date('YmdHis') . substr($basecode, 2, 10) . mt_rand(1000, 9999);
        goto EIk0D;
        uFJ8A:
        list($t1, $t2) = explode(' ', microtime());
        goto EXukX;
        EXukX:
        $basecode = (double) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
        goto SPBIc;
        EIk0D:
    }
    public function unifiedPay($member, $desc, $fee, $goods_id)
    {
        goto MI_bO;
        CFokV:
        $resp = json_decode(json_encode(simplexml_load_string($resp, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        goto EaTU6;
        m9Knt:
        return array("errcode" => 1, "errmsg" => $resp['return_msg']);
        goto FaEsI;
        B9Xms:
        $system = $this->module['config'];
        goto gofcL;
        EaTU6:
        if ($resp['result_code'] != 'SUCCESS') {
            goto s2HKt;
        }
        goto RNRND;
        J9Jtv:
        goto VfLpo;
        goto td41z;
        dcYJG:
        $sign = md5($string);
        goto NGFVK;
        gofcL:
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        goto sple_;
        tPeY6:
        $thisappid = $_W['account']['key'];
        goto KA9VX;
        FaEsI:
        VfLpo:
        goto ZLx0H;
        O8O8C:
        $orderno = $this->randorder();
        goto MPPQL;
        MPPQL:
        $trade_type = 'JSAPI';
        goto tPeY6;
        sple_:
        $random = random(8);
        goto O8O8C;
        NGFVK:
        $post['sign'] = strtoupper($sign);
        goto kBnd0;
        srvxk:
        ksort($post);
        goto jpuas;
        jpuas:
        $string = $this->ToUrlParams($post);
        goto zrfnv;
        LtACQ:
        libxml_disable_entity_loader(true);
        goto CFokV;
        kBnd0:
        $resp = $this->postXmlCurl($this->ToXml($post), $url);
        goto LtACQ;
        RNRND:
        $orderid = $this->addOrder($member, $post, $goods_id);
        goto RsfEE;
        L2CbS:
        $result = array("errcode" => 0, "auth" => 0, "timeStamp" => $params['timeStamp'], "nonceStr" => $params['nonceStr'], "package" => $params['package'], "signType" => $params['signType'], "paySign" => $params['paySign'], "orderno" => $orderno, "orderid" => $orderid);
        goto PTGlH;
        MI_bO:
        global $_W;
        goto B9Xms;
        PTGlH:
        return $result;
        goto J9Jtv;
        td41z:
        s2HKt:
        goto m9Knt;
        zrfnv:
        $string .= "&key={$system['apikey']}";
        goto dcYJG;
        RsfEE:
        $params = $this->getWxPayJsParams($resp['prepay_id']);
        goto L2CbS;
        KA9VX:
        $post = array("appid" => $system['appid'], "mch_id" => $system['mchid'], "nonce_str" => $random, "body" => $desc, "out_trade_no" => $orderno, "total_fee" => $fee * 100, "spbill_create_ip" => $system['ip'], "notify_url" => 'http://' . $_SERVER['HTTP_HOST'] . '/payment/wechat/pay.php', "trade_type" => $trade_type, "openid" => $member['from_user']);
        goto srvxk;
        ZLx0H:
    }
    public function addOrder($member, $post, $goods_id)
    {
        goto jLuIB;
        jLuIB:
        global $_W;
        goto cMXYQ;
        OyYXb:
        pdo_insert($this->modulename . '_order', $data);
        goto Y2_gh;
        KS7at:
        return $orderid;
        goto Q22ga;
        Or04o:
        $data = array("weid" => $_W['uniacid'], "orderno" => $post['out_trade_no'], "goods_id" => $goods_id, "price" => $fee, "memberid" => $member['id'], "openid" => $member['from_user'], "nickname" => $member['nickname'], "avatar" => $member['avatar'], "tel" => $member['tel'], "cengji" => 0, "usernames" => $member['nickname'], "msg" => $member['nickname'] . '代理费用', "createtime" => time());
        goto OyYXb;
        Y2_gh:
        $orderid = pdo_insertid();
        goto KS7at;
        cMXYQ:
        $fee = $post['total_fee'] / 100;
        goto Or04o;
        Q22ga:
    }
    public function dldealpayresult($orderno, $gpc)
    {
        goto pOsXH;
        ScbVx:
        $ores = pdo_update($this->modulename . '_order', $data, array("id" => $order['id']));
        goto pm5bo;
        lYV0V:
        zGfX7:
        goto gQISS;
        cNu_V:
        $msg = $this->mbmsg($cfg['glyopenid'], $mb, $mb['mbid'], $mb['turl'], $fans, '');
        goto bwK9V;
        ebK7h:
        $data['state'] = 1;
        goto LjO7I;
        sWjiE:
        xpbDl:
        goto kuKNw;
        qt6yo:
        $result['errcode'] = 0;
        goto PAeuU;
        ar4S6:
        nfPUs:
        goto KEIdS;
        lNjTM:
        pdo_update('tiger_newhu_share', $dldata, array("weid" => $_W['uniacid'], "id" => $order['memberid']));
        goto XQGxv;
        PAeuU:
        $result['msg'] = '支付成功!';
        goto TfGEQ;
        pm5bo:
        $dldata = array("helpid" => 0, "tztype" => 1, "tzpaytime" => time(), "tztime" => time(), "tzendtime" => time() + $order['tzday'] * 24 * 60 * 60);
        goto lNjTM;
        XhNzl:
        $data = array("paystate" => 1, "paytime" => time());
        goto rcOTO;
        kuKNw:
        $url = '';
        goto qt6yo;
        Q0A2y:
        $result['errcode'] = 1;
        goto VzUjr;
        hx016:
        if ($checkresult['errcode'] == 0) {
            goto zGfX7;
        }
        goto Q0A2y;
        NKJiX:
        $mbid = $cfg['dlsqtx'];
        goto XBm_x;
        yUZMY:
        if (empty($orderno)) {
            goto ugXj9;
        }
        goto ZxIph;
        pns5f:
        $this->jiangli($order['openid'], $order);
        goto ScbVx;
        wt1z8:
        goto vjc9m;
        goto lYV0V;
        dF2Zr:
        $result['errmsg'] = '订单号为空';
        goto ar4S6;
        XBm_x:
        $mb = pdo_fetch('select * from ' . tablename('tiger_newhu_mobanmsg') . " where weid='{$_W['uniacid']}' and id='{$mbid}'");
        goto cNu_V;
        gQISS:
        $order = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_order') . " WHERE  weid = '{$_W['uniacid']}' and orderno ='{$orderno}'");
        goto or09y;
        KiHSS:
        vjc9m:
        goto U3FVa;
        Q3zNl:
        ugXj9:
        goto HsUiU;
        jwuso:
        if (empty($cfg['dlsqtx'])) {
            goto WKRn_;
        }
        goto NKJiX;
        bwK9V:
        WKRn_:
        goto sWjiE;
        HsUiU:
        $result['errcode'] = 1;
        goto dF2Zr;
        LjO7I:
        lCfo0:
        goto pns5f;
        ZxIph:
        $checkresult = $this->checkWechatTranByOrderNo($orderno);
        goto hx016;
        TfGEQ:
        $result['url'] = $url;
        goto KiHSS;
        U3FVa:
        goto nfPUs;
        goto Q3zNl;
        VzUjr:
        $result['errmsg'] = $checkresult['errmsg'];
        goto wt1z8;
        pOsXH:
        global $_W;
        goto zl5cR;
        KEIdS:
        return $result;
        goto QXhPM;
        XQGxv:
        $cfg = $this->module['config'];
        goto jwuso;
        rcOTO:
        if (!($order['state'] == 0)) {
            goto lCfo0;
        }
        goto ebK7h;
        or09y:
        if (!($order['paystate'] == 0)) {
            goto xpbDl;
        }
        goto XhNzl;
        zl5cR:
        $result = array();
        goto yUZMY;
        QXhPM:
    }
    public function dealpayresult($orderno, $gpc)
    {
        goto F2NTy;
        DR24o:
        pdo_update('tiger_newhu_share', $dldata, array("weid" => $_W['uniacid'], "id" => $order['memberid']));
        goto Yvxbi;
        kPFni:
        $url = $_W['siteroot'] . 'app/' . $this->createMobileUrl('jiameng', array("goods_id" => $order['goods_id']));
        goto GvkP4;
        uFacG:
        yFC7o:
        goto kPFni;
        WIX2N:
        G1000:
        goto wMwzH;
        NMUdA:
        oxHk3:
        goto uFacG;
        iaPhy:
        $result['errcode'] = 1;
        goto YQZja;
        Mkmer:
        $checkresult = $this->checkWechatTranByOrderNo($orderno);
        goto iI0QC;
        GaGhU:
        $mb = pdo_fetch('select * from ' . tablename('tiger_newhu_mobanmsg') . " where weid='{$_W['uniacid']}' and id='{$mbid}'");
        goto RlvBD;
        Hu3Wy:
        $order = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_order') . " WHERE  weid = '{$_W['uniacid']}' and orderno ='{$orderno}'");
        goto iyUnA;
        iyUnA:
        if (!($order['paystate'] == 0)) {
            goto yFC7o;
        }
        goto xqxLM;
        LuB1p:
        $dldata = array("weixin" => $gpc['weixin'], "tel" => $gpc['tel'], "pcuser" => $gpc['tel'], "pcpasswords" => $gpc['pcpasswords'], "dlmsg" => $gpc['dlmsg'], "tname" => $gpc['tname'], "zfbuid" => $gpc['zfbuid'], "dltype" => 2);
        goto DR24o;
        RlvBD:
        $msg = $this->mbmsg($cfg['glyopenid'], $mb, $mb['mbid'], $mb['turl'], $fans, '');
        goto NMUdA;
        KT9B8:
        $result['msg'] = '支付成功!';
        goto L4jaP;
        F2NTy:
        global $_W;
        goto YPFhs;
        FKoM9:
        ay_BC:
        goto AjLFp;
        xqxLM:
        $data = array("paystate" => 1, "paytime" => time());
        goto Q6IwM;
        Fou2O:
        $data['state'] = 1;
        goto FKoM9;
        hYMsA:
        $result['errmsg'] = '订单号为空';
        goto kocD4;
        NPA1D:
        VRL3t:
        goto znkeY;
        Yvxbi:
        $this->jiangli($order['openid'], $order);
        goto ubRp5;
        l2YHY:
        if (empty($orderno)) {
            goto G1000;
        }
        goto Mkmer;
        iI0QC:
        if ($checkresult['errcode'] == 0) {
            goto waVpd;
        }
        goto iaPhy;
        AjLFp:
        pdo_update($this->modulename . '_order', $data, array("id" => $order['id']));
        goto LuB1p;
        kocD4:
        APd_f:
        goto VROAk;
        GvkP4:
        $result['errcode'] = 0;
        goto KT9B8;
        Q6IwM:
        if (!($order['state'] == 0)) {
            goto ay_BC;
        }
        goto Fou2O;
        H3GJm:
        goto VRL3t;
        goto Pp23L;
        DShJL:
        if (empty($cfg['dlsqtx'])) {
            goto oxHk3;
        }
        goto h2Ywo;
        YPFhs:
        $result = array();
        goto l2YHY;
        znkeY:
        goto APd_f;
        goto WIX2N;
        ubRp5:
        $cfg = $this->module['config'];
        goto DShJL;
        YQZja:
        $result['errmsg'] = $checkresult['errmsg'];
        goto H3GJm;
        VROAk:
        return $result;
        goto p_Ux6;
        Pp23L:
        waVpd:
        goto Hu3Wy;
        wMwzH:
        $result['errcode'] = 1;
        goto hYMsA;
        h2Ywo:
        $mbid = $cfg['dlsqtx'];
        goto GaGhU;
        L4jaP:
        $result['url'] = $url;
        goto NPA1D;
        p_Ux6:
    }
    public function jiangli($openid, $order)
    {
        goto bYfaJ;
        rHLv2:
        fCNUG:
        goto TR7_F;
        OoyUD:
        AFeF5:
        goto D3H7R;
        t13SF:
        GGNPy:
        goto aQlS7;
        G0Txa:
        M932l:
        goto CxJt4;
        K0KSh:
        qsP7G:
        goto cyHDM;
        heal_:
        $msg3 = str_replace('#昵称#', $member['nickname'], $bl['zfmsg3']);
        goto f7O9O;
        m74kk:
        Z_0jk:
        goto HAVEt;
        f7O9O:
        $msg3 = str_replace('#金额#', $data['price'], $msg3);
        goto SKuy5;
        kFlkK:
        $this->mc_jl($sjmember['id'], 1, 10, $data['price'], $data['msg'], $order['orderno']);
        goto hV0B9;
        JLHUa:
        if (empty($sjmember['from_user'])) {
            goto FY289;
        }
        goto TieIr;
        lWUhq:
        $data['msg'] = $member['nickname'] . '三级奖励';
        goto g90Y2;
        nSZnx:
        $msg1 = str_replace('#金额#', $data['price'], $msg1);
        goto R_nyD;
        pbMsk:
        goto a91sZ;
        goto IzhGm;
        uTOo5:
        $data['price'] = $bl['glevel2'];
        goto tNmUR;
        k8I91:
        $data['avatar'] = $sjmember['avatar'];
        goto EC5me;
        p06Aa:
        if (empty($data['price'])) {
            goto Z_0jk;
        }
        goto heal_;
        E1Bat:
        file_put_contents(IA_ROOT . '/addons/tiger_wxdaili/log.txt', '
' . json_encode($uid . '--3--' . $data['price']), FILE_APPEND);
        goto G0Txa;
        xE7my:
        OQvlt:
        goto SHsdT;
        LF40s:
        $data = array("weid" => $_W['uniacid'], "orderno" => $order['orderno'], "goods_id" => $order['goods_id'], "state" => 1, "paystate" => 1, "paytime" => $order['paytime'], "createtime" => time());
        goto HzU73;
        N6Pl9:
        a91sZ:
        goto N_JuI;
        HAVEt:
        CENVQ:
        goto E1Bat;
        tcbNI:
        $data['openid'] = $hmember['from_user'];
        goto aVcby;
        i6w7i:
        $this->postText($member['from_user'], $msg0);
        goto D43nk;
        R_nyD:
        $this->postText($sjmember['from_user'], $msg1);
        goto kFlkK;
        uMHAF:
        $msg2 = str_replace('#金额#', $data['price'], $msg2);
        goto DQuz5;
        TR7_F:
        FY289:
        goto Eq2Sf;
        RkxnT:
        $msg0 = str_replace('#金额#', $order['price'], $msg0);
        goto i6w7i;
        pmYl4:
        if (empty($data['price'])) {
            goto OTK3S;
        }
        goto GlR0b;
        DQuz5:
        $this->postText($hmember['from_user'], $msg2);
        goto zWQFx;
        lkP9X:
        $data['price'] = $bl['glevel3'];
        goto PNFO_;
        aQlS7:
        $data['price'] = $order['price'] * $bl['level3'] / 100;
        goto xE7my;
        JK2Ey:
        $data['nickname'] = $hmember['nickname'];
        goto iElYS;
        tNmUR:
        goto AFeF5;
        goto zvA9T;
        hHgZO:
        $member = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_share') . " WHERE id = '{$order['memberid']}' and weid='{$_W['uniacid']}'");
        goto LF40s;
        aVcby:
        $data['cengji'] = 2;
        goto CMLI8;
        hV0B9:
        pdo_insert($this->modulename . '_order', $data);
        goto rHLv2;
        Eq2Sf:
        if (empty($sjmember['helpid'])) {
            goto daJdn;
        }
        goto dgZTH;
        sn6QE:
        $data['price'] = $order['price'] * $bl['level2'] / 100;
        goto OoyUD;
        i0WY0:
        $data['avatar'] = $smember['avatar'];
        goto p0_ub;
        mh_Ac:
        $cfg = $this->module['config'];
        goto Qtrkb;
        SKuy5:
        $this->postText($smember['from_user'], $msg3);
        goto GPOyj;
        FdBMo:
        $smember = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_share') . " WHERE id = '{$hmember['helpid']}' and weid='{$_W['uniacid']}' and dltype=1 order by id desc limit 1");
        goto PEVMW;
        rv2kj:
        if (!empty($bl['level1'])) {
            goto DlUTX;
        }
        goto uTOo5;
        HzU73:
        $msg0 = str_replace('#昵称#', $member['nickname'], $bl['zfmsg0']);
        goto RkxnT;
        PNFO_:
        goto OQvlt;
        goto t13SF;
        YEvp7:
        $data['nickname'] = $sjmember['nickname'];
        goto k8I91;
        SHsdT:
        $data['memberid'] = $smember['id'];
        goto ni8ER;
        Qc6oQ:
        pdo_insert($this->modulename . '_order', $data);
        goto DkzlB;
        hRRg3:
        $data['cengji'] = 3;
        goto lWUhq;
        NQoJq:
        pdo_insert($this->modulename . '_order', $data);
        goto m74kk;
        D43nk:
        if (empty($member['helpid'])) {
            goto qsP7G;
        }
        goto COsQF;
        ni8ER:
        $data['nickname'] = $smember['nickname'];
        goto i0WY0;
        CxJt4:
        daJdn:
        goto K0KSh;
        g90Y2:
        if (empty($smember['openid'])) {
            goto CENVQ;
        }
        goto p06Aa;
        GlR0b:
        $msg2 = str_replace('#昵称#', $member['nickname'], $bl['zfmsg2']);
        goto uMHAF;
        Qtrkb:
        $bl = pdo_fetch('select * from ' . tablename('tiger_wxdaili_set') . " where weid='{$_W['uniacid']}'");
        goto hHgZO;
        pkSBb:
        $data['price'] = $bl['glevel1'];
        goto pbMsk;
        EKtvk:
        if (empty($hmember['helpid'])) {
            goto M932l;
        }
        goto FdBMo;
        DkzlB:
        OTK3S:
        goto M998k;
        CMLI8:
        $data['msg'] = $member['nickname'] . '二级奖励';
        goto hc7Jb;
        bYfaJ:
        global $_W;
        goto SYqS2;
        csonE:
        $msg1 = str_replace('#昵称#', $member['nickname'], $bl['zfmsg1']);
        goto nSZnx;
        p0_ub:
        $data['openid'] = $smember['from_user'];
        goto hRRg3;
        GPOyj:
        $this->mc_jl($smember['id'], 1, 10, $data['price'], $data['msg'], $order['orderno']);
        goto NQoJq;
        D3H7R:
        $data['memberid'] = $hmember['id'];
        goto JK2Ey;
        iOpDE:
        $data['msg'] = $member['nickname'] . '一级奖励';
        goto JLHUa;
        urjH3:
        $data['cengji'] = 1;
        goto iOpDE;
        hc7Jb:
        if (empty($hmember['openid'])) {
            goto UKnV3;
        }
        goto pmYl4;
        HUwJs:
        if (!empty($bl['level1'])) {
            goto aRJok;
        }
        goto pkSBb;
        w6H4A:
        $data['price'] = $order['price'] * $bl['level1'] / 100;
        goto N6Pl9;
        TieIr:
        if (empty($data['price'])) {
            goto fCNUG;
        }
        goto csonE;
        COsQF:
        $sjmember = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_share') . " WHERE id = '{$member['helpid']}' and weid='{$_W['uniacid']}' and dltype=1");
        goto HUwJs;
        zWQFx:
        $this->mc_jl($hmember['id'], 1, 10, $data['price'], $data['msg'], $order['orderno']);
        goto Qc6oQ;
        iElYS:
        $data['avatar'] = $hmember['avatar'];
        goto tcbNI;
        dgZTH:
        $hmember = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_share') . " WHERE id = '{$sjmember['helpid']}' and weid='{$_W['uniacid']}' and dltype=1 order by id desc limit 1");
        goto rv2kj;
        IzhGm:
        aRJok:
        goto w6H4A;
        SYqS2:
        load()->model('mc');
        goto mh_Ac;
        PEVMW:
        if (!empty($bl['level1'])) {
            goto GGNPy;
        }
        goto lkP9X;
        EC5me:
        $data['openid'] = $sjmember['from_user'];
        goto urjH3;
        M998k:
        UKnV3:
        goto EKtvk;
        zvA9T:
        DlUTX:
        goto sn6QE;
        N_JuI:
        $data['memberid'] = $sjmember['id'];
        goto YEvp7;
        cyHDM:
    }
    public function checkWechatTranByOrderNo($orderno)
    {
        goto CZUcY;
        TGuaz:
        $resp = json_decode(json_encode(simplexml_load_string($resp, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        goto GSqsS;
        QH22V:
        if ($resp['trade_state'] == 'SUCCESS') {
            goto lA8U4;
        }
        goto GemSL;
        AP1mu:
        A5blH:
        goto qn55K;
        V3RsT:
        $url = 'https://api.mch.weixin.qq.com/pay/orderquery';
        goto aFR7i;
        GSqsS:
        if ($resp['return_code'] == 'SUCCESS') {
            goto Z9OmP;
        }
        goto MEql6;
        IHmxG:
        $post = array("appid" => $system['appid'], "out_trade_no" => $orderno, "nonce_str" => $random, "mch_id" => $system['mchid']);
        goto dHoy8;
        rGspm:
        return array("errcode" => 0, "fee" => $resp['total_fee'] / 100);
        goto AP1mu;
        GemSL:
        return array("errcode" => 1, "errmsg" => '未支付:' . $resp['trade_state']);
        goto tW3Cl;
        tW3Cl:
        goto A5blH;
        goto WmERl;
        Bj_cU:
        goto BBDGD;
        goto zKo6f;
        xblPo:
        if ($resp['result_code'] == 'SUCCESS') {
            goto qLm1p;
        }
        goto nicoZ;
        qn55K:
        BBDGD:
        goto O74wV;
        CZUcY:
        global $_W;
        goto k62LS;
        eaXQq:
        Z9OmP:
        goto xblPo;
        zKo6f:
        qLm1p:
        goto QH22V;
        aFR7i:
        $random = random(8);
        goto IHmxG;
        MEql6:
        return array("errcode" => 1, "errmsg" => '查询失败:' . $resp['return_msg']);
        goto gqG8N;
        nicoZ:
        return array("errcode" => 1, "errmsg" => '订单不存在' . $resp['err_code']);
        goto Bj_cU;
        GyOYT:
        $string .= "&key={$system['apikey']}";
        goto j1Oo6;
        O74wV:
        vIztY:
        goto fJZRj;
        k62LS:
        $system = $this->module['config'];
        goto V3RsT;
        n6TBM:
        $string = $this->ToUrlParams($post);
        goto GyOYT;
        gqG8N:
        goto vIztY;
        goto eaXQq;
        j1Oo6:
        $sign = md5($string);
        goto ZfdgQ;
        u3i0X:
        $resp = $this->postXmlCurl($this->ToXml($post), $url);
        goto cqEHN;
        dHoy8:
        ksort($post);
        goto n6TBM;
        cqEHN:
        libxml_disable_entity_loader(true);
        goto TGuaz;
        WmERl:
        lA8U4:
        goto rGspm;
        ZfdgQ:
        $post['sign'] = strtoupper($sign);
        goto u3i0X;
        fJZRj:
    }
    public function ToUrlParams($urlObj)
    {
        goto ZQTEn;
        cy6YT:
        return $buff;
        goto vbyq9;
        grobu:
        foreach ($urlObj as $k => $v) {
            goto hb89l;
            Z0OeQ:
            Daj6u:
            goto s9A4b;
            s9A4b:
            JM0dI:
            goto y1sIK;
            h8UXg:
            $buff .= $k . '=' . $v . '&';
            goto Z0OeQ;
            hb89l:
            if (!($k != 'sign')) {
                goto Daj6u;
            }
            goto h8UXg;
            y1sIK:
        }
        goto AMCby;
        HNAv5:
        $buff = trim($buff, '&');
        goto cy6YT;
        AMCby:
        Ln_n6:
        goto HNAv5;
        ZQTEn:
        $buff = '';
        goto grobu;
        vbyq9:
    }
    public function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {
        goto m5MVk;
        keqli:
        curl_setopt($ch, CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
        goto jMf7a;
        iFbkL:
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        goto keqli;
        gEIOP:
        return $data;
        goto e9oF0;
        D15su:
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        goto gNAGW;
        xNuep:
        curl_setopt($ch, CURLOPT_POST, TRUE);
        goto BfHzU;
        BFTBY:
        E0z58:
        goto xNuep;
        SP0CC:
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        goto s4jyY;
        v2D6s:
        $data = curl_exec($ch);
        goto Kch7R;
        e9oF0:
        scWDT:
        goto wiOF8;
        Kch7R:
        if (!$data) {
            goto scWDT;
        }
        goto YmLAi;
        s4jyY:
        curl_setopt($ch, CURLOPT_URL, $url);
        goto L2gzR;
        L2gzR:
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        goto D15su;
        jMf7a:
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        goto YqEeK;
        IYkbT:
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        goto q7Jh3;
        BfHzU:
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        goto v2D6s;
        m5MVk:
        $ch = curl_init();
        goto SP0CC;
        YmLAi:
        curl_close($ch);
        goto gEIOP;
        YqEeK:
        curl_setopt($ch, CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
        goto BFTBY;
        q7Jh3:
        if (!($useCert == true)) {
            goto E0z58;
        }
        goto iFbkL;
        gNAGW:
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        goto IYkbT;
        wiOF8:
    }
    public function ToXml($post)
    {
        goto nPUid;
        YZmBS:
        foreach ($post as $key => $val) {
            goto tjd3l;
            bFMkv:
            $xml .= '<' . $key . '>' . $val . '</' . $key . '>';
            goto KQpw_;
            KQpw_:
            dOlFm:
            goto emeCl;
            Y0KDG:
            $xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
            goto c__EU;
            emeCl:
            mxjXN:
            goto stFea;
            c__EU:
            goto dOlFm;
            goto hL2nX;
            tjd3l:
            if (is_numeric($val)) {
                goto Ipxs2;
            }
            goto Y0KDG;
            hL2nX:
            Ipxs2:
            goto bFMkv;
            stFea:
        }
        goto ZrIMR;
        XIQ7s:
        $xml .= '</xml>';
        goto PF8GO;
        PF8GO:
        return $xml;
        goto INLIe;
        nPUid:
        $xml = '<xml>';
        goto YZmBS;
        ZrIMR:
        AZz80:
        goto XIQ7s;
        INLIe:
    }
    public function getWxPayJsParams($prepay_id)
    {
        goto iLhjh;
        MuiiL:
        $random = random(8);
        goto AIRwC;
        SBAdo:
        $sign = md5($string);
        goto Wavel;
        kVdRK:
        $system = $this->module['config'];
        goto MuiiL;
        PTHds:
        return $post;
        goto JOeXx;
        zJ9pC:
        ksort($post);
        goto ym40t;
        ym40t:
        $string = $this->ToUrlParams($post);
        goto PBKDw;
        iLhjh:
        global $_W;
        goto kVdRK;
        Wavel:
        $post['paySign'] = strtoupper($sign);
        goto PTHds;
        AIRwC:
        $post = array("appId" => $system['appid'], "timeStamp" => time(), "nonceStr" => $random, "package" => 'prepay_id=' . $prepay_id, "signType" => "MD5");
        goto zJ9pC;
        PBKDw:
        $string .= "&key={$system['apikey']}";
        goto SBAdo;
        JOeXx:
    }
    function post_txhb($cfg, $openid, $dtotal_amount, $desc, $dmch_billno)
    {
        goto EbY1A;
        i149O:
        $root = IA_ROOT . '/attachment/tiger_newhu/cert/' . $_W['uniacid'] . '/';
        goto L2ZIu;
        f511D:
        return $ret;
        goto oXEBT;
        eBHEY:
        $pars['remark'] = '来自' . $_W['account']['name'] . '的红包';
        goto wERBY;
        L2ZIu:
        $ret = array();
        goto HiDas;
        r85XH:
        $string1 = '';
        goto oPvOB;
        qfs9w:
        ksw8C:
        goto FNuuI;
        SrpDt:
        Sm6w6:
        goto i149O;
        rPlGd:
        $ret['dissuccess'] = 1;
        goto wwsQL;
        zjGeG:
        $ret['message'] = 'success';
        goto Sqncv;
        fAGiV:
        return $ret;
        goto CWx9E;
        yw8Vf:
        goto PMAgr;
        goto Hpips;
        gPA_0:
        $pars['sign'] = strtoupper(md5($string1));
        goto BqV_P;
        TcDyv:
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
        goto JR5ii;
        JdjZP:
        $ret['message'] = $procResult;
        goto bQNhm;
        GoTzZ:
        $ret['dissuccess'] = 0;
        goto Sqy54;
        IqU5A:
        if ($dom->loadXML($xml)) {
            goto EDyd5;
        }
        goto QSBe5;
        nd_N7:
        $pars['send_name'] = $_W['account']['name'];
        goto OrxLp;
        abX4J:
        $procResult = $resp['message'];
        goto Nzg3p;
        Xat4g:
        $ret['message'] = '3error3';
        goto f511D;
        HiDas:
        $ret['code'] = 0;
        goto zjGeG;
        WRnWh:
        $extras = array();
        goto ow4fp;
        yXjBt:
        $pars['nonce_str'] = random(32);
        goto WV5aD;
        DzQjG:
        QXyWj:
        goto JUsh9;
        oPvOB:
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
            zUd38:
        }
        goto VALLo;
        oXEBT:
        goto QXyWj;
        goto dZpXk;
        Zc4z8:
        $pars['mch_id'] = $cfg['mchid'];
        goto Jxp37;
        YaOXP:
        $extras['CURLOPT_SSLCERT'] = $root . 'apiclient_cert.pem';
        goto TS2mD;
        Hpips:
        wpp2P:
        goto exonj;
        ow4fp:
        $extras['CURLOPT_CAINFO'] = $root . 'rootca.pem';
        goto YaOXP;
        Sdh_p:
        $result = $xpath->evaluate('string(//xml/result_code)');
        goto TEfvc;
        rMGz5:
        $ret['code'] = -1;
        goto GoTzZ;
        VALLo:
        bGD8k:
        goto vYvlh;
        wWVQq:
        if (empty($desc)) {
            goto ksw8C;
        }
        goto MgxGg;
        exonj:
        $ret['code'] = 0;
        goto rPlGd;
        vYvlh:
        $string1 .= "key={$cfg['apikey']}";
        goto gPA_0;
        TS2mD:
        $extras['CURLOPT_SSLKEY'] = $root . 'apiclient_key.pem';
        goto P8GCV;
        FW_Fo:
        return $ret;
        goto sYf2K;
        RmVkI:
        $code = $xpath->evaluate('string(//xml/return_code)');
        goto Sdh_p;
        Sqy54:
        $ret['message'] = '余额不足';
        goto FW_Fo;
        GmTow:
        $ret['code'] = -2;
        goto cocIi;
        oELEG:
        $ret['dissuccess'] = 0;
        goto Xat4g;
        Sqncv:
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        goto lPVEi;
        P8GCV:
        load()->func('communication');
        goto fbdz_;
        KuxG6:
        $dmch_billno = random(10) . date('Ymd') . random(3);
        goto SrpDt;
        MgxGg:
        $fans = mc_fetch($_W['openid']);
        goto GZmKA;
        lDVa4:
        return $ret;
        goto yw8Vf;
        OrxLp:
        $pars['re_openid'] = $openid;
        goto R3fJY;
        kiPNK:
        $pars['total_num'] = 1;
        goto KVbbj;
        QSBe5:
        $ret['code'] = -3;
        goto oELEG;
        R3fJY:
        $pars['total_amount'] = $dtotal_amount;
        goto VK4ID;
        NNsEm:
        $ret['dissuccess'] = 0;
        goto JdjZP;
        GJC5f:
        Bw_DQ:
        goto abX4J;
        fbdz_:
        $procResult = null;
        goto ywN8V;
        lv_xH:
        $pars['max_value'] = $dtotal_amount;
        goto kiPNK;
        GZmKA:
        $dtotal = $dtotal_amount / 100;
        goto VGcAI;
        g0jYW:
        $pars['client_ip'] = $cfg['ip'];
        goto krrKi;
        bQNhm:
        return $ret;
        goto b1v8g;
        krrKi:
        $pars['act_name'] = '提现红包';
        goto eBHEY;
        TEfvc:
        if (strtolower($code) == 'success' && strtolower($result) == 'success') {
            goto wpp2P;
        }
        goto Dc2mj;
        KVbbj:
        $pars['wishing'] = '提现红包成功!';
        goto g0jYW;
        Npmb2:
        $pars['nick_name'] = $_W['account']['name'];
        goto nd_N7;
        BqV_P:
        $xml = array2xml($pars);
        goto WRnWh;
        Nzg3p:
        $ret['code'] = -1;
        goto NNsEm;
        KrX9y:
        if (is_error($resp)) {
            goto Bw_DQ;
        }
        goto TcDyv;
        Yl8Ad:
        load()->model('mc');
        goto wWVQq;
        VK4ID:
        $pars['min_value'] = $dtotal_amount;
        goto lv_xH;
        JUsh9:
        goto B0wWm;
        goto GJC5f;
        WV5aD:
        $pars['mch_billno'] = $dmch_billno;
        goto Zc4z8;
        Dc2mj:
        $error = $xpath->evaluate('string(//xml/err_code_des)');
        goto GmTow;
        VGcAI:
        if (!($dtotal > $fans['credit2'])) {
            goto Ns1wu;
        }
        goto rMGz5;
        JR5ii:
        $dom = new DOMDocument();
        goto IqU5A;
        b1v8g:
        B0wWm:
        goto bJ0ew;
        HbInC:
        $ret['message'] = $error;
        goto lDVa4;
        FNuuI:
        if (!empty($dmch_billno)) {
            goto Sm6w6;
        }
        goto KuxG6;
        ywN8V:
        $resp = ihttp_request($url, $xml, $extras);
        goto KrX9y;
        dZpXk:
        EDyd5:
        goto xXIhj;
        Jxp37:
        $pars['wxappid'] = $cfg['appid'];
        goto Npmb2;
        CWx9E:
        PMAgr:
        goto DzQjG;
        cocIi:
        $ret['dissuccess'] = 0;
        goto HbInC;
        EbY1A:
        global $_W;
        goto Yl8Ad;
        sYf2K:
        exit;
        goto CZb9R;
        xXIhj:
        $xpath = new DOMXPath($dom);
        goto RmVkI;
        wERBY:
        ksort($pars, SORT_STRING);
        goto r85XH;
        lPVEi:
        $pars = array();
        goto yXjBt;
        wwsQL:
        $ret['message'] = 'success';
        goto fAGiV;
        CZb9R:
        Ns1wu:
        goto qfs9w;
        bJ0ew:
    }
    public function post_qyfk($cfg, $openid, $amount, $desc, $dmch_billno)
    {
        goto vgmgC;
        z4dRj:
        $pars = array();
        goto oGiOY;
        WMUoj:
        bchLa:
        goto gfQGL;
        jz4uH:
        rUkY0:
        goto eelXf;
        o3oKM:
        return $ret;
        goto nnG2y;
        xys_3:
        WHW2z:
        goto XMXan;
        H1YAT:
        $ret['message'] = '余额不足';
        goto FKNC2;
        U1MmL:
        $ret['code'] = -2;
        goto E9cI2;
        UlYuj:
        $pars['amount'] = $amount;
        goto l96My;
        b4J4g:
        $ret['dissuccess'] = 1;
        goto aoMmH;
        vjbp4:
        $error = $xpath->evaluate('string(//xml/err_code_des)');
        goto U1MmL;
        L0GR0:
        $pars['mchid'] = $cfg['mchid'];
        goto Jzf6L;
        P1C3s:
        return $ret;
        goto Fb4eL;
        FKNC2:
        return $ret;
        goto SCHy_;
        fe91t:
        $dom = new DOMDocument();
        goto xxMaG;
        un9ll:
        AEHc9:
        goto mpL3j;
        irSQY:
        $fans = mc_fetch($_W['openid']);
        goto gwbtS;
        Jzf6L:
        $pars['nonce_str'] = random(32);
        goto hT2gi;
        hMWk8:
        $ret['dissuccess'] = 0;
        goto a6oWD;
        JEzUP:
        $pars['check_name'] = 'NO_CHECK';
        goto UlYuj;
        Pb2oR:
        $extras['CURLOPT_SSLCERT'] = $root . 'apiclient_cert.pem';
        goto RI7Yy;
        Nun0C:
        load()->model('mc');
        goto CRXsW;
        vgmgC:
        global $_W;
        goto Nun0C;
        E9cI2:
        $ret['dissuccess'] = 0;
        goto H231w;
        tIyE7:
        $dmch_billno = random(10) . date('Ymd') . random(3);
        goto YwDIt;
        mpL3j:
        $ret['code'] = 0;
        goto b4J4g;
        bKjXi:
        if (!($dtotal > $fans['credit2'])) {
            goto WHW2z;
        }
        goto cm9Go;
        cm9Go:
        $ret['code'] = -1;
        goto TthYu;
        o3ERV:
        $ret['code'] = 0;
        goto Yd31R;
        Plj1E:
        $procResult = null;
        goto nK2Qf;
        S7s5O:
        $string1 .= "key={$cfg['apikey']}";
        goto Aw3P2;
        EMHUv:
        $ret['dissuccess'] = 0;
        goto HFnB4;
        XMXan:
        ZrMtL:
        goto TADdp;
        gwbtS:
        $dtotal = $amount / 100;
        goto bKjXi;
        H231w:
        $ret['message'] = '-2:' . $error;
        goto IrGJK;
        hT2gi:
        $pars['partner_trade_no'] = $dmch_billno;
        goto OoTN6;
        gfQGL:
        $xpath = new DOMXPath($dom);
        goto Mi1td;
        eelXf:
        $procResult = $resp['message'];
        goto lUNje;
        jcHIz:
        $result = $xpath->evaluate('string(//xml/result_code)');
        goto j_M9a;
        MLF3l:
        $string1 = '';
        goto BvuZN;
        YDqHV:
        $pars['spbill_create_ip'] = $cfg['ip'];
        goto fuq_e;
        zezi3:
        $ret['amount'] = $amount;
        goto WN9Y0;
        xxMaG:
        if ($dom->loadXML($xml)) {
            goto bchLa;
        }
        goto wIvW6;
        finoA:
        return $ret;
        goto ZqW8B;
        AbPyK:
        $extras = array();
        goto SmOXo;
        RsM0F:
        jL2Ux:
        goto DncAn;
        SCHy_:
        exit;
        goto xys_3;
        CRXsW:
        if (empty($desc)) {
            goto ZrMtL;
        }
        goto irSQY;
        HFnB4:
        $ret['message'] = '-1:' . $procResult;
        goto finoA;
        Aw3P2:
        $pars['sign'] = strtoupper(md5($string1));
        goto sg3eK;
        SmOXo:
        $extras['CURLOPT_CAINFO'] = $root . 'rootca.pem';
        goto Pb2oR;
        nnG2y:
        goto jL2Ux;
        goto WMUoj;
        YwDIt:
        C1Fbd:
        goto xajqA;
        Yd31R:
        $ret['message'] = 'success';
        goto zezi3;
        RI7Yy:
        $extras['CURLOPT_SSLKEY'] = $root . 'apiclient_key.pem';
        goto p8E7I;
        Mi1td:
        $code = $xpath->evaluate('string(//xml/return_code)');
        goto jcHIz;
        BvuZN:
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
            fHGAg:
        }
        goto lt6cj;
        TADdp:
        if (!empty($dmch_billno)) {
            goto C1Fbd;
        }
        goto tIyE7;
        a6oWD:
        $ret['message'] = 'error response';
        goto o3oKM;
        fuq_e:
        ksort($pars, SORT_STRING);
        goto MLF3l;
        wIvW6:
        $ret['code'] = -3;
        goto hMWk8;
        j_M9a:
        if (strtolower($code) == 'success' && strtolower($result) == 'success') {
            goto AEHc9;
        }
        goto vjbp4;
        lt6cj:
        kQ8P_:
        goto S7s5O;
        OoTN6:
        $pars['openid'] = $openid;
        goto JEzUP;
        nsIVM:
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
        goto fe91t;
        DncAn:
        goto Kz2XO;
        goto jz4uH;
        IrGJK:
        return $ret;
        goto irJwv;
        Fb4eL:
        a2sTI:
        goto RsM0F;
        xajqA:
        $root = IA_ROOT . '/attachment/tiger_newhu/cert/' . $_W['uniacid'] . '/';
        goto lbu3P;
        ZqW8B:
        Kz2XO:
        goto bL1J_;
        oGiOY:
        $pars['mch_appid'] = $cfg['appid'];
        goto L0GR0;
        lUNje:
        $ret['code'] = -1;
        goto EMHUv;
        sg3eK:
        $xml = array2xml($pars);
        goto AbPyK;
        lbu3P:
        $ret = array();
        goto o3ERV;
        nK2Qf:
        $resp = ihttp_request($url, $xml, $extras);
        goto R19rB;
        irJwv:
        goto a2sTI;
        goto un9ll;
        WN9Y0:
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        goto z4dRj;
        TthYu:
        $ret['dissuccess'] = 0;
        goto H1YAT;
        p8E7I:
        load()->func('communication');
        goto Plj1E;
        aoMmH:
        $ret['message'] = 'success';
        goto P1C3s;
        R19rB:
        if (is_error($resp)) {
            goto rUkY0;
        }
        goto nsIVM;
        l96My:
        $pars['desc'] = '来自' . $_W['account']['name'] . '的提现';
        goto YDqHV;
        bL1J_:
    }
    public function postText($openid, $text)
    {
        goto wtslV;
        giZfb:
        $ret = $this->postRes($this->getAccessToken(), $post);
        goto iJ8t4;
        wtslV:
        $post = '{"touser":"' . $openid . '","msgtype":"text","text":{"content":"' . $text . '"}}';
        goto giZfb;
        iJ8t4:
        return $ret;
        goto NQ2_P;
        NQ2_P:
    }
    private function postRes($access_token, $data)
    {
        goto CIhUn;
        Lz5xy:
        return $content['errcode'];
        goto GsNim;
        apfhq:
        $content = @json_decode($ret['content'], true);
        goto Lz5xy;
        CIhUn:
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        goto NyoAg;
        rlyjt:
        $ret = ihttp_request($url, $data);
        goto apfhq;
        NyoAg:
        load()->func('communication');
        goto rlyjt;
        GsNim:
    }
}