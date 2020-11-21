<?php
goto s2zO0;
s2zO0:
defined('IN_IA') or die('Access Denied');
goto Dbi6j;
RkKoE:
require SILENCE_MODEL_FUNC . '/function.php';
goto RgW_Z;
Dbi6j:
require IA_ROOT . '/addons/silence_vote/defines.php';
goto RkKoE;
RgW_Z:
class Silence_voteModuleSite extends WeModuleSite
{
    public $tablereply = "silence_vote_reply";
    public $tablevoteuser = "silence_vote_voteuser";
    public $tablevotedata = "silence_vote_votedata";
    public $tablegift = "silence_vote_gift";
    public $tablecount = "silence_vote_count";
    public $table_fans = "silence_vote_fansdata";
    public $tableredpack = "silence_vote_redpack";
    public $tablelooklist = "silence_vote_looklist";
    public $tableviporder = "silence_vote_viporder";
    public $tableblacklist = "silence_vote_blacklist";
    public $tabledomainlist = "silence_vote_domainlist";
    public $tablesetmeal = "silence_vote_setmeal";
    public $auth_url = "http://token.aijiam.com";
    public function __construct()
    {
        goto zO6RA;
        Arknd:
        $this->oauthuser = $oauthuser;
        goto VC0ME;
        KDGzA:
        $oauthuser = m('user')->Get_checkoauth();
        goto Arknd;
        zO6RA:
        global $_GPC;
        goto pHW5a;
        XpDXj:
        if (!(strpos($useragent, 'MicroMessenger') !== false || strpos($useragent, 'Windows Phone') !== false)) {
            goto ec4ty;
        }
        goto KDGzA;
        VC0ME:
        ec4ty:
        goto vyJrh;
        pHW5a:
        $useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
        goto XpDXj;
        vyJrh:
    }
    public function doWebpay()
    {
        $url = murl('entry/module/payresult', array("m" => "silence_vote", "ty" => "user", "rid" => $order['rid'], "id" => $order['tid'], "i" => $order['uniacid']));
        print_r($url);
    }
    public function payResult($params)
    {
        goto iBdiu;
        wcS0u:
        $config = $this->module['config'];
        goto CwN7h;
        ehd2d:
        gCdWf:
        goto xI5VF;
        CuKOk:
        $postdata = array("first" => array("value" => "选手收到礼物", "color" => "#173177"), "tradeDateTime" => array("value" => date('Y-m-d H:i:s', $_W['timestamp']), "color" => "#173177"), "orderType" => array("value" => "收到礼物", "color" => "#173177"), "customerInfo" => array("value" => "送礼人:{$order['nickname']}", "color" => "#173177"), "orderItemName" => array("value" => "通知提醒", "color" => "#173177"), "orderItemData" => array("value" => "刚刚{$order['nickname']}送给你{$order['giftcount']}份 {$order['gifttitle']} 礼物！", "color" => "#173177"), "remark" => array("value" => "截止目前你总共收到礼物金额{$votedata['giftcount']}￥ 。", "color" => "#173177"));
        goto ZH6Fb;
        kx506:
        goto UyyzW;
        goto Bf09O;
        STS2G:
        $reply = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_reply') . " WHERE uniacid = {$_W['uniacid']} AND  rid = {$rid}");
        goto bEGxy;
        HGXNs:
        Q1NgT:
        goto HTVTq;
        OazYG:
        sm3lf:
        goto wDTL3;
        j1eG8:
        $order = pdo_fetch('SELECT id,tid,rid,uniacid FROM ' . tablename($this->tablegift) . ' WHERE  ptid = :ptid ', array(":ptid" => $params['tid']));
        goto YOn3O;
        MmwXG:
        foreach ($sendagent as $v) {
            goto I1iFG;
            I1iFG:
            $postdata3 = array("first" => array("value" => "你的下级经纪人{$agent['realname']}旗下选手收到礼物！", "color" => "#173177"), "tradeDateTime" => array("value" => date('Y-m-d H:i:s', $_W['timestamp']), "color" => "#173177"), "orderType" => array("value" => "收到礼物", "color" => "#173177"), "customerInfo" => array("value" => "[经纪人]{$agent['realname']}", "color" => "#173177"), "orderItemName" => array("value" => "通知提醒", "color" => "#173177"), "orderItemData" => array("value" => "刚刚你的下级经纪人{$agent['realname']}的选手收到礼物 {$order['gifttitle']} {$order['giftcount']} 份！", "color" => "#173177"), "remark" => array("value" => "截止目前{$agent['realname']}的选手{$votedata['name']}总共总共收到礼物金额{$votedata['giftcount']}￥", "color" => "#173177"));
            goto qfpj7;
            qfpj7:
            $f = $acc->sendTplNotice($v['openid'], $config['TM00351'], $postdata3, $url, $topcolor = '#FF683F');
            goto OUxmW;
            OUxmW:
            RecDa:
            goto eHY21;
            eHY21:
        }
        goto jM3bf;
        y6N44:
        $piao = $order['giftvote'];
        goto KMMN1;
        euWll:
        A1poI:
        goto b0UmP;
        wENDk:
        if (empty($reply['awardgive_num'])) {
            goto QSX89;
        }
        goto mpm7T;
        bYs6p:
        pdo_update($this->{$tablegift}, array("isdeal" => 0), array("ptid" => $params['tid']));
        goto RUKNa;
        QwWLz:
        if (!$firstagent) {
            goto kw0By;
        }
        goto TEFCu;
        DB1sD:
        $rid = $votedata['rid'];
        goto STS2G;
        CwN7h:
        $acc = WeAccount::create($_W['uniacid']);
        goto aRljr;
        DR7AP:
        QSX89:
        goto PF525;
        FreJT:
        $b = $finalnum - $a;
        goto mWsBG;
        AKMs2:
        $reply = pdo_fetch('SELECT rewardplayer,rewardplayerpercent FROM ' . tablename($this->tablereply) . ' WHERE rid = :rid ', array(":rid" => $order['rid']));
        goto mxaYr;
        mxZ6j:
        $sendagent[] = array("openid" => $thirdagent['openid'], "realname" => $thirdagent['realname']);
        goto Tp7Mv;
        uB0il:
        $viporder = pdo_fetch('SELECT * FROM ' . tablename($this->tableviporder) . ' WHERE ptid = :ptid', array(":ptid" => $params['tid']));
        goto aDja9;
        mpm7T:
        m('present')->upcredit($votedata['openid'], $reply['awardgive_type'], $reply['awardgive_num'] * $params['fee'], 'silence_vote');
        goto DR7AP;
        FkoJB:
        $url = murl('entry/module/payresult', array("m" => "silence_vote", "ty" => "user", "rid" => $order['rid'], "id" => $order['tid'], "i" => $order['uniacid']));
        goto NkvA5;
        aRljr:
        $url = $_W['siteroot'] . 'app/' . $this->createMobileUrl('ht_index');
        goto zQo8t;
        k0pXS:
        if (!$secondagent) {
            goto lmluK;
        }
        goto b_QQk;
        zQo8t:
        $vu_url = $_W['siteroot'] . 'app/' . $this->createMobileUrl('view', array("rid" => $order['rid'], "id" => $order['tid'], "op" => "xsrecommend", "xsid" => 'xs' . $order['tid'])) . '&time=' . time();
        goto CuKOk;
        jPVxl:
        $percent = $reply['rewardplayerpercent'];
        goto y6N44;
        u98dp:
        $reply = pdo_fetch('SELECT config FROM ' . tablename($this->tablereply) . ' WHERE rid = :rid ', array(":rid" => $order['rid']));
        goto f8xge;
        kT9tM:
        if (!($rl > 2)) {
            goto p7uCc;
        }
        goto Dac_I;
        RUKNa:
        EnALH:
        goto b7AVy;
        TSpL8:
        HCvSH:
        goto YorL4;
        Amb4z:
        Xeu6z:
        goto Ok1Vk;
        aIFx_:
        AKBkg:
        goto AKMs2;
        EpPgf:
        if ($params['result'] == 'success') {
            goto Q1NgT;
        }
        goto kpUzm;
        b0UmP:
        if (!($params['from'] == 'return')) {
            goto TjbbC;
        }
        goto EpPgf;
        ao4tM:
        m('present')->upcredit($order['openid'], $reply['giftgive_type'], $reply['giftgive_num'] * $params['fee'], 'silence_vote');
        goto Ukf6B;
        Iw0fB:
        $piao = 0;
        goto Amb4z;
        Tp7Mv:
        wrxo7:
        goto MmwXG;
        Xg0ct:
        $finalnum = sprintf('%.2f', $vnum + $renum);
        goto nn3q8;
        b_QQk:
        $sendagent[] = array("openid" => $secondagent['openid'], "realname" => $secondagent['realname']);
        goto aryqv;
        GxOzX:
        if (!($tycode == '8888')) {
            goto gCdWf;
        }
        goto uB0il;
        fWzSV:
        $tycode = substr($params['tid'], 0, 4);
        goto GxOzX;
        WCo75:
        if (empty($resetvote)) {
            goto J9EZX;
        }
        goto u98dp;
        mxaYr:
        $voteuser = pdo_fetch('SELECT id,noid,name,status,oauth_openid,openid,votenum,giftcount,locktime,fromuser_id,rewardvote FROM ' . tablename($this->tablevoteuser) . ' WHERE id = :id AND uniacid=:uniacid AND rid = :rid  ', array(":uniacid" => $_W['uniacid'], ":rid" => $order['rid'], ":id" => $order['tid']));
        goto hUu3i;
        aDja9:
        if (!($params['fee'] == $viporder['fee'] && $viporder['ispay'] == 0)) {
            goto cPLc3;
        }
        goto J9tru;
        mWsBG:
        $sql = 'update ' . tablename($this->tablevoteuser) . " set votenum=votenum+{$a}, rewardvote = {$b}" . ' where id = ' . $voteuser['fromuser_id'];
        goto AvIw8;
        X6ONr:
        gAlaz:
        goto wcS0u;
        WUOGF:
        pdo_query($sql);
        goto X6ONr;
        MwCAw:
        unset($reply['config']);
        goto AxF14;
        PF525:
        if (!empty($reply['isvotemsg'])) {
            goto AKBkg;
        }
        goto gUxxZ;
        bKpuM:
        goto sm3lf;
        goto HGXNs;
        YorL4:
        $order = pdo_fetch('SELECT rid,tid,uniacid FROM ' . tablename($this->tableviporder) . ' WHERE ptid = :ptid', array(":ptid" => $params['tid']));
        goto FkoJB;
        GM5XT:
        if (!$qjfy) {
            goto oOR4V;
        }
        goto sBfZB;
        ChNOv:
        $reupvote = pdo_update($this->tablegift, array("ispay" => "1", "isdeal" => "1", "paytype" => $params['type'], "uniontid" => $params['uniontid']), array("ptid" => $params['tid'], "oauth_openid" => $params['user']));
        goto Ghk8X;
        Ukf6B:
        jfq4N:
        goto wENDk;
        nY989:
        header('location: ' . $_W['siteroot'] . 'app/' . $url);
        goto OazYG;
        J9tru:
        $reviporder = pdo_update($this->tableviporder, array("ispay" => "1", "paytype" => $params['type'], "uniontid" => $params['uniontid']), array("ptid" => $params['tid']));
        goto A3tdi;
        S4qsp:
        oOR4V:
        goto rP3KS;
        YOn3O:
        $url = murl('entry/module/payresult', array("m" => "silence_vote", "rid" => $order['rid'], "id" => $order['tid'], "i" => $order['uniacid']));
        goto dKCXg;
        umKNG:
        p7uCc:
        goto S2XsM;
        Dac_I:
        $thirdagent = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_agentlist') . " WHERE uniacid = {$_W['uniacid']} AND openid != '' and openid != '0' and id = {$secondagent['agentrecommend']}");
        goto umKNG;
        NCSfY:
        H7HHp:
        goto kwmfA;
        p84gQ:
        die('用户支付的金额与订单金额不符合或已修改状态。');
        goto kx506;
        bEGxy:
        $rl = $reply['rakebacklevel'];
        goto IHeAK;
        a8jp3:
        if (!$thirdagent) {
            goto wrxo7;
        }
        goto mxZ6j;
        ZZYj7:
        if (!$agent['openid']) {
            goto QQ8zu;
        }
        goto nOJ4j;
        fZ8Kj:
        J9EZX:
        goto bYs6p;
        rP3KS:
        goto EnALH;
        goto fZ8Kj;
        P8YAf:
        die;
        goto ehd2d;
        E62yH:
        $a = floor($finalnum);
        goto FreJT;
        Ok1Vk:
        $vnum = sprintf('%.2f', $piao * ($percent / 100));
        goto lFhWV;
        vpLqo:
        $secondagent = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_agentlist') . " WHERE uniacid = {$_W['uniacid']} AND openid != '' and openid != '0' and id = {$firstagent['agentrecommend']}");
        goto kT9tM;
        iBdiu:
        global $_W, $_GPC;
        goto QEPdb;
        AxF14:
        if (!(empty($reply['isvotemsg']) || !empty($reply['awardgive_num']))) {
            goto H7HHp;
        }
        goto LKkQk;
        lFhWV:
        $renum = pdo_fetchcolumn('select rewardvote from ' . tablename($this->tablevoteuser) . " where id = {$voteuser['fromuser_id']}");
        goto Xg0ct;
        Ghk8X:
        if (!empty($reupvote)) {
            goto fk6OO;
        }
        goto p84gQ;
        r4qHV:
        QQ8zu:
        goto DB1sD;
        TEFCu:
        $sendagent[] = array("openid" => $firstagent['openid'], "realname" => $firstagent['realname']);
        goto EEh70;
        DNnT1:
        PEyiF:
        goto euWll;
        kpUzm:
        message('抱歉，支付失败，请刷新后再试！', 'referer', 'error');
        goto bKpuM;
        S2XsM:
        byF_V:
        goto QwWLz;
        um0w5:
        $resetvote = pdo_query($setvotesql);
        goto WCo75;
        XxGh6:
        $qjfy = $config['israkeback'];
        goto GM5XT;
        bRFhu:
        $setvotesql = 'update ' . tablename($this->tablevoteuser) . ' set votenum=votenum+' . $order['giftvote'] . ',giftcount=giftcount+' . $order['fee'] . ',lastvotetime=' . time() . '  where id = ' . $order['tid'];
        goto um0w5;
        aryqv:
        lmluK:
        goto a8jp3;
        nn3q8:
        if ($finalnum >= 1) {
            goto B7m3Y;
        }
        goto tXFtX;
        D24Ci:
        if (!($rl > 1)) {
            goto byF_V;
        }
        goto vpLqo;
        HTVTq:
        $tycode = substr($params['tid'], 0, 4);
        goto WotWM;
        JFI1X:
        B7m3Y:
        goto E62yH;
        xI5VF:
        $order = pdo_fetch('SELECT * FROM ' . tablename($this->tablegift) . ' WHERE ptid = :ptid', array(":ptid" => $params['tid']));
        goto WhlLh;
        b7AVy:
        UyyzW:
        goto DNnT1;
        KMMN1:
        if (!($piao < 0)) {
            goto Xeu6z;
        }
        goto Iw0fB;
        sBfZB:
        $agent = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_agentlist') . " WHERE uniacid = {$_W['uniacid']} AND openid != '' and openid != '0' and id = {$votedata['agent_id']}");
        goto ukAHD;
        jM3bf:
        bhrBR:
        goto S4qsp;
        AvIw8:
        MXzcB:
        goto WUOGF;
        IHeAK:
        $firstagent = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_agentlist') . " WHERE uniacid = {$_W['uniacid']} AND openid != '' and openid != '0' and id = {$agent['agentrecommend']}");
        goto D24Ci;
        f8xge:
        $reply = @array_merge($reply, unserialize($reply['config']));
        goto MwCAw;
        nm0Pa:
        goto MXzcB;
        goto JFI1X;
        hUu3i:
        if (!(!empty($reply['rewardplayer']) && !empty($voteuser['fromuser_id']))) {
            goto gAlaz;
        }
        goto jPVxl;
        dk6JR:
        $content = '您的好友【' . $order['nickname'] . '】给你' . $votedata['noid'] . '号【' . $votedata['name'] . '】送【' . $order['gifttitle'] . '】作为礼物！目前礼物共￥' . $votedata['giftcount'] . '，目前共' . $votedata['votenum'] . '票。<a href=\\"' . $uservoteurl . '\\">点击查看详情<\\/a>';
        goto jQoQs;
        ukAHD:
        $postdata2 = array("first" => array("value" => "经纪人{$agent['realname']}你的选手{$votedata['name']}收到礼物！", "color" => "#173177"), "tradeDateTime" => array("value" => date('Y-m-d H:i:s', $_W['timestamp']), "color" => "#173177"), "orderType" => array("value" => "收到礼物", "color" => "#173177"), "customerInfo" => array("value" => "[选手]{$votedata['name']}", "color" => "#173177"), "orderItemName" => array("value" => "通知提醒", "color" => "#173177"), "orderItemData" => array("value" => "刚刚你招募的选手{$votedata['name']}收到礼物 {$order['gifttitle']} {$order['giftcount']}份！", "color" => "#173177"), "remark" => array("value" => "截止目前你的选手{$votedata['name']}总共收到礼物金额{$votedata['giftcount']}￥ 。", "color" => "#173177"));
        goto ZZYj7;
        EEh70:
        kw0By:
        goto k0pXS;
        Bf09O:
        fk6OO:
        goto bRFhu;
        kwmfA:
        if (empty($reply['giftgive_num'])) {
            goto jfq4N;
        }
        goto ao4tM;
        tXFtX:
        $sql = 'update ' . tablename($this->tablevoteuser) . " set rewardvote = {$finalnum}" . ' where id = ' . $voteuser['fromuser_id'];
        goto nm0Pa;
        A3tdi:
        cPLc3:
        goto P8YAf;
        wDTL3:
        TjbbC:
        goto bkS2M;
        WotWM:
        if ($tycode == '8888') {
            goto HCvSH;
        }
        goto j1eG8;
        QEPdb:
        if (!($params['result'] == 'success' && $params['from'] == 'notify')) {
            goto A1poI;
        }
        goto fWzSV;
        nOJ4j:
        $e = $acc->sendTplNotice($agent['openid'], $config['TM00351'], $postdata2, $url, $topcolor = '#FF683F');
        goto r4qHV;
        dKCXg:
        goto WnH7x;
        goto TSpL8;
        gUxxZ:
        $uservoteurl = $_W['siteroot'] . 'app/' . $this->createMobileUrl('view', array("rid" => $order['rid'], "id" => $votedata['id']));
        goto dk6JR;
        WhlLh:
        if (!($params['fee'] == $order['fee'] && $order['ispay'] == 0)) {
            goto PEyiF;
        }
        goto ChNOv;
        NkvA5:
        WnH7x:
        goto nY989;
        LKkQk:
        $votedata = pdo_fetch('SELECT * FROM ' . tablename($this->tablevoteuser) . ' WHERE id = :id ', array(":id" => $order['tid']));
        goto NCSfY;
        jQoQs:
        m('user')->sendkfinfo($votedata['openid'], $content);
        goto aIFx_;
        ZH6Fb:
        $d = $acc->sendTplNotice($votedata['openid'], $config['TM00351'], $postdata, $vu_url, $topcolor = '#FF683F');
        goto XxGh6;
        bkS2M:
    }
    public function authorization()
    {
    }
    public function check_ticket($type = "")
    {
        goto gO28o;
        ktWgw:
        RcxB2:
        goto b7k03;
        LbX42:
        exit(json_encode($result));
        goto ktWgw;
        b7k03:
        goto AmQ5H;
        goto iSEyu;
        kIdA9:
        $url = $this->auth_url . '/index/vote/checkauth';
        goto b1XsZ;
        z7EJd:
        $content = ihttp_post($url, $post_data);
        goto QRt4C;
        iOr7T:
        if ($result['sta']) {
            goto l9a4_;
        }
        goto ouG26;
        X31ju:
        goto RcxB2;
        goto YjHzO;
        YjHzO:
        vjlox:
        goto LbX42;
        ouG26:
        if ($type == 'ajax') {
            goto vjlox;
        }
        goto IDijj;
        QRt4C:
        $result = json_decode($content['content'], true);
        goto iOr7T;
        gO28o:
        $cfg = $this->module['config'];
        goto kIdA9;
        ZU5Uq:
        load()->func('communication');
        goto z7EJd;
        iSEyu:
        l9a4_:
        goto z4EqR;
        b1XsZ:
        $post_data = array("time" => time(), "ticket" => $cfg['ticket'], "module_id" => 3);
        goto w2Zg9;
        lYHnC:
        AmQ5H:
        goto vcS54;
        w2Zg9:
        ksort($post_data);
        goto pehuD;
        IDijj:
 //       message('授权错误，请联系客服！', 'referer', 'error');
        goto X31ju;
        pehuD:
        $post_data['token'] = md5(sha1(implode('', $post_data)));
        goto ZU5Uq;
        z4EqR:
        return true;
        goto lYHnC;
        vcS54:
    }
    public function savedata($data = array())
    {
        goto zJtKf;
        SY8yb:
        $content = ihttp_post($url, $data);
        goto Fro4g;
        qt1zr:
        $data['img4'] = tomedia($data['img4']);
        goto Zr5N3;
        MF24G:
        gG_Gb:
        goto q6bKD;
        qYOCd:
        return false;
        goto Mfzpw;
        xzrON:
        $data['img1'] = tomedia($data['img1']);
        goto iO0Je;
        q6bKD:
        return true;
        goto rJHL2;
        iO0Je:
        euEjP:
        goto jcSlE;
        G11tg:
        if (!($result['sta'] == 0)) {
            goto gG_Gb;
        }
        goto MImSI;
        Fro4g:
        if (!($content['code'] != 200)) {
            goto AQPlO;
        }
        goto Jw6P1;
        Zr5N3:
        BzmtE:
        goto v0L2o;
        Mfzpw:
        iN0F7:
        goto VP7JA;
        D40Ud:
        if (!$data['avatar']) {
            goto VlZ0t;
        }
        goto uLmZG;
        fb85N:
        $cfg = $this->module['config'];
        goto zu8In;
        q0bTt:
        $data['token'] = md5(sha1(implode('', $data_token)));
        goto Zu9QC;
        Zu9QC:
        load()->func('communication');
        goto SY8yb;
        xcMas:
        AQPlO:
        goto MqCRM;
        ugVRb:
        $data['img3'] = tomedia($data['img3']);
        goto Hcw3W;
        uLmZG:
        $data['avatar'] = tomedia($data['avatar']);
        goto T2dsZ;
        w_qK5:
        $data_token['module_id'] = $data['module_id'] = 3;
        goto Myc0R;
        zu8In:
        $url = $this->auth_url . '/index/vote/savedata';
        goto r5dgm;
        zJtKf:
        if (!empty($data)) {
            goto iN0F7;
        }
        goto qYOCd;
        Myc0R:
        $data_token['time'] = $data['time'] = time();
        goto l4LzE;
        Jw6P1:
        return false;
        goto xcMas;
        l4LzE:
        ksort($data_token);
        goto q0bTt;
        MqCRM:
        $result = json_decode($content['content'], true);
        goto G11tg;
        zX2WU:
        Clete:
        goto g5AH0;
        Hcw3W:
        Q_Jpa:
        goto Ub313;
        v0L2o:
        if (!$data['img5']) {
            goto PRyPc;
        }
        goto j9aA_;
        jcSlE:
        if (!$data['img2']) {
            goto Clete;
        }
        goto pR2y4;
        Ub313:
        if (!$data['img4']) {
            goto BzmtE;
        }
        goto qt1zr;
        T2dsZ:
        VlZ0t:
        goto fb85N;
        VP7JA:
        if (!$data['img1']) {
            goto euEjP;
        }
        goto xzrON;
        g5AH0:
        if (!$data['img3']) {
            goto Q_Jpa;
        }
        goto ugVRb;
        aenKn:
        PRyPc:
        goto D40Ud;
        pR2y4:
        $data['img2'] = tomedia($data['img2']);
        goto zX2WU;
        r5dgm:
        $data_token['ticket'] = $data['ticket'] = $cfg['ticket'];
        goto w_qK5;
        j9aA_:
        $data['img5'] = tomedia($data['img5']);
        goto aenKn;
        MImSI:
        return false;
        goto MF24G;
        rJHL2:
    }
    public function get_cloud_data($tag, $count, $source_str)
    {
        goto p2o8z;
        QnkE3:
        load()->func('communication');
        goto YJJ1X;
        Ae9Td:
        $result = json_decode($content['content'], true);
        goto uMZdY;
        D6Jqw:
        return false;
        goto EF6PO;
        GLkcV:
        $data_token['module_id'] = $data['module_id'] = 3;
        goto CVjMR;
        uDERP:
        $data['count'] = $count;
        goto MBCWW;
        HpwVj:
        if (!($content['code'] != 200)) {
            goto hFdCN;
        }
        goto iuVun;
        CVjMR:
        $data_token['time'] = $data['time'] = time();
        goto lkKw1;
        EF6PO:
        nvhhA:
        goto V43iV;
        YJJ1X:
        $content = ihttp_post($url, $data);
        goto HpwVj;
        gBqlq:
        $data['token'] = md5(sha1(implode('', $data_token)));
        goto GxHsw;
        SrACB:
        $cfg = $this->module['config'];
        goto SWctV;
        v8p0w:
        $data_token['ticket'] = $data['ticket'] = $cfg['ticket'];
        goto GLkcV;
        UyEKS:
        hFdCN:
        goto Ae9Td;
        lkKw1:
        ksort($data_token);
        goto gBqlq;
        uMZdY:
        if (!($result['sta'] == 0)) {
            goto nvhhA;
        }
        goto D6Jqw;
        SWctV:
        $url = $this->auth_url . '/index/vote/getuser';
        goto v8p0w;
        MBCWW:
        $data['source_str'] = $source_str;
        goto QnkE3;
        iuVun:
        return false;
        goto UyEKS;
        V43iV:
        return json_encode($result['data']);
        goto Sjrzk;
        p2o8z:
        global $_W, $_GPC;
        goto SrACB;
        GxHsw:
        $data['tag'] = $tag;
        goto uDERP;
        Sjrzk:
    }
    public function getImage($url)
    {
        goto X5VHY;
        w_jhL:
        $url = $remote['cos']['url'];
        goto KUCAA;
        PWXDT:
        goto a0NwT;
        goto u8sBO;
        JaKbH:
        if (!(trim($url) == '')) {
            goto mwE2W;
        }
        goto sLq5B;
        VZsTv:
        goto a0NwT;
        goto NUAuZ;
        MnJXs:
        $ch = curl_init();
        goto Lb9NP;
        FrEBA:
        m('attachment')->file_voteremote_upload($re_dir . $filename, $remote);
        goto Ot2rx;
        Q9B8S:
        $remotestatus = file_remote_upload($re_dir . $filename);
        goto SsQyq;
        aKBio:
        goto Hww_V;
        goto QvtuO;
        MuxrL:
        if (!(!file_exists($upload_path) && !mkdir($upload_path, 0777, true))) {
            goto N9CQS;
        }
        goto KsQ85;
        qeGZn:
        Hww_V:
        goto MwF99;
        sSP2h:
        $fp2 = @fopen($upload_path . $filename, 'a');
        goto Ysjnm;
        iBPlZ:
        $url = $remote['qiniu']['url'];
        goto uJ0p_;
        GCnik:
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        goto ZwfGq;
        j9KtB:
        curl_setopt($ch, CURLOPT_URL, $url);
        goto wbWS5;
        qETrF:
        return array("file_name" => $filename, "save_path" => $pathname, "error" => 0);
        goto v3zHa;
        WFMPv:
        load()->func('file');
        goto KfdKN;
        uM5zO:
        $pathname = tomedia($re_dir . $filename);
        goto sG7q2;
        GN31P:
        if ($remote['type'] == '2') {
            goto WIeZf;
        }
        goto McEuh;
        wO9H5:
        N9CQS:
        goto MnJXs;
        yWX7B:
        goto a0NwT;
        goto vSfHF;
        koi_3:
        goto Ohigh;
        goto AyWzG;
        KsQ85:
        return false;
        goto wO9H5;
        rclIr:
        Xs9JT:
        goto Q9B8S;
        FPxWB:
        $modulelist = uni_modules(false);
        goto LOiQ0;
        Ot2rx:
        if ($remote['type'] == '1') {
            goto F_g8L;
        }
        goto GN31P;
        QQyv4:
        $ext = strrchr($url, '.');
        goto jkXSB;
        IzzvY:
        if (empty($remote['type'])) {
            goto W2J1H;
        }
        goto FrEBA;
        R5lHt:
        fclose($fp2);
        goto FEUa0;
        X5VHY:
        global $_W, $_GPC;
        goto WFMPv;
        Ysjnm:
        fwrite($fp2, $img);
        goto R5lHt;
        KfdKN:
        $uniacid = $_W['uniacid'];
        goto JaKbH;
        Vh5nI:
        file_delete($re_dir . $filename);
        goto bSPPY;
        McEuh:
        if ($remote['type'] == '3') {
            goto OYjmp;
        }
        goto qophN;
        ekSrI:
        Ohigh:
        goto qETrF;
        poWOO:
        $url = $remote['ftp']['url'];
        goto PWXDT;
        wbWS5:
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        goto GCnik;
        ZwfGq:
        $img = curl_exec($ch);
        goto z6NAH;
        YiM5X:
        if (!empty($_W['setting']['remote']['type'])) {
            goto Xs9JT;
        }
        goto uM5zO;
        QvtuO:
        fdaSw:
        goto wIp4C;
        sLq5B:
        return false;
        goto ZfQkB;
        E1YPK:
        $filename = md5(time() . rand(1000000, 9999999)) . $ext;
        goto MuxrL;
        JoQd2:
        $pathname = $url . '/' . $re_dir . $filename;
        goto koi_3;
        bSPPY:
        $pathname = tomedia($re_dir . $filename);
        goto aKBio;
        uJ0p_:
        goto a0NwT;
        goto nC34I;
        K9Vw1:
        $url = $remote['alioss']['url'];
        goto yWX7B;
        z6NAH:
        curl_close($ch);
        goto sSP2h;
        Lb9NP:
        $timeout = 5;
        goto j9KtB;
        FEUa0:
        unset($img, $url);
        goto FPxWB;
        jkXSB:
        if (!($ext != '.gif' && $ext != '.jpg' && $ext != '.png' && $ext != '.jpeg')) {
            goto ynOcM;
        }
        goto K60Dv;
        SWtjZ:
        $upload_path = ATTACHMENT_ROOT . $re_dir;
        goto QQyv4;
        u8sBO:
        WIeZf:
        goto K9Vw1;
        ZfQkB:
        mwE2W:
        goto l1Ec5;
        P88Pz:
        ynOcM:
        goto E1YPK;
        LOiQ0:
        $remote = $modulelist['silence_vote']['config']['remote'];
        goto IzzvY;
        nC34I:
        Xe09B:
        goto w_jhL;
        MwF99:
        c0gnG:
        goto ekSrI;
        K60Dv:
        return false;
        goto P88Pz;
        wIp4C:
        return false;
        goto qeGZn;
        AyWzG:
        W2J1H:
        goto YiM5X;
        NUAuZ:
        F_g8L:
        goto poWOO;
        qophN:
        if ($remote['type'] == '4') {
            goto Xe09B;
        }
        goto VZsTv;
        SsQyq:
        if (is_error($remotestatus)) {
            goto fdaSw;
        }
        goto Vh5nI;
        KUCAA:
        a0NwT:
        goto JoQd2;
        sG7q2:
        goto c0gnG;
        goto rclIr;
        l1Ec5:
        $re_dir = "images/{$uniacid}/silence_vote/" . date('Y/m/');
        goto SWtjZ;
        vSfHF:
        OYjmp:
        goto iBPlZ;
        v3zHa:
    }
    public function doMobileQrcodeurl()
    {
        goto mNwwO;
        mNwwO:
        global $_W, $_GPC;
        goto yYaij;
        FPi25:
        $matrixPointSize = '6';
        goto DYYXp;
        yYaij:
        $url = $_GPC['url'];
        goto jJd6d;
        jJd6d:
        require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
        goto VqaGt;
        DYYXp:
        QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize);
        goto PDmWN;
        VqaGt:
        $errorCorrectionLevel = 'L';
        goto FPi25;
        PDmWN:
        die;
        goto WJV56;
        WJV56:
    }
    public function template_footer($name)
    {
    }
    public function oauth_uniacid()
    {
        goto ehtCK;
        xbOb4:
        uf9Xv:
        goto X8kNx;
        Qg0te:
        return $uniacid;
        goto Ez3SN;
        ehtCK:
        global $_W, $_GPC;
        goto uRpQm;
        Oy_Ti:
        if ($_W['oauth_account']['level'] == 4) {
            goto fKeJ1;
        }
        goto QSEXz;
        nUDj5:
        $oauth_acid = $_W['oauth_account']['acid'];
        goto I73To;
        QSEXz:
        $uniacid = $_W['uniacid'];
        goto kOmhZ;
        uRpQm:
        if ($_W['account']['level'] == 4) {
            goto uf9Xv;
        }
        goto Oy_Ti;
        KkTq2:
        goto qH5PQ;
        goto xbOb4;
        X8kNx:
        $uniacid = $_W['uniacid'];
        goto ANkbR;
        kOmhZ:
        goto nKL1r;
        goto EMXwx;
        I73To:
        $account_wechats = pdo_fetch('SELECT uniacid FROM ' . tablename('account_wechats') . ' WHERE acid = :acid ', array(":acid" => $oauth_acid));
        goto tNCyl;
        RvJKo:
        nKL1r:
        goto KkTq2;
        EMXwx:
        fKeJ1:
        goto nUDj5;
        tNCyl:
        $uniacid = $account_wechats['uniacid'];
        goto RvJKo;
        ANkbR:
        qH5PQ:
        goto Qg0te;
        Ez3SN:
    }
    public function get_resource($pic_path)
    {
        goto hC64A;
        DtnnK:
        MA6aI:
        goto hlSna;
        hC64A:
        $pathInfo = pathinfo($pic_path);
        goto e3lFu;
        O28e4:
        $resource = $imagecreatefromjpeg($pic_path);
        goto iGYj_;
        e3lFu:
        switch (strtolower($pathInfo['extension'])) {
            case 'jpg':
                $imagecreatefromjpeg = 'imagecreatefromjpeg';
                goto klVtR;
            case 'jpeg':
                $imagecreatefromjpeg = 'imagecreatefromjpeg';
                goto klVtR;
            case 'png':
                $imagecreatefromjpeg = 'imagecreatefrompng';
                goto klVtR;
            case 'gif':
            default:
                goto xDlNb;
                TM3F8:
                $pic_path = file_get_contents($pic_path);
                goto vdbmn;
                vdbmn:
                goto klVtR;
                goto lTXW2;
                xDlNb:
                $imagecreatefromjpeg = 'imagecreatefromstring';
                goto TM3F8;
                lTXW2:
        }
        goto DtnnK;
        iGYj_:
        return $resource;
        goto FGgm9;
        hlSna:
        klVtR:
        goto O28e4;
        FGgm9:
    }
    public function json_exit($status, $msg)
    {
        die(json_encode(array("status" => $status, "msg" => $msg)));
    }
    public function doWebUpdateSql()
    {
        goto KnTs6;
        fQ1Xi:
        AuIIR:
        goto VjvUO;
        VbTnR:
        pdo_query('ALTER TABLE ' . tablename('silence_vote_reply') . ' ADD `djsstatus` tinyint(1) DEFAULT \'0\' COMMENT \'倒计时是否显示\' AFTER `maxkluse`;');
        goto fQ1Xi;
        aPzCD:
        $uniacid = $_W['uniacid'];
        goto ZKCx2;
        ZKCx2:
        if (pdo_fieldexists('silence_vote_reply', 'djsstatus')) {
            goto AuIIR;
        }
        goto VbTnR;
        xk9sS:
        pdo_query($sql);
        goto QMYPj;
        KnTs6:
        global $_W, $_GPC;
        goto aPzCD;
        VjvUO:
        $sql = 'update ' . tablename('silence_vote_robotstatus') . "set mode1 = 0,mode2 =0,mode3 =0,mode4 = 0 where uniacid = {$uniacid}";
        goto xk9sS;
        QMYPj:
        echo 'success';
        goto Mia2U;
        Mia2U:
    }
    public function doWebTestQN()
    {
        global $_W, $_GPC;
        include $this->template('qnindex');
    }
    public function doMobilegetqntoken()
    {
        goto RbTAX;
        z4NBt:
        $auth = new Qiniu\Auth($remote['qiniu']['accesskey'], $remote['qiniu']['secretkey']);
        goto TvLL2;
        TvLL2:
        $uploadtoken = $auth->uploadToken($remote['qiniu']['bucket'], null, 3600, null, true);
        goto KGl7W;
        RbTAX:
        global $_W, $_GPC;
        goto H0NLh;
        kY5bv:
        $remote = $modulelist['silence_vote']['config']['remote'];
        goto pHHNR;
        xyRpg:
        exit;
        goto ZIeYf;
        H0NLh:
        $modulelist = uni_modules(false);
        goto kY5bv;
        yi4qw:
        echo json_encode($token);
        goto xyRpg;
        pHHNR:
        require_once '../addons/silence_vote/lib/Qiniu/autoload.php';
        goto z4NBt;
        KGl7W:
        $token = array("domain" => $remote['qiniu']['url'], "uptoken" => $uploadtoken);
        goto yi4qw;
        ZIeYf:
    }
    public function doMobileFopQiniu($vuid = 0, $video = "", $isbg = false)
    {
        goto uQYXx;
        ihWx4:
        echo json_encode(array("code" => 500, "msg" => "video不是一个数组", "video" => $video));
        goto rVkpR;
        v3OOJ:
        $accessKey = $remote['qiniu']['accesskey'];
        goto li6a6;
        zDwFZ:
        fpD2q:
        goto Fc1WK;
        XIYC9:
        $config = new Qiniu\Config();
        goto tJS5J;
        S1vHN:
        C54DR:
        goto FYIN3;
        W5AI6:
        if (!$isbg) {
            goto WaH5v;
        }
        goto ak7J3;
        rVkpR:
        exit;
        goto S1vHN;
        nPrXX:
        exit;
        goto DaiW0;
        zRJea:
        cXL8A:
        goto JKtUV;
        r2Ff6:
        require_once '../addons/silence_vote/lib/Qiniu/autoload.php';
        goto nPzVD;
        ZfDAQ:
        goto sU2tF;
        goto zRJea;
        FcvO9:
        $bucket = $remote['qiniu']['bucket'];
        goto r2Ff6;
        JKtUV:
        pdo_update($this->tablevoteuser, array("videoarr" => $videoarr), array("id" => $vuid));
        goto YzoK9;
        iusN3:
        if (is_array($video)) {
            goto C54DR;
        }
        goto ihWx4;
        AoJ2a:
        WaH5v:
        goto hC6x0;
        FYIN3:
        $handlevideo = array();
        goto R5CtU;
        vsPFa:
        return json_encode(array("code" => 200, "msg" => "经纪人选手页视频数组加水印成功", "videoarr" => $videoarr));
        goto ZfDAQ;
        li6a6:
        $secretKey = $remote['qiniu']['secretkey'];
        goto FcvO9;
        dZFcP:
        $notifyUrl = $_W['siteroot'] . str_replace('./', 'app/', $this->createMobileurl('QnNotify'));
        goto XIYC9;
        lKq2q:
        $_GPC['video'] = $video;
        goto AoJ2a;
        YzoK9:
        echo json_encode(array("code" => 200, "msg" => "报名页视频数组加水印成功", "videoarr" => $videoarr));
        goto nPrXX;
        uQYXx:
        global $_W, $_GPC;
        goto W5AI6;
        NOVBM:
        $remote = $modulelist['silence_vote']['config']['remote'];
        goto v3OOJ;
        sJNzi:
        $video = $_GPC['video'];
        goto MgGGa;
        tJS5J:
        $pfop = new Qiniu\Processing\PersistentFop($auth, $config);
        goto iusN3;
        DaiW0:
        sU2tF:
        goto PQj2c;
        idLqa:
        $force = '1';
        goto dZFcP;
        Fc1WK:
        $videoarr = json_encode($handlevideo);
        goto aacuy;
        aacuy:
        if (!$isbg) {
            goto cXL8A;
        }
        goto vsPFa;
        R5CtU:
        foreach ($video as $k => $v) {
            goto NzjBt;
            HHXbh:
            $fops = 'avthumb/mp4/vb/1.4m' . $wmImg . '|saveas/' . $putpolicy;
            goto oARP7;
            dc44Z:
            AouUC:
            goto YSiFH;
            vHQsO:
            goto B0O3e;
            goto WDi16;
            YSiFH:
            B0O3e:
            goto VuA0V;
            NzjBt:
            if (!empty($v)) {
                goto XMgXS;
            }
            goto pWS_3;
            aDjiP:
            $handlevideo[] = $remote['qiniu']['url'] . '/' . $v;
            goto ewwKN;
            HeeLE:
            $handlevideo[] = $remote['qiniu']['url'] . '/' . $rstring;
            goto q2PTo;
            Z03Vc:
            if (empty($remote['qiniu']['watermark'])) {
                goto AGbJ4;
            }
            goto SOaGu;
            oARP7:
            list($id, $err) = $pfop->execute($bucket, $key, $fops, $pipeline, $notifyUrl, 1);
            goto Um3OF;
            dZsEb:
            $wmImg .= '/wmGravity/NorthEast';
            goto sci7S;
            NKc9v:
            $karr = explode('.', $key);
            goto TQVO7;
            pWS_3:
            $handlevideo[] = '';
            goto vHQsO;
            IWBVH:
            $putpolicy = Qiniu\base64_urlSafeEncode($remote['qiniu']['bucket'] . ':' . $rstring);
            goto hNZS6;
            sci7S:
            AGbJ4:
            goto HHXbh;
            cP6SF:
            $wmImg .= Qiniu\base64_urlSafeEncode(tomedia($remote['qiniu']['watermark']));
            goto dZsEb;
            qAOME:
            iS56L:
            goto aDjiP;
            SOaGu:
            $wmImg = '/wmImage/';
            goto cP6SF;
            hNZS6:
            $wmImg = '';
            goto Z03Vc;
            TQVO7:
            $rstring = $karr[0] . rand(1000, 9999) . '.' . $karr[1];
            goto IWBVH;
            q2PTo:
            goto AouUC;
            goto qAOME;
            ewwKN:
            goto B0O3e;
            goto dc44Z;
            hhADV:
            $key = $v;
            goto NKc9v;
            WDi16:
            XMgXS:
            goto hhADV;
            Um3OF:
            if ($err != null) {
                goto iS56L;
            }
            goto HeeLE;
            VuA0V:
        }
        goto zDwFZ;
        nPzVD:
        $auth = new Qiniu\Auth($accessKey, $secretKey);
        goto oSjZW;
        ak7J3:
        $_GPC['vuid'] = $vuid;
        goto lKq2q;
        MgGGa:
        $modulelist = uni_modules(false);
        goto NOVBM;
        hC6x0:
        $vuid = $_GPC['vuid'];
        goto sJNzi;
        oSjZW:
        $pipeline = $remote['qiniu']['qn_queuename'];
        goto idLqa;
        PQj2c:
    }
    public function doMobileQnNotify()
    {
        global $_W, $_GPC;
        var_dump($_GPC);
    }
    public function saverobot($data = array())
    {
        goto ayqsB;
        venGx:
        ojvkF:
        goto vaugo;
        cZfk4:
        return false;
        goto If6G1;
        ayqsB:
        if (!empty($data)) {
            goto wTtLx;
        }
        goto cZfk4;
        Axxma:
        load()->func('communication');
        goto ONm8G;
        If6G1:
        wTtLx:
        goto sizca;
        ONm8G:
        $content = ihttp_post($url, $data);
        goto YgFIg;
        tIZ89:
        $data_token['module_id'] = $data['module_id'] = 3;
        goto IqEWH;
        vaugo:
        return true;
        goto sKtgE;
        YgFIg:
        if (!($content['code'] != 200)) {
            goto qXc3H;
        }
        goto OXJ7J;
        myrmU:
        $data_token['ticket'] = $data['ticket'] = $cfg['ticket'];
        goto tIZ89;
        klK8F:
        $data['token'] = md5(sha1(implode('', $data_token)));
        goto Axxma;
        XuBdt:
        $cfg = $this->module['config'];
        goto HH3DI;
        IqEWH:
        $data_token['time'] = $data['time'] = time();
        goto J2JCz;
        sizca:
        $robot_auth_url = 'http://player.aijiam.com';
        goto XuBdt;
        BH9W0:
        return false;
        goto venGx;
        HH3DI:
        $url = $robot_auth_url . '/index/vote/saverobot';
        goto myrmU;
        q2H7B:
        $result = json_decode($content['content'], true);
        goto YUk43;
        w9Y7K:
        qXc3H:
        goto q2H7B;
        YUk43:
        if (!($result['sta'] == 0)) {
            goto ojvkF;
        }
        goto BH9W0;
        OXJ7J:
        return false;
        goto w9Y7K;
        J2JCz:
        ksort($data_token);
        goto klK8F;
        sKtgE:
    }
    public function getrobot($data)
    {
        goto Yo06B;
        pr4rZ:
        return $result['error'];
        goto GmUcw;
        Lpdy3:
        if (!($content['code'] != 200)) {
            goto jLiOd;
        }
        goto LuIXL;
        nxHTJ:
        ksort($data_token);
        goto gniWG;
        iDI_b:
        $cfg = $this->module['config'];
        goto ZWx1v;
        r3x5l:
        jLiOd:
        goto ddorr;
        K21pF:
        YbgPv:
        goto iDI_b;
        xewg5:
        ZbKJv:
        goto pr4rZ;
        BAMGx:
        return false;
        goto xewg5;
        ddorr:
        $result = json_decode($content['content'], true);
        goto PD_B0;
        ZSHSK:
        $data_token['module_id'] = $data['module_id'] = 3;
        goto HXdfY;
        ZWx1v:
        $url = 'http://player.aijiam.com' . '/index/vote/getrobot';
        goto YYG5P;
        Q5dK0:
        $content = ihttp_post($url, $data);
        goto Lpdy3;
        gniWG:
        $data['token'] = md5(sha1(implode('', $data_token)));
        goto KnRSf;
        HXdfY:
        $data_token['time'] = $data['time'] = time();
        goto nxHTJ;
        PD_B0:
        if (!($result['sta'] == 0)) {
            goto ZbKJv;
        }
        goto BAMGx;
        LuIXL:
        return false;
        goto r3x5l;
        KnRSf:
        load()->func('communication');
        goto Q5dK0;
        YYG5P:
        $data_token['ticket'] = $data['ticket'] = $cfg['ticket'];
        goto ZSHSK;
        wmAjF:
        return false;
        goto K21pF;
        Yo06B:
        if (!empty($data['rid'])) {
            goto YbgPv;
        }
        goto wmAjF;
        GmUcw:
    }
    public function delrobot($data)
    {
        goto cXr2E;
        Cpfvg:
        $cfg = $this->module['config'];
        goto xVwll;
        AKq09:
        $data_token['module_id'] = $data['module_id'] = 3;
        goto Waa7w;
        cXr2E:
        if (!(empty($data['id']) && empty($data['rid']))) {
            goto FpF0F;
        }
        goto FMvzo;
        a71n8:
        return false;
        goto oA2YM;
        xVwll:
        $url = 'http://player.aijiam.com' . '/index/vote/delrobot';
        goto zE4gb;
        GDAje:
        $content = ihttp_post($url, $data);
        goto kxzU0;
        yu_gt:
        if (!($result['sta'] == 0)) {
            goto bqkQd;
        }
        goto BSOQH;
        zE4gb:
        $data_token['ticket'] = $data['ticket'] = $cfg['ticket'];
        goto AKq09;
        iq3gw:
        load()->func('communication');
        goto GDAje;
        Waa7w:
        $data_token['time'] = $data['time'] = time();
        goto LjtV7;
        d4sMJ:
        bqkQd:
        goto Bl8C4;
        jxpi9:
        FpF0F:
        goto Cpfvg;
        kxzU0:
        if (!($content['code'] != 200)) {
            goto zXdCr;
        }
        goto a71n8;
        mz6Wu:
        $result = json_decode($content['content'], true);
        goto yu_gt;
        BXP7J:
        $data['token'] = md5(sha1(implode('', $data_token)));
        goto iq3gw;
        oA2YM:
        zXdCr:
        goto mz6Wu;
        Bl8C4:
        return $result['error'];
        goto vsM4f;
        FMvzo:
        return false;
        goto jxpi9;
        BSOQH:
        return false;
        goto d4sMJ;
        LjtV7:
        ksort($data_token);
        goto BXP7J;
        vsM4f:
    }
    public function get_tplprefix($html_id)
    {
        goto oGo8U;
        nplwK:
        $data_token['html_id'] = $data['html_id'] = $html_id;
        goto TAUq0;
        TU19E:
        if (!($result['sta'] == 0)) {
            goto PrLRj;
        }
        goto eHPdh;
        BtyTa:
        return $result['data'];
        goto DPeKY;
        s9EFF:
        return false;
        goto ulaqZ;
        UU4Ak:
        $cfg = $this->module['config'];
        goto ki90Z;
        mAI3j:
        $content = ihttp_post($url, $data);
        goto wk8VX;
        eHPdh:
        return false;
        goto nWl6X;
        JlMxf:
        $data_token['ticket'] = $data['ticket'] = $cfg['ticket'];
        goto nplwK;
        oGo8U:
        global $_W, $_GPC;
        goto UU4Ak;
        Qkwt0:
        load()->func('communication');
        goto mAI3j;
        ki90Z:
        $url = $this->auth_url . '/index/votehtml/gettplprefix';
        goto JlMxf;
        nWl6X:
        PrLRj:
        goto BtyTa;
        ulaqZ:
        icfr7:
        goto LHmW1;
        Y22vC:
        ksort($data_token);
        goto mKVPI;
        LHmW1:
        $result = json_decode($content['content'], true);
        goto TU19E;
        wk8VX:
        if (!($content['code'] != 200)) {
            goto icfr7;
        }
        goto s9EFF;
        TAUq0:
        $data_token['time'] = $data['time'] = time();
        goto Y22vC;
        mKVPI:
        $data['token'] = md5(sha1(implode('', $data_token)));
        goto Qkwt0;
        DPeKY:
    }
    public function get_cloud_data_robot($tag, $count, $source_str)
    {
        goto KhdR2;
        UC5M2:
        n20KI:
        goto yqqeP;
        u1va3:
        ksort($data_token);
        goto fZ1Fx;
        lu2Pd:
        return json_encode($result['data']);
        goto DZsoG;
        aUcTm:
        vys_X:
        goto lu2Pd;
        uoLOX:
        return false;
        goto UC5M2;
        v2c5H:
        if (!($result['sta'] == 0)) {
            goto vys_X;
        }
        goto y1nef;
        fQFOh:
        $data_token['ticket'] = $data['ticket'] = $cfg['ticket'];
        goto BJCQe;
        vJFpJ:
        $data['count'] = $count;
        goto RORZw;
        bMcoe:
        $url = 'http://player.aijiam.com' . '/index/vote/getuser';
        goto fQFOh;
        BJCQe:
        $data_token['module_id'] = $data['module_id'] = 3;
        goto SVQwQ;
        RORZw:
        $data['source_str'] = $source_str;
        goto s9Yy3;
        mTxJN:
        if (!($content['code'] != 200)) {
            goto n20KI;
        }
        goto uoLOX;
        yqqeP:
        $result = json_decode($content['content'], true);
        goto v2c5H;
        y1nef:
        return false;
        goto aUcTm;
        s9Yy3:
        load()->func('communication');
        goto c7q13;
        SVQwQ:
        $data_token['time'] = $data['time'] = time();
        goto u1va3;
        aG2Fn:
        $cfg = $this->module['config'];
        goto bMcoe;
        KhdR2:
        global $_W, $_GPC;
        goto aG2Fn;
        c7q13:
        $content = ihttp_post($url, $data);
        goto mTxJN;
        Qrs8d:
        $data['tag'] = $tag;
        goto vJFpJ;
        fZ1Fx:
        $data['token'] = md5(sha1(implode('', $data_token)));
        goto Qrs8d;
        DZsoG:
    }
}