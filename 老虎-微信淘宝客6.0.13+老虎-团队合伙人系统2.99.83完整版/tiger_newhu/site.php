<?php

goto x9btd;
PgX_E:
require_once ROOT_PATH . 'inc/sdk/tbk/TopSdk.php';
goto AFKkZ;
tNK_3:
define('ROOT_PATH', IA_ROOT . '/addons/tiger_newhu/');
goto K9Mn1;
K9Mn1:
require_once ROOT_PATH . 'lib/excel.php';
goto PgX_E;
x9btd:
defined('IN_IA') or exit('Access Denied');
goto tNK_3;
AFKkZ:
class tiger_newhuModuleSite extends WeModuleSite
{
    public $table_request = "tiger_newhu_request";
    public $table_goods = "tiger_newhu_goods";
    public $table_ad = "tiger_newhu_ad";
    private static $t_sys_member = "mc_members";
/*     public function __construct()
    {
        goto CFcq4;
        S_x_0:
        bQx2b:
        goto YN36z;
        gc13T:
        $cfg = $this->module['config'];
        goto iaRL2;
        O8boB:
        $tbuid = $cfg['tbuid'];
        goto X1_vM;
        X1_vM:
        $tkurl1 = urlencode($host);
        goto QEk71;
        lRi1A:
        $_W['siteroot'] = $cfg['tknewurl'];
        goto TGAor;
        EVsoy:
        if (!($c == 'entry')) {
            goto Oy280;
        }
        goto vOuYO;
        fFu1r:
        yxPrP:
        goto gc13T;
        XuH1r:
        $loginurl = $_W['siteroot'] . str_replace('./', 'app/', $this->createMobileurl('login')) . '&m=tiger_newhu' . '&tzurl=' . urlencode($tktzurl);
        goto RMPZ9;
        ZJNbc:
        $tktzurl = $_W['siteurl'];
        goto XuH1r;
        CFcq4:
        session_start();
        goto YTBG3;
        PKTU0:
        echo $arr['msg'];
        goto QrlrE;
        VWtq2:
        exit;
        goto z0hjz;
        f1nFg:
        $aa = $this->curl_request($url);
        goto w8g3O;
        Up_bK:
        $host = $_SERVER['HTTP_HOST'];
        goto o78S8;
        Oil_c:
        $tkip = $this->get_server_ip();
        goto MRgqg;
        IHaCz:
        t8MuM:
        goto EVsoy;
        RMPZ9:
        if (!($do != 'login' and $do != 'bdlogin' and $do != 'tupian' and $do != 'postorder' and $do != 'tk')) {
            goto kr6PC;
        }
        goto sl73z;
        Vp1yW:
        $cfg = $this->module['config'];
        goto F06bF;
        o78S8:
        $host = strtolower($host);
        goto O8boB;
        vOuYO:
        if (!($cfg['logintype'] == 1)) {
            goto QBTRb;
        }
        goto Ha363;
        z0hjz:
        kr6PC:
        goto S_x_0;
        QrlrE:
        exit;
        goto Btvk1;
        Btvk1:
        Gdzu1:
        goto fFu1r;
        iaRL2:
        if (empty($cfg['tknewurl'])) {
            goto t8MuM;
        }
        goto w2uiP;
        w8g3O:
        $arr = @json_decode($aa, true);
        goto ES337;
        w2uiP:
        if (!($c == 'entry')) {
            goto jO8D9;
        }
        goto lRi1A;
        ES337:
        if (!($arr['error'] == 2)) {
            goto Gdzu1;
        }
        goto PKTU0;
        YN36z:
        QBTRb:
        goto q1YSx;
        m9KE2:
        $do = $_GPC['do'];
        goto Vp1yW;
        F06bF:
        if (!($c == 'site')) {
            goto yxPrP;
        }
        goto Up_bK;
        TGAor:
        jO8D9:
        goto IHaCz;
        Ha363:
        if (!empty($_SESSION['tkuid'])) {
            goto bQx2b;
        }
        goto ZJNbc;
        q1YSx:
        Oy280:
        goto yhbDz;
        YTBG3:
        global $_W, $_GPC;
        goto D6MuL;
        MRgqg:
        $url = 'http://api1.laohucms.com/sqnew.php?tbuid=' . $tbuid . '&tkurl=' . $tkurl1 . '&tkurl2=' . $tkurl2 . '&tkip=' . $tkip . '&sign=' . md5($tkip . 'tig');
        goto f1nFg;
        sl73z:
        header('Location: ' . $loginurl);
        goto VWtq2;
        QEk71:
        $tkurl2 = urlencode($_W['setting']['site']['url']);
        goto Oil_c;
        D6MuL:
        $c = $_GPC['c'];
        goto m9KE2;
        yhbDz:
    } */
    public function doMobileMdorderlist()
    {
        goto ofdR9;
        Nj0at:
        goto N5Qkv;
        goto GCm8K;
        Lj6JW:
        goto KgGfL;
        goto rcHvu;
        t85HJ:
        if (!empty($fans['tkuid'])) {
            goto GpiOZ;
        }
        goto QVip2;
        ofdR9:
        global $_W, $_GPC;
        goto oZnO7;
        Wxavl:
        $order = pdo_fetchall('select * from ' . tablename($this->modulename . '_mdorder') . " where weid='{$_W['uniacid']}' and openid='{$fans['openid']}' and sh=2  order by id desc");
        goto rNfo2;
        hK1xm:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$uid}'");
        goto Lj6JW;
        mkD4y:
        KhJXY:
        goto BOa3k;
        fPvPP:
        if ($op == 'qb') {
            goto guHo2;
        }
        goto O9wxz;
        qfQJj:
        $uid = $share['id'];
        goto B5eGd;
        O9wxz:
        if ($op == 'df') {
            goto HVNse;
        }
        goto oarTx;
        SOMk6:
        $op = $_GPC['op'];
        goto fPvPP;
        SunwM:
        $order = pdo_fetchall('select * from ' . tablename($this->modulename . '_mdorder') . " where weid='{$_W['uniacid']}' and openid='{$fans['openid']}' and sh=1 order by id desc");
        goto Nj0at;
        LtqOV:
        $uid = $_GPC['uid'];
        goto fHLIy;
        hrJo3:
        echo '请从微信客户端打开！';
        goto KeuVi;
        RvmAS:
        $fans = $this->islogin();
        goto t85HJ;
        fHLIy:
        if (empty($uid)) {
            goto eBTA2;
        }
        goto hK1xm;
        pWFis:
        goto N5Qkv;
        goto b8ZLt;
        Il1CK:
        include $this->template('md/mdorderlist');
        goto HZaoc;
        KeuVi:
        exit;
        goto mkD4y;
        oZnO7:
        $cfg = $this->module['config'];
        goto LtqOV;
        B5eGd:
        KgGfL:
        goto SOMk6;
        b8ZLt:
        HVNse:
        goto SunwM;
        MB2k9:
        guHo2:
        goto FVaaW;
        FVaaW:
        $order = pdo_fetchall('select * from ' . tablename($this->modulename . '_mdorder') . " where weid='{$_W['uniacid']}' {$ddorwehre} and openid='{$fans['openid']}' order by id desc");
        goto pWFis;
        z8NSX:
        goto N5Qkv;
        goto MB2k9;
        QVip2:
        $fans = mc_oauth_userinfo();
        goto exZ1t;
        rNfo2:
        N5Qkv:
        goto Il1CK;
        cQHV8:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        goto qfQJj;
        oarTx:
        if ($op == 'yf') {
            goto f3zqn;
        }
        goto z8NSX;
        rcHvu:
        eBTA2:
        goto RvmAS;
        BOa3k:
        GpiOZ:
        goto cQHV8;
        exZ1t:
        if (!empty($fans['openid'])) {
            goto KhJXY;
        }
        goto hrJo3;
        GCm8K:
        f3zqn:
        goto Wxavl;
        HZaoc:
    }
    public function doMobileMdaddorder()
    {
        goto kIV9F;
        HZVFo:
        if ($tkorder['orderzt'] == '订单付款') {
            goto k5BBJ;
        }
        goto QlVW4;
        rvexH:
        die(json_encode(array("error" => 1, "msg" => '您提交的订单已经存在！' . $member['nickname'])));
        goto aeEP6;
        lBiZp:
        goto hjiuy;
        goto blAOw;
        Yy2Bt:
        $mdtype = 3;
        goto APy14;
        vmyLi:
        ito1K:
        goto iqanv;
        QlVW4:
        if ($tkorder['orderzt'] == '订单结算') {
            goto ZwRWm;
        }
        goto kg_1z;
        KAeu2:
        $order = pdo_fetch('select * from ' . tablename('tiger_newhu_mdorder') . " where weid='{$weid}' and orderid='{$orderid}'");
        goto i02c3;
        ifszv:
        if (empty($mdset['mdrensum'])) {
            goto Nq4Bv;
        }
        goto R_Kbx;
        D24XC:
        KhG_k:
        goto l2mcr;
        eT0cK:
        if ($time > $mdset['endtime']) {
            goto EMW5Y;
        }
        goto W363P;
        DrEfC:
        Aa0eg:
        goto OHwXu;
        xyMai:
        if ($time < $mdset['starttime']) {
            goto Aa0eg;
        }
        goto eT0cK;
        YPajV:
        die(json_encode(array("error" => 1, "msg" => "系统繁忙、数据有错误！")));
        goto pYrU7;
        QJu51:
        goto ito1K;
        goto DrEfC;
        W363P:
        if ($mdtime > $time) {
            goto CwG5G;
        }
        goto My2Ay;
        F7YBe:
        if (empty($myorder)) {
            goto z8KQA;
        }
        goto MmqhW;
        yz2D5:
        goto dNgGC;
        goto zWUUx;
        e0a_n:
        $sh = 0;
        goto jzpSE;
        iqanv:
        goto xA9Dh;
        goto E0R4O;
        gpSlI:
        if ($tkorder['orderzt'] == '订单失效') {
            goto KhG_k;
        }
        goto HZVFo;
        APy14:
        die(json_encode(array("error" => 0, "msg" => "免单已结束！")));
        goto n7s16;
        HS4e0:
        $myorder = pdo_fetch('select * from ' . tablename('tiger_newhu_mdorder') . " where weid='{$weid}' and createtime>'{$mytimetoday}' and uid='{$uid}'");
        goto F7YBe;
        E0R4O:
        flStb:
        goto KcE70;
        qzoEM:
        $tkorder = pdo_fetch('select * from ' . tablename('tiger_newhu_tkorder') . " where weid='{$weid}' and orderid='{$orderid}'");
        goto zQHNN;
        blAOw:
        Nq4Bv:
        goto qcUT2;
        MmqhW:
        die(json_encode(array("error" => 0, "msg" => "一天只能免单一个商品！")));
        goto tEDVG;
        EzAkI:
        goto jvzJX;
        goto Wr9Ci;
        IrjAr:
        die(json_encode(array("error" => 0, "msg" => "免单未开始！")));
        goto vmyLi;
        dlu8r:
        $mdtype = 5;
        goto sAyXA;
        I1nnP:
        goto ZVe1T;
        goto pWLRy;
        nECk9:
        goto dNgGC;
        goto AutsG;
        zQHNN:
        if (empty($tkorder)) {
            goto rlHnf;
        }
        goto gpSlI;
        gZhQp:
        $mdtype = 8;
        goto huB0c;
        pYrU7:
        eHvky:
        goto I1nnP;
        mBhpB:
        hjiuy:
        goto FPTvH;
        qJ6mI:
        Qm9Tg:
        goto KAeu2;
        tEDVG:
        z8KQA:
        goto QN0Yj;
        kUGLL:
        goto yumFp;
        goto aCew3;
        My2Ay:
        if (!($mdset['mdyaoqingcount'] >= 1)) {
            goto NSmLd;
        }
        goto Gdjhe;
        a869q:
        $timetoday = strtotime(date('Y-m-d', time()));
        goto c8g0r;
        kg_1z:
        goto dNgGC;
        goto D24XC;
        hMEDz:
        die(json_encode(array("error" => 1, "msg" => "您提交的订单已退款！")));
        goto yz2D5;
        Mfm9Y:
        if (!(empty($mdtype) && empty($sgmdtype))) {
            goto Qm9Tg;
        }
        goto IphXq;
        vEX22:
        goto eHvky;
        goto GE3VC;
        c8g0r:
        $mdyaoqing = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiger_newhu_order') . " WHERE weid='{$_W['uniacid']}' and uid='{$member['id']}' and createtime>'{$timetoday}' order by id desc ");
        goto c55x4;
        FPTvH:
        $mdtime = $member['createtime'] + $mdday;
        goto NRMwT;
        SZ7B6:
        $weid = $_W['uniacid'];
        goto t3wap;
        Gdjhe:
        $timetoday = strtotime(date('Y-m-d', time()));
        goto eTgp7;
        kStQ_:
        if (pdo_insert('tiger_newhu_mdorder', $data) === false) {
            goto biHwR;
        }
        goto a4n0J;
        qcUT2:
        $mdday = 1 * 86400;
        goto mBhpB;
        QN0Yj:
        if (empty($order)) {
            goto m1WXk;
        }
        goto qzGNA;
        oW6PW:
        nZwKY:
        goto rvexH;
        aCew3:
        CwG5G:
        goto gZhQp;
        OHwXu:
        $mdtype = 2;
        goto IrjAr;
        pQOjZ:
        $op = $_GPC['op'];
        goto IVl9E;
        Ab6uS:
        goto nZwKY;
        goto wPI58;
        UuhtS:
        if (!($mdyaoqing >= $mdset['mdyaoqingcount'])) {
            goto oyepZ;
        }
        goto dlu8r;
        LyPTV:
        NSmLd:
        goto R1jZr;
        R_Kbx:
        $mdday = $mdset['mdrensum'] * 86400;
        goto lBiZp;
        iNn3x:
        if (empty($mdset['mdtype'])) {
            goto flStb;
        }
        goto xyMai;
        omYyz:
        die(json_encode(array("error" => 0, "msg" => "今天免单不满足！")));
        goto qJ6mI;
        jzpSE:
        die(json_encode(array("error" => 1, "msg" => "您提交的订单暂未更新，请过15分钟后在提交，感谢您的支持！")));
        goto DcXeQ;
        n7s16:
        jvzJX:
        goto QJu51;
        Wr9Ci:
        EMW5Y:
        goto Yy2Bt;
        HJ1co:
        $mdset = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_miandanset') . " WHERE weid='{$_W['uniacid']}' order by id desc ");
        goto OQ2FC;
        huB0c:
        yumFp:
        goto EzAkI;
        l2mcr:
        $sh = 4;
        goto hMEDz;
        RONvy:
        VrEo_:
        goto kUGLL;
        NRMwT:
        $time = time();
        goto iNn3x;
        V7LUd:
        $sh = 1;
        goto pdUSr;
        eTgp7:
        $mdyaoqing = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiger_newhu_share') . " WHERE weid='{$_W['uniacid']}' and helpid='{$member['id']}' and createtime>'{$timetoday}' order by id desc ");
        goto UuhtS;
        qzGNA:
        die(json_encode(array("error" => 1, "msg" => "订单已经存在！")));
        goto Ab6uS;
        dM1CI:
        die(json_encode(array("error" => 0, "msg" => "会员数据错误、请稍后在试！")));
        goto zzzjy;
        a4n0J:
        die(json_encode(array("error" => 1, "msg" => "订单提交成功")));
        goto vEX22;
        AutsG:
        ZwRWm:
        goto V7LUd;
        KcE70:
        xA9Dh:
        goto Mfm9Y;
        pdUSr:
        dNgGC:
        goto Tsr66;
        Tsr66:
        $data = array("weid" => $weid, "openid" => $member['from_user'], "uid" => $member['id'], "nickname" => $member['nickname'], "avatar" => $member['avatar'], "orderid" => $orderid, "itemid" => $tkorder['numid'], "jl" => $jl, "jltype" => $jltype, "sh" => $sh, "yongjin" => $tkorder['xgyg'], "price" => $tkorder['fkprice'], "type" => 0, "createtime" => TIMESTAMP);
        goto kStQ_;
        eoCKZ:
        u8ncC:
        goto RONvy;
        t3wap:
        $orderid = $_GPC['code'];
        goto VSl7Y;
        KARfc:
        $sgmdtype = 6;
        goto eoCKZ;
        zWUUx:
        k5BBJ:
        goto rZK3S;
        IVl9E:
        $uid = $_GPC['uid'];
        goto SZ7B6;
        zzzjy:
        lZ6Ew:
        goto ifszv;
        OQ2FC:
        if (!empty($uid)) {
            goto lZ6Ew;
        }
        goto dM1CI;
        pWLRy:
        rlHnf:
        goto e0a_n;
        kIV9F:
        global $_W, $_GPC;
        goto pQOjZ;
        VSl7Y:
        $member = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_share') . " WHERE weid='{$_W['uniacid']}' and id='{$uid}'");
        goto HJ1co;
        DcXeQ:
        ZVe1T:
        goto oW6PW;
        R1jZr:
        if (!($mdset['mdzgcount'] >= 1)) {
            goto VrEo_;
        }
        goto a869q;
        wPI58:
        m1WXk:
        goto qzoEM;
        IphXq:
        $mderr = 1;
        goto omYyz;
        c55x4:
        if (!($mdyaoqing >= $mdset['mdzgcount'])) {
            goto u8ncC;
        }
        goto KARfc;
        i02c3:
        $mytimetoday = strtotime(date('Y-m-d', time()));
        goto HS4e0;
        sAyXA:
        oyepZ:
        goto LyPTV;
        GE3VC:
        biHwR:
        goto YPajV;
        rZK3S:
        $sh = 3;
        goto nECk9;
        aeEP6:
    }
    public function doMobileMd()
    {
        goto CMwin;
        Md42W:
        if (!empty($fans)) {
            goto Ch_Rl;
        }
        goto g5Sb3;
        LONcC:
        print_r($list);
        goto CqCL4;
        xJKgI:
        FylwE:
        goto k9w6R;
        Okt8d:
        $fans = $this->islogin();
        goto ugCQJ;
        Pq64P:
        $pager = pagination($total, $pindex, $psize);
        goto r2xfk;
        DqBVP:
        $mdset = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_miandanset') . " WHERE weid='{$_W['uniacid']}' order by id desc ");
        goto DPLCi;
        FhQCw:
        $mdday = $mdset['mdrensum'] * 86400;
        goto GAzQV;
        BSdZd:
        uA0CU:
        goto BE8qu;
        H3QNL:
        MNh0U:
        goto Yuvdy;
        XX7m9:
        $mdyaoqing = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiger_newhu_share') . " WHERE weid='{$_W['uniacid']}' and helpid='{$member['id']}' and createtime>'{$timetoday}' order by id desc ");
        goto EpOVB;
        RoI6V:
        if (!(empty($mdtype) && empty($sgmdtype))) {
            goto QeswQ;
        }
        goto NOcZS;
        OGCLE:
        if (!($mdyaoqing >= $mdset['mdzgcount'])) {
            goto qno1e;
        }
        goto EFdgU;
        xtIVM:
        ebjtK:
        goto N6ROt;
        RBsHf:
        ea6KE:
        goto OzpIh;
        jCvzN:
        ISSeX:
        goto LTEnQ;
        hq7hU:
        goto pfdE2;
        goto eCRH1;
        EFdgU:
        $sgmdtype = 6;
        goto pMmlP;
        QhuAh:
        if ($time < $mdset['starttime']) {
            goto O6TDo;
        }
        goto s2Kfh;
        fzmOq:
        if (!($mdset['mdyaoqingcount'] >= 1)) {
            goto AJyhD;
        }
        goto shgdH;
        B__Vw:
        $list = pdo_fetchall('select * from ' . tablename($this->modulename . '_miandangoods') . " where weid='{$_W['uniacid']}'  order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        goto lbTf3;
        GAzQV:
        goto umxMD;
        goto lbeoN;
        Rs_14:
        oiX1c:
        goto VDZXl;
        uE3Jo:
        $member = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$uid}'");
        goto hq7hU;
        eCRH1:
        qWHFr:
        goto Okt8d;
        Nz5TJ:
        $pindex = max(1, intval($_GPC['page']));
        goto cwYIE;
        BE8qu:
        goto gnS41;
        goto pZi34;
        VDZXl:
        $member = $this->getmember($fans, $mc['uid']);
        goto qDBSW;
        s2Kfh:
        if ($time > $mdset['endtime']) {
            goto MNh0U;
        }
        goto Zk54K;
        c0wPA:
        $mdtype = 5;
        goto IhniY;
        qDBSW:
        pfdE2:
        goto f_Wy0;
        XPEyf:
        EN6CY:
        goto RoI6V;
        UKKeq:
        if (empty($mdset['mdtype'])) {
            goto FylwE;
        }
        goto QhuAh;
        NaUdl:
        $time = time();
        goto UKKeq;
        PaIEl:
        if (empty($uid)) {
            goto qWHFr;
        }
        goto uE3Jo;
        caJCe:
        include $this->template('md/index');
        goto DpZh1;
        kgbxB:
        $timetoday = strtotime(date('Y-m-d', time()));
        goto VbcM2;
        Yuvdy:
        $mdtype = 3;
        goto BSdZd;
        ugCQJ:
        if (!empty($fans['tkuid'])) {
            goto oiX1c;
        }
        goto DMwz8;
        sUpT5:
        LlPB7:
        goto caJCe;
        shgdH:
        $timetoday = strtotime(date('Y-m-d', time()));
        goto XX7m9;
        lbTf3:
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->modulename . '_miandangoods') . " where weid='{$_W['uniacid']}'");
        goto Pq64P;
        DPLCi:
        $cfg = $this->module['config'];
        goto eiEXG;
        pZi34:
        O6TDo:
        goto Wlvja;
        Wlvja:
        $mdtype = 2;
        goto Lat29;
        eiEXG:
        $uid = $_GPC['uid'];
        goto PaIEl;
        Lat29:
        gnS41:
        goto nGV9f;
        VbcM2:
        $mdyaoqing = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiger_newhu_order') . " WHERE weid='{$_W['uniacid']}' and uid='{$member['id']}' and createtime>'{$timetoday}' order by id desc ");
        goto OGCLE;
        pMmlP:
        qno1e:
        goto jCvzN;
        k9w6R:
        $mdtype = 1;
        goto XPEyf;
        t1Gh9:
        $mdday = 1 * 86400;
        goto noynr;
        eW5OM:
        $op = $_GPC['op'];
        goto DqBVP;
        lbeoN:
        qvDYa:
        goto t1Gh9;
        CqCL4:
        exit;
        goto sUpT5;
        Di9lz:
        if (!($mdset['mdzgcount'] >= 1)) {
            goto ISSeX;
        }
        goto kgbxB;
        r2xfk:
        exit(json_encode(array("pages" => $pager, "data" => $list, "lm" => 1)));
        goto ldXDW;
        x1DmA:
        exit;
        goto dVhT8;
        IhniY:
        XgEmp:
        goto qqqFY;
        f_Wy0:
        if (empty($mdset['mdrensum'])) {
            goto qvDYa;
        }
        goto FhQCw;
        nGV9f:
        goto EN6CY;
        goto xJKgI;
        g5Sb3:
        $loginurl = $_W['siteroot'] . str_replace('./', 'app/', $this->createMobileurl('login')) . '&m=tiger_newhu' . '&tzurl=' . urlencode($tktzurl);
        goto KXjhE;
        ldXDW:
        echo '<pre>';
        goto LONcC;
        dra0u:
        QeswQ:
        goto wmVgU;
        N6ROt:
        $mdtype = 8;
        goto RBsHf;
        wmVgU:
        if (!($op == 1)) {
            goto LlPB7;
        }
        goto Nz5TJ;
        PbMHA:
        $mdtime = $member['createtime'] + $mdday;
        goto NaUdl;
        NOcZS:
        $mderr = 1;
        goto dra0u;
        DMwz8:
        $fans = mc_oauth_userinfo();
        goto Md42W;
        OzpIh:
        goto uA0CU;
        goto H3QNL;
        Zk54K:
        if ($mdtime > $time) {
            goto ebjtK;
        }
        goto fzmOq;
        qqqFY:
        AJyhD:
        goto Di9lz;
        CMwin:
        global $_W, $_GPC;
        goto eW5OM;
        EpOVB:
        if (!($mdyaoqing >= $mdset['mdyaoqingcount'])) {
            goto XgEmp;
        }
        goto c0wPA;
        LTEnQ:
        goto ea6KE;
        goto xtIVM;
        KXjhE:
        header('Location: ' . $loginurl);
        goto x1DmA;
        dVhT8:
        Ch_Rl:
        goto Rs_14;
        noynr:
        umxMD:
        goto PbMHA;
        cwYIE:
        $psize = 20;
        goto B__Vw;
        DpZh1:
    }
    public function doMobileMdadd()
    {
        goto At_3J;
        QSVf_:
        if (!empty($fans)) {
            goto CsXWd;
        }
        goto Lcn6F;
        aYiyV:
        $member = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$uid}'");
        goto DBk1I;
        W3cFj:
        exit;
        goto sc8R_;
        Lcn6F:
        $loginurl = $_W['siteroot'] . str_replace('./', 'app/', $this->createMobileurl('login')) . '&m=tiger_newhu' . '&tzurl=' . urlencode($tktzurl);
        goto emZBr;
        S50Nl:
        B6rSH:
        goto Fs142;
        ncE78:
        if (!empty($fans['tkuid'])) {
            goto B6rSH;
        }
        goto tYnEF;
        C1C6N:
        $mdset = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_miandanset') . " WHERE weid='{$_W['uniacid']}' order by id desc ");
        goto M7_bp;
        DBk1I:
        goto SBT2_;
        goto cAxGV;
        sc8R_:
        CsXWd:
        goto S50Nl;
        cAxGV:
        qpDUJ:
        goto zmONo;
        tYnEF:
        $fans = mc_oauth_userinfo();
        goto QSVf_;
        At_3J:
        global $_W, $_GPC;
        goto C1C6N;
        FvgZs:
        SBT2_:
        goto q1At6;
        GRinA:
        if (empty($uid)) {
            goto qpDUJ;
        }
        goto aYiyV;
        emZBr:
        header('Location: ' . $loginurl);
        goto W3cFj;
        q1At6:
        include $this->template('md/mdadd');
        goto Q3uaX;
        zmONo:
        $fans = $this->islogin();
        goto ncE78;
        M7_bp:
        $uid = $_GPC['uid'];
        goto GRinA;
        Fs142:
        $member = $this->getmember($fans, $mc['uid']);
        goto FvgZs;
        Q3uaX:
    }
    public function doMobileTaolijin()
    {
        goto DTWH0;
        IDJRJ:
        $req = new TbkDgVegasTljCreateRequest();
        goto wXYnx;
        PcCGY:
        $req->setUserTotalWinNumLimit('1');
        goto nr1gS;
        dOo9u:
        $req->setItemId('584558401295');
        goto k6nIP;
        gT9Vd:
        $resp = $c->execute($req);
        goto AdYsu;
        bPquR:
        echo '<pre>';
        goto b54w7;
        xjf5V:
        $req->setName('淘礼金来啦');
        goto PcCGY;
        DTWH0:
        $cfg = $this->module['config'];
        goto tj_oY;
        k6nIP:
        $req->setTotalNum('1');
        goto xjf5V;
        wXYnx:
        $req->setAdzoneId('110806711');
        goto dOo9u;
        SbFM3:
        $req->setPerFace('10');
        goto VYsz5;
        tj_oY:
        $appkey = $cfg['tkAppKey'];
        goto VXYFE;
        b54w7:
        print_r($resp);
        goto It3KX;
        VYsz5:
        $req->setSendStartTime('2019-06-20 00:00:00');
        goto D0zlq;
        AdYsu:
        $resp = json_decode(json_encode($resp), TRUE);
        goto a2r_y;
        nr1gS:
        $req->setSecuritySwitch('false');
        goto SbFM3;
        Duw4m:
        $req->setUseEndTimeMode('1');
        goto AS2ZN;
        VXYFE:
        $secret = $cfg['tksecretKey'];
        goto pBCT3;
        It3KX:
        exit;
        goto IvgmX;
        AS2ZN:
        $req->setUseStartTime('2019-06-20');
        goto gT9Vd;
        LXzlv:
        $req->setUseEndTime('1');
        goto Duw4m;
        SkyQE:
        $c->appkey = $appkey;
        goto PwPIU;
        D0zlq:
        $req->setSendEndTime('2019-06-11 00:00:00');
        goto LXzlv;
        a2r_y:
        echo $resp['result']['msg_info'];
        goto bPquR;
        PwPIU:
        $c->secretKey = $secret;
        goto IDJRJ;
        pBCT3:
        $c = new TopClient();
        goto SkyQE;
        IvgmX:
    }
    public function doMobileWnqtzgoods()
    {
        goto I1MM7;
        RXNOZ:
        $qtzcate = explode('|', $qtz['cate']);
        goto xEZm7;
        CUfZr:
        goto O3_f5;
        goto lEKKI;
        xS_Vt:
        YR306:
        goto NCX3D;
        NCX3D:
        if (!empty($page)) {
            goto pag6x;
        }
        goto NNj0h;
        p2xgT:
        TefRO:
        goto RXNOZ;
        UW0e6:
        O3_f5:
        goto OGcp0;
        JmtTs:
        ZSm2N:
        goto M01ql;
        czar8:
        include $this->template('zt/wnqtzgoods');
        goto xFSFN;
        ufIXB:
        $op = $_GPC['op'];
        goto LtiVq;
        RTDj8:
        $page = $page + 1;
        goto MIlik;
        NNj0h:
        $page = 0;
        goto xjrzw;
        ehjHa:
        $islm = $this->getlmid($MaterialId);
        goto GWohE;
        xjrzw:
        pag6x:
        goto LjkTt;
        EzK2m:
        $MaterialId = 7950;
        goto xS_Vt;
        OGcp0:
        exit(json_encode(array("pages" => "", "data" => $goodslist, "lm" => 2)));
        goto UCvWM;
        M01ql:
        $page = $_GPC['page'];
        goto ufIXB;
        KJ2Gq:
        if (!empty($MaterialId)) {
            goto TefRO;
        }
        goto nDZPa;
        MIlik:
        goto PkRAE;
        goto FCHlB;
        LtiVq:
        if (!($op == 'toajax')) {
            goto ltBIJ;
        }
        goto ehjHa;
        nDZPa:
        $MaterialId = $qtz['cateid'];
        goto p2xgT;
        i1G3Q:
        $MaterialId = trim($_GPC['MaterialId']);
        goto SGJpU;
        WpI0j:
        $goodslist = $this->tbqtz($page, $MaterialId);
        goto CUfZr;
        I1MM7:
        global $_W, $_GPC;
        goto biZYj;
        ybQon:
        PkRAE:
        goto WpI0j;
        Zq5jx:
        $page = 1;
        goto ybQon;
        oqtV_:
        foreach ($qtzcate as $k => $v) {
            $catlist[$k] = explode('-', $v);
            H9I9n:
        }
        goto JmtTs;
        LjkTt:
        $goodslist = $this->tblmnewgoods($page, $MaterialId);
        goto UW0e6;
        O3Mtq:
        $tigerapp = $_GPC['tigerapp'];
        goto i1G3Q;
        i3UXg:
        if (empty($page)) {
            goto DnPa7;
        }
        goto RTDj8;
        z35DY:
        if (!($MaterialId == 1)) {
            goto YR306;
        }
        goto EzK2m;
        SGJpU:
        $qtz = pdo_fetch('select * from ' . tablename('tiger_newhu_qtzlist') . " where weid='{$_W['uniacid']}' and id='{$id}'");
        goto KJ2Gq;
        lEKKI:
        i2DeB:
        goto z35DY;
        FCHlB:
        DnPa7:
        goto Zq5jx;
        biZYj:
        $id = trim($_GPC['id']);
        goto O3Mtq;
        xEZm7:
        $catlist = array();
        goto oqtV_;
        UCvWM:
        ltBIJ:
        goto czar8;
        GWohE:
        if ($islm == 1) {
            goto i2DeB;
        }
        goto i3UXg;
        xFSFN:
    }
    function getlmid($lmid)
    {
        goto dQYPV;
        jC9Py:
        return 1;
        goto NegEA;
        Z9UAJ:
        return 2;
        goto uYKBk;
        dQYPV:
        $arr = array("19541", "19543", "19540", "19539", "19542", "19579", "19728", "19727", "19719", "19718", "19646", "19705", "19703", "19623", "18493", "19701", "19625", "18845", "18847", "11830", "11842", "7951", "7950", "16697", "16335", "15444", "18935", "18934", "18933", "18931", "18930", "1", "7950", "18620", "18621", "18622", "18623", "18625", "18626", "18627", "18634", "18635", "18636", "18637", "18577", "18578", "18579", "18580", "18581", "18582", "18583", "18584", "18585", "18586", "18587", "18591", "18592", "18593", "18594", "18595", "18596", "18597", "18598", "18599", "18600", "18601", "18628", "18629", "18630", "18631", "18632", "18914", "18906", "18903", "18909", "18910", "18912", "18968", "18969", "18970", "18971", "18976", "18620", "18621", "18622", "18623", "18625", "18626", "18627", "18634", "18635", "18636", "18637", "16217", "15895", "15893", "15896", "15897", "15898", "15899", "15900", "15903", "15902", "15901", "18222", "13671", "13865", "13851", "13852", "13858", "13855", "13854", "13856", "13853", "13857", "13859", "13968", "17122", "14971", "14976", "17359", "11049");
        goto dIgir;
        pwts5:
        lhz0q:
        goto Z9UAJ;
        uYKBk:
        LnX7D:
        goto tfTMo;
        dIgir:
        if (!in_array($lmid, $arr)) {
            goto lhz0q;
        }
        goto jC9Py;
        NegEA:
        goto LnX7D;
        goto pwts5;
        tfTMo:
    }
    public function tbqtz($page, $MaterialId)
    {
        goto KTaPx;
        FFnsc:
        $goods = qtz($tksign['sign'], $cfg['ptpid'], $MaterialId, $page);
        goto Lee1P;
        VzCDh:
        return $list;
        goto H0ROT;
        RuUY2:
        $tksign = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_tksign') . " WHERE  tbuid='{$cfg['tbuid']}'");
        goto L2PWq;
        SmfNi:
        kjG_e:
        goto RuUY2;
        KTaPx:
        global $_W, $_GPC;
        goto UZzmc;
        VM_x0:
        $pidSplit = explode('_', $cfg['ptpid']);
        goto MWHta;
        L2PWq:
        AghqY:
        goto FFnsc;
        WmAt8:
        goto AghqY;
        goto SmfNi;
        f79ci:
        TOqVa:
        goto VzCDh;
        GgTmv:
        $tksign = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_tksign') . " WHERE  memberid='{$memberid}'");
        goto WmAt8;
        MWHta:
        $memberid = $pidSplit[1];
        goto vr7I7;
        vr7I7:
        if (empty($memberid)) {
            goto kjG_e;
        }
        goto GgTmv;
        UZzmc:
        include IA_ROOT . '/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php';
        goto btnWT;
        btnWT:
        $cfg = $this->module['config'];
        goto VM_x0;
        Lee1P:
        foreach ($goods['result_list']['map_data'] as $k => $v) {
            goto n19WV;
            P352B:
            hrgyj:
            goto X0oj5;
            J7JjS:
            $list[$k]['shoptype'] = $goods['user_type'];
            goto xF0Ll;
            tkXWW:
            A1CD3:
            goto rDgJy;
            JPm3M:
            IRoji:
            goto L00y7;
            Zi499:
            L5PJK:
            goto MuvUB;
            bAfj_:
            SMms0:
            goto h8MIi;
            Ev6CI:
            $sj = '升级赚:' . $sj;
            goto P352B;
            Niz0a:
            $list[$k]['itemtitle'] = $goods['title'];
            goto J7JjS;
            qjwSK:
            $list[$k]['yj'] = '预估赚:' . $ratea;
            goto q9lXz;
            w93Et:
            if (empty($ratea)) {
                goto IwRDK;
            }
            goto yRW9F;
            jIHMX:
            $list[$k]['click_url'] = $goods['click_url'];
            goto VW6zJ;
            cXu2D:
            $list[$k]['itemsale'] = $goods['volume'];
            goto jIHMX;
            fzZZQ:
            $appcfg = pdo_fetch('select * from ' . tablename('tiger_newhu_appset') . " where weid='{$_W['uniacid']}'");
            goto M3g4I;
            MuvUB:
            $itemendprice = $goods['zk_final_price'] - $conmany;
            goto vKcHp;
            VW6zJ:
            $list[$k]['coupon_click_url'] = $goods['coupon_click_url'];
            goto eZOBH;
            X0oj5:
            goto AIW6G;
            goto TCzF4;
            M3g4I:
            if ($appcfg['sjztype'] == 1) {
                goto SMms0;
            }
            goto oguy3;
            eZOBH:
            $list[$k]['shopTitle'] = $goods['shop_title'];
            goto sKzxu;
            n19WV:
            $goods = $v;
            goto bzffz;
            oguy3:
            $sj = 0;
            goto zxc2Q;
            h8MIi:
            $sj = $ratea * $appset['jl'] / 100 + $ratea;
            goto GXkjy;
            yRW9F:
            $appset = pdo_fetch('SELECT * FROM ' . tablename('tiger_app_tuanzhangset') . " WHERE weid='{$_W['uniacid']}' order by px desc ");
            goto fzZZQ;
            PK1cf:
            $conmany = 0;
            goto yv66E;
            KwxeT:
            goto wWsLs;
            goto JPm3M;
            jk0kt:
            $list[$k]['itemendprice'] = $itemendprice;
            goto kS3lH;
            ZXw_p:
            b20Fv:
            goto ubyRt;
            kS3lH:
            $list[$k]['couponmoney'] = $conmany;
            goto cXu2D;
            dRKrf:
            $list[$k]['itemprice'] = $goods['zk_final_price'];
            goto jk0kt;
            L00y7:
            $ratea = $this->ptyjjl($itemendprice, $goods['commission_rate'], $cfg);
            goto B3MyG;
            sKzxu:
            $list[$k]['itempic'] = $goods['pict_url'];
            goto SEPp_;
            q9lXz:
            $list[$k]['sj'] = $sj;
            goto aQ6e2;
            ANXmk:
            $list[$k]['couponnum'] = $goods['coupon_remain_count'];
            goto tkXWW;
            GXkjy:
            $sj = number_format($sj, 2, '.', '');
            goto Ev6CI;
            U2UJQ:
            $ratea = $this->sharejl($itemendprice, $goods['commission_rate'], $bl, $share, $cfg);
            goto KwxeT;
            B3MyG:
            wWsLs:
            goto w93Et;
            jDL4S:
            $list[$k]['commission_rate'] = $goods['commission_rate'];
            goto rZ6zM;
            vKcHp:
            $status = 1;
            goto Niz0a;
            SEPp_:
            $list[$k]['pid'] = $pid;
            goto o_KE1;
            rZ6zM:
            if ($cfg['lbratetype'] == 3) {
                goto IRoji;
            }
            goto U2UJQ;
            o_KE1:
            $list[$k]['lm'] = 1;
            goto jDL4S;
            F3tx_:
            AIW6G:
            goto qjwSK;
            zxc2Q:
            goto hrgyj;
            goto bAfj_;
            aQ6e2:
            $list[$k]['rate'] = $ratea;
            goto ANXmk;
            bzffz:
            if (!empty($goods['coupon_amount'])) {
                goto b20Fv;
            }
            goto PK1cf;
            TCzF4:
            IwRDK:
            goto ZIJ_1;
            ZIJ_1:
            $sj = '0';
            goto F3tx_;
            ubyRt:
            $conmany = $goods['coupon_amount'];
            goto Zi499;
            xF0Ll:
            $list[$k]['itemid'] = $goods['item_id'];
            goto dRKrf;
            yv66E:
            goto L5PJK;
            goto ZXw_p;
            rDgJy:
        }
        goto f79ci;
        H0ROT:
    }
    public function tblmnewgoods($page, $hdid)
    {
        goto UpmIO;
        AMlT8:
        return $list;
        goto SP8fe;
        kEPGI:
        $cfg = $this->module['config'];
        goto pZhY_;
        k2fb4:
        $list = array();
        goto aTSav;
        Iu3vI:
        print_r($list);
        goto HNmYo;
        SP8fe:
        echo '<pre>';
        goto Iu3vI;
        V_2Zc:
        r8pwT:
        goto AMlT8;
        sbRpd:
        $page = 0;
        goto VM2X4;
        pZhY_:
        $bl = pdo_fetch('select * from ' . tablename('tiger_wxdaili_set') . " where weid='{$_W['uniacid']}'");
        goto e0IkW;
        aTSav:
        foreach ($data['resultList'] as $k => $v) {
            goto PAmUs;
            ldyck:
            $istm = 0;
            goto v8UT2;
            kpRjx:
            $ratea = $this->sharejl($itemendprice, $tkrates, $bl, $share, $cfg);
            goto BmGbX;
            q_2__:
            if ($appcfg['sjztype'] == 1) {
                goto c4Lqy;
            }
            goto wVdD2;
            H2Wva:
            if (empty($ratea)) {
                goto IPcPc;
            }
            goto DLjN6;
            xXQRs:
            x8haz:
            goto zrtQL;
            BmGbX:
            goto skky8;
            goto xXQRs;
            Ej7N8:
            $list[$k]['itemtitle'] = $v['itemName'];
            goto cOMwX;
            DLjN6:
            $appset = pdo_fetch('SELECT * FROM ' . tablename('tiger_app_tuanzhangset') . " WHERE weid='{$_W['uniacid']}' order by px desc ");
            goto df3lf;
            bJ6nM:
            J21Aj:
            goto V1FzD;
            uTTA9:
            if (empty($v['tkMktRate'])) {
                goto vmd9o;
            }
            goto iOpT_;
            u_Btm:
            $list[$k]['itemsale'] = $v['monthSellCount'];
            goto XCrLE;
            WJH4f:
            AUQLD:
            goto YSvtj;
            zuq3h:
            tIPnF:
            goto SAJhD;
            WxnQV:
            $sj = number_format($sj, 2, '.', '');
            goto bS_fd;
            Au2Uf:
            $list[$k]['lm'] = 1;
            goto P4Vn5;
            iOpT_:
            $tkrates = $v['tkMktRate'] / 100;
            goto b7wHb;
            YIXuu:
            $list[$k]['rate'] = $ratea;
            goto ik3sF;
            PAmUs:
            $itemendprice = $v['promotionPrice'] - $v['couponAmount'];
            goto uTTA9;
            IN1I0:
            if (empty($v['userType'])) {
                goto ctjDF;
            }
            goto y3Bq5;
            CqgOp:
            uvhK2:
            goto gVbmc;
            iHmXZ:
            $list[$k]['pid'] = $pid;
            goto Au2Uf;
            tOrpY:
            $list[$k]['itempic'] = 'http:' . $v['pic'];
            goto iHmXZ;
            C3vEF:
            goto AUQLD;
            goto sY0aW;
            kMWTt:
            $list[$k]['itemid'] = $v['itemId'];
            goto qrHWS;
            eET2b:
            if ($v['isTmall'] == true) {
                goto uvhK2;
            }
            goto ldyck;
            WFg24:
            $tkrates = $v['calTkRate'] / 100;
            goto gB1ZX;
            NdHXB:
            $list[$k]['itemendprice'] = $itemendprice;
            goto qYeWl;
            NAamt:
            $sj = '0';
            goto dPdRj;
            K647R:
            $list[$k]['shopTitle'] = $v['sellerNickName'];
            goto tOrpY;
            dPdRj:
            zRvWs:
            goto IN1I0;
            hhJi_:
            skky8:
            goto H2Wva;
            XCrLE:
            $list[$k]['url'] = $v['url'];
            goto K647R;
            cOMwX:
            $list[$k]['shoptype'] = $istm;
            goto kMWTt;
            YSvtj:
            goto zRvWs;
            goto UHK6U;
            m5PwC:
            ctjDF:
            goto eET2b;
            BoXkK:
            vmd9o:
            goto WFg24;
            qYeWl:
            $list[$k]['couponmoney'] = $v['couponAmount'];
            goto u_Btm;
            sY0aW:
            c4Lqy:
            goto bWmPx;
            wVdD2:
            $sj = 0;
            goto C3vEF;
            gVbmc:
            $istm = 1;
            goto bJ6nM;
            y3Bq5:
            $istm = $v['userType'];
            goto WQT8l;
            b7wHb:
            goto BJ0i5;
            goto BoXkK;
            P4Vn5:
            $list[$k]['couponnum'] = $v['couponsurplus'];
            goto zuq3h;
            ik3sF:
            $list[$k]['yj'] = '预估赚:' . $ratea;
            goto zmUFk;
            v8UT2:
            goto J21Aj;
            goto CqgOp;
            df3lf:
            $appcfg = pdo_fetch('select * from ' . tablename('tiger_newhu_appset') . " where weid='{$_W['uniacid']}'");
            goto q_2__;
            WQT8l:
            goto Ra8hT;
            goto m5PwC;
            zrtQL:
            $ratea = $this->ptyjjl($itemendprice, $tkrates, $cfg);
            goto hhJi_;
            bS_fd:
            $sj = '升级赚:' . $sj;
            goto WJH4f;
            V1FzD:
            Ra8hT:
            goto YIXuu;
            qrHWS:
            $list[$k]['itemprice'] = $v['promotionPrice'];
            goto NdHXB;
            gB1ZX:
            BJ0i5:
            goto nzgWJ;
            nzgWJ:
            if ($cfg['lbratetype'] == 3) {
                goto x8haz;
            }
            goto kpRjx;
            bWmPx:
            $sj = $ratea * $appset['jl'] / 100 + $ratea;
            goto WxnQV;
            UHK6U:
            IPcPc:
            goto NAamt;
            zmUFk:
            $list[$k]['sj'] = $sj;
            goto Ej7N8;
            SAJhD:
        }
        goto V_2Zc;
        UpmIO:
        global $_W, $_GPC;
        goto kEPGI;
        bU6gJ:
        $data = array("pNum" => $page, "pSize" => 15, "floorId" => $hdid, "refpid" => $cfg['ptpid']);
        goto Qz0P0;
        VM2X4:
        afXxG:
        goto bU6gJ;
        Qz0P0:
        $data = $this->tblmres($data);
        goto k2fb4;
        e0IkW:
        if (!empty($page)) {
            goto afXxG;
        }
        goto sbRpd;
        HNmYo:
    }
    public function doMobileCs6()
    {
        goto ZhRyh;
        xZgWB:
        $jsondata = str_replace(')', '', $jsondata);
        goto eIZWG;
        sLwmI:
        $_m_h5_tk = $this->qudaimapianduan($json['cookie'], '_m_h5_tk=', '_');
        goto gOG84;
        zbGc8:
        return $dataarr['data']['recommend'];
        goto DWQJf;
        RjWG5:
        $appkey = '12574478';
        goto mMeBa;
        nEnAZ:
        $json = $this->curl_request($url, '', $cookies, 1);
        goto sLwmI;
        NO9zp:
        $jsondata = str_replace('mtopjsonp1(', '', $json);
        goto xZgWB;
        gOG84:
        $singjson = $_m_h5_tk . '&' . $t . '&' . $appkey . '&' . $jsondata;
        goto B82Wu;
        TKMrm:
        $jsondata = json_encode($data);
        goto FMjTx;
        B82Wu:
        $sign = md5($singjson);
        goto XKSWL;
        mMeBa:
        $t = '0';
        goto TKMrm;
        Yidr4:
        $json = $this->curl_request($url, '', $json['cookie'], 0);
        goto WPcwp;
        ZhRyh:
        $data = array("pSize" => 3, "refpid" => "mm_30925699_86000271_15983150226", "count" => 200, "appPvid" => "a2e0r.12997699_1560735681303_8920814488387201_URF+F", "spm" => "a2e0r.12997699.19439177", "ctm" => "spm-url:a313p.22.5j.1042183779612", "floorId" => "18847", "pNum" => 0);
        goto RjWG5;
        eIZWG:
        $dataarr = @json_decode($jsondata, true);
        goto zbGc8;
        WPcwp:
        print_r($json);
        goto NO9zp;
        xF7eH:
        $url = 'https://acs.m.taobao.com/h5/mtop.alimama.union.xt.en.api.entry/1.0/?jsv=2.4.16&appKey=' . $appkey;
        goto nEnAZ;
        XKSWL:
        $url = 'https://acs.m.taobao.com/h5/mtop.alimama.union.xt.en.api.entry/1.0/?jsv=2.4.16&appKey=' . $appkey . '&t=' . $t . '&sign=' . $sign . '&api=mtop.alimama.union.xt.en.api.entry&v=1.0&AntiCreep=true&type=jsonp&dataType=jsonp&callback=mtopjsonp1&data=' . urlencode($jsondata);
        goto Yidr4;
        FMjTx:
        $jsondata = str_replace('\\/', '/', $jsondata);
        goto xF7eH;
        DWQJf:
    }
    public function tblmres($data)
    {
        goto Mld4H;
        OcgFC:
        $dataarr = @json_decode($jsondata, true);
        goto e2iiD;
        jJHqH:
        $json = $this->curl_request($url, '', $cookies, 1);
        goto IBa24;
        Mld4H:
        $appkey = '12574478';
        goto b08FF;
        h6FW6:
        $jsondata = str_replace(')', '', $jsondata);
        goto OcgFC;
        l9JZ5:
        $singjson = $_m_h5_tk . '&' . $t . '&' . $appkey . '&' . $jsondata;
        goto RURUw;
        e2iiD:
        return $dataarr['data']['recommend'];
        goto r23Ov;
        lyAPQ:
        $url = 'https://acs.m.taobao.com/h5/mtop.alimama.union.xt.en.api.entry/1.0/?jsv=2.4.16&appKey=' . $appkey . '&t=' . $t . '&sign=' . $sign . '&api=mtop.alimama.union.xt.en.api.entry&v=1.0&AntiCreep=true&type=jsonp&dataType=jsonp&callback=mtopjsonp1&data=' . urlencode($jsondata);
        goto GqOY3;
        dkaYi:
        $url = 'https://acs.m.taobao.com/h5/mtop.alimama.union.xt.en.api.entry/1.0/?jsv=2.4.16&appKey=' . $appkey;
        goto jJHqH;
        b08FF:
        $t = '0';
        goto txFsd;
        txFsd:
        $jsondata = json_encode($data);
        goto Lk7ap;
        IBa24:
        $_m_h5_tk = $this->qudaimapianduan($json['cookie'], '_m_h5_tk=', '_');
        goto l9JZ5;
        S2Duj:
        $jsondata = str_replace('mtopjsonp1(', '', $json);
        goto h6FW6;
        RURUw:
        $sign = md5($singjson);
        goto lyAPQ;
        Lk7ap:
        $jsondata = str_replace('\\/', '/', $jsondata);
        goto dkaYi;
        GqOY3:
        $json = $this->curl_request($url, '', $json['cookie'], 0);
        goto S2Duj;
        r23Ov:
    }
    public function doMobileCs4()
    {
        goto NEKlA;
        awaPs:
        $data = $this->tbviewimg($data);
        goto Km5kC;
        TFnWE:
        print_r($data);
        goto aqZfJ;
        NEKlA:
        $data = array("id" => "19673324092", "type" => "1");
        goto KD3uN;
        aqZfJ:
        exit;
        goto cknqC;
        Km5kC:
        echo '<pre>';
        goto TFnWE;
        reWhE:
        echo $this->getMillisecond();
        goto awaPs;
        KD3uN:
        echo 11;
        goto reWhE;
        cknqC:
    }
    public function getMillisecond()
    {
        goto sxBu4;
        nzlXn:
        return $t;
        goto jjBFi;
        FCRYA:
        $ran = rand(100, 300);
        goto oZJ16;
        sxBu4:
        $time = time();
        goto FCRYA;
        oZJ16:
        $t = $time . $ran;
        goto nzlXn;
        jjBFi:
    }
    public function tbviewimg($data)
    {
        goto lFXMd;
        QilYY:
        $descstr = $dataarr['data']['pcDescContent'];
        goto SwPnM;
        pnFt0:
        $json = $this->curl_request($url, '', $cookies, 1);
        goto v4MHm;
        Rff99:
        $sign = md5($singjson);
        goto u80HD;
        vFGr5:
        return $dataarr;
        goto QilYY;
        ROcrA:
        $jsondata = str_replace('\\/', '/', $jsondata);
        goto U1qdP;
        ag3z4:
        $jsondata = json_encode($data);
        goto ROcrA;
        qHS1Z:
        $singjson = $_m_h5_tk . '&' . $t . '&' . $appkey . '&' . $jsondata;
        goto Rff99;
        le0hT:
        $dataarr = @json_decode($jsondata, true);
        goto vFGr5;
        SwPnM:
        preg_match_all('<img[\\s\\S]*?src="([\\s\\S]*?)"[\\s\\S]*?>', $descstr, $descarr);
        goto Na2Xr;
        Na2Xr:
        foreach ($descarr[1] as $k => $v) {
            goto kgWxq;
            uDKn0:
            l4BeV:
            goto ZlALx;
            kgWxq:
            $img .= '<img src=\'' . $v . '\'/>';
            goto KQOz0;
            KQOz0:
            $xcximg[$k] = $v;
            goto uDKn0;
            ZlALx:
        }
        goto rTsV1;
        qz3Nn:
        $jsondata = str_replace('mtopjsonp1(', '', $json);
        goto E0JSx;
        U1qdP:
        $url = 'https://h5api.m.taobao.com/h5/mtop.taobao.detail.getdesc/6.0/?jsv=2.4.0&appKey=' . $appkey;
        goto pnFt0;
        ziRPE:
        $t = $this->getMillisecond();
        goto ag3z4;
        iqxRL:
        return $img;
        goto xDcxT;
        E0JSx:
        $jsondata = str_replace(')', '', $jsondata);
        goto le0hT;
        B04I3:
        $json = $this->curl_request($url, '', $json['cookie'], 0);
        goto qz3Nn;
        u80HD:
        $url = 'https://h5api.m.taobao.com/h5/mtop.taobao.detail.getdesc/6.0/?jsv=2.4.0&appKey=' . $appkey . '&t=' . $t . '&sign=' . $sign . '&api=mtop.taobao.detail.getdesc&v=6.0&AntiFlool=true&AntiCreep=true&type=jsonp&dataType=jsonp&callback=mtopjsonp1&data=' . urlencode($jsondata);
        goto B04I3;
        v4MHm:
        $_m_h5_tk = $this->qudaimapianduan($json['cookie'], '_m_h5_tk=', '_');
        goto qHS1Z;
        rTsV1:
        jtw0v:
        goto iqxRL;
        lFXMd:
        $appkey = '12574478';
        goto ziRPE;
        xDcxT:
    }
    function qudaimapianduan($ss, $qian, $hou)
    {
        goto Lny7n;
        Lny7n:
        $i = strpos($ss, $qian);
        goto fjhQu;
        XGZG7:
        return $output;
        goto fqFHZ;
        QCyzm:
        $i = strpos($output, $hou);
        goto Jfg33;
        fjhQu:
        $output = substr($ss, $i + strlen($qian), strlen($ss));
        goto QCyzm;
        Jfg33:
        $output = substr($output, 0, $i);
        goto XGZG7;
        fqFHZ:
    }
    public function jd1fgoufl()
    {
        goto Gef4m;
        lkHAG:
        $hjkview = $this->curl_request($hjkurl, $hjkpost);
        goto Ao7BD;
        DxTjD:
        $hjkpost = array("hdid" => 3);
        goto lkHAG;
        Gef4m:
        $hjkurl = 'https://api.91fyt.com/index.php/api/v1/hd/hdgoodscname';
        goto DxTjD;
        iV1mt:
        return $hjkarr;
        goto uqjyD;
        Ao7BD:
        $hjkarr = @json_decode($hjkview, true);
        goto iV1mt;
        uqjyD:
    }
    public function jd1fgougoodlist($page, $cid)
    {
        goto uNpwo;
        uNpwo:
        $hjkurl = 'https://api.91fyt.com/index.php/api/v1/hd/hdgoodslist';
        goto aXkMF;
        aXkMF:
        $hjkpost = array("hdid" => 3, "pagesize" => 10, "pageindex" => $page, "cid" => $cid);
        goto H7yLa;
        oajJJ:
        $hjkarr = @json_decode($hjkview, true);
        goto Lm_hd;
        H7yLa:
        $hjkview = $this->curl_request($hjkurl, $hjkpost);
        goto oajJJ;
        Lm_hd:
        return $hjkarr;
        goto ABha8;
        ABha8:
    }
    public function jd1fgougoodurl($goods_id, $subunionid)
    {
        goto JuDiK;
        wQBpk:
        $hjkview = $this->curl_request($hjkurl, $hjkpost);
        goto VUtbW;
        JuDiK:
        $hjkurl = 'https://api.91fyt.com/index.php/api/v1/hd/hdgetunionurlapi';
        goto htYaW;
        htYaW:
        $hjkpost = array("memberid" => 1014414, "hdid" => 3, "goods_id" => $goods_id, "subunionid" => $subunionid);
        goto wQBpk;
        jUXis:
        return $hjkarr;
        goto b5fsh;
        VUtbW:
        $hjkarr = @json_decode($hjkview, true);
        goto jUXis;
        b5fsh:
    }
    public function jd1fgorder($subunionid = "", $page = 1)
    {
        goto ne3vI;
        xI6w3:
        $hjkpost = array("memberid" => 1014414, "hdid" => 3, "pageindex" => $page, "pagesize" => 50, "subunionid" => $subunionid);
        goto NkHcS;
        zSJ2G:
        return $hjkarr;
        goto d37jJ;
        ONbdR:
        $hjkarr = @json_decode($hjkview, true);
        goto zSJ2G;
        ne3vI:
        $hjkurl = 'https://api.91fyt.com/index.php/api/v1/hd/hdorderlistapi';
        goto xI6w3;
        NkHcS:
        $hjkview = $this->curl_request($hjkurl, $hjkpost);
        goto ONbdR;
        d37jJ:
    }
    public function dlzdsh($uid, $share, $guanliopenid = "", $cfg = "")
    {
        goto DaAbv;
        Ij31g:
        $pddpidres = pdo_fetch('select * from ' . tablename('tiger_wxdaili_pddpid') . " where weid='{$_W['uniacid']}' and type=0 order by id desc ");
        goto HwYDE;
        HwYDE:
        if (!empty($pddpidres)) {
            goto TNK6K;
        }
        goto sqwqK;
        g9rgu:
        DHB70:
        goto Ij31g;
        ImI37:
        if (!empty($share['tgwid'])) {
            goto pb8bU;
        }
        goto OdZja;
        wFrf3:
        PEZvl:
        goto Z9vsO;
        oaZL0:
        $this->postText($share['from_user'], $dlmsg);
        goto KuGnz;
        Q73Qn:
        TNK6K:
        goto lgZD2;
        ZOK0y:
        $res = pdo_update('tiger_wxdaili_pddpid', array("type" => 1, "uid" => $share['id'], "nickname" => $share['nickname']), array("id" => $pddpidres['id']));
        goto idqBq;
        OdZja:
        $res = pdo_update('tiger_newhu_share', array("tgwid" => 11111), array("id" => $uid, "weid" => $_W['uniacid']));
        goto q_w3g;
        q2YHs:
        QZd5J:
        goto S7uns;
        Y0NuF:
        byafo:
        goto Q73Qn;
        lgZD2:
        if (empty($jdpidres['pid'])) {
            goto PEZvl;
        }
        goto CL2Ug;
        hkCQx:
        $jdpidres = pdo_fetch('select * from ' . tablename('tiger_wxdaili_jdpid') . " where weid='{$_W['uniacid']}' and type=0 order by id desc ");
        goto cI0Fd;
        DaAbv:
        global $_W;
        goto ImI37;
        sy8LU:
        if (empty($guanliopenid)) {
            goto YgmGc;
        }
        goto nxKGk;
        nxKGk:
        YgmGc:
        goto g9rgu;
        Qs8Md:
        $dlmsg = '<a href=\'' . $tturl . '\'>进入合伙人中心</a>
重点：进入合伙人中心，复制口令，打开淘♂寳APP完成渠道授权，未授权不能跟单结算佣金！';
        goto oaZL0;
        PIiDO:
        eDF6l:
        goto wFrf3;
        q_w3g:
        pb8bU:
        goto hkCQx;
        idqBq:
        pz1PN:
        goto q2YHs;
        Ga0EQ:
        $res = pdo_update('tiger_wxdaili_jdpid', array("type" => 1, "uid" => $share['id'], "nickname" => $share['nickname']), array("id" => $jdpidres['id']));
        goto PIiDO;
        eJ32t:
        $res = pdo_update('tiger_newhu_share', array("pddpid" => $pddpidres['pid'], "dltype" => 1), array("id" => $uid, "weid" => $_W['uniacid']));
        goto p03aj;
        cI0Fd:
        if (!empty($jdpidres)) {
            goto DHB70;
        }
        goto sy8LU;
        CL2Ug:
        $res = pdo_update('tiger_newhu_share', array("jdpid" => $jdpidres['pid'], "dltype" => 1), array("id" => $uid, "weid" => $_W['uniacid']));
        goto Z_ON0;
        sqwqK:
        if (empty($guanliopenid)) {
            goto byafo;
        }
        goto Y0NuF;
        p03aj:
        if (empty($res)) {
            goto pz1PN;
        }
        goto ZOK0y;
        Z9vsO:
        if (empty($pddpidres['pid'])) {
            goto QZd5J;
        }
        goto eJ32t;
        S7uns:
        $tturl = $cfg['tknewurl'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=newmember&m=tiger_wxdaili';
        goto Qs8Md;
        Z_ON0:
        if (empty($res)) {
            goto eDF6l;
        }
        goto Ga0EQ;
        KuGnz:
    }
    public function doMobileMobanxiaoxi()
    {
        goto AW2dA;
        CQukv:
        if (!empty($openid)) {
            goto uAPM5;
        }
        goto XFb0S;
        dEAgV:
        exit;
        goto z7R4q;
        M3bV7:
        print_r($str);
        goto IO_0k;
        B2XFC:
        $str = $this->mbmsg($openid, $mb, $mb['mbid'], $url = '', $fans, $orderid, $cfg = '', $valuedata = '');
        goto M3bV7;
        ewOWu:
        $openid = $_GPC['openid'];
        goto a_sD3;
        XFb0S:
        echo 'openid必填';
        goto dEAgV;
        a_sD3:
        $yhopenid = $_GPC['yhopenid'];
        goto CQukv;
        wjq8E:
        $id = $_GPC['id'];
        goto eA5J7;
        eA5J7:
        $orderid = $_GPC['orderid'];
        goto wlgcJ;
        z7R4q:
        uAPM5:
        goto wjq8E;
        AW2dA:
        global $_W, $_GPC;
        goto ewOWu;
        VIHNO:
        $fans = pdo_fetch('select * from ' . tablename($this->modulename . '_share') . " where weid='{$_W['uniacid']}' and from_user='{$yhopenid}'");
        goto B2XFC;
        wlgcJ:
        $mb = pdo_fetch('select * from ' . tablename($this->modulename . '_mobanmsg') . " where weid='{$_W['uniacid']}' and id='{$id}'");
        goto VIHNO;
        IO_0k:
    }
    public function doMobileKefuxiaoxi()
    {
        goto CwaDJ;
        svdka:
        if (!empty($openid)) {
            goto PXyhT;
        }
        goto E8EBP;
        u02yO:
        PXyhT:
        goto k1ue1;
        k1ue1:
        $msg = $_GPC['msg'];
        goto rz2nc;
        e67s7:
        exit;
        goto u02yO;
        R34ur:
        $openid = $_GPC['openid'];
        goto svdka;
        rz2nc:
        $str = $this->postText($openid, $msg);
        goto WF_ei;
        WF_ei:
        echo $str;
        goto AErVl;
        CwaDJ:
        global $_W, $_GPC;
        goto R34ur;
        E8EBP:
        echo 'openid必填';
        goto e67s7;
        AErVl:
    }
    public function jiangli($openid, $order)
    {
        goto ESk4E;
        vTJ9o:
        goto IHz7v;
        goto xwFeP;
        qEVfq:
        DmEdN:
        goto k4ivL;
        FYuM_:
        if (empty($sjmember['helpid'])) {
            goto NRgS0;
        }
        goto hdRCh;
        mdZAO:
        $data['avatar'] = $sjmember['avatar'];
        goto BKwbd;
        KUeh0:
        if (empty($hmember['openid'])) {
            goto v2myE;
        }
        goto Tedih;
        wUu2A:
        $sjmember = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_share') . " WHERE id = '{$member['helpid']}' and weid='{$_W['uniacid']}' and dltype=1");
        goto oiqgE;
        Riyul:
        if (empty($sjmember['from_user'])) {
            goto CB7m8;
        }
        goto QomKB;
        BKwbd:
        $data['openid'] = $sjmember['from_user'];
        goto u1M7w;
        CUj40:
        $data['price'] = $bl['glevel1'];
        goto UYGZu;
        tqCs3:
        $bl = pdo_fetch('select * from ' . tablename('tiger_wxdaili_set') . " where weid='{$_W['uniacid']}'");
        goto VOW3s;
        ilGbF:
        cZjj4:
        goto zmfHf;
        XyYKI:
        T1BuN:
        goto lIszW;
        PtVhA:
        $this->postText($hmember['from_user'], $msg2);
        goto HKV0M;
        ESk4E:
        global $_W;
        goto e0tqm;
        WSVyN:
        if (empty($smember['openid'])) {
            goto GXbs5;
        }
        goto Jqb7n;
        oiqgE:
        if (!empty($bl['level1'])) {
            goto p1L2k;
        }
        goto CUj40;
        N7YPf:
        $this->postText($sjmember['from_user'], $msg1);
        goto m_lxM;
        CGdne:
        if (!empty($bl['level1'])) {
            goto ahFZk;
        }
        goto F9_oO;
        yjyub:
        $msg3 = str_replace('#金额#', $data['price'], $msg3);
        goto E7Vo6;
        g1arp:
        $data['msg'] = $member['nickname'] . '二级奖励';
        goto KUeh0;
        a49ug:
        $msg0 = str_replace('#昵称#', $member['nickname'], $bl['zfmsg0']);
        goto kIlZe;
        FF7Gf:
        pdo_insert($this->modulename . '_order', $data);
        goto NFj19;
        L2AWs:
        pdo_insert($this->modulename . '_order', $data);
        goto ilGbF;
        c0cSP:
        e3L5p:
        goto EU_He;
        mtuYy:
        $data['cengji'] = 3;
        goto MSSSf;
        VJ3Bb:
        $data['price'] = $order['price'] * $bl['level3'] / 100;
        goto qEVfq;
        ow5nt:
        CB7m8:
        goto FYuM_;
        F9_oO:
        $data['price'] = $bl['glevel2'];
        goto vTJ9o;
        m_lxM:
        $this->mc_jl($sjmember['id'], 1, 10, $data['price'], $data['msg'], $order['orderno']);
        goto FF7Gf;
        UYGZu:
        goto V6t2v;
        goto IucR2;
        wnj9Z:
        file_put_contents(IA_ROOT . '/addons/tiger_wxdaili/log.txt', '
' . json_encode($uid . '--3--' . $data['price']), FILE_APPEND);
        goto XyYKI;
        Gq9SJ:
        $msg3 = str_replace('#昵称#', $member['nickname'], $bl['zfmsg3']);
        goto yjyub;
        IucR2:
        p1L2k:
        goto y19YL;
        R1h0a:
        $this->postText($member['from_user'], $msg0);
        goto j3pSF;
        E7Vo6:
        $this->postText($smember['from_user'], $msg3);
        goto jkv0C;
        Tedih:
        if (empty($data['price'])) {
            goto e3L5p;
        }
        goto v23qE;
        aWzmk:
        $data['nickname'] = $smember['nickname'];
        goto zq0eF;
        v23qE:
        $msg2 = str_replace('#昵称#', $member['nickname'], $bl['zfmsg2']);
        goto gKCuc;
        k4ivL:
        $data['memberid'] = $smember['id'];
        goto aWzmk;
        zmfHf:
        GXbs5:
        goto wnj9Z;
        oHAyt:
        $data['nickname'] = $hmember['nickname'];
        goto UNvBS;
        jDJfr:
        V6t2v:
        goto GDauq;
        ZfffL:
        $cfg = $this->module['config'];
        goto tqCs3;
        KM3hm:
        if (empty($hmember['helpid'])) {
            goto T1BuN;
        }
        goto GMlaw;
        UNvBS:
        $data['avatar'] = $hmember['avatar'];
        goto jU31X;
        lIszW:
        NRgS0:
        goto oTsiW;
        xwFeP:
        ahFZk:
        goto vM5Aa;
        naYeK:
        $data['nickname'] = $sjmember['nickname'];
        goto mdZAO;
        NFj19:
        FSwUr:
        goto ow5nt;
        jU31X:
        $data['openid'] = $hmember['from_user'];
        goto xiXo3;
        gKCuc:
        $msg2 = str_replace('#金额#', $data['price'], $msg2);
        goto PtVhA;
        hdRCh:
        $hmember = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_share') . " WHERE id = '{$sjmember['helpid']}' and weid='{$_W['uniacid']}' and dltype=1 order by id desc limit 1");
        goto CGdne;
        EiiuV:
        if (!empty($bl['level1'])) {
            goto Lzhyp;
        }
        goto Ge2ca;
        GUUAJ:
        $data['openid'] = $smember['from_user'];
        goto mtuYy;
        E5yR9:
        $data = array("weid" => $_W['uniacid'], "orderno" => $order['orderno'], "goods_id" => $order['goods_id'], "state" => 1, "paystate" => 1, "paytime" => $order['paytime'], "createtime" => time());
        goto a49ug;
        aKgzV:
        $msg1 = str_replace('#昵称#', $member['nickname'], $bl['zfmsg1']);
        goto Klj6j;
        u1M7w:
        $data['cengji'] = 1;
        goto mwDEL;
        xIO58:
        IHz7v:
        goto nCO3_;
        mwDEL:
        $data['msg'] = $member['nickname'] . '一级奖励';
        goto Riyul;
        kIlZe:
        $msg0 = str_replace('#金额#', $order['price'], $msg0);
        goto R1h0a;
        j3pSF:
        if (empty($member['helpid'])) {
            goto U4tBa;
        }
        goto wUu2A;
        MSSSf:
        $data['msg'] = $member['nickname'] . '三级奖励';
        goto WSVyN;
        oTsiW:
        U4tBa:
        goto itlSS;
        lJPM9:
        goto DmEdN;
        goto E9jVW;
        Ge2ca:
        $data['price'] = $bl['glevel3'];
        goto lJPM9;
        E9jVW:
        Lzhyp:
        goto VJ3Bb;
        rx9gh:
        pdo_insert($this->modulename . '_order', $data);
        goto c0cSP;
        xiXo3:
        $data['cengji'] = 2;
        goto g1arp;
        HKV0M:
        $this->mc_jl($hmember['id'], 1, 10, $data['price'], $data['msg'], $order['orderno']);
        goto rx9gh;
        Jqb7n:
        if (empty($data['price'])) {
            goto cZjj4;
        }
        goto Gq9SJ;
        zq0eF:
        $data['avatar'] = $smember['avatar'];
        goto GUUAJ;
        Klj6j:
        $msg1 = str_replace('#金额#', $data['price'], $msg1);
        goto N7YPf;
        y19YL:
        $data['price'] = $order['price'] * $bl['level1'] / 100;
        goto jDJfr;
        vM5Aa:
        $data['price'] = $order['price'] * $bl['level2'] / 100;
        goto xIO58;
        EU_He:
        v2myE:
        goto KM3hm;
        VOW3s:
        $member = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_share') . " WHERE id = '{$order['memberid']}' and weid='{$_W['uniacid']}'");
        goto E5yR9;
        e0tqm:
        load()->model('mc');
        goto ZfffL;
        GMlaw:
        $smember = pdo_fetch('SELECT * FROM ' . tablename('tiger_newhu_share') . " WHERE id = '{$hmember['helpid']}' and weid='{$_W['uniacid']}' and dltype=1 order by id desc limit 1");
        goto EiiuV;
        nCO3_:
        $data['memberid'] = $hmember['id'];
        goto oHAyt;
        QomKB:
        if (empty($data['price'])) {
            goto FSwUr;
        }
        goto aKgzV;
        GDauq:
        $data['memberid'] = $sjmember['id'];
        goto naYeK;
        jkv0C:
        $this->mc_jl($smember['id'], 1, 10, $data['price'], $data['msg'], $order['orderno']);
        goto L2AWs;
        itlSS:
    }
    public function jdtbtgetorder($appKey, $appSecret, $accesstoken, $unionid, $page, $time)
    {
        goto pAln7;
        PMSZH:
        $arrres = $arr;
        goto mvrjO;
        BdxiN:
        $req->setUnionId($unionid);
        goto DT7rF;
        Jd9dH:
        $resp = $resp->result;
        goto GgCcF;
        k4n73:
        $c->serverUrl = 'https://gw.api.360buy.com/routerjson';
        goto ZuobH;
        pAln7:
        $c = new JdClient();
        goto Et8VK;
        Vd4O4:
        $arrres = $arr['data'];
        goto nGzy2;
        Et8VK:
        $c->appKey = $appKey;
        goto XaDAI;
        COpMj:
        $c->accessToken = $accesstoken;
        goto k4n73;
        vkK1D:
        $resp = $c->execute($req, $c->accessToken);
        goto Jd9dH;
        xETD2:
        $req->setPageIndex($page);
        goto QT5M5;
        ZuobH:
        $req = new UnionServiceQueryOrderListRequest();
        goto BdxiN;
        mvrjO:
        L34MT:
        goto eNM_O;
        QT5M5:
        $req->setPageSize(400);
        goto vkK1D;
        eNM_O:
        return $arrres;
        goto fHCcs;
        nGzy2:
        if (!empty($arrres)) {
            goto L34MT;
        }
        goto PMSZH;
        GgCcF:
        $arr = @json_decode($arr, true);
        goto Vd4O4;
        DT7rF:
        $req->setTime($time);
        goto xETD2;
        XaDAI:
        $c->appSecret = $appSecret;
        goto COpMj;
        fHCcs:
    }
    public function get_server_ip()
    {
        goto HlTsK;
        xWs9F:
        goto cj_Tj;
        goto IZvZR;
        D40QW:
        $server_ip = getenv('SERVER_ADDR');
        goto xWs9F;
        IZvZR:
        W5dey:
        goto BFtZA;
        iWp3z:
        NMBez:
        goto Z8KDL;
        BY237:
        return $server_ip;
        goto wdFVj;
        Qhe78:
        goto NMBez;
        goto kxVD2;
        Z8KDL:
        cj_Tj:
        goto BY237;
        BFtZA:
        if ($_SERVER['SERVER_ADDR']) {
            goto oS1b6;
        }
        goto SolHa;
        HlTsK:
        if (isset($_SERVER)) {
            goto W5dey;
        }
        goto D40QW;
        kxVD2:
        oS1b6:
        goto eJhPM;
        eJhPM:
        $server_ip = $_SERVER['SERVER_ADDR'];
        goto iWp3z;
        SolHa:
        $server_ip = $_SERVER['LOCAL_ADDR'];
        goto Qhe78;
        wdFVj:
    }
    public function sms($tel, $accessKeyId, $accessKeySecret, $SignName, $TemplateCode, $code)
    {
        goto noTXw;
        noTXw:
        global $_W, $_GPC;
        goto ESgDS;
        jbjCt:
        return 'OK';
        goto c7z2O;
        c7z2O:
        JEDhn:
        goto lOHjx;
        ESgDS:
        $cfg = $this->module['config'];
        goto Bvv1S;
        bVnGj:
        sfuSF:
        goto jbjCt;
        EbKbk:
        if (strpos($rurl, 'OK') !== false) {
            goto sfuSF;
        }
        goto QU_5b;
        We2El:
        goto JEDhn;
        goto bVnGj;
        y2HC9:
        $rurl = $this->curl_request($smsurl);
        goto uRER1;
        uRER1:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/sms_log.txt', '
' . json_encode($rurl), FILE_APPEND);
        goto EbKbk;
        QU_5b:
        return '发送失败';
        goto We2El;
        Bvv1S:
        $smsurl = $_W['siteroot'] . 'addons/tiger_newhu/inc/sms/sms/sendSms.php?tel=' . $tel . '&accessKeyId=' . $accessKeyId . '&accessKeySecret=' . $accessKeySecret . '&SignName=' . $SignName . '&TemplateCode=' . $TemplateCode . '&code=' . $code . '';
        goto y2HC9;
        lOHjx:
    }
    public function getzdorder($member, $cfg)
    {
        goto dn_bp;
        uaSDw:
        if (!empty($member['tbsbuid6'])) {
            goto YK2x9;
        }
        goto oTZOO;
        Whtw4:
        d70gP:
        goto TY15a;
        bObav:
        $ztime = mktime(0, 0, 0, date('m'), date('d') - date('w') + 1 - 20, date('Y'));
        goto B6LLT;
        RQRrt:
        return '';
        goto iz0YB;
        n3MOR:
        vkp14:
        goto t8Xzn;
        dOaaH:
        return '';
        goto n3MOR;
        dn_bp:
        global $_W;
        goto O__lR;
        oTZOO:
        return '';
        goto FDyhs;
        Jt2cv:
        foreach ($tkorlist as $k => $tkorder) {
            goto ut0Ki;
            ummfh:
            $jl = $cfg['zgf'];
            goto d4kuj;
            QRh0V:
            Pks10:
            goto pVW6N;
            zEGsY:
            if ($cfg['gdfxtype'] == 1) {
                goto g0e1g;
            }
            goto y_OmW;
            u2y4a:
            $ejtxmsg = str_replace('#金额#', $jl, $ejtxmsg);
            goto uDRT0;
            WsytV:
            cwl1v:
            goto mx2zb;
            yjUok:
            qounJ:
            goto NRqNo;
            fX7X8:
            $jl = number_format($jl, 2, '.', '');
            goto Z3vFY;
            CrzEL:
            SMTM5:
            goto vyDFc;
            wFOpJ:
            $sh = 3;
            goto voUKI;
            qJmjP:
            $dltgw = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and qdid='{$tkorder['relation_id']}'");
            goto IfEkg;
            I2G43:
            goto h6Lp3;
            goto yHwMa;
            c_j9y:
            KrBBb:
            goto YCm3a;
            P5zLt:
            if ($cfg['gdfxtype'] == 1) {
                goto pHtKz;
            }
            goto PX2TN;
            hTIqu:
            goto m5TUD;
            goto tD8Ti;
            se0Mh:
            OmGH_:
            goto zKG9f;
            zosZl:
            $dltgw = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and tgwid='{$tkorder['tgwid']}'");
            goto lU1r0;
            dpKCM:
            pdo_update($this->modulename . '_tkorder', array("zdgd" => 1), array("weid" => $_W['uniacid'], "orderid" => $orderid));
            goto LI22a;
            gNU6R:
            $jl = intval($tkorder['xgyg'] * $cfg['ejf'] / 100 * $cfg['jfbl']);
            goto GT6sS;
            zRFFJ:
            $jl = $tkorder['xgyg'] * $cfg['yjf'] / 100;
            goto olfKO;
            KhOqy:
            goto NukMc;
            goto x5rFo;
            otX16:
            if ($cfg['gdfxtype'] == 1) {
                goto uCdbs;
            }
            goto zRFFJ;
            B_0VG:
            $resorder = pdo_insert($this->modulename . '_order', $data);
            goto MSp4J;
            tQgKD:
            $jltype = 1;
            goto I_Pp9;
            fPG5Y:
            ONA9n:
            goto pS4XD;
            Jahfh:
            goto NukMc;
            goto fPG5Y;
            zKG9f:
            $order = pdo_fetch('select * from ' . tablename($this->modulename . '_order') . " where weid='{$_W['uniacid']}' and orderid='{$tkorder['orderid']}' and itemid='{$tkorder['numid']}'");
            goto oq1Nt;
            S3C6b:
            $jl = $cfg['yjf'];
            goto tfhDK;
            XYapc:
            o0s24:
            goto JWek9;
            bWWzW:
            r5GVA:
            goto tQgKD;
            VyyQa:
            $jl = number_format($jl, 2, '.', '');
            goto P8sSp;
            wUCmt:
            goto qxFKv;
            goto xF4wg;
            xuxgE:
            $yjmember = pdo_fetch('select * from ' . tablename($this->modulename . '_share') . " where weid='{$_W['uniacid']}' and id='{$member['helpid']}' order by id desc");
            goto MfDfZ;
            d4kuj:
            kDBKK:
            goto U3UXO;
            okCRO:
            $jltype = 0;
            goto UVYrl;
            xAtCO:
            $jl = $tkorder['xgyg'] * $cfg['ejf'] / 100;
            goto VyyQa;
            hbIgZ:
            if (!empty($order)) {
                goto cCGw5;
            }
            goto ycEdL;
            dbllM:
            if (empty($dltgw)) {
                goto HJYtE;
            }
            goto Mz91n;
            mx2zb:
            $jl = $cfg['ejf'];
            goto WkESV;
            vSuf2:
            goto Om8lo;
            goto wRFRG;
            y_OmW:
            $jl = intval($tkorder['xgyg'] * $cfg['yjf'] / 100 * $cfg['jfbl']);
            goto wUCmt;
            xF4wg:
            g0e1g:
            goto VSa44;
            yHwMa:
            lLR0U:
            goto otX16;
            lcvO0:
            goto Z2cgl;
            goto M7WMq;
            GT6sS:
            goto OZi2Y;
            goto c_j9y;
            wWIXA:
            if (empty($tkorder['relation_id'])) {
                goto wzlY4;
            }
            goto qJmjP;
            UpVTe:
            $data = array("weid" => $_W['uniacid'], "openid" => $member['from_user'], "memberid" => $member['openid'], "uid" => $member['id'], "nickname" => $member['nickname'], "avatar" => $member['avatar'], "orderid" => $orderid, "itemid" => $tkorder['numid'], "jl" => $jl, "jltype" => $jltype, "sh" => $sh, "yongjin" => $tkorder['xgyg'], "type" => 0, "createtime" => TIMESTAMP);
            goto B_0VG;
            iiH7p:
            h6Lp3:
            goto xuxgE;
            wkchQ:
            $yjtxmsg = str_replace('#金额#', $jl, $yjtxmsg);
            goto Q3ugI;
            U0LTg:
            if ($cfg['fxtype'] == 2) {
                goto lLR0U;
            }
            goto HBfln;
            lFvRK:
            LN_bc:
            goto jfIXI;
            vyDFc:
            if ($cfg['fxtype'] == 1) {
                goto ONA9n;
            }
            goto pSZKG;
            AsPIK:
            zLrF0:
            goto zEGsY;
            psTEt:
            if ($cfg['fxtype'] == 1) {
                goto zLrF0;
            }
            goto U0LTg;
            beDhG:
            $jl = intval($tkorder['xgyg'] * $cfg['zgf'] / 100 * $cfg['jfbl']);
            goto lcvO0;
            diyPd:
            pHtKz:
            goto ummfh;
            N3wG4:
            if ($cfg['fxtype'] == 1) {
                goto yoAwk;
            }
            goto XBRa4;
            voUKI:
            if ($cfg['fxtype'] == 1) {
                goto v8CCi;
            }
            goto U64bl;
            tD8Ti:
            rey9x:
            goto YdGh3;
            I_Pp9:
            sNIJ7:
            goto wFOpJ;
            olfKO:
            $jl = number_format($jl, 2, '.', '');
            goto vSuf2;
            P8sSp:
            goto P69eH;
            goto WsytV;
            Q3ugI:
            $this->postText($yjmember['from_user'], $yjtxmsg);
            goto nB3Df;
            KCCad:
            if (empty($cfg['yjf'])) {
                goto PbjrA;
            }
            goto psTEt;
            o4H9R:
            $rjmember = pdo_fetch('select * from ' . tablename($this->modulename . '_share') . " where weid='{$_W['uniacid']}' and id='{$yjmember['helpid']}' order by id desc");
            goto slgGG;
            tfhDK:
            Om8lo:
            goto iiH7p;
            YdVWc:
            HJYtE:
            goto se0Mh;
            PXKn6:
            $jl = $cfg['zgf'];
            goto U0N6E;
            CwWSd:
            pdo_insert($this->modulename . '_order', $data2);
            goto yjUok;
            pNDv1:
            if ($cfg['fxtype'] == 2) {
                goto rey9x;
            }
            goto vqMnV;
            Mz91n:
            goto iTRil;
            goto YdVWc;
            wRFRG:
            uCdbs:
            goto S3C6b;
            XBRa4:
            if ($cfg['fxtype'] == 2) {
                goto r5GVA;
            }
            goto sCwsP;
            bGIA7:
            yoAwk:
            goto zf1Pz;
            PX2TN:
            $jl = $tkorder['xgyg'] * $cfg['zgf'] / 100;
            goto fX7X8;
            KzQgp:
            $orderid = $tkorder['orderid'];
            goto UpVTe;
            W6X__:
            goto SMTM5;
            goto Ur3In;
            oq1Nt:
            if (!empty($order['id'])) {
                goto Pks10;
            }
            goto N3wG4;
            LI22a:
            YSjqL:
            goto Ewjn8;
            xrRkV:
            m5TUD:
            goto o4H9R;
            uDRT0:
            $this->postText($rjmember['from_user'], $ejtxmsg);
            goto Pc8Tk;
            OHHiG:
            $order = pdo_fetchall('select * from ' . tablename($this->modulename . '_order') . " where weid='{$_W['uniacid']}' and type=1 and orderid={$orderid} and itemid='{$tkorder['numid']}'");
            goto uz399;
            sCwsP:
            goto sNIJ7;
            goto bGIA7;
            NiGyq:
            goto sNIJ7;
            goto bWWzW;
            lU1r0:
            Z8wgG:
            goto dbllM;
            VSa44:
            $jl = $cfg['yjf'];
            goto sAhtP;
            U3UXO:
            NukMc:
            goto KzQgp;
            OYU8X:
            uFDlS:
            goto LFTo1;
            q1m3s:
            wzlY4:
            goto zosZl;
            HBfln:
            goto h6Lp3;
            goto AsPIK;
            sAhtP:
            qxFKv:
            goto I2G43;
            PEPTE:
            G91bn:
            goto QRh0V;
            MfDfZ:
            $yjtxmsg = str_replace('#昵称#', $member['nickname'], $cfg['yjtxmsg']);
            goto oJTY8;
            pSZKG:
            if ($cfg['fxtype'] == 2) {
                goto rlNdN;
            }
            goto Jahfh;
            U64bl:
            if ($cfg['fxtype'] == 2) {
                goto LN_bc;
            }
            goto W6X__;
            Mf6CS:
            OZi2Y:
            goto hTIqu;
            IfEkg:
            goto Z8wgG;
            goto q1m3s;
            Mpz8X:
            if (empty($yjmember['helpid'])) {
                goto yNnUf;
            }
            goto eKqND;
            U0N6E:
            Z2cgl:
            goto KhOqy;
            NRqNo:
            PbjrA:
            goto Mpz8X;
            YCm3a:
            $jl = $cfg['ejf'];
            goto Mf6CS;
            ut0Ki:
            if (!($cfg['dlddfx'] == 1)) {
                goto OmGH_;
            }
            goto wWIXA;
            ycEdL:
            pdo_insert($this->modulename . '_order', $data3);
            goto RDMYB;
            Z3vFY:
            goto kDBKK;
            goto diyPd;
            WkESV:
            P69eH:
            goto xrRkV;
            eKqND:
            if (empty($cfg['ejf'])) {
                goto o0s24;
            }
            goto Zu_EN;
            nB3Df:
            $data2 = array("weid" => $_W['uniacid'], "openid" => $yjmember['from_user'], "memberid" => $yjmember['openid'], "uid" => $yjmember['id'], "nickname" => $yjmember['nickname'], "jl" => $jl, "jltype" => $jltype, "avatar" => $yjmember['avatar'], "jlnickname" => $member['nickname'], "jlavatar" => $member['avatar'], "orderid" => $orderid, "yongjin" => $tkorder['xgyg'], "itemid" => $tkorder['numid'], "type" => 1, "sh" => $sh, "createtime" => TIMESTAMP);
            goto OHHiG;
            pS4XD:
            if ($cfg['gdfxtype'] == 1) {
                goto CcBES;
            }
            goto beDhG;
            LFTo1:
            if ($cfg['gdfxtype'] == 1) {
                goto KrBBb;
            }
            goto gNU6R;
            slgGG:
            $ejtxmsg = str_replace('#昵称#', $member['nickname'], $cfg['ejtxmsg']);
            goto wdhRd;
            Ewjn8:
            if (empty($member['helpid'])) {
                goto G91bn;
            }
            goto KCCad;
            wdhRd:
            $ejtxmsg = str_replace('#订单号#', $orderid, $ejtxmsg);
            goto u2y4a;
            RDMYB:
            cCGw5:
            goto XYapc;
            jfIXI:
            $jltype = 1;
            goto CrzEL;
            uz399:
            if (!empty($order)) {
                goto qounJ;
            }
            goto CwWSd;
            pVW6N:
            iTRil:
            goto IqqHq;
            x5rFo:
            rlNdN:
            goto P5zLt;
            Zu_EN:
            if ($cfg['fxtype'] == 1) {
                goto uFDlS;
            }
            goto pNDv1;
            zf1Pz:
            $jltype = 0;
            goto NiGyq;
            Ur3In:
            v8CCi:
            goto okCRO;
            cfCqe:
            $order = pdo_fetchall('select * from ' . tablename($this->modulename . '_order') . " where weid='{$_W['uniacid']}' and type=2 and orderid={$orderid}  and itemid='{$tkorder['numid']}'");
            goto hbIgZ;
            MSp4J:
            if (!($resorder != false)) {
                goto YSjqL;
            }
            goto dpKCM;
            JWek9:
            yNnUf:
            goto PEPTE;
            oJTY8:
            $yjtxmsg = str_replace('#订单号#', $orderid, $yjtxmsg);
            goto wkchQ;
            M7WMq:
            CcBES:
            goto PXKn6;
            YdGh3:
            if ($cfg['gdfxtype'] == 1) {
                goto cwl1v;
            }
            goto xAtCO;
            Pc8Tk:
            $data3 = array("weid" => $_W['uniacid'], "openid" => $rjmember['from_user'], "memberid" => $rjmember['openid'], "uid" => $rjmember['id'], "nickname" => $rjmember['nickname'], "jl" => $jl, "jltype" => $jltype, "avatar" => $rjmember['avatar'], "jlnickname" => $member['nickname'], "jlavatar" => $member['avatar'], "orderid" => $orderid, "yongjin" => $tkorder['xgyg'], "itemid" => $tkorder['numid'], "type" => 2, "sh" => $sh, "createtime" => TIMESTAMP);
            goto cfCqe;
            vqMnV:
            goto m5TUD;
            goto OYU8X;
            UVYrl:
            goto SMTM5;
            goto lFvRK;
            IqqHq:
        }
        goto Whtw4;
        Vftbl:
        if (!($bl['dlfxtype'] == 1)) {
            goto SlCqY;
        }
        goto B04tv;
        FDyhs:
        YK2x9:
        goto C_aI4;
        O__lR:
        if (!($cfg['zdgdtype'] != 1)) {
            goto UD2qm;
        }
        goto RQRrt;
        C_aI4:
        $tbsbuid6 = $member['tbsbuid6'];
        goto bObav;
        p6JjT:
        bectP:
        goto uaSDw;
        t8Xzn:
        SlCqY:
        goto p6JjT;
        vt6qF:
        if (!pdo_tableexists('tiger_wxdaili_set')) {
            goto bectP;
        }
        goto H_42N;
        H_42N:
        $bl = pdo_fetch('select * from ' . tablename('tiger_wxdaili_set') . " where weid='{$weid}'");
        goto Vftbl;
        iz0YB:
        UD2qm:
        goto vt6qF;
        B04tv:
        if (!($member['dltype'] == 1)) {
            goto vkp14;
        }
        goto dOaaH;
        B6LLT:
        $tkorlist = pdo_fetchall('select * from ' . tablename($this->modulename . '_tkorder') . " where weid='{$_W['uniacid']}' and tbsbuid6='{$tbsbuid6}' and addtime>'{$ztime}' and orderzt<>'订单失效' and zdgd<>1 order by id desc");
        goto Jt2cv;
        TY15a:
    }
    public function getmember($fans = "", $wqid = "", $helpid = "", $lytype = 0)
    {
        goto vb5j9;
        C9pGB:
        return $share;
        goto EDXwU;
        MjLzr:
        h5jIA:
        goto BP38f;
        bwGG9:
        goto MK0s0;
        goto yMs6o;
        xnoTH:
        $updata = array("unionid" => $fans['unionid'], "openid" => $wqid, "nickname" => $fans['nickname'], "avatar" => $fans['avatar']);
        goto W_xT9;
        cJtaD:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$share['id']}'");
        goto PxQRm;
        wzsGD:
        XniJd:
        goto DcpIY;
        RYPtK:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and unionid='{$fans['unionid']}'");
        goto sIXI2;
        rcxFt:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and unionid='{$fans['unionid']}'");
        goto yCjO6;
        CgBEO:
        $updata = array("from_user" => $fans['openid'], "openid" => $wqid, "nickname" => $fans['nickname'], "avatar" => $fans['avatar']);
        goto h89tq;
        f4oAX:
        return $share;
        goto rhim8;
        gZ3Pg:
        pdo_insert('tiger_newhu_share', array("openid" => $wqid, "nickname" => $fans['nickname'], "avatar" => $fans['avatar'], "unionid" => $fans['unionid'], "pid" => "", "updatetime" => time(), "createtime" => time(), "parentid" => 0, "weid" => $_W['uniacid'], "helpid" => $helpid, "score" => "", "cscore" => "", "pscore" => "", "from_user" => $fans['openid'], "lytype" => $lytype, "follow" => 1));
        goto oUyX6;
        XE07r:
        goto aT4Hf;
        goto BgV2l;
        RJVRn:
        return $share;
        goto wzsGD;
        F5rKk:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        goto vZNtp;
        yCjO6:
        return $share;
        goto MjLzr;
        iOwEL:
        if (!empty($share['id'])) {
            goto ahrAh;
        }
        goto Ocpbv;
        Qg1wu:
        qyqI1:
        goto CgBEO;
        iGzIH:
        pdo_update('tiger_newhu_share', $updata, array("weid" => $_W['uniacid'], "from_user" => $fans['openid']));
        goto Q3tF_;
        htrfX:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        goto RJVRn;
        h8oy5:
        return '';
        goto bwGG9;
        ebZfU:
        return $share;
        goto UMEwz;
        H6BlE:
        if (!($cfg['dlgzsdtype'] == 1)) {
            goto pFBrN;
        }
        goto X2TCM;
        Ocpbv:
        if (!empty($fans['openid'])) {
            goto ja9XE;
        }
        goto h8oy5;
        daMa9:
        nxJdR:
        goto BGKdY;
        oUyX6:
        $share['id'] = pdo_insertid();
        goto cJtaD;
        kA3NC:
        pFBrN:
        goto ebZfU;
        Wt7t2:
        pdo_insert('tiger_newhu_share', array("openid" => $wqid, "nickname" => $fans['nickname'], "avatar" => $fans['avatar'], "unionid" => $fans['unionid'], "pid" => "", "updatetime" => time(), "createtime" => time(), "parentid" => 0, "weid" => $_W['uniacid'], "helpid" => $helpid, "score" => "", "cscore" => "", "pscore" => "", "from_user" => $fans['openid'], "lytype" => $lytype, "follow" => 1));
        goto dORzS;
        rhim8:
        goto XniJd;
        goto G2Gwt;
        dORzS:
        $share['id'] = pdo_insertid();
        goto f79gI;
        Qujdo:
        if (!empty($fans['unionid'])) {
            goto hmnm8;
        }
        goto f4oAX;
        yMs6o:
        ja9XE:
        goto Wt7t2;
        JlwSB:
        ahrAh:
        goto Qujdo;
        iW9yU:
        if (!empty($fans['openid'])) {
            goto nxJdR;
        }
        goto sbetZ;
        UMEwz:
        goto OITsf;
        goto PmDFn;
        f79gI:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        goto ipNZ1;
        PxQRm:
        $cfg = $this->module['config'];
        goto H6BlE;
        X2TCM:
        $this->dlzdsh($share['id'], $share, '', $cfg);
        goto kA3NC;
        CIZJ8:
        goto dHe7a;
        goto JlwSB;
        h89tq:
        pdo_update('tiger_newhu_share', $updata, array("weid" => $_W['uniacid'], "unionid" => $fans['unionid']));
        goto rcxFt;
        EDXwU:
        OITsf:
        goto VTrF2;
        W_xT9:
        pdo_update('tiger_newhu_share', $updata, array("weid" => $_W['uniacid'], "from_user" => $fans['openid']));
        goto htrfX;
        ipNZ1:
        return $share;
        goto RWYMd;
        Q3tF_:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        goto C9pGB;
        v9aVg:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        goto iOwEL;
        VTrF2:
        goto h5jIA;
        goto Qg1wu;
        BGKdY:
        if (!empty($fans['unionid'])) {
            goto i4ilM;
        }
        goto v9aVg;
        G2Gwt:
        hmnm8:
        goto xnoTH;
        DcpIY:
        dHe7a:
        goto XE07r;
        sIXI2:
        if (!empty($share['id'])) {
            goto qyqI1;
        }
        goto F5rKk;
        vZNtp:
        if (!empty($share['id'])) {
            goto zn7vz;
        }
        goto gZ3Pg;
        BP38f:
        aT4Hf:
        goto Uo0oJ;
        sbetZ:
        return '';
        goto daMa9;
        GX_OX:
        $updata = array("unionid" => $fans['unionid'], "openid" => $wqid, "nickname" => $fans['nickname'], "avatar" => $fans['avatar']);
        goto iGzIH;
        PmDFn:
        zn7vz:
        goto GX_OX;
        RWYMd:
        MK0s0:
        goto CIZJ8;
        vb5j9:
        global $_W;
        goto iW9yU;
        BgV2l:
        i4ilM:
        goto RYPtK;
        Uo0oJ:
    }
    public function bryj($share, $begin_time, $end_time, $zt, $bl, $cfg)
    {
        goto wtn5c;
        DbwCx:
        WG1LH:
        goto HzMfv;
        LElnP:
        n5ad4:
        goto j12Un;
        WhmO6:
        if (empty($byygsum)) {
            goto Z1nyj;
        }
        goto wzrNU;
        gJTLW:
        if (empty($sj)) {
            goto FtViU;
        }
        goto ajeBH;
        t77Zp:
        $dj = 1;
        goto fYTo8;
        FlOAM:
        if ($bl['fxtype'] == 1) {
            goto NOF4M;
        }
        goto SGmB3;
        i9kX8:
        $byygsum = $byygsum * $bl['dlbl1'] / 100;
        goto RSaBI;
        QHc3Z:
        $byygsum = $byygsum * $bl['dlbl1'] / 100;
        goto Q5crp;
        URISW:
        ZMEXH:
        goto CNF2n;
        TrOSt:
        if (empty($end_time)) {
            goto n5ad4;
        }
        goto K5frw;
        ZNVRx:
        $dj = 2;
        goto IhEG4;
        aNl0L:
        $where .= 'and (';
        goto Ie4KJ;
        QQSBq:
        if ($zt == 2) {
            goto GkSeg;
        }
        goto sOll_;
        J0LoL:
        $sj2 = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$sj['helpid']}'");
        goto s3T6n;
        kyXHw:
        NAcBp:
        goto z2gOn;
        o4Sjh:
        $ddzt = ' and orderzt=\'订单付款\'';
        goto K8P4k;
        tFDhO:
        FtViU:
        goto HRe21;
        qcVfq:
        L4m1_:
        goto cWAtK;
        ciZiC:
        if (!($zt == 2)) {
            goto NAcBp;
        }
        goto Pi1dt;
        j12Un:
        if (empty($begin_time)) {
            goto i4CSo;
        }
        goto VJzfM;
        dInKQ:
        return $byygsum;
        goto SzHh5;
        Hm5LO:
        goto ajHn9;
        goto Y4mIV;
        OrUgX:
        OJvbM:
        goto ZNVRx;
        wzrNU:
        $sj = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");
        goto gJTLW;
        QhLTl:
        $dwhere = "and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
        goto o1yM1;
        Xl209:
        $bl['dlbl1'] = $share['dlbl'];
        goto URISW;
        Ie4KJ:
        foreach ($tgwarr as $k => $v) {
            $where .= ' tgwid=' . $v . ' or ';
            GVghO:
        }
        goto qcVfq;
        UcuB7:
        MLT3M:
        goto ciZiC;
        s3T6n:
        if (!($bl['dltype'] == 3)) {
            goto qn3ZG;
        }
        goto DX9WX;
        IhEG4:
        gea3x:
        goto jBijY;
        wsq2F:
        $ddzt = ' and orderzt=\'订单结算\'';
        goto jFH5i;
        uLsK2:
        goto ZNdGF;
        goto LElnP;
        CNF2n:
        $send_time = strtotime(date('Y-m-d 23:59:59', strtotime(-date('d') . 'day')));
        goto oWICw;
        K5frw:
        if (empty($begin_time)) {
            goto Mq1jd;
        }
        goto QhLTl;
        cWAtK:
        $where .= 'tgwid=' . $tgwarr[0] . ')';
        goto hGMme;
        SGmB3:
        if ($dj == 1) {
            goto pzekS;
        }
        goto a0mDu;
        d5bPJ:
        if (!empty($share['tgwid'])) {
            goto kx19j;
        }
        goto HQT44;
        gdAx6:
        ZNdGF:
        goto Ko0kR;
        Q5crp:
        E9BnB:
        goto dInKQ;
        SgqJm:
        $addtime = 'jstime';
        goto UcuB7;
        i9P23:
        if ($send_time == $end_time) {
            goto T_tJh;
        }
        goto fW7nG;
        mevlb:
        goto E9BnB;
        goto vUM0A;
        tvnNl:
        js5zp:
        goto WhmO6;
        WrgAa:
        SWz1w:
        goto hqfg2;
        ajeBH:
        if (!($bl['dltype'] == 2)) {
            goto DBRgY;
        }
        goto t77Zp;
        DnTtr:
        $yj2 = $byygsum * $bl['dlbl2'] / 100;
        goto dtUEI;
        CQtbA:
        i4CSo:
        goto gdAx6;
        zStdF:
        goto MLT3M;
        goto aJVYk;
        Pi1dt:
        $addtime = 'addtime';
        goto kyXHw;
        jBijY:
        qn3ZG:
        goto tFDhO;
        XVPcD:
        pzekS:
        goto DnTtr;
        hqfg2:
        $yj3 = $byygsum * $bl['dlbl3'] / 100;
        goto oso7Y;
        fW7nG:
        $addtime = 'addtime';
        goto zStdF;
        OpOZC:
        $byygsum = $byygsum * (100 - $bl['dlkcbl']) / 100;
        goto tvnNl;
        AeUHM:
        $byygsum = '0.00';
        goto VXUaX;
        fYTo8:
        DBRgY:
        goto J0LoL;
        RN2Vv:
        XpEWO:
        goto KzIkB;
        KzIkB:
        $tgwarr = explode('|', $share['tgwid']);
        goto lA9kL;
        HIpfR:
        if (empty($share['dlbl'])) {
            goto ZMEXH;
        }
        goto Xl209;
        z2gOn:
        XmXaZ:
        goto TrOSt;
        Hb4ql:
        m7uZm:
        goto mevlb;
        HRe21:
        goto CSiHi;
        goto wIyAk;
        aJVYk:
        T_tJh:
        goto SgqJm;
        lA9kL:
        $where = '';
        goto d5bPJ;
        sOll_:
        if ($zt == 3) {
            goto WG1LH;
        }
        goto jp_VR;
        o1yM1:
        Mq1jd:
        goto uLsK2;
        L3CmH:
        $byygsum = pdo_fetchcolumn('SELECT sum(xgyg) FROM ' . tablename('tiger_newhu_tkorder') . " where weid='{$_W['uniacid']}'  {$ddzt} {$dwhere} {$where}");
        goto wVa_w;
        HzMfv:
        $ddzt = ' and orderzt<>\'订单失效\'';
        goto RN2Vv;
        DX9WX:
        if (!empty($sj2)) {
            goto OJvbM;
        }
        goto k3lgv;
        wVa_w:
        if (empty($bl['dlkcbl'])) {
            goto js5zp;
        }
        goto OpOZC;
        HQT44:
        $where .= ' and tgwid=111111';
        goto Hm5LO;
        EWF_S:
        $yj1 = $yj3 * $bl['dlbl1t3'] / 100;
        goto ZYsFt;
        FekJd:
        $addtime = 'addtime';
        goto n2ub1;
        ADJSz:
        goto m7uZm;
        goto WrgAa;
        n2ub1:
        goto XmXaZ;
        goto tGelV;
        VJzfM:
        $dwhere = "and addtime>={$begin_time}";
        goto CQtbA;
        K8P4k:
        goto XpEWO;
        goto DbwCx;
        RSaBI:
        goto m7uZm;
        goto XVPcD;
        hGMme:
        ajHn9:
        goto L3CmH;
        Ko0kR:
        if ($zt == 1) {
            goto Lc3Ha;
        }
        goto QQSBq;
        rGgiI:
        GkSeg:
        goto o4Sjh;
        KgZVg:
        Lc3Ha:
        goto wsq2F;
        dtUEI:
        $yj1 = $yj2 * $bl['dlbl1t2'] / 100;
        goto YUJ3z;
        jFH5i:
        goto XpEWO;
        goto rGgiI;
        oso7Y:
        $yj2 = $yj3 * $bl['dlbl2t3'] / 100;
        goto EWF_S;
        vUM0A:
        NOF4M:
        goto QHc3Z;
        oWICw:
        if ($cfg['jsms'] == 1) {
            goto k7_yf;
        }
        goto FekJd;
        wtn5c:
        global $_W;
        goto HIpfR;
        ZYsFt:
        $byygsum = $yj3 - $yj2 - $yj1;
        goto Hb4ql;
        zf2YN:
        goto gea3x;
        goto OrUgX;
        wIyAk:
        Z1nyj:
        goto AeUHM;
        YUJ3z:
        $byygsum = $yj2 - $yj1;
        goto ADJSz;
        Y4mIV:
        kx19j:
        goto aNl0L;
        a0mDu:
        if ($dj == 2) {
            goto SWz1w;
        }
        goto i9kX8;
        tGelV:
        k7_yf:
        goto i9P23;
        k3lgv:
        $dj = 1;
        goto zf2YN;
        VXUaX:
        CSiHi:
        goto FlOAM;
        jp_VR:
        goto XpEWO;
        goto KgZVg;
        SzHh5:
    }
    public function jcbl($share, $bl)
    {
        goto ReEhR;
        yaX0Y:
        $cj = 2;
        goto fGnrN;
        vlzvE:
        $sj2 = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$sj['helpid']}'");
        goto ABx__;
        bn532:
        $djbl = $bl['dlbl1'];
        goto aRlRA;
        fw0Sq:
        $tname = $bl['dlname1'];
        goto CN69V;
        Bi5WE:
        goto BhLU0;
        goto C_Pdf;
        Op8K9:
        if ($bl['dltype'] == 3) {
            goto xCfFY;
        }
        goto XCACy;
        Ap1Jh:
        $tname = $bl['dlname2'];
        goto yaX0Y;
        oLanE:
        ylSGU:
        goto BOyvp;
        mXnw6:
        $djbl = $share['dlbl'];
        goto fw0Sq;
        gYVRz:
        $tname = $bl['dlname3'];
        goto BlEvh;
        BlEvh:
        $cj = 3;
        goto i6jJX;
        daYne:
        $cj = 1;
        goto Bi5WE;
        C_Pdf:
        RpZcQ:
        goto vlzvE;
        EPud4:
        $djbl = $bl['dlbl2'];
        goto Ap1Jh;
        cCn5h:
        $tname = $bl['dlname1'];
        goto Z9PvP;
        m3rxm:
        SbVkY:
        goto p0KwE;
        LEPte:
        $tname = $bl['dlname2'];
        goto j3wvQ;
        FnDss:
        $tname = $bl['dlname1'];
        goto pXbIV;
        pXbIV:
        $cj = 1;
        goto q84L_;
        BEvYR:
        FAhxl:
        goto SpHOg;
        q84L_:
        goto SbVkY;
        goto tKx6s;
        ekDkf:
        $djbl = $bl['dlbl1'];
        goto FnDss;
        vV4lK:
        return $arr;
        goto lZ0np;
        aRlRA:
        $tname = $bl['dlname1'];
        goto daYne;
        SpHOg:
        $djbl = $bl['dlbl3'];
        goto gYVRz;
        a9II8:
        if (!empty($sj)) {
            goto ylSGU;
        }
        goto hMRjR;
        Z9PvP:
        $cj = 1;
        goto xbKLU;
        ReEhR:
        global $_W;
        goto Zfc4Z;
        rUDb9:
        g7eTx:
        goto a9II8;
        aFtC7:
        $arr = array("bl" => $djbl, "tname" => $tname, "cj" => $cj);
        goto vV4lK;
        JdJx5:
        if (!empty($sj)) {
            goto RpZcQ;
        }
        goto bn532;
        CN69V:
        YfjPG:
        goto aFtC7;
        fGnrN:
        goto aR7x8;
        goto BEvYR;
        wm7Fh:
        goto SbVkY;
        goto rUDb9;
        XCACy:
        if ($bl['dltype'] == 2) {
            goto g7eTx;
        }
        goto ekDkf;
        p0KwE:
        if (empty($share['dlbl'])) {
            goto YfjPG;
        }
        goto mXnw6;
        hMRjR:
        $djbl = $bl['dlbl1'];
        goto cCn5h;
        xbKLU:
        goto CmoYz;
        goto oLanE;
        yAmYR:
        CmoYz:
        goto m3rxm;
        j3wvQ:
        $cj = 2;
        goto yAmYR;
        siFWY:
        BhLU0:
        goto wm7Fh;
        i6jJX:
        aR7x8:
        goto siFWY;
        Zfc4Z:
        $sj = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");
        goto Op8K9;
        ABx__:
        if (!empty($sj2)) {
            goto FAhxl;
        }
        goto EPud4;
        BOyvp:
        $djbl = $bl['dlbl2'];
        goto LEPte;
        tKx6s:
        xCfFY:
        goto JdJx5;
        lZ0np:
    }
    public function bydlyj($share, $begin_time, $end_time = "", $zt, $bl, $cfg)
    {
        goto HWHiE;
        onJj8:
        SyjTn:
        goto sDhf3;
        iMfA6:
        if ($bl['dltype'] == 3) {
            goto yTAsO;
        }
        goto n9jDj;
        CLg0e:
        S1B8X:
        goto NXciu;
        LAuG1:
        if (empty($begin_time)) {
            goto H2i5e;
        }
        goto J2KjK;
        tMp4O:
        oyXKk:
        goto hdbMy;
        UsJtp:
        $where = "and addtime>={$begin_time}";
        goto BJKqe;
        zHkkR:
        $sjrs = '0.00';
        goto qzkR8;
        Mh4En:
        return $array;
        goto PQ1Yo;
        ZNIgr:
        if ($zt == 2) {
            goto vwaQc;
        }
        goto TapBZ;
        vdGzt:
        $send_time = strtotime(date('Y-m-d 23:59:59', strtotime(-date('d') . 'day')));
        goto o7VKA;
        mSGPa:
        goto SyjTn;
        goto XGEb9;
        I0eSl:
        if (!($zt == 2)) {
            goto oyXKk;
        }
        goto SaWQU;
        uzJvS:
        $rjrs = $rjrs * (100 - $bl['dlkcbl']) / 100;
        goto hh5d6;
        qzkR8:
        Hv629:
        goto qKFgV;
        Uo5QI:
        if (!($bl['dltype'] == 1)) {
            goto Hv629;
        }
        goto uNuuu;
        lj5AC:
        $r = '';
        goto Z4ob9;
        dTttp:
        XUJ9C:
        goto DZ8Op;
        DZ8Op:
        $rjrs = $r;
        goto wadBk;
        SaWQU:
        $addtime = 'addtime';
        goto tMp4O;
        M2Vz3:
        $ddzt = ' and orderzt=\'订单付款\'';
        goto I_n4Z;
        X1ZCE:
        $rjrs = '0.00';
        goto yYeUf;
        o7VKA:
        if ($cfg['jsms'] == 1) {
            goto e20m5;
        }
        goto tFr17;
        rRFGK:
        $sjrs = '0.00';
        goto oRJhP;
        hXnL4:
        goto iHRof;
        goto CLg0e;
        hh5d6:
        zW1Xg:
        goto PlZgN;
        uAWFS:
        $addtime = 'addtime';
        goto hXnL4;
        WBbzM:
        $sjrs = pdo_fetchcolumn('SELECT sum(t.xgyg) FROM ' . tablename('tiger_newhu_share') . ' s left join ' . tablename('tiger_newhu_tkorder') . " t ON s.tgwid=t.tgwid where s.weid='{$_W['uniacid']}'   and s.dltype=1  {$ddzt} and s.helpid in (" . implode(',', array_keys($fans1)) . ") {$where}");
        goto O0Yji;
        NUufT:
        hWYvF:
        goto vdGzt;
        Z4ob9:
        foreach ($rjshare as $k => $v) {
            goto MilFm;
            WFaga:
            $r = $r + $a;
            goto KuLfp;
            MilFm:
            $a = pdo_fetchcolumn('SELECT sum(xgyg) FROM ' . tablename('tiger_newhu_tkorder') . "  where weid='{$_W['uniacid']}' and tgwid='{$v['tgwid']}' {$ddzt} {$where}");
            goto WFaga;
            KuLfp:
            HE9I9:
            goto xwpuS;
            xwpuS:
        }
        goto dTttp;
        SKuiZ:
        yTAsO:
        goto VNiFa;
        O0Yji:
        ZLrSr:
        goto X7KCu;
        nMn6N:
        if (empty($share['dlbl'])) {
            goto hWYvF;
        }
        goto rWU1H;
        sDhf3:
        $bbegin_time = strtotime(date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), 1, date('Y'))));
        goto k0F6i;
        I_n4Z:
        goto SyjTn;
        goto ywe5x;
        oRJhP:
        GG8rD:
        goto JLSLX;
        HWHiE:
        global $_W;
        goto nMn6N;
        X7KCu:
        if (empty($bl['dlkcbl'])) {
            goto lrIlm;
        }
        goto MvfzW;
        hdbMy:
        z3yuI:
        goto bOuJK;
        n9jDj:
        $sjrs = '0.00';
        goto FBl0F;
        VNiFa:
        $fans1 = pdo_fetchall('select id from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and dltype=1 and helpid='{$share['id']}'", array(), 'id');
        goto mQUuT;
        k0F6i:
        $rjshare = pdo_fetchall('SELECT id,helpid,tgwid FROM ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and helpid='{$share['id']}' and dltype=1");
        goto lj5AC;
        tFr17:
        $addtime = 'addtime';
        goto eXalq;
        yYeUf:
        GmRX9:
        goto iMfA6;
        eXalq:
        goto z3yuI;
        goto PDXPm;
        CBaAs:
        if (empty($begin_time)) {
            goto yJK3J;
        }
        goto UsJtp;
        PlZgN:
        if (!empty($rjrs)) {
            goto GmRX9;
        }
        goto X1ZCE;
        bMR7P:
        wejdl:
        goto OfTve;
        XGEb9:
        vwaQc:
        goto M2Vz3;
        OfTve:
        $ddzt = ' and orderzt=\'订单结算\'';
        goto mSGPa;
        PDXPm:
        e20m5:
        goto DBdMv;
        BJKqe:
        yJK3J:
        goto on2EN;
        JLSLX:
        Dro_o:
        goto Uo5QI;
        QOLH6:
        iHRof:
        goto I0eSl;
        mQUuT:
        if (empty($fans1)) {
            goto ZLrSr;
        }
        goto WBbzM;
        bOuJK:
        if (empty($end_time)) {
            goto wIuLO;
        }
        goto LAuG1;
        J2KjK:
        $where = "and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
        goto Va_Tw;
        wadBk:
        if (empty($bl['dlkcbl'])) {
            goto zW1Xg;
        }
        goto uzJvS;
        rWU1H:
        $bl['dlbl1'] = $share['dlbl'];
        goto NUufT;
        on2EN:
        yqu42:
        goto AWfeG;
        B7Yzv:
        lrIlm:
        goto JU0iO;
        aVDJg:
        goto SyjTn;
        goto bMR7P;
        AWfeG:
        if ($zt == 1) {
            goto wejdl;
        }
        goto ZNIgr;
        OAiqb:
        wIuLO:
        goto CBaAs;
        Ea4pd:
        goto yqu42;
        goto OAiqb;
        ywe5x:
        Zyt1o:
        goto TTIQ9;
        FBl0F:
        goto Dro_o;
        goto SKuiZ;
        DBdMv:
        if ($send_time == $end_time) {
            goto S1B8X;
        }
        goto uAWFS;
        MvfzW:
        $sjrs = $sjrs * (100 - $bl['dlkcbl']) / 100;
        goto B7Yzv;
        TTIQ9:
        $ddzt = ' and orderzt<>\'订单失效\'';
        goto onJj8;
        uNuuu:
        $rjrs = '0.00';
        goto zHkkR;
        JU0iO:
        if (!empty($sjrs)) {
            goto GG8rD;
        }
        goto rRFGK;
        TapBZ:
        if ($zt == 3) {
            goto Zyt1o;
        }
        goto aVDJg;
        NXciu:
        $addtime = 'jstime';
        goto QOLH6;
        qKFgV:
        $array = array("yj2" => $rjrs * $bl['dlbl2'] / 100, "yj3" => $sjrs * $bl['dlbl3'] / 100);
        goto Mh4En;
        Va_Tw:
        H2i5e:
        goto Ea4pd;
        PQ1Yo:
    }
    public function dljiangli($endprice, $tkrate, $bl, $share)
    {
        goto HpCT_;
        kkWP8:
        $jryj = $yj * $bl['dlbl2t3'] / 100;
        goto iN2ei;
        sRtFB:
        QLHqo:
        goto PEnxe;
        cbBWj:
        pbtWI:
        goto cT6YQ;
        Mvp6p:
        YmYsa:
        goto k6MSY;
        PEnxe:
        $jrzyj = $yj - $jryj - $jrsjyj;
        goto rqqR3;
        B44uC:
        goto Vqun1;
        goto Mvp6p;
        XJp7e:
        xH2s5:
        goto ywVeX;
        dApNU:
        $dlyj = $dlyj * (100 - $bl['dlkcbl']) / 100;
        goto XJp7e;
        HpCT_:
        global $_W;
        goto uZH8V;
        rqqR3:
        file_put_contents(IA_ROOT . '/addons/tiger_tkxcx/yj_log.txt', '
' . 'uid:' . $share['id'] . '------' . $yj . '-' . $jryj . '-' . $jrsjyj . '=' . $jrzyj, FILE_APPEND);
        goto HQ8ki;
        jo7_w:
        $dlrate = number_format($dlyj * $dlbl / 100, 2);
        goto P6DyT;
        xHkuQ:
        if ($bl['dltype'] == 2) {
            goto JiDbQ;
        }
        goto Egq9u;
        uTzEl:
        goto QLHqo;
        goto Tehcc;
        wynqo:
        $jryj = $yj * $bl['dlbl1t2'] / 100;
        goto T0J_E;
        KJYIR:
        goto FdLgS;
        goto z99UX;
        kNfWE:
        if ($bl['fxtype'] == 1) {
            goto MJmYY;
        }
        goto vrRsF;
        Tehcc:
        JiDbQ:
        goto lswY8;
        z99UX:
        hzW3H:
        goto OiTez;
        uZH8V:
        $dlyj = $endprice * $tkrate / 100;
        goto ssFv4;
        E1S30:
        if (empty($share['dlbl'])) {
            goto pbtWI;
        }
        goto i09bY;
        cT6YQ:
        $dlbl = $bl['dlbl1'];
        goto PsujK;
        P3eJv:
        goto VIiLk;
        goto FEuix;
        i09bY:
        $dlbl = $fs['bl'];
        goto qby1C;
        P6DyT:
        VIiLk:
        goto YRlJ6;
        kM7vH:
        fY2Fm:
        goto DyXIF;
        FewuX:
        d0lGl:
        goto wCxvw;
        MBLhc:
        KrnwV:
        goto FGa_c;
        Egq9u:
        if ($bl['dltype'] == 3) {
            goto fY2Fm;
        }
        goto uTzEl;
        HQ8ki:
        $dlrate = number_format($jrzyj, 2);
        goto P3eJv;
        AjOvW:
        Vqun1:
        goto KJYIR;
        ywVeX:
        $fs = $this->jcbl($share, $bl);
        goto E1S30;
        FEuix:
        MJmYY:
        goto jo7_w;
        FGa_c:
        goto QLHqo;
        goto kM7vH;
        wCxvw:
        $jryj = 0;
        goto MBLhc;
        prw6w:
        FdLgS:
        goto sRtFB;
        DyXIF:
        if (empty($share['helpid'])) {
            goto hzW3H;
        }
        goto noSJc;
        YRlJ6:
        return $dlrate;
        goto Ki1BI;
        MIz1T:
        $jrsjyj = $yj * $bl['dlbl1t3'] / 100;
        goto B44uC;
        vrRsF:
        $yj = number_format($dlyj * $dlbl / 100, 2);
        goto xHkuQ;
        T0J_E:
        goto KrnwV;
        goto FewuX;
        noSJc:
        $sjshare = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$share['weid']}'and dltype=1 and id='{$share['helpid']}'");
        goto kkWP8;
        PsujK:
        PR0nW:
        goto kNfWE;
        lswY8:
        if (empty($share['helpid'])) {
            goto d0lGl;
        }
        goto wynqo;
        OiTez:
        $jryj = 0;
        goto prw6w;
        ssFv4:
        if (empty($bl['dlkcbl'])) {
            goto xH2s5;
        }
        goto dApNU;
        k6MSY:
        $jrsjyj = 0;
        goto AjOvW;
        qby1C:
        goto PR0nW;
        goto cbBWj;
        iN2ei:
        if (empty($sjshare['helpid'])) {
            goto YmYsa;
        }
        goto MIz1T;
        Ki1BI:
    }
    public function ptyjjl($endprice, $tkrate, $cfg)
    {
        goto dONkb;
        Nc3Ni:
        if (!empty($yongj)) {
            goto Op8Pi;
        }
        goto q6fWr;
        Wbrkr:
        if ($cfg['fxtype'] == 1) {
            goto ZSB6z;
        }
        goto slb6k;
        dONkb:
        global $_W;
        goto OKbx4;
        P1fQS:
        goto lH_Xv;
        goto XJU_3;
        bWaPJ:
        Op8Pi:
        goto Wbrkr;
        bxrzL:
        goto lH_Xv;
        goto dpo_J;
        slb6k:
        if ($cfg['fxtype'] == 2) {
            goto WeROU;
        }
        goto bxrzL;
        dpo_J:
        ZSB6z:
        goto jZgPN;
        aDgYZ:
        $yongj = $yj * $cfg['zgf'] / 100;
        goto Nc3Ni;
        XJU_3:
        WeROU:
        goto s67cJ;
        q6fWr:
        $yongj = '0.00';
        goto bWaPJ;
        OKbx4:
        $yj = $endprice * $tkrate / 100;
        goto aDgYZ;
        hjslj:
        $yj1 = intval($yj1);
        goto P1fQS;
        K4sog:
        lH_Xv:
        goto B6NIt;
        s67cJ:
        $yj1 = number_format($yongj, 2);
        goto K4sog;
        jZgPN:
        $yj1 = $yongj * $cfg['jfbl'];
        goto hjslj;
        B6NIt:
        return $yj1;
        goto NQrNi;
        NQrNi:
    }
    public function sharejl($endprice, $tkrate, $bl, $share, $cfg)
    {
        goto idpGc;
        duSZv:
        af5Mn:
        goto pdBmn;
        clOHM:
        $yj = $this->ptyjjl($endprice, $tkrate, $cfg);
        goto IZoYc;
        BLBzk:
        XcmoQ:
        goto S0wEN;
        pdBmn:
        $yj = $this->dljiangli($endprice, $tkrate, $bl, $share);
        goto BLBzk;
        IZoYc:
        goto XcmoQ;
        goto duSZv;
        idpGc:
        if ($share['dltype'] == 1) {
            goto af5Mn;
        }
        goto clOHM;
        S0wEN:
        return $yj;
        goto Zc2q6;
        Zc2q6:
    }
    public function tkljx($msg)
    {
        goto zQTzC;
        p1o3H:
        $c = new TopClient();
        goto R6qDg;
        aAW1n:
        $resp = $c->execute($req);
        goto HFlld;
        DrT33:
        $secret = $cfg['jqtksecretKey'];
        goto wh7LQ;
        rmH0t:
        if ($cfg['jqtkAppKey']) {
            goto uYSp3;
        }
        goto tcgNP;
        zQTzC:
        global $_W, $_GPC;
        goto Z7qt3;
        DEwQZ:
        $req = new WirelessShareTpwdQueryRequest();
        goto Pmr3C;
        v5ZKt:
        $appkey = $cfg['jqtkAppKey'];
        goto DrT33;
        E_1t3:
        uYSp3:
        goto v5ZKt;
        R6qDg:
        $c->appkey = $appkey;
        goto CQjmG;
        s3p87:
        goto tldYS;
        goto E_1t3;
        cLnNm:
        $secret = $cfg['tksecretKey'];
        goto s3p87;
        tcgNP:
        $appkey = $cfg['tkAppKey'];
        goto cLnNm;
        wh7LQ:
        tldYS:
        goto p1o3H;
        g2VO2:
        return $jsonArray;
        goto khlMS;
        Z7qt3:
        $cfg = $this->module['config'];
        goto rmH0t;
        Pmr3C:
        $req->setPasswordContent($msg);
        goto aAW1n;
        HFlld:
        $jsonStr = json_encode($resp);
        goto ULE5o;
        CQjmG:
        $c->secretKey = $secret;
        goto DEwQZ;
        ULE5o:
        $jsonArray = json_decode($jsonStr, true);
        goto g2VO2;
        khlMS:
    }
    public function mc_jl($uid, $type, $typelx, $num, $remark, $orderid)
    {
        goto Q8CIN;
        q9YkK:
        goto kbPBs;
        goto vAxwj;
        Q8CIN:
        global $_W;
        goto PGB_k;
        ZGRwb:
        icFT2:
        goto rSgjk;
        bqHlp:
        $res = pdo_update($this->modulename . '_share', array("credit2" => $credit2), array("id" => $uid));
        goto MM8RY;
        hnn2J:
        kbPBs:
        goto LBr6U;
        lh1yO:
        return array("error" => 0, "data" => "积分更新失败");
        goto WVAD9;
        dQE9M:
        $data = array("uid" => $uid, "weid" => $_W['uniacid'], "type" => $type, "typelx" => $typelx, "num" => $num, "remark" => $remark, "orderid" => $orderid, "createtime" => time());
        goto a6etP;
        uPdL6:
        return array("error" => 1, "data" => "积分更新成功");
        goto VnLoB;
        qyYB8:
        if ($inst === false) {
            goto GxeBU;
        }
        goto bXrNo;
        l97i9:
        return array("error" => 0, "data" => "积分不足");
        goto YzDtJ;
        MM8RY:
        if ($res === false) {
            goto eytOQ;
        }
        goto V__gq;
        tq1k7:
        $inst = pdo_insert($this->modulename . '_jl', $data);
        goto sA5gS;
        SINQw:
        $res = pdo_update($this->modulename . '_share', array("credit1" => $credit1), array("id" => $uid));
        goto eyMmA;
        A8POg:
        if (!($credit2 < 0)) {
            goto c8c6y;
        }
        goto t8SNf;
        BMmYq:
        goto kbPBs;
        goto ctfny;
        t8SNf:
        return array("error" => 0, "data" => "余额不足");
        goto H2F13;
        u86DP:
        goto Ha4Tr;
        goto dXv2U;
        eyMmA:
        if ($res === false) {
            goto icFT2;
        }
        goto tq1k7;
        PGB_k:
        if (!empty($uid)) {
            goto Nqa7g;
        }
        goto i8zWT;
        V__gq:
        $inst = pdo_insert($this->modulename . '_jl', $data);
        goto qyYB8;
        gJVDQ:
        if (!($credit1 < 0)) {
            goto BZ_mu;
        }
        goto l97i9;
        ctfny:
        JeqGS:
        goto w2w75;
        OkIbH:
        goto WeZlT;
        goto ZGRwb;
        w8Lz8:
        F58IY:
        goto lh1yO;
        O9TTQ:
        WeZlT:
        goto hnn2J;
        vAxwj:
        U39U1:
        goto Nk8h_;
        sjZiA:
        Ha4Tr:
        goto UzUPw;
        b0V5G:
        eytOQ:
        goto CALKZ;
        SsHKy:
        Nqa7g:
        goto dQE9M;
        Jfe3s:
        if ($type == 0) {
            goto JeqGS;
        }
        goto q9YkK;
        sA5gS:
        if ($inst === false) {
            goto F58IY;
        }
        goto uPdL6;
        CALKZ:
        return array("error" => 0, "data" => "余额更新失败");
        goto UGMvr;
        w2w75:
        $credit1 = $share['credit1'] + $num;
        goto gJVDQ;
        UGMvr:
        I90Va:
        goto BMmYq;
        rSgjk:
        return array("error" => 0, "data" => "积分更新失败");
        goto O9TTQ;
        Nk8h_:
        $credit2 = $share['credit2'] + $num;
        goto A8POg;
        bXrNo:
        return array("error" => 1, "data" => "余额更新成功");
        goto u86DP;
        UzUPw:
        goto I90Va;
        goto b0V5G;
        dXv2U:
        GxeBU:
        goto dyyXo;
        VnLoB:
        goto TAg2k;
        goto w8Lz8;
        a6etP:
        $share = pdo_fetch('SELECT credit1,credit2 FROM ' . tablename($this->modulename . '_share') . " WHERE id='{$uid}' and weid='{$_W['uniacid']}' ");
        goto VECGB;
        VECGB:
        if ($type == 1) {
            goto U39U1;
        }
        goto Jfe3s;
        H2F13:
        c8c6y:
        goto bqHlp;
        i8zWT:
        return;
        goto SsHKy;
        dyyXo:
        return array("error" => 0, "data" => "余额更新失败");
        goto sjZiA;
        WVAD9:
        TAg2k:
        goto OkIbH;
        YzDtJ:
        BZ_mu:
        goto SINQw;
        LBr6U:
    }
    public function islogin()
    {
        goto OEZUB;
        bSCdd:
        $mc = mc_fetch($fans['openid']);
        goto i3vj6;
        mKLLO:
        return $fans;
        goto LRXuB;
        r81tB:
        $share = pdo_fetch('select * from ' . tablename($this->modulename . '_share') . " where weid='{$_W['uniacid']}' and id='{$_SESSION['tkuid']}'");
        goto iZA2P;
        iZA2P:
        OFgj4:
        goto bSCdd;
        OH_i3:
        if (empty($_SESSION['openid'])) {
            goto OFgj4;
        }
        goto lXrBj;
        lXrBj:
        $fans['openid'] = $_SESSION['openid'];
        goto r81tB;
        i3vj6:
        $fans = array("id" => $_SESSION['tkuid'], "tkuid" => $_SESSION['tkuid'], "wquid" => $mc['uid'], "credit1" => $share['credit1'], "credit2" => $share['credit2'], "nickname" => $share['nickname'], "avatar" => $share['avatar'], "helpid" => $share['helpid'], "dlptpid" => $share['dlptpid'], "unionid" => $share['unionid'], "from_user" => $share['from_user'], "openid" => $share['from_user'], "createtime" => $share['createtime'], "tgwid" => $share['tgwid'], "cqtype" => $share['cqtype'], "dltype" => $share['dltype'], "status" => $share['status']);
        goto mKLLO;
        OEZUB:
        global $_W;
        goto OH_i3;
        LRXuB:
    }
    public function doMobileLogin()
    {
        goto Uto9_;
        hurg2:
        if (!$_W['isajax']) {
            goto W0ZDq;
        }
        goto S1JO5;
        SWttK:
        $_SESSION['unionid'] = $share['unionid'];
        goto CYQja;
        JVaHp:
        $pid = $_GPC['pid'];
        goto SEhkd;
        CYQja:
        $_SESSION['pid'] = $share['dlptpid'];
        goto IbIZN;
        S1JO5:
        $username = trim($_GPC['username']);
        goto ZEC2N;
        wINRL:
        exit(json_encode(array("status" => 0, "msg" => "帐号密码错误", "tzurl" => urldecode($tzurl))));
        goto V0ct3;
        q13dY:
        if ($username == $share['pcuser'] && $password == $share['pcpasswords']) {
            goto GKTYM;
        }
        goto wINRL;
        TiHUQ:
        gvsAP:
        goto MZSpt;
        FzwDx:
        $_SESSION['username'] = $share['pcuser'];
        goto kNB86;
        kNB86:
        $_SESSION['tkuid'] = $share['id'];
        goto VkeiA;
        IbIZN:
        exit(json_encode(array("status" => 1, "msg" => "登录成功", "tzurl" => urldecode($tzurl))));
        goto TiHUQ;
        MqgvI:
        include $this->template('login');
        goto QxDzD;
        SEhkd:
        $tzurl = $_GPC['tzurl'];
        goto ZyECm;
        xVFQ4:
        GKTYM:
        goto FzwDx;
        Uto9_:
        global $_GPC, $_W;
        goto Tu6Uo;
        iLgWj:
        $share = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_share') . " WHERE pcuser='{$username}' and weid='{$_W['uniacid']}' ");
        goto q13dY;
        ZyECm:
        $fans = mc_oauth_userinfo();
        goto hurg2;
        VkeiA:
        $_SESSION['openid'] = $share['from_user'];
        goto SWttK;
        ZEC2N:
        $password = trim($_GPC['password']);
        goto iLgWj;
        MZSpt:
        W0ZDq:
        goto MqgvI;
        V0ct3:
        goto gvsAP;
        goto xVFQ4;
        Tu6Uo:
        $cfg = $this->module['config'];
        goto JVaHp;
        QxDzD:
    }
    public function doMobileLoginout()
    {
        goto oNFn2;
        w50Di:
        exit(json_encode(array("status" => 1, "msg" => "退出登录成功")));
        goto uLOti;
        oNFn2:
        session_unset();
        goto H6tqX;
        H6tqX:
        session_destroy();
        goto w50Di;
        uLOti:
    }
    public function doMobilebdLogin()
    {
        goto xL11S;
        JWITs:
        $share = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_share') . " WHERE from_user='{$openid}' and weid='{$_W['uniacid']}' ");
        goto ibuGy;
        fmt6C:
        if (!empty($share['id'])) {
            goto Vmr4X;
        }
        goto jHeT_;
        a6089:
        if (!$_W['isajax']) {
            goto lo8Ev;
        }
        goto yITPa;
        ibuGy:
        if (empty($share['id'])) {
            goto pEUwX;
        }
        goto Mw53K;
        VoyAr:
        XSrWg:
        goto Avo46;
        u5mz6:
        if (empty($sharepcuser['id'])) {
            goto pOYRy;
        }
        goto mB3Le;
        yhQdr:
        zpURG:
        goto fmt6C;
        Avo46:
        pdo_update($this->modulename . '_share', $usdata, array("weid" => $_W['uniacid'], "id" => $share['id']));
        goto sKXQ9;
        M1CiY:
        exit(json_encode(array("status" => 0, "msg" => "用户不存在，请先关注公众号")));
        goto KYiDW;
        iIfSy:
        $usdata = array("pcuser" => $username, "pcpasswords" => $password);
        goto a6089;
        Tlcrl:
        Vmr4X:
        goto fCANl;
        QX_Dq:
        $username = trim($_GPC['username']);
        goto sewb2;
        siYhe:
        pEUwX:
        goto ZQeuj;
        UrqcH:
        if (!empty($share['id'])) {
            goto XSrWg;
        }
        goto M1CiY;
        mB3Le:
        exit(json_encode(array("status" => 0, "msg" => "手机号已经存在！")));
        goto zO_J4;
        BK1eQ:
        $unionid = $_GPC['unionid'];
        goto QX_Dq;
        sKXQ9:
        ArImG:
        goto yhQdr;
        KYiDW:
        goto ArImG;
        goto VoyAr;
        nEt_V:
        exit(json_encode(array("status" => 1, "msg" => "绑定成功！")));
        goto JBkuh;
        yITPa:
        if (!empty($openid)) {
            goto H06ey;
        }
        goto LVjNB;
        kgbtI:
        if (!($aaa !== 'false')) {
            goto adOrX;
        }
        goto nEt_V;
        LVjNB:
        exit(json_encode(array("status" => 0, "msg" => "请在微信端绑定")));
        goto sZ7Hc;
        RLeEi:
        $openid = $_GPC['openid'];
        goto BK1eQ;
        fCANl:
        lo8Ev:
        goto oDwRc;
        J0ePu:
        $cfg = $this->module['config'];
        goto aOAKS;
        ZQeuj:
        $share = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_share') . " WHERE unionid='{$unionid}' and weid='{$_W['uniacid']}' ");
        goto UrqcH;
        jHeT_:
        exit(json_encode(array("status" => 0, "msg" => "用户不存在，请先关注公众号")));
        goto Tlcrl;
        xL11S:
        global $_GPC, $_W;
        goto J0ePu;
        oDwRc:
        include $this->template('bdlogin');
        goto um3fB;
        HkD80:
        $sharepcuser = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_share') . " WHERE pcuser='{$username}' and weid='{$_W['uniacid']}' ");
        goto u5mz6;
        Mw53K:
        $aaa = pdo_update($this->modulename . '_share', $usdata, array("weid" => $_W['uniacid'], "id" => $share['id']));
        goto kgbtI;
        JBkuh:
        adOrX:
        goto oKAHE;
        oKAHE:
        exit(json_encode(array("status" => 0, "msg" => $aaa)));
        goto tx9Y2;
        aOAKS:
        $fans = mc_oauth_userinfo();
        goto RLeEi;
        tx9Y2:
        goto zpURG;
        goto siYhe;
        sZ7Hc:
        H06ey:
        goto HkD80;
        zO_J4:
        pOYRy:
        goto JWITs;
        sewb2:
        $password = trim($_GPC['password']);
        goto iIfSy;
        um3fB:
    }
    public function sjrd44($length = 4)
    {
        goto txhRK;
        vAffW:
        Ux1Tg:
        goto GRMRJ;
        XZvm0:
        if (!($i < $length)) {
            goto Ux1Tg;
        }
        goto Mc9nd;
        gPbE1:
        ce3qp:
        goto YmAWW;
        txhRK:
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        goto DBrK3;
        GRMRJ:
        return $str;
        goto uFiSl;
        oelUy:
        Xy_VQ:
        goto XZvm0;
        YmAWW:
        $i++;
        goto i4k2e;
        u_vkJ:
        $i = 0;
        goto oelUy;
        i4k2e:
        goto Xy_VQ;
        goto vAffW;
        Mc9nd:
        $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        goto gPbE1;
        DBrK3:
        $str = '';
        goto u_vkJ;
        uFiSl:
    }
    public function getimg($url, $path = "", $_W)
    {
        goto yzUyM;
        jEoht:
        ob_end_clean();
        goto CspFH;
        KQlig:
        !file_exists($path) && mkdir($path, 0777, true);
        goto lAUc4;
        yzUyM:
        empty($path) && ($path = IA_ROOT . '/addons/tiger_newhu/goodsimg/' . date('Ymd'));
        goto KQlig;
        WSD0h:
        $sctime = date('YmdHis') . $this->sjrd44(6);
        goto MwilK;
        u16Vl:
        GIllC:
        goto WSD0h;
        TUk4M:
        fwrite($fp, $img);
        goto eOiye;
        JTD74:
        return $_W['siteroot'] . 'addons/tiger_newhu/goodsimg/' . date('Ymd') . '/' . $sctime . '.png';
        goto bR0HC;
        eOiye:
        fclose($fp);
        goto JTD74;
        LVMD8:
        return false;
        goto u16Vl;
        FrPUT:
        ob_start();
        goto S0YNZ;
        S0YNZ:
        readfile($url);
        goto VI8GX;
        lAUc4:
        if (!($url == '')) {
            goto GIllC;
        }
        goto LVMD8;
        VI8GX:
        $img = ob_get_contents();
        goto jEoht;
        CspFH:
        $fp = fopen($filename, 'a');
        goto TUk4M;
        MwilK:
        $filename = $path . '/' . $sctime . '.png';
        goto FrPUT;
        bR0HC:
    }
    public function doMobileTupian()
    {
        goto RFygX;
        U7Xg4:
        $url = urldecode($_GPC['url']);
        goto JHxTm;
        Xq11C:
        $cfg = $this->module['config'];
        goto YO3CT;
        T6WuD:
        $price = $_GPC['price'];
        goto RXeL2;
        YO3CT:
        $title = urldecode($_GPC['title']);
        goto T6WuD;
        uuRJB:
        picjialidun($_W, $title, $price, $yhj, $orprice, $xiaol, $jrprice, $taoimage, $ewm);
        goto YHLRW;
        I63jF:
        $orprice = $_GPC['orprice'];
        goto Jbbnj;
        GhsBs:
        $ewm = $this->getimg('http://bshare.optimix.asia/barCode?site=weixin&url=' . $url, '', $_W);
        goto uuRJB;
        LQpBR:
        $taoimage = $_GPC['taoimage'];
        goto U7Xg4;
        RFygX:
        global $_GPC, $_W;
        goto Xq11C;
        RXeL2:
        $yhj = $_GPC['yhj'];
        goto I63jF;
        V2do5:
        $url = $urlarr;
        goto GhsBs;
        JHxTm:
        include IA_ROOT . '/addons/tiger_newhu/inc/sdk/tbk/tb.php';
        goto MSBd3;
        MSBd3:
        $urlarr = $this->dwzw($url);
        goto V2do5;
        Oqc5B:
        $jrprice = $_GPC['jrprice'];
        goto LQpBR;
        Jbbnj:
        $xiaol = $_GPC['xiaol'];
        goto Oqc5B;
        YHLRW:
    }
    public function getfc($string, $len = 2)
    {
        goto mrxsb;
        ff9Ah:
        S41DD:
        goto lILL_;
        OcP8o:
        $array[] = mb_substr($string, $start, $len, 'utf8');
        goto ZBQF4;
        GNcEM:
        $strlen = mb_strlen($string);
        goto TJYFv;
        TJYFv:
        goto S41DD;
        goto V2V2i;
        mrxsb:
        $string = str_replace(' ', '', $string);
        goto oA4ix;
        tsgyS:
        $strlen = mb_strlen($string);
        goto ff9Ah;
        lILL_:
        if (!$strlen) {
            goto DZXYj;
        }
        goto OcP8o;
        oA4ix:
        $start = 0;
        goto tsgyS;
        SKVXq:
        return $array;
        goto Vhfrp;
        V2V2i:
        DZXYj:
        goto SKVXq;
        ZBQF4:
        $string = mb_substr($string, $len, $strlen, 'utf8');
        goto GNcEM;
        Vhfrp:
    }
    public function curl_request($url, $post = "", $cookie = "", $returnCookie = 0)
    {
        goto jjfxT;
        XaIdZ:
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        goto Ya_gQ;
        nStKd:
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        goto ioBQw;
        Y_638:
        goto bKN7Z;
        goto kPCzv;
        k7P6K:
        yRKmS:
        goto Y_638;
        jXwfA:
        curl_setopt($curl, CURLOPT_POST, 1);
        goto pQd3d;
        kPCzv:
        H6Ue7:
        goto Kddnz;
        JKeIC:
        return $data;
        goto r5ZNx;
        pLpM7:
        return curl_error($curl);
        goto tUWZw;
        Eh_ta:
        return $info;
        goto LGfvl;
        GPouR:
        if ($cookies == '') {
            goto Iwf0d;
        }
        goto XSSZm;
        TW1Qu:
        if ($returnCookie) {
            goto HyfMj;
        }
        goto JKeIC;
        pY8qh:
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        goto FlpHo;
        DluWb:
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        goto XaIdZ;
        VTSqJ:
        bKN7Z:
        goto tdbcV;
        Ya_gQ:
        $data = curl_exec($curl);
        goto f9Orq;
        hz15a:
        $info['content'] = $body;
        goto Eh_ta;
        cBoOK:
        list($header, $body) = explode('

', $data, 2);
        goto EH1yd;
        jjfxT:
        $curl = curl_init();
        goto JRZ4O;
        ICxx5:
        if (!$cookie) {
            goto fTC7p;
        }
        goto JJKlB;
        KvLfm:
        Iwf0d:
        goto P8h6C;
        LGfvl:
        pgreB:
        goto ubON3;
        f9Orq:
        if (!curl_errno($curl)) {
            goto RnwdK;
        }
        goto pLpM7;
        UmTzY:
        goto yRKmS;
        goto KvLfm;
        FlpHo:
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        goto B7zs5;
        V5Kcz:
        j9uA5:
        goto ICxx5;
        ioBQw:
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; 	Trident/6.0)');
        goto pY8qh;
        B7zs5:
        curl_setopt($curl, CURLOPT_REFERER, 'http://XXX');
        goto tOfsq;
        JRZ4O:
        curl_setopt($curl, CURLOPT_URL, $url);
        goto nStKd;
        tOfsq:
        if (!$post) {
            goto j9uA5;
        }
        goto jXwfA;
        P8h6C:
        $cookies = $val;
        goto k7P6K;
        Kddnz:
        $info['cookie'] = substr($cookies, 1);
        goto hz15a;
        JJKlB:
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        goto KeEcy;
        XSSZm:
        $cookies = $cookies . '; ' . $val;
        goto UmTzY;
        pQd3d:
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        goto V5Kcz;
        tUWZw:
        RnwdK:
        goto EfG1H;
        EH1yd:
        preg_match_all('/Set\\-Cookie:([^;]*);/', $header, $matches);
        goto VTSqJ;
        KeEcy:
        fTC7p:
        goto XG2Fx;
        XG2Fx:
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        goto DluWb;
        ddzKm:
        HyfMj:
        goto cBoOK;
        r5ZNx:
        goto pgreB;
        goto ddzKm;
        EfG1H:
        curl_close($curl);
        goto TW1Qu;
        tdbcV:
        if (!(list($key, $val) = each($matches[1]))) {
            goto H6Ue7;
        }
        goto GPouR;
        ubON3:
    }
    public function strurl($coupons_url)
    {
        goto UV_tP;
        En6Km:
        kCxE9:
        goto EV38N;
        Qj2M5:
        $wz = strpos($url, $activity_id);
        goto upuFj;
        UV_tP:
        $url = strtolower($coupons_url);
        goto p_uC0;
        Ur4Ra:
        $wz = strpos($url, $activity_id);
        goto sMUme;
        sMUme:
        if (empty($wz)) {
            goto kCxE9;
        }
        goto kaHf0;
        cHfIX:
        MtvdT:
        goto uL_Pe;
        kaHf0:
        return substr($url, $wz + 12, 32);
        goto FgcU1;
        EV38N:
        $activity_id = 'activityid=';
        goto Qj2M5;
        upuFj:
        return substr($url, $wz + 11, 32);
        goto cHfIX;
        p_uC0:
        $activity_id = 'activity_id=';
        goto Ur4Ra;
        FgcU1:
        goto MtvdT;
        goto En6Km;
        uL_Pe:
    }
    public function doMobileLjtkl()
    {
        goto LH3u5;
        a_cIq:
        die(json_encode(array("tkl" => $tkl)));
        goto EWVgI;
        LH3u5:
        global $_W, $_GPC;
        goto ihJTR;
        FFc_r:
        $img = urldecode($_GPC['img']);
        goto a7BPF;
        ymF8Y:
        $tkl = $this->tkl($url, $img, $tjcontent);
        goto a_cIq;
        ihJTR:
        $url = urldecode($_GPC['url']);
        goto FFc_r;
        a7BPF:
        $tjcontent = $_GPC['title'];
        goto ymF8Y;
        EWVgI:
    }
    public function tkl($url, $img, $tjcontent)
    {
        goto pWXS2;
        rGuTd:
        $taokou = str_replace('《', '￥', $taokou);
        goto pIRtb;
        g5QqU:
        $c->secretKey = $secret;
        goto s0B8a;
        Qn1xh:
        $jsonArray = json_decode($jsonStr, true);
        goto Bw0XW;
        JQc0v:
        $secret = $cfg['tksecretKey'];
        goto BhOc6;
        AJc4f:
        if (empty($cfg['tklleft'])) {
            goto FbPFd;
        }
        goto UIgVo;
        TJAvz:
        $req->setText($tjcontent);
        goto O_auS;
        Bw0XW:
        $taokou = $jsonArray['data']['model'];
        goto UprN9;
        I48PW:
        $req->setExt('{}');
        goto gLvdx;
        pIRtb:
        SeiHT:
        goto AJc4f;
        ADRgj:
        FbPFd:
        goto oXtCJ;
        fHEVz:
        $c->appkey = $appkey;
        goto g5QqU;
        x9m9z:
        $cfg = $this->module['config'];
        goto hBf7d;
        hBf7d:
        $appkey = $cfg['tkAppKey'];
        goto JQc0v;
        R3F0i:
        $taokou = $cfg['tklleft'] . $taokou . $cfg['tklright'];
        goto ADRgj;
        PeC6E:
        $jsonStr = json_encode($resp);
        goto Qn1xh;
        oXtCJ:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/tkl_log.txt', '
' . $url . '------' . $img . '-----' . $tjcontent . '------' . json_encode($jsonArray), FILE_APPEND);
        goto OtJJN;
        wcvxq:
        $req->setLogo($img);
        goto I48PW;
        pWXS2:
        global $_W, $_GPC;
        goto x9m9z;
        O_auS:
        $req->setUrl($url);
        goto wcvxq;
        OtJJN:
        return $taokou;
        goto DVDBE;
        gLvdx:
        $resp = $c->execute($req);
        goto PeC6E;
        BhOc6:
        $c = new TopClient();
        goto fHEVz;
        UIgVo:
        $taokou = str_replace('￥', '', $taokou);
        goto R3F0i;
        s0B8a:
        $req = new TbkTpwdCreateRequest();
        goto TJAvz;
        UprN9:
        if (!($cfg['tklnewtype'] == 1)) {
            goto SeiHT;
        }
        goto rGuTd;
        DVDBE:
    }
    public function doMobileSq88888888()
    {
        goto CBeq1;
        BKbAh:
        $tkurl2 = $_W['setting']['site']['url'];
        goto AW8rQ;
        QoiAD:
        $host = $_SERVER['HTTP_HOST'];
        goto XEd2e;
        AW8rQ:
        $tkip = $this->get_server_ip();
        goto dq9FA;
        KYeix:
        $s = pdo_fetchall('select settings from ' . tablename('uni_account_modules') . ' where module=\'tiger_newhu\'');
        goto rti_u;
        dq9FA:
        echo '使用域名:' . $host . '<br>';
        goto lHGne;
        yJKm0:
        $tbuid = $cfg['tbuid'];
        goto RYGY0;
        lHGne:
        echo '淘ID:' . $tbuid . '<br>';
        goto GSQwa;
        JhnWp:
        $cfg = $this->module['config'];
        goto QoiAD;
        XEd2e:
        $host = strtolower($host);
        goto yJKm0;
        bHtfF:
        exit;
        goto YE7rM;
        rti_u:
        foreach ($s as $k => $v) {
            goto FyiBI;
            OGJQi:
            P9zOb:
            goto z6CM9;
            FyiBI:
            $b = unserialize($v['settings']);
            goto fAKR4;
            fAKR4:
            echo ',' . $b['tbuid'];
            goto OGJQi;
            z6CM9:
        }
        goto TWWWI;
        QNKZ4:
        echo 'tkip:' . $tkip . '<br>';
        goto KYeix;
        CBeq1:
        global $_W, $_GPC;
        goto pZ5t1;
        WTTUO:
        echo 'cs';
        goto bHtfF;
        TWWWI:
        WzMPY:
        goto eSTYG;
        YE7rM:
        KlkVZ:
        goto JhnWp;
        pZ5t1:
        if (!($_GPC['my'] != 'tigernewhu')) {
            goto KlkVZ;
        }
        goto WTTUO;
        GSQwa:
        echo '域名:' . $tkurl2 . '<br>';
        goto QNKZ4;
        RYGY0:
        $tkurl1 = $host;
        goto BKbAh;
        eSTYG:
    }
    public function oldtkl($url, $img, $tjcontent)
    {
        goto jFjEK;
        HQjbE:
        $tpwd_param->text = $tjcontent;
        goto SkaFl;
        Uo6Xz:
        $tpwd_param->ext = '{"":""}';
        goto kYXXe;
        oLAlg:
        $c->appkey = $appkey;
        goto ZaZuL;
        Fo_ng:
        settype($taokou, 'string');
        goto XweJZ;
        SkaFl:
        $tpwd_param->url = $url;
        goto LxBvz;
        ZaZuL:
        $c->secretKey = $secret;
        goto O_t2a;
        szirv:
        $cfg = $this->module['config'];
        goto MdLTz;
        NxfwP:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/oldtkl_log.txt', '
' . json_encode($resp), FILE_APPEND);
        goto hCkGY;
        DN_PL:
        $secret = $cfg['tksecretKey'];
        goto EQmGZ;
        stuEs:
        $taokou = $resp->model;
        goto Fo_ng;
        EiZ7q:
        $resp = $c->execute($req);
        goto stuEs;
        MdLTz:
        $appkey = $cfg['tkAppKey'];
        goto DN_PL;
        jFjEK:
        global $_W, $_GPC;
        goto szirv;
        S_VeT:
        ENSiQ:
        goto NxfwP;
        XweJZ:
        if (!($cfg['tklnewtype'] == 1)) {
            goto ENSiQ;
        }
        goto hxQrf;
        M5jfe:
        $tpwd_param = new GenPwdIsvParamDto();
        goto Uo6Xz;
        hxQrf:
        $taokou = str_replace('《', '￥', $taokou);
        goto S_VeT;
        O_t2a:
        $req = new WirelessShareTpwdCreateRequest();
        goto M5jfe;
        hCkGY:
        return $taokou;
        goto izsDf;
        EQmGZ:
        $c = new TopClient();
        goto oLAlg;
        LxBvz:
        $req->setTpwdParam(json_encode($tpwd_param));
        goto EiZ7q;
        kYXXe:
        $tpwd_param->logo = $img;
        goto HQjbE;
        izsDf:
    }
    public function hlinorder($userInfo, $_W)
    {
        goto qWCg5;
        hARhL:
        H8moj:
        goto DEZOj;
        uHe3Y:
        $cfg = $this->module['config'];
        goto PyPLt;
        qWCg5:
        global $_W, $_GPC;
        goto uHe3Y;
        PyPLt:
        foreach ($userInfo as $v) {
            goto VKQDN;
            NFc_M:
            weyvm:
            goto G6Nvt;
            VKQDN:
            $fztype = pdo_fetch('select * from ' . tablename($this->modulename . '_fztype') . " where weid='{$_W['uniacid']}' and hlcid='{$v['fqcat']}' order by px desc");
            goto WtK9_;
            gdmo8:
            goto Q0hDX;
            goto NFc_M;
            CeADv:
            $item = array("weid" => $_W['uniacid'], "fqcat" => $fztype['id'], "zy" => 2, "quan_id" => $Quan_id, "itemid" => $v['itemid'], "itemtitle" => $v['itemtitle'], "itemshorttitle" => $v['itemshorttitle'], "itemdesc" => $v['itemdesc'], "itemprice" => $v['itemprice'], "itemsale" => $v['itemsale'], "itemsale2" => $v['itemsale2'], "conversion_ratio" => $v['conversion_ratio'], "itempic" => $v['itempic'], "itemendprice" => $v['itemendprice'], "shoptype" => $v['shoptype'], "userid" => $v['userid'], "sellernick" => $v['sellernick'], "tktype" => $v['tktype'], "tkrates" => $v['tkrates'], "ctrates" => $v['ctrates'], "cuntao" => $v['cuntao'], "tkmoney" => $v['tkmoney'], "tkurl" => $v['tkurl'], "couponurl" => $v['couponurl'], "planlink" => $v['planlink'], "couponmoney" => $v['couponmoney'], "couponsurplus" => $v['couponsurplus'], "couponreceive" => $v['couponreceive'], "couponreceive2" => $v['couponreceive2'], "couponnum" => $v['couponnum'], "couponexplain" => $v['couponexplain'], "couponstarttime" => $v['couponstarttime'], "couponendtime" => $v['couponendtime'], "starttime" => $v['starttime'], "isquality" => $v['isquality'], "item_status" => $v['item_status'], "report_status" => $v['report_status'], "is_brand" => $v['is_brand'], "is_live" => $v['is_live'], "videoid" => $v['videoid'], "activity_type" => $v['activity_type'], "createtime" => TIMESTAMP);
            goto Dg1KP;
            alCcA:
            pdo_update($this->modulename . '_newtbgoods', $item, array("weid" => $_W['uniacid'], "itemid" => $v['itemid']));
            goto gdmo8;
            WtK9_:
            $Quan_id = $this->strurl($v['couponurl']);
            goto CeADv;
            pfZws:
            if (empty($go)) {
                goto weyvm;
            }
            goto alCcA;
            FaFqb:
            OuOO2:
            goto ZzaZX;
            Dg1KP:
            $go = pdo_fetch('SELECT id FROM ' . tablename($this->modulename . '_newtbgoods') . " WHERE weid='{$_W['uniacid']}' and itemid='{$v['itemid']}' ORDER BY id desc");
            goto pfZws;
            y4bSX:
            Q0hDX:
            goto FaFqb;
            G6Nvt:
            pdo_insert($this->modulename . '_newtbgoods', $item);
            goto y4bSX;
            ZzaZX:
        }
        goto hARhL;
        DEZOj:
    }
    public function indtkgoods($dtklist)
    {
        goto iI1E_;
        E6v_7:
        foreach ($dtklist as $v) {
            goto AFEW0;
            RAkYp:
            O2cne:
            goto SrM2X;
            Qo8lK:
            $yjbl = $v['Commission_jihua'];
            goto w1j5b;
            Hbn8x:
            $lxtype = '通用计划';
            goto BwGkq;
            nY0fL:
            xm3bP:
            goto j1I8l;
            mtfzu:
            Df86f:
            goto RAkYp;
            lVrMn:
            d7_sb:
            goto L6oKo;
            Cx9mO:
            goto P4XMT;
            goto nY0fL;
            CxwoR:
            $go = pdo_fetch('SELECT itemid FROM ' . tablename($this->modulename . '_newtbgoods') . " WHERE weid = '{$_W['uniacid']}' and  itemid={$v['GoodsID']} ");
            goto WrFdn;
            h9Z4X:
            if ($v['Commission_jihua'] != '0.00') {
                goto xm3bP;
            }
            goto Hbn8x;
            Hd59s:
            pdo_update($this->modulename . '_newtbgoods', $item, array("weid" => $_W['uniacid'], "itemid" => $v['GoodsID']));
            goto JCUSL;
            BwGkq:
            $yjbl = $v['Commission_jihua'];
            goto NC0Gq;
            WrFdn:
            if (empty($go)) {
                goto d7_sb;
            }
            goto Hd59s;
            L6oKo:
            pdo_insert($this->modulename . '_newtbgoods', $item);
            goto mtfzu;
            j1I8l:
            $lxtype = '营销计划';
            goto Qo8lK;
            oxgvs:
            $shoptype = 'C';
            goto YSEts;
            FSc45:
            $item = array("weid" => $_W['uniacid'], "fqcat" => $fztype['id'], "zy" => 1, "tktype" => $lxtype, "itemid" => $v['GoodsID'], "itemtitle" => $v['Title'], "itemdesc" => $v['Introduce'], "itempic" => $v['Pic'], "itemendprice" => $v['Price'], "itemsale" => $v['Sales_num'], "tkrates" => $yjbl, "couponreceive" => $v['Quan_receive'], "couponsurplus" => $v['Quan_surplus'], "couponmoney" => $v['Quan_price'], "couponendtime" => strtotime($v['Quan_time']), "couponurl" => $v['Quan_link'], "shoptype" => $shoptype, "quan_id" => $v['Quan_id'], "couponexplain" => $v['Quan_condition'], "itemprice" => $v['Org_Price'], "tkurl" => $v['Jihua_link'], "createtime" => TIMESTAMP);
            goto CxwoR;
            JCUSL:
            goto Df86f;
            goto lVrMn;
            uyVrY:
            $yjbl = $v['Commission_queqiao'];
            goto Cx9mO;
            AFEW0:
            $fztype = pdo_fetch('select * from ' . tablename($this->modulename . '_fztype') . " where weid='{$_W['uniacid']}' and dtkcid='{$v['Cid']}' order by px desc");
            goto uAl91;
            JmaDN:
            KZ24l:
            goto CXTcP;
            WJkpw:
            $lxtype = '鹊桥活动';
            goto uyVrY;
            wsEUo:
            aK0Rf:
            goto WJkpw;
            NC0Gq:
            goto P4XMT;
            goto wsEUo;
            uAl91:
            if ($v['Commission_queqiao'] != '0.00') {
                goto aK0Rf;
            }
            goto h9Z4X;
            YSEts:
            goto iUNyr;
            goto JmaDN;
            AgVqu:
            iUNyr:
            goto FSc45;
            CXTcP:
            $shoptype = 'B';
            goto AgVqu;
            w1j5b:
            P4XMT:
            goto B2oB2;
            B2oB2:
            if ($v['IsTmall'] == 1) {
                goto KZ24l;
            }
            goto oxgvs;
            SrM2X:
        }
        goto foowl;
        vfBCp:
        $cfg = $this->module['config'];
        goto E6v_7;
        GXuTf:
        $page = $_GPC['page'];
        goto vfBCp;
        foowl:
        R2rbv:
        goto XSTGn;
        iI1E_:
        global $_W, $_GPC;
        goto GXuTf;
        XSTGn:
    }
    public function apUpload($media_id)
    {
        goto TenD5;
        wXr_7:
        load()->classs('weixin.account');
        goto YPp1N;
        V02bS:
        $fp = fopen($targetName, 'wb');
        goto xy005;
        ilYeP:
        curl_setopt($ch, CURLOPT_HEADER, 0);
        goto bYGW1;
        cIA0G:
        fclose($fp);
        goto FALPm;
        dGkS6:
        curl_close($ch);
        goto cIA0G;
        xy005:
        curl_setopt($ch, CURLOPT_FILE, $fp);
        goto ilYeP;
        OH2Hj:
        if (is_dir($newfolder)) {
            goto DxkdW;
        }
        goto YoRZ7;
        FALPm:
        return $picurl;
        goto QWRY7;
        oUyRs:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/log.txt', '
 old:' . json_encode($media_id), FILE_APPEND);
        goto S53n8;
        TenD5:
        global $_W, $_GPC;
        goto wXr_7;
        qR60X:
        $picurl = 'images' . '/tiger_newhu_photos' . '/' . date('YmdHis') . rand(1000, 9999) . '.jpg';
        goto c67nr;
        oBmEc:
        $ch = curl_init($url);
        goto V02bS;
        fy94W:
        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=' . $access_token . '&media_id=' . $media_id;
        goto JeqKJ;
        YPp1N:
        $accObj = WeixinAccount::create($_W['uniacid']);
        goto Gz9YU;
        JeqKJ:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/log.txt', '
 old:' . json_encode($access_token), FILE_APPEND);
        goto oUyRs;
        Gz9YU:
        $access_token = $accObj->fetch_token();
        goto fy94W;
        c67nr:
        $targetName = ATTACHMENT_ROOT . $picurl;
        goto oBmEc;
        XBJO9:
        DxkdW:
        goto qR60X;
        YoRZ7:
        mkdir($newfolder, 7777);
        goto XBJO9;
        bYGW1:
        curl_exec($ch);
        goto dGkS6;
        S53n8:
        $newfolder = ATTACHMENT_ROOT . 'images' . '/tiger_newhu_photos' . '/';
        goto OH2Hj;
        QWRY7:
    }
    public function dwz($url)
    {
        goto N5c2l;
        Eta6h:
        $urlarr = $this->zydwz($turl);
        goto riQbx;
        X97jZ:
        $cfg = $this->module['config'];
        goto gzkV2;
        hmNmH:
        EEUC1:
        goto Hd_0F;
        lB5Jv:
        $url = $this->wxdwz($turl);
        goto wCOrz;
        WUC71:
        $turl = $_W['siteroot'] . str_replace('./', 'app/', $this->createMobileurl('openlink', array("link" => $url)));
        goto SIIpu;
        Q6lPB:
        R6DIV:
        goto lB5Jv;
        wCOrz:
        Wf7mB:
        goto u4dCZ;
        Hd_0F:
        $url = $this->sinadwz($turl);
        goto e8jkf;
        N5c2l:
        global $_W;
        goto X97jZ;
        e8jkf:
        goto Wf7mB;
        goto Q6lPB;
        gzkV2:
        $url = urlencode($url);
        goto WUC71;
        riQbx:
        goto Wf7mB;
        goto hmNmH;
        SIIpu:
        if ($cfg['dwzlj'] == 0) {
            goto EEUC1;
        }
        goto qJEpI;
        qJEpI:
        if ($cfg['dwzlj'] == 1) {
            goto R6DIV;
        }
        goto Eta6h;
        u4dCZ:
    }
    public function dwzw($turl)
    {
        goto Dpo9d;
        XLjre:
        X2hLv:
        goto X8_cu;
        vpUCy:
        SyrHQ:
        goto hl_Ik;
        FkLTB:
        $cfg = $this->module['config'];
        goto q4d5s;
        Ay1um:
        goto SyrHQ;
        goto XLjre;
        q4d5s:
        if ($cfg['dwzlj'] == 0) {
            goto gIiBH;
        }
        goto k2yBa;
        X8_cu:
        $url = $this->wxdwz($turl);
        goto vpUCy;
        MhSiA:
        $url = $this->zydwz($turl);
        goto nF3kp;
        Sn4F5:
        $url = $this->sinadwz($turl);
        goto Ay1um;
        k2yBa:
        if ($cfg['dwzlj'] == 1) {
            goto X2hLv;
        }
        goto MhSiA;
        hl_Ik:
        return $url;
        goto Umy5x;
        nF3kp:
        goto SyrHQ;
        goto zrRWS;
        zrRWS:
        gIiBH:
        goto Sn4F5;
        Dpo9d:
        global $_W;
        goto FkLTB;
        Umy5x:
    }
    public function zydwz($turl)
    {
        goto FffQF;
        tCV7M:
        $data = array("weid" => $_W['uniacid'], "url" => $turl, "createtime" => TIMESTAMP);
        goto EY53U;
        ksueW:
        $url = $cfg['zydwz'] . 't.php?d=' . $id;
        goto QgQQx;
        yp26T:
        $cfg = $this->module['config'];
        goto tCV7M;
        EY53U:
        pdo_insert('tiger_newhu_dwz', $data);
        goto Szrx1;
        Szrx1:
        $id = pdo_insertid();
        goto ksueW;
        QgQQx:
        return $url;
        goto wm3Db;
        FffQF:
        global $_W;
        goto yp26T;
        wm3Db:
    }
    public function wxdwz($url)
    {
        goto lwIUP;
        rLrYR:
        $access_token = $this->getAccessToken();
        goto x4Hb9;
        eGU1x:
        $content = @json_decode($ret['content'], true);
        goto sfnso;
        x4Hb9:
        $url = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token={$access_token}";
        goto RgPs2;
        RgPs2:
        $ret = ihttp_request($url, $result);
        goto eGU1x;
        lwIUP:
        $result = '{"action":"long2short","long_url":"' . $url . '"}';
        goto rLrYR;
        sfnso:
        return $content['short_url'];
        goto eT7bw;
        eT7bw:
    }
    public function sinadwz($url)
    {
        goto TzAe_;
        s1r3I:
        $json = ihttp_get($sinaurl);
        goto Uby6L;
        C9SFJ:
        $sinaurl = "http://api.t.sina.com.cn/short_url/shorten.json?source={$key}&url_long={$turl2}";
        goto i5p1z;
        DiG7g:
        return $result[0]['url_short'];
        goto mjPkQ;
        TzAe_:
        global $_W;
        goto jXKPX;
        LdceZ:
        YsZPl:
        goto YcUuF;
        WuIZ8:
        GJ0V3:
        goto Wfrr5;
        DLFYv:
        goto YsZPl;
        goto WuIZ8;
        jXKPX:
        $cfg = $this->module['config'];
        goto nqXPZ;
        i5p1z:
        load()->func('communication');
        goto s1r3I;
        Wfrr5:
        $key = '1549359964';
        goto LdceZ;
        bh3pd:
        $result = @json_decode($json['content'], true);
        goto DiG7g;
        mY2Zx:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/log--sina.txt', '
--3' . json_encode($json), FILE_APPEND);
        goto bh3pd;
        Uby6L:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/log--sina.txt', '
--3' . $url, FILE_APPEND);
        goto mY2Zx;
        YcUuF:
        $turl2 = urlencode($url);
        goto C9SFJ;
        nqXPZ:
        if (empty($cfg['sinkey'])) {
            goto GJ0V3;
        }
        goto Rr7X3;
        Rr7X3:
        $key = trim($cfg['sinkey']);
        goto DLFYv;
        mjPkQ:
    }
    public function addtbgoods($data)
    {
        goto Ypq2U;
        Ya6cf:
        pdo_insert($this->modulename . '_tbgoods', $data);
        goto nzTrT;
        kwzMt:
        shh8Y:
        goto JCftt;
        UEWlg:
        if (!empty($data['num_iid'])) {
            goto Q5nfk;
        }
        goto hUEnR;
        vQhoh:
        goto CJ7JK;
        goto MBvmp;
        xsxBR:
        Q5nfk:
        goto OW5bw;
        hUEnR:
        return '';
        goto xsxBR;
        ShPjt:
        pdo_update($this->modulename . '_tbgoods', $data, array("weid" => $data['weid'], "num_iid" => $data['num_iid']));
        goto vQhoh;
        nzTrT:
        CJ7JK:
        goto kwzMt;
        Ypq2U:
        $cfg = $this->module['config'];
        goto MxwxY;
        MxwxY:
        if (!($cfg['cxrk'] == 1)) {
            goto shh8Y;
        }
        goto UEWlg;
        WnI4d:
        if (empty($go)) {
            goto uPZaO;
        }
        goto ShPjt;
        MBvmp:
        uPZaO:
        goto Ya6cf;
        OW5bw:
        $go = pdo_fetch('SELECT id FROM ' . tablename($this->modulename . '_tbgoods') . " WHERE weid = '{$data['weid']}' and  num_iid='{$data['num_iid']}'");
        goto WnI4d;
        JCftt:
    }
    public function mygetID($url)
    {
        goto C2F_6;
        nVkXh:
        goto qhlNL;
        goto w501Z;
        w501Z:
        kyfDc:
        goto HeIPy;
        C2F_6:
        if (preg_match('/[\\?&]id=(\\d+)/', $url, $match)) {
            goto kyfDc;
        }
        goto A3OC5;
        Nqsvo:
        qhlNL:
        goto tmHVI;
        HeIPy:
        return $match[1];
        goto Nqsvo;
        A3OC5:
        return '';
        goto nVkXh;
        tmHVI:
    }
    public function getyouhui2($str)
    {
        preg_match_all('|(￥[^￥]+￥)|ism', $str, $matches);
        return $matches[1][0];
    }
    public function geturl($str)
    {
        goto F6Iko;
        pSBJq:
        return '';
        goto gUE8i;
        jtYPJ:
        goto PHKQv;
        goto Ojy0d;
        F6Iko:
        $exp = explode('http', $str);
        goto zDyxn;
        zDyxn:
        $url = 'http' . trim($exp[1]) . ' ';
        goto q3qrj;
        gUE8i:
        PHKQv:
        goto GcFDU;
        Ojy0d:
        jJVeN:
        goto pSBJq;
        DbKS8:
        $url = substr($url, 0, $matches[0][1]);
        goto cMaLs;
        cMaLs:
        if ($url == 'http') {
            goto jJVeN;
        }
        goto ppfzg;
        ppfzg:
        return $url;
        goto jtYPJ;
        q3qrj:
        preg_match('/[\\s]/u', $url, $matches, PREG_OFFSET_CAPTURE);
        goto DbKS8;
        GcFDU:
    }
    public function myisexists($url)
    {
        goto HDtAY;
        QeZ2l:
        return 1;
        goto kWbPa;
        xCQ5J:
        XntzJ:
        goto z9y0T;
        HDtAY:
        if (stripos($url, 'taobao.com') !== false) {
            goto qoyc3;
        }
        goto o6UDX;
        o6UDX:
        if (stripos($url, 'tmall.com') !== false) {
            goto XntzJ;
        }
        goto bZZsJ;
        kWbPa:
        goto jv1A6;
        goto XtMpI;
        z9y0T:
        return 2;
        goto eiWsW;
        eiWsW:
        goto jv1A6;
        goto Dfo6R;
        ouivL:
        return 2;
        goto TI0vo;
        IR8_P:
        return 0;
        goto RQNQM;
        kwx3t:
        return 2;
        goto rjdxM;
        Dfo6R:
        McxJ9:
        goto ouivL;
        rjdxM:
        goto jv1A6;
        goto xCQ5J;
        TI0vo:
        jv1A6:
        goto IR8_P;
        bZZsJ:
        if (stripos($url, 'tmall.hk') !== false) {
            goto McxJ9;
        }
        goto QeZ2l;
        XtMpI:
        qoyc3:
        goto kwx3t;
        RQNQM:
    }
    public function jdgoodsID($url)
    {
        goto EZmpe;
        ml3yP:
        if (!empty($goodsid)) {
            goto JxS1E;
        }
        goto PoSDY;
        S15u2:
        JxS1E:
        goto lhaAe;
        EZmpe:
        $goodsid = $this->Text_qzj($url, '?sku=', '&');
        goto ml3yP;
        Hl5U8:
        if (!empty($goodsid)) {
            goto hg65Z;
        }
        goto VWLap;
        lhaAe:
        if (!empty($goodsid)) {
            goto JfsDn;
        }
        goto Z09X_;
        VWLap:
        $goodsid = $this->jdgoods($url);
        goto NXSBw;
        Z09X_:
        $goodsid = $this->Text_qzj($url, 'com/', '.html');
        goto AwQU8;
        AwQU8:
        JfsDn:
        goto Hl5U8;
        NXSBw:
        hg65Z:
        goto i_IxV;
        PoSDY:
        $goodsid = $this->Text_qzj($url, 'product/', '.html');
        goto S15u2;
        i_IxV:
        return $goodsid;
        goto dAzCc;
        dAzCc:
    }
    public function pddgoodsID($url)
    {
        goto DiSKJ;
        cpZQR:
        JjdIU:
        goto HB8se;
        uXJz0:
        return '';
        goto Bwqol;
        HB8se:
        return $match[1];
        goto ryVr2;
        ryVr2:
        unkdx:
        goto dG_4D;
        DiSKJ:
        if (preg_match('/[\\?&]goods_id=(\\d+)/', $url, $match)) {
            goto JjdIU;
        }
        goto uXJz0;
        Bwqol:
        goto unkdx;
        goto cpZQR;
        dG_4D:
    }
    public function pdddwzw($turl)
    {
        goto eh8Xp;
        q6yOc:
        $url = $this->zydwz($turl);
        goto oAhaz;
        eh8Xp:
        global $_W;
        goto H2nrp;
        H2nrp:
        $cfg = $this->module['config'];
        goto q6yOc;
        oAhaz:
        return $url;
        goto CRIb7;
        CRIb7:
    }
    public function getgoodsid($url)
    {
        goto cqiwu;
        hD0yc:
        UJVRO:
        goto ZetXz;
        ULMsT:
        return $goodsid;
        goto FPFGr;
        IIW03:
        NRe0c:
        goto Wp06p;
        Wp06p:
        if (!empty($goodsid)) {
            goto c2k7_;
        }
        goto RAGEd;
        YWhln:
        if (!empty($goodsid)) {
            goto NRe0c;
        }
        goto kPsVH;
        EAz5s:
        if (!empty($goodsid)) {
            goto AcmD_;
        }
        goto KhsGu;
        zHJzL:
        if (!empty($goodsid)) {
            goto UJVRO;
        }
        goto thBRu;
        X8r1Y:
        i0cW4:
        goto alaZT;
        cqiwu:
        $str = $url;
        goto rcQVO;
        KhsGu:
        $goodsid = $this->Text_qzj($str, 'itemid=', '&');
        goto oDhP7;
        i6qPy:
        $url = $this->Text_qzj($str, 'url = \'', '\';');
        goto q4gUo;
        kPsVH:
        $goodsid = $this->Text_qzj($str, 'itemId=', '&');
        goto IIW03;
        j3qnf:
        OVVXu:
        goto EAz5s;
        rcQVO:
        $goodsid = $this->Text_qzj($str, '?id=', '&');
        goto zHJzL;
        alaZT:
        if (!empty($goodsid)) {
            goto OVVXu;
        }
        goto i6qPy;
        TDaXB:
        $goodsid = $this->Text_qzj($str, 'itemId:', ',');
        goto X8r1Y;
        RM8Mf:
        c2k7_:
        goto ULMsT;
        RAGEd:
        $goodsid = $this->Text_qzj($str, 'itemId%3D', '%26');
        goto RM8Mf;
        q4gUo:
        $goodsid = $this->Text_qzj($str, 'com/i', '.htm');
        goto j3qnf;
        ZetXz:
        if (!empty($goodsid)) {
            goto i0cW4;
        }
        goto TDaXB;
        thBRu:
        $goodsid = $this->Text_qzj($str, '&id=', '&');
        goto hD0yc;
        oDhP7:
        AcmD_:
        goto YWhln;
        FPFGr:
    }
    public function hqgoodsid($url)
    {
        goto amVIs;
        MxKUg:
        return $goodsid;
        goto m8RLp;
        QtgHY:
        $goodsid = $this->Text_qzj($str, '?id=', '&');
        goto tvLw9;
        WWseb:
        I4_dJ:
        goto MxKUg;
        aEAUK:
        if (!empty($goodsid)) {
            goto I4_dJ;
        }
        goto Zr8X2;
        Trq6f:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/log.txt', '
' . $str, FILE_APPEND);
        goto QtgHY;
        TUubj:
        if (!empty($goodsid)) {
            goto EKcMm;
        }
        goto RyFtn;
        TYioi:
        dzhGv:
        goto TUubj;
        tvLw9:
        if (!empty($goodsid)) {
            goto dzhGv;
        }
        goto N5wtV;
        Zr8X2:
        $url = $this->Text_qzj($str, 'url = \'', '\';');
        goto WwbAa;
        t9bfa:
        EKcMm:
        goto aEAUK;
        amVIs:
        $str = file_get_contents($url);
        goto xmvvT;
        N5wtV:
        $goodsid = $this->Text_qzj($str, '&id=', '&');
        goto TYioi;
        RyFtn:
        $goodsid = $this->Text_qzj($str, 'itemId:', ',');
        goto t9bfa;
        xmvvT:
        $str = str_replace('"', '', $str);
        goto Trq6f;
        WwbAa:
        $goodsid = $this->Text_qzj($str, 'com/i', '.htm');
        goto E1sEu;
        E1sEu:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/log.txt', '
' . json_encode($goodsid), FILE_APPEND);
        goto WWseb;
        m8RLp:
    }
    public function Text_qzj($Text, $Front, $behind)
    {
        goto rOiAd;
        s9ly1:
        IT2fC:
        goto BGtIf;
        kdmTM:
        $t2 = mb_strpos($temp, $behind);
        goto HuoUa;
        yg5Cu:
        return mb_substr($temp, 0, $t2);
        goto r0mpb;
        QqTug:
        if ($t1 == FALSE) {
            goto IT2fC;
        }
        goto Fg_bI;
        gClGz:
        goto sN7tW;
        goto s9ly1;
        BGtIf:
        return '';
        goto esqs6;
        HuoUa:
        if (!($t2 == FALSE)) {
            goto e1PHs;
        }
        goto T3Dyi;
        y3t8Q:
        e1PHs:
        goto yg5Cu;
        rOiAd:
        $t1 = mb_strpos('.' . $Text, $Front);
        goto QqTug;
        T3Dyi:
        return '';
        goto y3t8Q;
        Y8Zff:
        $temp = mb_substr($Text, $t1, strlen($Text) - $t1);
        goto kdmTM;
        esqs6:
        sN7tW:
        goto Y8Zff;
        Fg_bI:
        $t1 = $t1 - 1 + strlen($Front);
        goto gClGz;
        r0mpb:
    }
    function gstr($str)
    {
        goto IXiba;
        D0yZ2:
        suQHR:
        goto LjaTL;
        LjaTL:
        return $str;
        goto TAbDS;
        IXiba:
        $encode = mb_detect_encoding($str, array("ASCII", "UTF-8", "GB2312", "GBK"));
        goto b8Owf;
        b8Owf:
        if (!(!$encode == 'UTF-8')) {
            goto suQHR;
        }
        goto VIsf_;
        VIsf_:
        $str = iconv('UTF-8', $encode, $str);
        goto D0yZ2;
        TAbDS:
    }
    public function ewm($url)
    {
        goto QmQYF;
        WChTW:
        $matrixPointSize = '4';
        goto vnXRK;
        RO22h:
        $value = $url;
        goto KyITK;
        NdrEI:
        exit;
        goto zhlmh;
        KyITK:
        $errorCorrectionLevel = 'L';
        goto WChTW;
        vnXRK:
        QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize);
        goto NdrEI;
        QmQYF:
        include 'phpqrcode.php';
        goto RO22h;
        zhlmh:
    }
    public function sendNews($openid, $text)
    {
        goto j_2AB;
        lEKE2:
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        goto hViB_;
        j_2AB:
        global $_W, $_GPC;
        goto aVLY9;
        Jtri2:
        $access_token = $this->getAccessToken();
        goto lEKE2;
        aVLY9:
        $url = $_W['siteroot'] . str_replace('./', 'app/', $this->createMobileurl('index'));
        goto ewpVQ;
        hViB_:
        $ret = ihttp_request($url, $result);
        goto u7160;
        u7160:
        return $ret;
        goto RwdFJ;
        MGT7M:
        $result = urldecode(json_encode($custom));
        goto Jtri2;
        ewpVQ:
        $custom = array("touser" => $openid, "msgtype" => "news", "news" => array("articles" => array(array("title" => urlencode('晒单奖励提醒'), "description" => urlencode($text), "url" => $url, "picurl" => ""))));
        goto MGT7M;
        RwdFJ:
    }
    public function postText($openid, $text)
    {
        goto F63iQ;
        DPk1z:
        return $ret;
        goto sFeJm;
        F63iQ:
        $post = '{"touser":"' . $openid . '","msgtype":"text","text":{"content":"' . $text . '"}}';
        goto JEI9O;
        JEI9O:
        $ret = $this->postRes($this->getAccessToken(), $post);
        goto DPk1z;
        sFeJm:
    }
    private function postRes($access_token, $data)
    {
        goto HUo0X;
        HUo0X:
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        goto V26_a;
        U2Up4:
        $ret = ihttp_request($url, $data);
        goto Js4oy;
        V26_a:
        load()->func('communication');
        goto U2Up4;
        Js4oy:
        $content = @json_decode($ret['content'], true);
        goto Yue8v;
        Yue8v:
        return $content['errcode'];
        goto q5JCQ;
        q5JCQ:
    }
    private function getAccessToken()
    {
        goto zSewY;
        k6zHR:
        include IA_ROOT . '/addons/tiger_newhu/wxtoken.php';
        goto jepGV;
        jepGV:
        return $token;
        goto jZuyr;
        EDFt7:
        if (!empty($acid)) {
            goto f6Ksb;
        }
        goto yGz1X;
        zSewY:
        global $_W;
        goto FHI0d;
        PveUW:
        f6Ksb:
        goto k6zHR;
        yGz1X:
        $acid = $_W['uniacid'];
        goto PveUW;
        gf683:
        $acid = $_W['acid'];
        goto EDFt7;
        FHI0d:
        load()->model('account');
        goto gf683;
        jZuyr:
    }
    public function createRule($kword, $pid)
    {
        goto YZSWy;
        T1jye:
        $rule['type'] = 1;
        goto uaany;
        AroTa:
        pdo_update($this->modulename . '_poster', array("rid" => $rule['rid']), array("id" => $pid));
        goto bGSzh;
        IaaQf:
        pdo_insert('rule_keyword', $rule);
        goto bVjY4;
        EMcpB:
        $rule = array("uniacid" => $_W['uniacid'], "name" => $this->modulename, "module" => $this->modulename, "status" => 1, "displayorder" => 254);
        goto ATRLb;
        YZSWy:
        global $_W;
        goto EMcpB;
        uaany:
        $rule['rid'] = pdo_insertid();
        goto hd2KX;
        hd2KX:
        $rule['content'] = $kword;
        goto IaaQf;
        FRC81:
        unset($rule['name']);
        goto T1jye;
        bVjY4:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/log.txt', '
 old:' . json_encode($pid . '----' . $rule['rid']), FILE_APPEND);
        goto AroTa;
        ATRLb:
        pdo_insert('rule', $rule);
        goto FRC81;
        bGSzh:
    }
    public function get_device_type()
    {
        goto ZAUrf;
        Bdkb_:
        $type = 'android';
        goto yoC2w;
        ZAUrf:
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        goto ZAL0J;
        ZAL0J:
        $type = 'android';
        goto ZCOiS;
        yoC2w:
        IDisS:
        goto nJL7H;
        NAHXQ:
        if (!strpos($agent, 'android')) {
            goto IDisS;
        }
        goto Bdkb_;
        Tkv1n:
        yRWbT:
        goto NAHXQ;
        nJL7H:
        return $type;
        goto jKPu7;
        qKu14:
        $type = 'ios';
        goto Tkv1n;
        ZCOiS:
        if (!(strpos($agent, 'iphone') || strpos($agent, 'ipad'))) {
            goto yRWbT;
        }
        goto qKu14;
        jKPu7:
    }
    public function gettaogoods($numid, $api)
    {
        goto CyVII;
        QNj0C:
        $req->setNumIids($numid);
        goto NYmj4;
        hXEIg:
        $c->secretKey = $secretKey;
        goto u2UKw;
        cPvbu:
        $secretKey = $api['secretKey'];
        goto e97Gu;
        NvR7J:
        $c->appkey = $appkey;
        goto hXEIg;
        u2UKw:
        $req = new TbkItemInfoGetRequest();
        goto BjjOe;
        qkDa8:
        $arr = $resp['results']['n_tbk_item'];
        goto aMuEI;
        CyVII:
        $c = new TopClient();
        goto eCvg8;
        eVaBf:
        IR2G5:
        goto NvR7J;
        BjjOe:
        $req->setFields('num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick,shop_dsr,ratesum,i_rfd_rate,h_good_rate,h_pay_rate30');
        goto nytFH;
        FL12B:
        $appkey = $api['tkAppKey'];
        goto BlZo2;
        SBTZB:
        $resp = json_decode(json_encode($resp), TRUE);
        goto qkDa8;
        nytFH:
        $req->setPlatform('1');
        goto QNj0C;
        aMuEI:
        return $arr;
        goto haTL0;
        eCvg8:
        $appkey = $api['appkey'];
        goto cPvbu;
        BlZo2:
        $secretKey = $api['tksecretKey'];
        goto eVaBf;
        e97Gu:
        if (!empty($appkey)) {
            goto IR2G5;
        }
        goto FL12B;
        NYmj4:
        $resp = $c->execute($req);
        goto SBTZB;
        haTL0:
    }
    public function goodlist($key, $pid, $page)
    {
        goto ZVS9Q;
        oK4qw:
        $c->secretKey = $api['secretKey'];
        goto ib1_u;
        xd5IV:
        $c->appkey = $api['appkey'];
        goto oK4qw;
        w1jy_:
        $resp = $c->execute($req);
        goto to7Ty;
        hHtuB:
        $api = taobaopp($tiger);
        goto AWeQt;
        aIHHi:
        $req->setQ($key);
        goto Hnv5p;
        w98iN:
        return $list;
        goto rahSo;
        wm2OD:
        $req->setPid($pid);
        goto w1jy_;
        cBg3Q:
        $goods = $resp['results']['tbk_coupon'];
        goto jKw3P;
        to7Ty:
        $resp = json_decode(json_encode($resp), TRUE);
        goto cBg3Q;
        AWeQt:
        $c = new TopClient();
        goto xd5IV;
        Zbba_:
        $req->setPlatform('2');
        goto Cmll7;
        cv499:
        T9TlW:
        goto w98iN;
        Hnv5p:
        $req->setPageNo($page);
        goto wm2OD;
        Cmll7:
        $req->setPageSize('20');
        goto aIHHi;
        ib1_u:
        $req = new TbkItemCouponGetRequest();
        goto Zbba_;
        jKw3P:
        foreach ($goods as $k => $v) {
            goto jv1eE;
            Mszv2:
            $list[$k]['goods_sale'] = $v['volume'];
            goto Cyrmg;
            q82c4:
            $list[$k]['org_price'] = $v['zk_final_price'];
            goto zwgGm;
            e6vJH:
            $list[$k]['shop_title'] = $v['shop_title'];
            goto ZYWpr;
            y08f6:
            gA1n1:
            goto GJmbk;
            bZ_5a:
            $list[$k]['num_iid'] = $v['num_iid'];
            goto lXPDx;
            lXPDx:
            $list[$k]['url'] = $v['coupon_click_url'];
            goto mkwSs;
            RnH1H:
            $list[$k]['coupons_price'] = $matches[2][0];
            goto Mszv2;
            PQV0M:
            preg_match_all('|满([\\d\\.]+).*元减([\\d\\.]+).*元|ism', $v['coupon_info'], $matches);
            goto RnH1H;
            nl5Ex:
            $list[$k]['small_images'] = $v['small_images']['string'];
            goto J16F8;
            PYU38:
            $list[$k]['coupons_take'] = $v['coupon_remain_count'];
            goto bnLOW;
            mkwSs:
            $list[$k]['coupons_end'] = $v['coupon_end_time'];
            goto PQV0M;
            jv1eE:
            $list[$k]['title'] = $v['title'];
            goto t3Po5;
            bnLOW:
            $list[$k]['coupons_total'] = $v['coupon_total_count'];
            goto oLt5T;
            oLt5T:
            $list[$k]['item_url'] = $v['item_url'];
            goto nl5Ex;
            Cyrmg:
            $list[$k]['price'] = $v['zk_final_price'] - $matches[2][0];
            goto q82c4;
            ZYWpr:
            $list[$k]['tk_rate'] = $v['commission_rate'];
            goto h2_vs;
            zwgGm:
            $list[$k]['pic_url'] = $v['pict_url'];
            goto e6vJH;
            h2_vs:
            $list[$k]['nick'] = $v['nick'];
            goto PYU38;
            J16F8:
            $list[$k]['pic_url'] = $v['pict_url'];
            goto y08f6;
            t3Po5:
            $list[$k]['istmall'] = $v['user_type'];
            goto bZ_5a;
            GJmbk:
        }
        goto cv499;
        ZVS9Q:
        require_once IA_ROOT . '/addons/tiger_newhu/inc/sdk/getpic.php';
        goto hHtuB;
        rahSo:
    }
    public function rhy($quan_id, $num_iid, $pid)
    {
        $url = 'https://uland.taobao.com/coupon/edetail?activityId=' . $quan_id . '&itemId=' . $num_iid . '&src=tiger_tiger&pid=' . $pid . '';
        return $url;
    }
    public function rhydx($quan_id, $num_iid, $pid)
    {
        $url = 'https://uland.taobao.com/coupon/edetail?activityId=' . $quan_id . '&itemId=' . $num_iid . '&src=tiger_tiger&pid=' . $pid . '&dx=1';
        return $url;
    }
    private function sendtext($txt, $openid)
    {
        goto FRAId;
        F6B8g:
        include IA_ROOT . '/addons/tiger_newhu/wxtoken.php';
        goto fBpOg;
        hD7Uo:
        return $data;
        goto DbVWv;
        fBpOg:
        $data = $account->sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array("content" => urlencode($txt))));
        goto hD7Uo;
        uirkL:
        aG8rW:
        goto F6B8g;
        SaeDj:
        if ($acid) {
            goto aG8rW;
        }
        goto tiNrF;
        uA4ep:
        $acid = $_W['account']['acid'];
        goto SaeDj;
        tiNrF:
        $acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account') . ' WHERE uniacid=:uniacid ', array(":uniacid" => $_W['uniacid']));
        goto uirkL;
        FRAId:
        global $_W;
        goto uA4ep;
        DbVWv:
    }
    function GetIpLookup($ip = "")
    {
        goto NdS4G;
        NdS4G:
        if (!empty($ip)) {
            goto LKroP;
        }
        goto IqNny;
        cQxDd:
        return false;
        goto b17kN;
        ynwPL:
        unset($json['ret']);
        goto b8q_Z;
        PPS5r:
        LKroP:
        goto H17pX;
        PWrz2:
        $json = json_decode($jsonMatches[0], true);
        goto wSX9M;
        b8q_Z:
        WEzGD:
        goto g8nw8;
        F43OE:
        $jsonMatches = array();
        goto ceb0l;
        aOfCl:
        fIGWH:
        goto xQNNz;
        hf1Nn:
        return false;
        goto MJmrv;
        IqNny:
        $ip = GetIp();
        goto PPS5r;
        b17kN:
        I1IVW:
        goto F43OE;
        g8nw8:
        return $json;
        goto ZIbZY;
        Fc0ki:
        return false;
        goto Pyc6H;
        MJmrv:
        goto WEzGD;
        goto aOfCl;
        ceb0l:
        preg_match('#\\{.+?\\}#', $res, $jsonMatches);
        goto kGJz7;
        H17pX:
        $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
        goto hSx2b;
        wSX9M:
        if (isset($json['ret']) && $json['ret'] == 1) {
            goto fIGWH;
        }
        goto hf1Nn;
        kGJz7:
        if (isset($jsonMatches[0])) {
            goto Fc0Lg;
        }
        goto Fc0ki;
        Pyc6H:
        Fc0Lg:
        goto PWrz2;
        xQNNz:
        $json['ip'] = $ip;
        goto ynwPL;
        hSx2b:
        if (!empty($res)) {
            goto I1IVW;
        }
        goto cQxDd;
        ZIbZY:
    }
    function getIp()
    {
        goto BBlhf;
        ifPJ3:
        return $onlineip;
        goto aLO68;
        rDUoz:
        yeYnL:
        goto EUUvX;
        dBGKP:
        IQABv:
        goto YV0kG;
        PYj33:
        W9FCm:
        goto cRen5;
        sdxKU:
        K6ZiN:
        goto cpyWi;
        Otewm:
        goto T86Qq;
        goto PYj33;
        EUUvX:
        $onlineip = $_SERVER['REMOTE_ADDR'];
        goto sEMzu;
        UJmgH:
        if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            goto IQABv;
        }
        goto DAgrj;
        ibCbH:
        if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            goto K6ZiN;
        }
        goto UJmgH;
        T6HMO:
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            goto W9FCm;
        }
        goto ibCbH;
        DAgrj:
        if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            goto yeYnL;
        }
        goto Otewm;
        sEMzu:
        T86Qq:
        goto ifPJ3;
        d3rY7:
        goto T86Qq;
        goto rDUoz;
        nNoM1:
        goto T86Qq;
        goto dBGKP;
        cpyWi:
        $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        goto nNoM1;
        URfct:
        goto T86Qq;
        goto sdxKU;
        cRen5:
        $onlineip = getenv('HTTP_CLIENT_IP');
        goto URfct;
        YV0kG:
        $onlineip = getenv('REMOTE_ADDR');
        goto d3rY7;
        BBlhf:
        $onlineip = '';
        goto T6HMO;
        aLO68:
    }
    public function sendMsg($openid, $tplmsgid, $data = array(), $data1, $url = "")
    {
        goto opu0X;
        oiolx:
        $this->postText($this->message['from'], $data1);
        goto qBSnV;
        ppxg7:
        if (empty($tplmsgid)) {
            goto ogG0Y;
        }
        goto nx0Ku;
        DoDBG:
        goto OJd0W;
        goto LeUA1;
        iEY6Y:
        PLR6H:
        goto VuO0F;
        VuO0F:
        return $account->sendTplNotice($openid, $tplmsgid, $data, $url);
        goto YnktN;
        LeUA1:
        ogG0Y:
        goto oiolx;
        y2gBK:
        ZspNo:
        goto sFZvz;
        nx0Ku:
        if ($_W['account']['level'] == 4) {
            goto PLR6H;
        }
        goto DoDBG;
        opu0X:
        global $_W;
        goto lcGyn;
        Bg84N:
        if (empty($data)) {
            goto ZspNo;
        }
        goto FvJIf;
        YnktN:
        OJd0W:
        goto y2gBK;
        FvJIf:
        include IA_ROOT . '/addons/tiger_newhu/wxtoken.php';
        goto ppxg7;
        lcGyn:
        $cfg = $this->module['config'];
        goto Bg84N;
        qBSnV:
        goto OJd0W;
        goto iEY6Y;
        sFZvz:
    }
    public function sendMsg1($openid, $tplmsgid, $data = array(), $data1, $url = "")
    {
        goto XPW6T;
        NJ13d:
        return $account->sendTplNotice($openid, $tplmsgid, $data, $url);
        goto O0ues;
        XPW6T:
        global $_W;
        goto lkTuy;
        i9CkB:
        include IA_ROOT . '/addons/tiger_newhu/wxtoken.php';
        goto NJ13d;
        lkTuy:
        $cfg = $this->module['config'];
        goto i9CkB;
        O0ues:
    }
    public function mbmsg($openid, $mb, $mbid, $url = "", $fans, $orderid, $cfg = "", $valuedata = "")
    {
        goto wkegb;
        mQTGV:
        $tp_value1 = str_replace('#时间#', date('Y-m-d H:i:s', time()), $tp_value1);
        goto EiJsf;
        X0MSh:
        $mb['remark'] = str_replace('#时间#', date('Y-m-d H:i:s', time()), $mb['remark']);
        goto w8KcU;
        vop7M:
        $mb['first'] = str_replace('#昵称#', $fans['nickname'], $mb['first']);
        goto Xy48w;
        Yr2GG:
        uM8Gd:
        goto V1WcG;
        r22TH:
        return $msg;
        goto h502W;
        LD9sk:
        $tp_value1 = str_replace('#订单号#', $orderid, $tp_value1);
        goto NaSuv;
        xnXzi:
        $tplist1 = array("first" => array("value" => $mb['first'], "color" => $mb['firstcolor']));
        goto pO5YK;
        wkegb:
        global $_W;
        goto HjB5N;
        tGQNj:
        $mb['remark'] = str_replace('#订单号#', $orderid, $mb['remark']);
        goto HM7fo;
        HjB5N:
        $tp_value1 = unserialize($mb['zjvalue']);
        goto mQTGV;
        pO5YK:
        foreach ($tp_value1 as $key => $value) {
            goto eFzmf;
            WBWRo:
            wgqcm:
            goto Cgmso;
            eFzmf:
            if (!empty($value)) {
                goto J3aYH;
            }
            goto sFcey;
            sFcey:
            goto wgqcm;
            goto KNoDp;
            KNoDp:
            J3aYH:
            goto Aswo7;
            Aswo7:
            $tplist1['keyword' . $key] = array("value" => $value, "color" => $tp_color1[$key]);
            goto WBWRo;
            Cgmso:
        }
        goto SRbv6;
        EiJsf:
        $tp_value1 = str_replace('#昵称#', $fans['nickname'], $tp_value1);
        goto LD9sk;
        duR6V:
        $msg = $this->sendMsg1($openid, $mbid, $tplist1, '', $url);
        goto r22TH;
        DZpG4:
        $tp_value1 = str_replace('#提现账号#', $valuedata['txzhanghao'], $tp_value1);
        goto kcLA_;
        wa2CK:
        $tp_value1 = str_replace('#提现金额#', $valuedata['rmb'], $tp_value1);
        goto DZpG4;
        NaSuv:
        if (empty($valuedata)) {
            goto uM8Gd;
        }
        goto wa2CK;
        V1WcG:
        $tp_color1 = unserialize($mb['zjcolor']);
        goto ogV7h;
        Xy48w:
        $mb['first'] = str_replace('#订单号#', $orderid, $mb['first']);
        goto xnXzi;
        HM7fo:
        $tplist1['remark'] = array("value" => $mb['remark'], "color" => $mb['remarkcolor']);
        goto duR6V;
        c0By_:
        $tp_value1 = str_replace('#手机号#', $valuedata['tel'], $tp_value1);
        goto Yr2GG;
        w8KcU:
        $mb['remark'] = str_replace('#昵称#', $fans['nickname'], $mb['remark']);
        goto tGQNj;
        SRbv6:
        T29Uu:
        goto X0MSh;
        kcLA_:
        $tp_value1 = str_replace('#微信号#', $valuedata['weixin'], $tp_value1);
        goto c0By_;
        ogV7h:
        $mb['first'] = str_replace('#时间#', date('Y-m-d H:i:s', time()), $mb['first']);
        goto vop7M;
        h502W:
    }
    function post_txhb($cfg, $openid, $dtotal_amount, $desc, $dmch_billno)
    {
        goto p7Dbz;
        AeZQn:
        $code = $xpath->evaluate('string(//xml/return_code)');
        goto LfsG6;
        vhKDa:
        $string1 = '';
        goto hH7XS;
        LfsG6:
        $result = $xpath->evaluate('string(//xml/result_code)');
        goto x2oXb;
        e_kRr:
        $extras['CURLOPT_SSLCERT'] = $root . 'apiclient_cert.pem';
        goto QDe0j;
        OPf7C:
        $ret['code'] = -3;
        goto RqtQI;
        seNE4:
        JiV7e:
        goto L6Je_;
        C42G5:
        $pars['total_num'] = 1;
        goto Sm9wm;
        khIkb:
        $pars['nonce_str'] = random(32);
        goto zJJGH;
        UdgNj:
        $dtotal = $dtotal_amount / 100;
        goto pkdFg;
        bXqt9:
        if (!empty($dmch_billno)) {
            goto rFGu8;
        }
        goto YOrOH;
        RqtQI:
        $ret['dissuccess'] = 0;
        goto sFL8A;
        J_lt3:
        $pars['act_name'] = '兑换红包';
        goto tKwMl;
        Sm9wm:
        $pars['wishing'] = '提现红包成功!';
        goto o0Gzj;
        sSJQ6:
        goto tL_vA;
        goto seNE4;
        hH7XS:
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
            wKzWp:
        }
        goto WBzvP;
        j6DYY:
        $dom = new DOMDocument();
        goto taL5G;
        tKwMl:
        $pars['remark'] = '来自' . $cfg['copyright'] . '的红包';
        goto T5Uod;
        o0Gzj:
        $pars['client_ip'] = $cfg['client_ip'];
        goto J_lt3;
        e53i1:
        $pars['wxappid'] = $cfg['appid'];
        goto rH5Zw;
        Nadm_:
        $pars['re_openid'] = $openid;
        goto CU5vW;
        UXWin:
        $ret['dissuccess'] = 0;
        goto dj9cq;
        O23xI:
        if (empty($desc)) {
            goto rFfCO;
        }
        goto OinQu;
        vvITX:
        $xml = array2xml($pars);
        goto Gt0LU;
        K3Dcx:
        $ret['message'] = '余额不足';
        goto jI2Hr;
        vN53s:
        return $ret;
        goto eZ007;
        FDLLu:
        $pars['max_value'] = $dtotal_amount;
        goto C42G5;
        L6Je_:
        $xpath = new DOMXPath($dom);
        goto AeZQn;
        dBNxp:
        $ret['dissuccess'] = 1;
        goto KF1P7;
        j21Y9:
        exit;
        goto suXSm;
        z0z1o:
        $ret['code'] = 0;
        goto OFWMs;
        fLFYU:
        ygPoD:
        goto D2UBp;
        YKi6V:
        $ret['code'] = -1;
        goto ZsY8o;
        qkdV9:
        cH20g:
        goto gx7pi;
        CU5vW:
        $pars['total_amount'] = $dtotal_amount;
        goto EddO9;
        OFWMs:
        $ret['message'] = 'success';
        goto MD2OR;
        FEI31:
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
        goto j6DYY;
        ZsY8o:
        $ret['dissuccess'] = 0;
        goto ycMrT;
        pkdFg:
        if (!($dtotal > $fans['credit2'])) {
            goto P9BfV;
        }
        goto dRYsc;
        sFL8A:
        $ret['message'] = '3error3';
        goto UAJnk;
        MD2OR:
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        goto SntHC;
        suXSm:
        P9BfV:
        goto IuN08;
        RIuKS:
        $procResult = $resp['message'];
        goto YKi6V;
        bYkR9:
        $pars['send_name'] = $cfg['copyright'];
        goto Nadm_;
        VNljU:
        return $ret;
        goto qkdV9;
        gx7pi:
        tL_vA:
        goto OD7eY;
        r9ivU:
        $pars['mch_id'] = $cfg['mchid'];
        goto e53i1;
        SntHC:
        $pars = array();
        goto khIkb;
        QDe0j:
        $extras['CURLOPT_SSLKEY'] = $root . 'apiclient_key.pem';
        goto McB0n;
        rH5Zw:
        $pars['nick_name'] = $cfg['copyright'];
        goto bYkR9;
        p7Dbz:
        global $_W;
        goto BRTJB;
        EddO9:
        $pars['min_value'] = $dtotal_amount;
        goto FDLLu;
        oarCz:
        $procResult = null;
        goto uD33W;
        DgdO3:
        $ret = array();
        goto z0z1o;
        IXUvf:
        xjRkI:
        goto RIuKS;
        jI2Hr:
        return $ret;
        goto j21Y9;
        jLaEK:
        IL8Di:
        goto HaJFa;
        taL5G:
        if ($dom->loadXML($xml)) {
            goto JiV7e;
        }
        goto OPf7C;
        UAJnk:
        return $ret;
        goto sSJQ6;
        hNGEN:
        $string1 .= "key={$cfg['apikey']}";
        goto oIKNZ;
        OD7eY:
        goto ygPoD;
        goto IXUvf;
        HaJFa:
        $ret['code'] = 0;
        goto dBNxp;
        YOrOH:
        $dmch_billno = random(10) . date('Ymd') . random(3);
        goto TWlb8;
        BRTJB:
        load()->model('mc');
        goto O23xI;
        ShDVJ:
        $root = IA_ROOT . '/attachment/tiger_newhu/cert/' . $_W['uniacid'] . '/';
        goto DgdO3;
        J3D2R:
        $error = $xpath->evaluate('string(//xml/err_code_des)');
        goto z1U7y;
        Ciq41:
        $ret['dissuccess'] = 0;
        goto K3Dcx;
        LHUu3:
        return $ret;
        goto fLFYU;
        zJJGH:
        $pars['mch_billno'] = $dmch_billno;
        goto r9ivU;
        dj9cq:
        $ret['message'] = $error;
        goto vN53s;
        Gt0LU:
        $extras = array();
        goto jWG0f;
        oIKNZ:
        $pars['sign'] = strtoupper(md5($string1));
        goto vvITX;
        TWlb8:
        rFGu8:
        goto ShDVJ;
        McB0n:
        load()->func('communication');
        goto oarCz;
        WBzvP:
        o0cE3:
        goto hNGEN;
        z1U7y:
        $ret['code'] = -2;
        goto UXWin;
        T5Uod:
        ksort($pars, SORT_STRING);
        goto vhKDa;
        dRYsc:
        $ret['code'] = -1;
        goto Ciq41;
        jWG0f:
        $extras['CURLOPT_CAINFO'] = $root . 'rootca.pem';
        goto e_kRr;
        KF1P7:
        $ret['message'] = 'success';
        goto VNljU;
        x2oXb:
        if (strtolower($code) == 'success' && strtolower($result) == 'success') {
            goto IL8Di;
        }
        goto J3D2R;
        uD33W:
        $resp = ihttp_request($url, $xml, $extras);
        goto TCwlp;
        TCwlp:
        if (is_error($resp)) {
            goto xjRkI;
        }
        goto FEI31;
        eZ007:
        goto cH20g;
        goto jLaEK;
        ycMrT:
        $ret['message'] = $procResult;
        goto LHUu3;
        OinQu:
        $fans = mc_fetch($_W['openid']);
        goto UdgNj;
        IuN08:
        rFfCO:
        goto bXqt9;
        D2UBp:
    }
    public function post_qyfk($cfg, $openid, $amount, $desc, $dmch_billno)
    {
        goto bZy1S;
        iczU9:
        $string1 = '';
        goto Fz2YE;
        TuDNu:
        $xpath = new DOMXPath($dom);
        goto X0teo;
        W3sq3:
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
        goto x9rY2;
        ocpdT:
        ksort($pars, SORT_STRING);
        goto iczU9;
        X0teo:
        $code = $xpath->evaluate('string(//xml/return_code)');
        goto Khn0k;
        vr8Q9:
        $pars['desc'] = '来自' . $_W['account']['name'] . '的提现';
        goto dVAl3;
        SVvlz:
        $ret['message'] = '-1:' . $procResult;
        goto ADjhc;
        sT1vX:
        $dmch_billno = random(10) . date('Ymd') . random(3);
        goto buTHk;
        PEs18:
        $ret['message'] = 'error response';
        goto ItHYW;
        Ls1By:
        $extras['CURLOPT_CAINFO'] = $root . 'rootca.pem';
        goto HKmv6;
        z_8tZ:
        $ret['amount'] = $amount;
        goto VdD15;
        Rsjc1:
        $extras['CURLOPT_SSLKEY'] = $root . 'apiclient_key.pem';
        goto VADTW;
        j5B_T:
        $ret = array();
        goto lWGx0;
        XjD6x:
        if (is_error($resp)) {
            goto jnX_O;
        }
        goto W3sq3;
        Q3CMX:
        $ret['message'] = '余额不足';
        goto ejLFn;
        J4tng:
        $ret['message'] = '-2:' . $error;
        goto SUCeu;
        blpdP:
        AJ1HQ:
        goto l351M;
        k02nx:
        vGQX8:
        goto Tpz4O;
        dzj02:
        $ret['dissuccess'] = 0;
        goto SVvlz;
        I0avz:
        if ($dom->loadXML($xml)) {
            goto cL6KY;
        }
        goto MjawT;
        Fz2YE:
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
            HDK9k:
        }
        goto v5Yxm;
        AcuNh:
        $ret['message'] = 'success';
        goto natEO;
        ADjhc:
        return $ret;
        goto d056A;
        UbXKq:
        $ret['dissuccess'] = 0;
        goto PEs18;
        TbHie:
        goto c6jpC;
        goto jWdLj;
        RCqsC:
        $ret['message'] = 'success';
        goto z_8tZ;
        v5Yxm:
        hcJNk:
        goto wVfag;
        l4iGy:
        $ret['code'] = 0;
        goto k3p6L;
        HbWTo:
        goto AJ1HQ;
        goto kS_hJ;
        dDic7:
        $root = IA_ROOT . '/attachment/tiger_newhu/cert/' . $_W['uniacid'] . '/';
        goto j5B_T;
        VADTW:
        load()->func('communication');
        goto GYS5a;
        d056A:
        OBf5v:
        goto TuKZD;
        BP6af:
        $resp = ihttp_request($url, $xml, $extras);
        goto XjD6x;
        jWdLj:
        V3sT5:
        goto l4iGy;
        zIeDh:
        $pars['openid'] = $openid;
        goto u6jA0;
        bZy1S:
        global $_W;
        goto mNBTG;
        BOE_R:
        jnX_O:
        goto UVk3F;
        Tpz4O:
        if (!empty($dmch_billno)) {
            goto QyKMJ;
        }
        goto sT1vX;
        rBF90:
        Ug9Gd:
        goto k02nx;
        kKq0G:
        $ret['code'] = -2;
        goto GzsGr;
        wVfag:
        $string1 .= "key={$cfg['apikey']}";
        goto Eg5FR;
        uOL6E:
        $pars['amount'] = $amount;
        goto vr8Q9;
        natEO:
        return $ret;
        goto InBII;
        Eg5FR:
        $pars['sign'] = strtoupper(md5($string1));
        goto BDO98;
        kS_hJ:
        cL6KY:
        goto TuDNu;
        MjawT:
        $ret['code'] = -3;
        goto UbXKq;
        VdD15:
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        goto q4m7_;
        buTHk:
        QyKMJ:
        goto dDic7;
        lWGx0:
        $ret['code'] = 0;
        goto RCqsC;
        UVk3F:
        $procResult = $resp['message'];
        goto zroO0;
        ZnTYO:
        $pars['mchid'] = $cfg['mchid'];
        goto TWXzk;
        bak6P:
        $error = $xpath->evaluate('string(//xml/err_code_des)');
        goto kKq0G;
        SUCeu:
        return $ret;
        goto TbHie;
        GzsGr:
        $ret['dissuccess'] = 0;
        goto J4tng;
        GYS5a:
        $procResult = null;
        goto BP6af;
        jXlJZ:
        $ret['code'] = -1;
        goto o8629;
        vVwXy:
        $dtotal = $amount / 100;
        goto SINUx;
        HKmv6:
        $extras['CURLOPT_SSLCERT'] = $root . 'apiclient_cert.pem';
        goto Rsjc1;
        InBII:
        c6jpC:
        goto blpdP;
        BDO98:
        $xml = array2xml($pars);
        goto XNDBC;
        Khn0k:
        $result = $xpath->evaluate('string(//xml/result_code)');
        goto ABCN5;
        TWXzk:
        $pars['nonce_str'] = random(32);
        goto C84rf;
        ejLFn:
        return $ret;
        goto PTL4i;
        mNBTG:
        load()->model('mc');
        goto wtrYf;
        q4m7_:
        $pars = array();
        goto ftp3g;
        o8629:
        $ret['dissuccess'] = 0;
        goto Q3CMX;
        l351M:
        goto OBf5v;
        goto BOE_R;
        wtrYf:
        if (empty($desc)) {
            goto vGQX8;
        }
        goto q19iK;
        dVAl3:
        $pars['spbill_create_ip'] = $cfg['client_ip'];
        goto ocpdT;
        ABCN5:
        if (strtolower($code) == 'success' && strtolower($result) == 'success') {
            goto V3sT5;
        }
        goto bak6P;
        C84rf:
        $pars['partner_trade_no'] = $dmch_billno;
        goto zIeDh;
        x9rY2:
        $dom = new DOMDocument();
        goto I0avz;
        PTL4i:
        exit;
        goto rBF90;
        zroO0:
        $ret['code'] = -1;
        goto dzj02;
        q19iK:
        $fans = mc_fetch($_W['openid']);
        goto vVwXy;
        ItHYW:
        return $ret;
        goto HbWTo;
        k3p6L:
        $ret['dissuccess'] = 1;
        goto AcuNh;
        SINUx:
        if (!($dtotal > $fans['credit2'])) {
            goto Ug9Gd;
        }
        goto jXlJZ;
        XNDBC:
        $extras = array();
        goto Ls1By;
        ftp3g:
        $pars['mch_appid'] = $cfg['appid'];
        goto ZnTYO;
        u6jA0:
        $pars['check_name'] = 'NO_CHECK';
        goto uOL6E;
        TuKZD:
    }
    public function getAccountLevel()
    {
        goto gUgVo;
        w6off:
        $accObj = WeixinAccount::create($_W['uniacid']);
        goto krfIb;
        krfIb:
        $account = $accObj->account;
        goto ef7rh;
        B7BUi:
        load()->classs('weixin.account');
        goto w6off;
        ef7rh:
        return $account['level'];
        goto iORnY;
        gUgVo:
        global $_W;
        goto B7BUi;
        iORnY:
    }
    private function SendSMS($mobile, $content)
    {
        goto o5qQX;
        Sr_t9:
        onMjD:
        goto hmfhy;
        Qvaxt:
        $c = new TopClient();
        goto dxAqR;
        W6YZa:
        $resp = $c->execute($req);
        goto Hagw5;
        AuQSB:
        $c->secretKey = $config['dyAppSecret'];
        goto k6aAL;
        k6aAL:
        $req = new AlibabaAliqinFcSmsNumSendRequest();
        goto DCfyP;
        ltUV7:
        return $resp->sub_msg;
        goto NG0Fj;
        dxAqR:
        $c->appkey = $config['dyAppKey'];
        goto AuQSB;
        vX24j:
        return 0;
        goto Sr_t9;
        ofi5g:
        BJHKB:
        goto lbT2v;
        szLV8:
        goto BJHKB;
        goto HPSfO;
        o5qQX:
        $config = $this->module['config'];
        goto mmxJQ;
        CpVPe:
        goto UESQt;
        goto jQfGo;
        mmxJQ:
        load()->func('communication');
        goto MIeAG;
        DCfyP:
        $req->setSmsType('normal');
        goto oeUES;
        pKVM9:
        rf7bx:
        goto vX24j;
        MIeAG:
        if ($config['smstype'] == 'juhesj') {
            goto nw742;
        }
        goto uhEiF;
        zRsSL:
        if ($result['error_code'] == 0) {
            goto vHkLU;
        }
        goto drvOb;
        eKKFz:
        $req->setSmsTemplateCode($config['dysms_template_code']);
        goto W6YZa;
        AEPy8:
        if ($resp->result->err_code == 0) {
            goto rf7bx;
        }
        goto ltUV7;
        FEzF4:
        jjGYd:
        goto SHedX;
        ikGK0:
        $jhcode = $config['jhcode'];
        goto Ny5iB;
        HYtX4:
        $req->setSmsParam($content);
        goto v6rLg;
        SHedX:
        goto W6cbq;
        goto nkqL0;
        Ig3VR:
        $jhappkey = $config['jhappkey'];
        goto ikGK0;
        oeUES:
        $req->setSmsFreeSignName($config['dysms_free_sign_name']);
        goto HYtX4;
        SUWX1:
        $content = '接口调用错误.';
        goto CpVPe;
        NG0Fj:
        goto onMjD;
        goto pKVM9;
        uhEiF:
        if (empty($config['dyAppKey']) || empty($config['dyAppSecret']) || empty($config['dysms_free_sign_name']) || empty($config['dysms_template_code'])) {
            goto Rwp0x;
        }
        goto c6WO2;
        in0a8:
        Rwp0x:
        goto bjGXi;
        GinDa:
        $content = 0;
        goto ofi5g;
        jQfGo:
        YeeU9:
        goto zRsSL;
        c6WO2:
        include IA_ROOT . '/addons/tiger_newhu/inc/sdk/dayu/TopSdk.php';
        goto Qvaxt;
        Hagw5:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/log.txt', '
 old:' . json_encode($resp), FILE_APPEND);
        goto AEPy8;
        B5v1t:
        W6cbq:
        goto BFHel;
        HPSfO:
        vHkLU:
        goto GinDa;
        drvOb:
        $content = $result['error_code'] . $result['reason'];
        goto szLV8;
        hmfhy:
        goto jjGYd;
        goto in0a8;
        K2uJT:
        $result = @json_decode($json['content'], true);
        goto vwF6e;
        bjGXi:
        return '短信参数配置不正确，请联系管理员';
        goto FEzF4;
        TH1FJ:
        return $content;
        goto B5v1t;
        v6rLg:
        $req->setRecNum($mobile);
        goto eKKFz;
        vwF6e:
        if ($json['code'] == 200) {
            goto YeeU9;
        }
        goto SUWX1;
        Ny5iB:
        $json = ihttp_get("http://v.juhe.cn/sms/send?mobile={$mobile}&tpl_id={$jhcode}&tpl_value={$content}&key={$jhappkey}");
        goto K2uJT;
        nkqL0:
        nw742:
        goto Ig3VR;
        lbT2v:
        UESQt:
        goto TH1FJ;
        BFHel:
    }
    public function doMobileDuibaxf()
    {
        goto YBFhN;
        VB99j:
        $cfg = $this->module['config'];
        goto A3u3W;
        h6ljh:
        goto cNphd;
        goto KPFOp;
        oV2Xs:
        $ret = parseCreditConsume($settings['AppKey'], $settings['appSecret'], $request_array);
        goto SJ0JB;
        tW1zg:
        include 'duiba.php';
        goto VB99j;
        A3u3W:
        $settings = $this->module['config'];
        goto acM37;
        fcQb6:
        CXCF6:
        goto v0d_t;
        IKStE:
        pdo_insert($this->modulename . '_dborder', $insert);
        goto yOwrx;
        g3DSU:
        $insert = array("uniacid" => $_W['uniacid'], "uid" => $uid, "bizId" => date('YmdHi') . random(8, 1), "orderNum" => $request_array['orderNum'], "credits" => $request_array['credits'], "params" => $request_array['params'], "type" => $request_array['type'], "ip" => $request_array['ip'], "starttimestamp" => $request_array['timestamp'], "waitAudit" => $request_array['waitAudit'], "actualPrice" => $request_array['actualPrice'], "description" => $request_array['description'], "facePrice" => $request_array['facePrice'], "Audituser" => $request_array['Audituser'], "itemCode" => $request_array['itemCode'], "status" => 0, "createtime" => time());
        goto IKStE;
        k5WUN:
        exit(json_encode(array("status" => "fail", "errorMessage" => "扣除{$cfg['hztype']}错误", "credits" => $request_array['credits'])));
        goto eSoVa;
        v3omW:
        file_put_contents(IA_ROOT . '/addons/tiger_newhu/inc/mobile/log.txt', '
 old:' . json_encode($request_array), FILE_APPEND);
        goto oV2Xs;
        bs136:
        $share = pdo_fetch('select * from ' . tablename('tiger_newhu_share') . " where weid='{$_W['uniacid']}' and id='{$uid}'");
        goto Cbe2h;
        Tg9JE:
        exit(json_encode(array("status" => "ok", "errorMessage" => "", "bizId" => $insert['bizId'], "credits" => $yue)));
        goto fcQb6;
        e9evr:
        a1KWT:
        goto Z0X92;
        Cbe2h:
        $yue = intval($share['credit1']) - $request_array['credits'];
        goto xak8T;
        uGvPx:
        exit(json_encode(array("status" => "fail", "errorMessage" => $ret, "credits" => $request_array['credits'])));
        goto h6ljh;
        eSoVa:
        goto CXCF6;
        goto dq_YS;
        xak8T:
        if ($yue > 0) {
            goto a1KWT;
        }
        goto ELRVj;
        ti8na:
        $uid = $request_array['uid'];
        goto izD4p;
        yOwrx:
        if (pdo_insertid()) {
            goto lrTWl;
        }
        goto Zz3q4;
        etj_S:
        goto Wt8b6;
        goto e9evr;
        e2iZe:
        lrTWl:
        goto bs136;
        YBFhN:
        global $_W, $_GPC;
        goto tW1zg;
        NTMcx:
        rGPA1:
        goto mUrh_;
        ELRVj:
        exit(json_encode(array("status" => "fail", "errorMessage" => "积分不足", "credits" => $request_array['credits'])));
        goto etj_S;
        acM37:
        $request_array = $_GPC;
        goto ti8na;
        xPhPT:
        goto rGPA1;
        goto e2iZe;
        SJ0JB:
        if (is_array($ret)) {
            goto L6N7H;
        }
        goto uGvPx;
        KPFOp:
        L6N7H:
        goto g3DSU;
        QVlLQ:
        if ($updatecredit['error'] == 1) {
            goto Pdp96;
        }
        goto k5WUN;
        v0d_t:
        Wt8b6:
        goto NTMcx;
        mUrh_:
        cNphd:
        goto w3H2H;
        izD4p:
        foreach ($request_array as $key => $val) {
            goto WFMUo;
            bZQxu:
            yRZWb:
            goto PTTwY;
            eHGbo:
            BCBXW:
            goto bZQxu;
            WFMUo:
            $unsetkeyarr = array("i", "do", "m", "c", "module_status:1", "module_status:tiger_shouquan", "module_status:tiger_newhu", "notice", "state");
            goto Qzx9j;
            Qzx9j:
            if (!(in_array($key, $unsetkeyarr) || strstr($key, '__'))) {
                goto BCBXW;
            }
            goto IoAcL;
            IoAcL:
            unset($request_array[$key]);
            goto eHGbo;
            PTTwY:
        }
        goto e7ki7;
        e7ki7:
        nQAV4:
        goto v3omW;
        Zz3q4:
        exit(json_encode(array("status" => "fail", "errorMessage" => "系统错误，请重试！", "credits" => $request_array['credits'])));
        goto xPhPT;
        dq_YS:
        Pdp96:
        goto Tg9JE;
        Z0X92:
        $updatecredit = $this->mc_jl($uid, 0, 9, -abs($request_array['credits']), '兑吧兑换' . $request_array['description'], '');
        goto QVlLQ;
        w3H2H:
    }
    public function postgoods($goods, $openid)
    {
        goto EOcEy;
        mghNn:
        foreach ($goods as $key => $value) {
            goto VOQ9J;
            VOQ9J:
            $viewurl = $_W['siteroot'] . str_replace('./', 'app/', $this->createMobileurl('view', array("itemid" => $value['itemid'])));
            goto JP4dH;
            Q6B_t:
            LBRqy:
            goto Ye8BE;
            JP4dH:
            $response[] = array("title" => urlencode('【券后价:' . $value['itemendprice'] . '】' . $value['itemtitle']), "description" => urlencode($value['itemtitle']), "picurl" => tomedia($value['itemtitle'] . '_100x100.jpg'), "url" => $viewurl);
            goto Q6B_t;
            Ye8BE:
        }
        goto jhcEZ;
        jhcEZ:
        gXQoC:
        goto CGFai;
        EOcEy:
        global $_W;
        goto mghNn;
        TxLLR:
        if (!empty($acid)) {
            goto YEDH6;
        }
        goto hwXh2;
        CGFai:
        $message = array("touser" => trim($openid), "msgtype" => "news", "news" => array("articles" => $response));
        goto bEAHp;
        u0pIR:
        include IA_ROOT . '/addons/tiger_newhu/wxtoken.php';
        goto ccYEe;
        ccYEe:
        $status = $account->sendCustomNotice($message);
        goto x7e4A;
        cj8pJ:
        YEDH6:
        goto u0pIR;
        bEAHp:
        $acid = $_W['acid'];
        goto TxLLR;
        hwXh2:
        $acid = $_W['uniacid'];
        goto cj8pJ;
        x7e4A:
        return $status;
        goto ZG5Xs;
        ZG5Xs:
    }
}