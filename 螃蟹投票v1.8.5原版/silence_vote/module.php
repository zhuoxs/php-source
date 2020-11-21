<?php
goto sJgNp;
sJgNp:
defined('IN_IA') or die('Access Denied');
goto q7QrZ;
fF8IB:
require SILENCE_MODEL_FUNC . '/function.php';
goto Oaau8;
q7QrZ:
require IA_ROOT . '/addons/silence_vote/defines.php';
goto fF8IB;
Oaau8:
class Silence_voteModule extends WeModule
{
    public $table_reply = "silence_vote_reply";
    public $tablevoteuser = "silence_vote_voteuser";
    public $tablevotedata = "silence_vote_votedata";
    public $tablegift = "silence_vote_gift";
    public $tablecount = "silence_vote_count";
    public $table_fans = "silence_vote_fansdata";
    public $tableredpack = "silence_vote_redpack";
    public $tablefriendship = "silence_vote_friendship";
    public $tablelooklist = "silence_vote_looklist";
    public $tableviporder = "silence_vote_viporder";
    public $tableblacklist = "silence_vote_blacklist";
    public $tabledomainlist = "silence_vote_domainlist";
    public $tablesetmeal = "silence_vote_setmeal";
    public function fieldsFormDisplay($rid = 0)
    {
        goto UZRnE;
        ZZbwt:
        $reply['style'] = @unserialize($reply['style']);
        goto nUW6i;
        g13vX:
        $maxpiclist = count($piclist) + 1;
        goto Zh8F2;
        Nouo_:
        $meal = pdo_get($this->tablesetmeal, array("userid" => $_W['user']['uid']), array("count", "starttime", "endtime", "status"));
        goto aG1dZ;
        KNvwY:
        $tpl_setinput = $this->tpl_setinput($applydata);
        goto KfxCI;
        WXzqq:
        $template = $this->tplmobile();
        goto Td8nO;
        rVQxI:
        $setmealstatus = 1;
        goto omfm2;
        EHJBM:
        goto dQP2w;
        goto DU3_Y;
        omfm2:
        if (!$meal['count']) {
            goto ZfRkS;
        }
        goto Ic0U_;
        nUW6i:
        if (!empty($reply['style']['template'])) {
            goto i1Gmr;
        }
        goto ntB8r;
        d3B1F:
        JXBB7:
        goto RSMNG;
        G24f7:
        $setmealstatus = 1;
        goto ckhu9;
        eH8IP:
        $alevelpercent = @unserialize($reply['alevelpercent']);
        goto Uw7ss;
        AaOPC:
        if (!$reply['viewtopa']) {
            goto NQHx7;
        }
        goto plpBk;
        ln1M6:
        $reply['style'] = @unserialize($reply['style']);
        goto sxOdL;
        idbbC:
        dQP2w:
        goto XlXa0;
        Uw7ss:
        $arewardpercent = @unserialize($reply['arewardpercent']);
        goto i2wN7;
        cuW8S:
        OUpDp:
        goto ZoFlv;
        ZtDln:
        if ($creditnames) {
            goto Ggs1X;
        }
        goto VRDLt;
        QCG0A:
        $setmealstatus = 1;
        goto ZFuRW;
        lTjuJ:
        JKyvn:
        goto TWClk;
        ckhu9:
        $setmealmsg = '套餐未生效，请联系管理员开通，QQ：7367595';
        goto pGBtc;
        rB67z:
        $applydata = @unserialize($reply['applydata']);
        goto OPDYt;
        aFI54:
        $indexpica = json_decode($reply['indexpica'], true) ?: array();
        goto vjhd6;
        cGG_9:
        vIOOs:
        goto W5RMd;
        VBtHM:
        i1Gmr:
        goto UUdu1;
        PO3J2:
        $applydata = array("0" => array("infoname" => "手机", "infotype" => "mobile", "notnull" => "1"), "2" => array("infoname" => "收货地址", "infotype" => "affectivestatus", "notnull" => "1"));
        goto BATC1;
        Tod4k:
        FbTaJ:
        goto o7mAa;
        iM9Na:
        $reply['style']['setstyle'] = 'default_index';
        goto VBtHM;
        aG1dZ:
        if (!empty($meal)) {
            goto JXBB7;
        }
        goto QCG0A;
        VRDLt:
        $scredit = '';
        goto gT2Hm;
        e1Ul3:
        $setmealmsg = '套餐已禁用，请联系管理员开通，QQ：7367595';
        goto brUfm;
        VI71l:
        Ggs1X:
        goto X_ejL;
        W5RMd:
        cUW0O:
        goto AaOPC;
        UUdu1:
        $addata = @unserialize($reply['addata']);
        goto gAMc3;
        z8Orp:
        $totalrid = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename($this->table_reply) . ' WHERE   uniacid = :uniacid  ', array(":uniacid" => $_W['uniacid']));
        goto irGdI;
        RSMNG:
        if (!$meal['status']) {
            goto TJfes;
        }
        goto Ek5uX;
        Td8nO:
        $creditnames = uni_setting($_W['uniacid'], array("creditnames"));
        goto ZtDln;
        UZRnE:
        global $_W, $_GPC;
        goto WXzqq;
        XlXa0:
        if (file_exists(MODULE_ROOT . '/lib/font/font.ttf')) {
            goto xG6f_;
        }
        goto OlmRp;
        iGwFQ:
        if (!($meal['starttime'] > time())) {
            goto Z8q8Z;
        }
        goto G24f7;
        cTXiq:
        WCuis:
        goto z8Orp;
        ZoFlv:
        $scredit = implode(', ', array_keys($creditnames['creditnames']));
        goto bndwg;
        GHCAZ:
        $reply['rstatus'] = $reply['status'];
        goto qpknt;
        DNJi9:
        $giftdata = array("2" => array("gifticon" => $_W['siteroot'] . '/addons/silence_vote/template/static/images/mrgift1.png', "gifttitle" => "蛋糕", "giftprice" => 5, "giftvote" => "10"), "0" => array("gifticon" => $_W['siteroot'] . '/addons/silence_vote/template/static/images/mrgift2.png', "gifttitle" => "飞吻", "giftprice" => 1, "giftvote" => "3"), "1" => array("gifticon" => $_W['siteroot'] . '/addons/silence_vote/template/static/images/mrgift3.png', "gifttitle" => "棒棒糖", "giftprice" => 3, "giftvote" => "5"), "3" => array("gifticon" => $_W['siteroot'] . '/addons/silence_vote/template/static/images/mrgift4.png', "gifttitle" => "520", "giftprice" => 520, "giftvote" => "1188"), "4" => array("gifticon" => $_W['siteroot'] . '/addons/silence_vote/template/static/images/mrgift5.png', "gifttitle" => "手机", "giftprice" => 888, "giftvote" => "1888"), "5" => array("gifticon" => $_W['siteroot'] . '/addons/silence_vote/template/static/images/mrgift6.png', "gifttitle" => "钻戒", "giftprice" => 1888, "giftvote" => "2888"));
        goto bB3z1;
        O9F3_:
        $baiduapikey = $this->module['config']['baiduapikey'];
        goto EgKXn;
        mdRgm:
        $reply['title'] = $reply['title'] . '复制' . random(5, true);
        goto LtKuf;
        X_ejL:
        foreach ($creditnames['creditnames'] as $index => $creditname) {
            goto Po0WZ;
            Po0WZ:
            if (!($creditname['enabled'] == 0)) {
                goto XW9Tn;
            }
            goto ZLlUT;
            ZLlUT:
            unset($creditnames['creditnames'][$index]);
            goto RcKI8;
            YeVWz:
            oG9ea:
            goto qdHjo;
            RcKI8:
            XW9Tn:
            goto YeVWz;
            qdHjo:
        }
        goto cuW8S;
        mfJ5i:
        xG6f_:
        goto tNzmt;
        nWM0h:
        if (empty($rid)) {
            goto L_rIY;
        }
        goto ydWcy;
        o7mAa:
        $reply = array("title" => "男神女神，萌宝帅宠，快来参加吧", "thumb" => "../addons/silence_vote/template/static/images/topimg.jpg", "description" => "全民投票的时代，你怎么能错过，邀请好友一起来帮你吧。", "starttime" => time(), "endtime" => time() + 10 * 84400, "apstarttime" => time(), "apendtime" => time() + 10 * 84400, "votestarttime" => time(), "voteendtime" => time() + 10 * 84400, "topimg" => "../addons/silence_vote/template/static/images/topimg.jpg", "bgcolor" => "#fff", "eventrule" => "请设置活动规则内容，支持多媒体HTML！", "prizemsg" => "请设置活动奖品内容，支持多媒体HTML！", "area" => "", "ischecked" => 1, "followguide" => "关注公众号后，点击菜单或回复投票关键字即可参加投票。", "diamondvalue" => 1, "votecredit1" => 0, "votecredit2" => 0, "gvotecredit1" => 0, "gvotecredit2" => 0, "joincredit1" => 0, "joincredit2" => 0, "minupimg" => 1, "maxupimg" => 5, "posterkey" => $this->createRandomStr(5), "exchange" => 3, "jdexchange" => 3, "diamondmodel" => $_W['account']['level'] < 3 ? 1 : 0, "rankingnum" => 20, "everyoneuser" => 2, "dailyvote" => 6, "everyonevote" => 50, "everyonediamond" => 0, "giftscale" => 1, "giftunit" => "元", "virtualpv" => 0, "voteadimg" => "", "minnumpeople" => 0, "bill_hint" => "邀请方法：1、长按图片保存；2、发送给好友或朋友圈；3、好友帮忙投票", "bill_bg" => $_W['siteroot'] . '/addons/silence_vote/template/static/images/posterbg.jpg', "act_name" => "投票奖励红包", "send_name" => "投票", "wishing" => "恭喜发财，大吉大利！", "remark" => "玩越多得越多，奖励越多！", "isredpack" => 0, "rstatus" => 1, "views1" => 3, "views2" => 4, "views3" => 5);
        goto DNJi9;
        EgKXn:
        $ipcity = $retData['retData']['city'];
        goto nWM0h;
        ckgMe:
        $setmealstatus = 1;
        goto OD55a;
        irGdI:
        if (!($totalrid >= $meal['count'])) {
            goto xK32I;
        }
        goto rVQxI;
        j2EDY:
        $reply = pdo_fetch('SELECT * FROM ' . tablename($this->table_reply) . ' WHERE rid = :rid ORDER BY `id` DESC', array(":rid" => $_GPC['copyid']));
        goto mdRgm;
        brUfm:
        TJfes:
        goto iGwFQ;
        gAMc3:
        $giftdata = @unserialize($reply['giftdata']);
        goto KDjwm;
        Mn0Gl:
        jki2x:
        goto idbbC;
        OlmRp:
        $nofont = 1;
        goto mfJ5i;
        tNzmt:
        $piclist = array();
        goto JWOsR;
        gT2Hm:
        goto rgeRi;
        goto VI71l;
        JWOsR:
        if (!$reply['indexpic']) {
            goto cUW0O;
        }
        goto NLV1j;
        KDjwm:
        $applydata = @unserialize($reply['applydata']);
        goto iaaPS;
        OPDYt:
        $bill_data = json_decode(str_replace('&quot;', '\'', $reply['bill_data']), true);
        goto KNvwY;
        v9QpA:
        xK32I:
        goto lTjuJ;
        Zh8F2:
        include $this->template('form');
        goto gU1sy;
        bB3z1:
        ksort($giftdata);
        goto PO3J2;
        DU3_Y:
        L_rIY:
        goto MKtTC;
        ZFuRW:
        $setmealmsg = '未开通套餐，请联系管理员开通套餐，QQ：7367595';
        goto d3B1F;
        LtKuf:
        $reply['rstatus'] = $reply['status'];
        goto BtOeG;
        RFY9C:
        goto jki2x;
        goto Tod4k;
        Td48w:
        if (!($meal['endtime'] < time())) {
            goto WCuis;
        }
        goto ckgMe;
        cZRjV:
        NQHx7:
        goto g13vX;
        pGBtc:
        Z8q8Z:
        goto Td48w;
        sxOdL:
        $addata = @unserialize($reply['addata']);
        goto jlPG8;
        qpknt:
        $reply = @array_merge($reply, @unserialize($reply['config']));
        goto ZZbwt;
        OD55a:
        $setmealmsg = '套餐已过期，请联系管理员开通，QQ：7367595';
        goto cTXiq;
        iaaPS:
        $bill_data = json_decode(str_replace('&quot;', '\'', $reply['bill_data']), true);
        goto u9m3W;
        NLV1j:
        $indexpic = json_decode($reply['indexpic'], true) ?: array();
        goto xsQlx;
        bndwg:
        rgeRi:
        goto O9F3_;
        jlPG8:
        $giftdata = @unserialize($reply['giftdata']);
        goto rB67z;
        Ek5uX:
        $setmealstatus = 1;
        goto e1Ul3;
        u9m3W:
        $tpl_setinput = $this->tpl_setinput($applydata);
        goto eH8IP;
        kG8fa:
        $setmealstatus = 0;
        goto Nouo_;
        XTfT3:
        ZfRkS:
        goto v9QpA;
        KfxCI:
        unset($reply['id'], $reply['voteadurl']);
        goto RFY9C;
        ntB8r:
        $reply['style']['template'] = 'default';
        goto iM9Na;
        BATC1:
        $tpl_setinput = $this->tpl_setinput($applydata);
        goto Mn0Gl;
        wYU78:
        if (!($issetmeal && empty($_W['isfounder']))) {
            goto JKyvn;
        }
        goto kG8fa;
        i2wN7:
        $divtitle = json_decode($reply['divtitle'], true);
        goto EHJBM;
        TWClk:
        if (empty($_GPC['copyid'])) {
            goto FbTaJ;
        }
        goto j2EDY;
        plpBk:
        $viewtopa = unserialize($reply['viewtopa']);
        goto cZRjV;
        MKtTC:
        $issetmeal = pdo_tableexists('silence_vote_setmeal');
        goto wYU78;
        xsQlx:
        $indexpicbtn = json_decode($reply['indexpicbtn'], true) ?: array();
        goto aFI54;
        Ic0U_:
        $setmealmsg = $meal['count'] . '个活动套餐已用完，请联系管理员升级套餐，QQ：7367595';
        goto XTfT3;
        vjhd6:
        foreach ($indexpic as $k => $v) {
            goto xhhdY;
            g8EfR:
            $ipb = $indexpicbtn[$k] ?: '';
            goto M4uYI;
            M4uYI:
            $ipa = $indexpica[$k] ?: '';
            goto kJIzc;
            xhhdY:
            $ip = $indexpic[$k] ?: '';
            goto g8EfR;
            ZeF_Z:
            rNuFW:
            goto wiDR5;
            kJIzc:
            $piclist[] = array("indexpic" => $ip, "indexpicbtn" => $ipb, "indexpica" => $ipa);
            goto ZeF_Z;
            wiDR5:
        }
        goto cGG_9;
        BtOeG:
        $reply = @array_merge($reply, @unserialize($reply['config']));
        goto ln1M6;
        ydWcy:
        $reply = pdo_fetch('SELECT * FROM ' . tablename($this->table_reply) . ' WHERE rid = :rid ORDER BY `id` DESC', array(":rid" => $rid));
        goto GHCAZ;
        gU1sy:
    }
    public function fieldsFormValidate($rid = 0)
    {
        return '';
    }
    public function fieldsFormSubmit($rid)
    {
        goto r743Q;
        vpSWc:
        $detail['jpjs'] ?: ($detail['jpjs'] = '#000000');
        goto wGyUl;
        grt1H:
        $detail['dbxszt'] ?: ($detail['dbxszt'] = '#fc519e');
        goto IW8sh;
        NVrkw:
        message('默认分销返佣+默认选手返佣比例不能超过100%');
        goto fMGGC;
        vpuQW:
        u9AND:
        goto npB9v;
        cjkaz:
        $detail['jzgdzt'] ?: ($detail['jzgdzt'] = '#ffffff');
        goto mpp2L;
        bHAWX:
        $k = 0;
        goto nkOVQ;
        p0hSC:
        $detail['tabzt'] ?: ($detail['tabzt'] = '#555555');
        goto tr8lx;
        lTvjc:
        $k = 0;
        goto qVG5O;
        wGyUl:
        $detail['zjbt'] ?: ($detail['zjbt'] = '#000000');
        goto LZxpA;
        oKQqv:
        if (!($k >= count($_POST['gifttitle']))) {
            goto TqlS7;
        }
        goto UhtES;
        TYaQd:
        $setmealstatus = 1;
        goto MODKu;
        xdjUT:
        message('设置成功！', $this->createWebUrl('manage', array("name" => "silence_vote")), 'success');
        goto O2WQo;
        wirrF:
        goto RDXy9;
        goto fhW2F;
        IBltH:
        rlF_F:
        goto KaksE;
        H2Uja:
        $i = 0;
        goto KhVmZ;
        VTSRk:
        $levelt = $_GPC['levelt'];
        goto HKGXI;
        NKNTz:
        $k++;
        goto pDB6j;
        Vfy6x:
        GKvix:
        goto PLTL6;
        LZxpA:
        $detail['btfsz'] ?: ($detail['btfsz'] = '#ffffff');
        goto W3bR5;
        rjDdu:
        exit;
        goto aEqgW;
        GyL0r:
        $detail['viewnavbarzt'] ?: ($detail['viewnavbarzt'] = '#ffffff');
        goto Uukf7;
        Z8fxT:
        $al[$percental[$i]]['l1'] = $levelo[$i];
        goto uCJjb;
        riSIV:
        $detail['csjlzt'] ?: ($detail['csjlzt'] = '#999999');
        goto GYslk;
        fhW2F:
        d1W24:
        goto rQlCn;
        ZRm5X:
        $detail['zbzt'] ?: ($detail['zbzt'] = '#fc519e');
        goto lmXZs;
        vi7np:
        $detail['zjbtnbj'] ?: ($detail['zjbtnbj'] = '#000000');
        goto ZRm5X;
        Sq8VV:
        $detail['xsps'] ?: ($detail['xsps'] = '#ff75b3');
        goto nSBLA;
        oks1Y:
        $levelo = $_GPC['levelo'];
        goto VTSRk;
        K0Xi_:
        exit;
        goto lbUBo;
        rQlCn:
        $addata[$k] = array("type" => 1, "adtitle" => $_POST['adtitle'][$k], "adimg" => $_POST['adimg'][$k], "adurl" => $_POST['adurl'][$k]);
        goto z9VDd;
        f1F1A:
        Wm27O:
        goto ABasG;
        RfYXt:
        $applydata[$k] = array("infoname" => $_POST['infoname'][$k], "infotype" => $_POST['infotype'][$k], "notnull" => $_POST['notnull'][$k], "isshow" => $_POST['isshow'][$k]);
        goto NKNTz;
        VisD5:
        $indexpic = json_encode($_GPC['indexpic']);
        goto Fjotp;
        i3XFQ:
        $k++;
        goto wirrF;
        CEDt8:
        $detail['shsps'] ?: ($detail['shsps'] = '#fc519e');
        goto riSIV;
        x50e7:
        $al[$percental[$i]]['l3'] = $levelth[$i];
        goto imxdM;
        Tyjrb:
        if (!(empty($meal) && empty($_W['isfounder']))) {
            goto GKvix;
        }
        goto Sqi5j;
        BK0OW:
        if (!($k >= count($_POST['infoname']))) {
            goto jioLD;
        }
        goto C7eSs;
        yoRgJ:
        $detail['ranktabxzbj'] ?: ($detail['ranktabxzbj'] = '#42b9fe');
        goto m0hot;
        nSBLA:
        $detail['votebtnzt'] ?: ($detail['votebtnzt'] = '#ffffff');
        goto utsDD;
        iJqFi:
        $acc = WeAccount::create($uniacid);
        goto GdYye;
        DJ8dh:
        $indexpica = json_encode($_GPC['indexpica']);
        goto l4z9C;
        uxKfT:
        $id = intval($_GPC['reply_id']);
        goto fnCo2;
        imxdM:
        ImtXU:
        goto G6dx6;
        XEEYC:
        $al = array();
        goto KWHjm;
        KarUJ:
        $divtitle = json_encode($_GPC['divtitle']);
        goto VisD5;
        l4z9C:
        $insert = array("rid" => $rid, "uniacid" => $_W['uniacid'], "title" => $_GPC['title'], "thumb" => $_GPC['thumb'], "description" => $_GPC['description'], "starttime" => strtotime($_GPC['time']['start']), "endtime" => strtotime($_GPC['time']['end']), "apstarttime" => strtotime($_GPC['aptime']['start']), "apendtime" => strtotime($_GPC['aptime']['end']), "votestarttime" => strtotime($_GPC['votetime']['start']), "voteendtime" => strtotime($_GPC['votetime']['end']), "topimg" => $_GPC['topimg'], "viewtopimg1" => $_GPC['viewtopimg1'], "viewtopimg2" => $_GPC['viewtopimg2'], "viewtopimg3" => $_GPC['viewtopimg3'], "viewtopimg4" => $_GPC['viewtopimg4'], "viewtopimg5" => $_GPC['viewtopimg5'], "viewtopa" => serialize($_GPC['viewtopa']), "bgcolor" => $_GPC['bgcolor'], "style" => $style, "mastercount" => htmlspecialchars_decode($_GPC['mastercount']), "eventrule" => htmlspecialchars_decode($_GPC['eventrule']), "prizemsg" => htmlspecialchars_decode($_GPC['prizemsg']), "divtitle" => $divtitle, "prizemsgdiv1" => htmlspecialchars_decode($_GPC['prizemsgdiv1']), "prizemsgdiv2" => htmlspecialchars_decode($_GPC['prizemsgdiv2']), "prizemsgdiv3" => htmlspecialchars_decode($_GPC['prizemsgdiv3']), "prizemsgdiv4" => htmlspecialchars_decode($_GPC['prizemsgdiv4']), "prizemsgdiv5" => htmlspecialchars_decode($_GPC['prizemsgdiv5']), "config" => $config, "addata" => $addata, "giftdata" => $giftdata, "bill_data" => htmlspecialchars_decode($_GPC['bill_data']), "applydata" => $applydata, "area" => $_GPC['area'], "sharetitle" => $_GPC['sharetitle'], "shareimg" => $_GPC['shareimg'], "sharedesc" => $_GPC['sharedesc'], "status" => $_GPC['rstatus'], "createtime" => time(), "rakebacklevel" => $_GPC['rakebacklevel'], "levelonepercent" => $_GPC['levelonepercent'], "leveltwopercent" => $_GPC['leveltwopercent'], "levelthreepercent" => $_GPC['levelthreepercent'], "rewardagentpercent" => $_GPC['rewardagentpercent'], "rewardplayer" => $_GPC['rewardplayer'], "rewardplayerpercent" => $_GPC['rewardplayerpercent'], "activecode" => $_GPC['activecode'], "guardstatus" => $_GPC['guardstatus'], "guardname" => $_GPC['guardname'], "freezemoney" => $_GPC['freezemoney'], "iscommandvote" => $_GPC['iscommandvote'], "commandvotedesc" => trim($_GPC['commandvotedesc']), "commandvotepic" => $_GPC['commandvotepic'], "agentlevel" => $_GPC['agentlevel'] ?: 0, "alevelpercent" => $alevelpercent, "arewardpercent" => $arewardpercent, "diybtnname" => $_GPC['diybtnname'], "diybtnurl" => $_GPC['diybtnurl'], "maxmirrorcommandps" => $_GPC['maxmirrorcommandps'], "maxkluse" => $_GPC['maxkluse'], "djsstatus" => $_GPC['djsstatus'], "topimga" => $_GPC['topimga'], "indexpic" => $indexpic, "indexpicbtn" => $indexpicbtn, "indexpica" => $indexpica, "bmzdy" => $_GPC['bmzdy'] ?: '参赛简历', "showgr" => $_GPC['showgr'], "globaltp" => mb_substr($_GPC['globaltp'], 0, 2, 'utf-8'), "globalp" => mb_substr($_GPC['globalp'], 0, 1, 'utf-8'), "globalttyp" => mb_substr($_GPC['globalttyp'], 0, 6, 'utf-8'), "showpvgr" => $_GPC['showpvgr'], "auditcode" => $_GPC['auditcode'], "tjshow" => $_GPC['tjshow'], "views1" => $_GPC['views1'], "views2" => $_GPC['views2'], "views3" => $_GPC['views3'], "isindextop" => $_GPC['isindextop'], "index_status" => $_GPC['index_status'], "user_status" => $_GPC['user_status'], "sh_status_index" => $_GPC['sh_status_index'], "sh_status_user" => $_GPC['sh_status_user']);
        goto zcP3E;
        h666h:
        $detail['rankps'] ?: ($detail['rankps'] = '#555555');
        goto vxGX3;
        HKGXI:
        $levelth = $_GPC['levelth'];
        goto untJ2;
        Oh2s2:
        foreach ($al as $key => $val) {
            goto JdfdP;
            c0yjx:
            IqaEV:
            goto zSWLM;
            W1mHR:
            if (!($jjrfx + $jjrxs > 100)) {
                goto PjsZz;
            }
            goto uZ175;
            U17Y3:
            MTHa1:
            goto W1mHR;
            fY8mR:
            PjsZz:
            goto dYaik;
            YoutV:
            goto MTHa1;
            goto c0yjx;
            JdfdP:
            $jjrfx = $val['l1'] + $val['l2'] + $val['l3'];
            goto Ee1dF;
            H2VLz:
            $jjrxs = $mrjjrxs;
            goto YoutV;
            dYaik:
            pHz0V:
            goto LE81H;
            zSWLM:
            $jjrxs = $ral[$key];
            goto U17Y3;
            uZ175:
            message('分销返佣+独立选手返佣比例不能超过100%');
            goto fY8mR;
            Ee1dF:
            if (!empty($ral[$key])) {
                goto IqaEV;
            }
            goto H2VLz;
            LE81H:
        }
        goto o6JBo;
        W3bR5:
        $detail['btfzt'] ?: ($detail['btfzt'] = '#ffffff');
        goto fKNsQ;
        XI9qV:
        pdo_update($this->table_reply, $insert, array("id" => $id));
        goto H6bEk;
        rg3fw:
        UyZh8:
        goto ioC9h;
        dsTiz:
        if (!($meal['endtime'] < time())) {
            goto r4k7O;
        }
        goto QEv6M;
        V2EZ8:
        $insert['detailset'] = $serdetail;
        goto To3Gx;
        IW8sh:
        $detail['dbqyzt'] ?: ($detail['dbqyzt'] = '#000000');
        goto UryIb;
        yuVfz:
        if (!($k >= count($_POST['adtitle']))) {
            goto d1W24;
        }
        goto LZxNB;
        Ex41v:
        MnFAh:
        goto wVW0T;
        z9VDd:
        $k++;
        goto AYojS;
        fnCo2:
        $config = @iserializer(array("jumpdomain" => $_GPC['jumpdomain'], "isfollow" => $_GPC['isfollow'], "indexorder" => $_GPC['indexorder'], "infoorder" => $_GPC['infoorder'], "unsubscribe" => $_GPC['unsubscribe'], "diamondvalue" => $_GPC['diamondvalue'], "diamondmodel" => $_GPC['diamondmodel'], "exchange" => $_GPC['exchange'], "jdexchange" => $_GPC['jdexchange'], "rankingnum" => $_GPC['rankingnum'], "divideinto" => $_GPC['divideinto'], "followguide" => $_GPC['followguide'], "notice" => $_GPC['notice'], "everyoneuser" => $_GPC['everyoneuser'], "dailyvote" => $_GPC['dailyvote'], "everyonevote" => $_GPC['everyonevote'], "isoneself" => $_GPC['isoneself'], "ischecked" => $_GPC['ischecked'], "voteadimg" => $_GPC['voteadimg'], "voteadtext" => $_GPC['voteadtext'], "voteadurl" => $_GPC['voteadurl'], "everyonediamond" => $_GPC['everyonediamond'], "isvotemsg" => $_GPC['isvotemsg'], "virtualpv" => intval($_GPC['virtualpv']), "iseggnone" => $_GPC['iseggnone'], "locationtype" => $_GPC['locationtype'], "isdiamondnone" => $_GPC['isdiamondnone'], "minnumpeople" => intval($_GPC['minnumpeople']), "join_btn_show" => intval($_GPC['join_btn_show']), "minupimg" => intval($_GPC['minupimg']), "maxupimg" => intval($_GPC['maxupimg']), "perminute" => intval($_GPC['perminute']), "perminutevote" => intval($_GPC['perminutevote']), "lockminutes" => intval($_GPC['lockminutes']), "votegive_type" => $_GPC['votegive_type'], "votegive_num" => $_GPC['votegive_num'], "joingive_type" => $_GPC['joingive_type'], "joingive_num" => $_GPC['joingive_num'], "giftgive_type" => $_GPC['giftgive_type'], "giftgive_num" => $_GPC['giftgive_num'], "awardgive_type" => $_GPC['awardgive_type'], "awardgive_num" => $_GPC['awardgive_num'], "isshowgift" => $_GPC['isshowgift'], "weixinopen" => $_GPC['weixinopen'], "isredpack" => $_GPC['isredpack'], "act_name" => $_GPC['act_name'], "send_name" => $_GPC['send_name'], "wishing" => $_GPC['wishing'], "remark" => $_GPC['remark'], "redpackettotal" => $_GPC['redpackettotal'], "lotterychance" => $_GPC['lotterychance'], "probability" => $_GPC['probability'], "ipplace" => $_GPC['ipplace'], "redpackarea" => $_GPC['redpackarea'], "redpacketnum" => $_GPC['redpacketnum'], "everyonenum" => $_GPC['everyonenum'], "limitstart" => $_GPC['limitstart'], "limitend" => $_GPC['limitend'], "isposter" => $_GPC['isposter'], "posterkey" => $_GPC['posterkey'], "bill_bg" => $_GPC['bill_bg'], "bill_hint" => $_GPC['bill_hint'], "defaultpay" => $_GPC['defaultpay'], "usepwd" => $_GPC['usepwd'], "giftscale" => $_GPC['giftscale'], "giftunit" => $_GPC['giftunit'], "isgiftad" => $_GPC['isgiftad'], "upimgtype" => $_GPC['upimgtype'], "musicshare" => $_GPC['musicshare'], "verifycode" => $_GPC['verifycode'], "isindexslide" => $_GPC['isindexslide'], "indexsound" => $_GPC['indexsound'], "index_ad" => $_GPC['index_ad'], "prize_ad" => $_GPC['prize_ad'], "rank_ad" => $_GPC['rank_ad'], "view_ad" => $_GPC['view_ad'], "gift_ad" => $_GPC['gift_ad'], "upvideotype" => $_GPC['upvideotype'], "videolbpic" => $_GPC['videolbpic'], "indexadimg" => $_GPC['indexadimg'], "indexadtext" => $_GPC['indexadtext'], "indexadurl" => $_GPC['indexadurl'], "isindextc" => $_GPC['isindextc'], "isviewtc" => $_GPC['isviewtc'], "istconce" => $_GPC['istconce'], "verifymove" => $_GPC['verifymove'], "viewshowtype" => $_GPC['viewshowtype'], "upaudiotype" => $_GPC['upaudiotype'], "videomax" => intval($_GPC['videomax']), "audiomax" => intval($_GPC['audiomax']), "globallw" => $_GPC['globallw'], "limitlocation" => $_GPC['limitlocation'], "bmxm" => $_GPC['bmxm'], "mrshowxs" => intval($_GPC['mrshowxs']), "sympsshow" => $_GPC['sympsshow']));
        goto bHAWX;
        VwHtx:
        $cfg = $this->module['config'];
        goto YWNu_;
        ioC9h:
        $detail = array();
        goto Vc_xE;
        htvTo:
        foreach ($ral as $key => $val) {
            goto chUQJ;
            nrJXa:
            $jjrfx = $al[$key]['l1'] + $al[$key]['l2'] + $al[$key]['l3'];
            goto q1yup;
            GPuLs:
            message('独立选手返佣+分销返佣比例不能超过100%');
            goto nVsrF;
            o_AI_:
            if (!empty($al[$key])) {
                goto PmY4C;
            }
            goto hZRUv;
            hZRUv:
            $jjrfx = $mrjjrfx;
            goto mQTwc;
            q1yup:
            DrJjh:
            goto thvtk;
            thvtk:
            if (!($jjrfx + $jjrxs > 100)) {
                goto BCMYr;
            }
            goto GPuLs;
            xKC4k:
            PmY4C:
            goto nrJXa;
            nVsrF:
            BCMYr:
            goto mBLh2;
            mBLh2:
            YU026:
            goto d71p3;
            mQTwc:
            goto DrJjh;
            goto xKC4k;
            chUQJ:
            $jjrxs = $val;
            goto o_AI_;
            d71p3:
        }
        goto IBltH;
        bLMqK:
        $setmealstatus = 1;
        goto v_F86;
        wpm27:
        message($setmealmsg);
        goto rxGth;
        FTaMi:
        $detail['zjbtnzt'] ?: ($detail['zjbtnzt'] = '#ffffff');
        goto vi7np;
        AlsK0:
        $setmealstatus = 0;
        goto ZdU40;
        H5fZx:
        $detail['rankxszt'] ?: ($detail['rankxszt'] = '#555555');
        goto h666h;
        H6bEk:
        goto D_gsV;
        goto ifRvP;
        ykCqK:
        r4k7O:
        goto n6ykG;
        hb3ie:
        message('按等级分销返佣时,经纪人等级不能为0');
        goto K0Xi_;
        nZ2Eo:
        $setmealmsg = '未开通套餐，请联系管理员开通套餐，QQ：7367595';
        goto Vfy6x;
        SPm1P:
        jioLD:
        goto RfYXt;
        QEv6M:
        $setmealstatus = 1;
        goto vbGVF;
        cgSyi:
        $detail['ranktabbj'] ?: ($detail['ranktabbj'] = '#666666');
        goto yoRgJ;
        GYslk:
        $detail['giftzt'] ?: ($detail['giftzt'] = '#666666');
        goto O5nDF;
        KhVmZ:
        TV2n0:
        goto ysk6n;
        V4s9K:
        $detail['navbarbj'] ?: ($detail['navbarbj'] = '#FEFF5D');
        goto BTJ6b;
        bHNuq:
        $cfg = $this->module['config'];
        goto p_IDw;
        sAbRa:
        $agentlist = pdo_fetchall('SELECT * FROM ' . tablename($this->modulename . '_agentlist') . " WHERE uniacid = {$_W['uniacid']} AND openid != '' and openid != '0'" . $where);
        goto cVVkd;
        cRQ9v:
        $where = " and agentlevel >= {$_GPC['agentlevel']}";
        goto sAbRa;
        boLUL:
        $detail['xsmc'] ?: ($detail['xsmc'] = '#42b9fe');
        goto Sq8VV;
        Vc_xE:
        $detail['hdbt'] ?: ($detail['hdbt'] = '#42b9fe');
        goto vpSWc;
        MODKu:
        $setmealmsg = '套餐未生效，请联系管理员开通，QQ：7367595';
        goto BjrCA;
        Uukf7:
        $detail['viewnavbarbj'] ?: ($detail['viewnavbarbj'] = '#42b9fe');
        goto UlNYt;
        UyJqi:
        goto I0USF;
        goto VcVNJ;
        pg0NT:
        $detail['sybj2'] ?: ($detail['sybj2'] = '#a3d9f9');
        goto rRWOY;
        WSVv_:
        $detail['searchbj'] ?: ($detail['searchbj'] = '#ff75b3');
        goto p0hSC;
        PLvcL:
        if (empty($res)) {
            goto RXIMD;
        }
        goto VwHtx;
        niCig:
        $giftdata[$k] = array("gifticon" => $_POST['gifticon'][$k], "gifttitle" => $_POST['gifttitle'][$k], "giftprice" => $_POST['giftprice'][$k], "giftvote" => $_POST['giftvote'][$k]);
        goto i3XFQ;
        to95S:
        if (!($totalrid >= $meal['count'])) {
            goto MnFAh;
        }
        goto y82fU;
        aEqgW:
        Uxfkf:
        goto lb_Gt;
        BCH05:
        $detail['shszt'] ?: ($detail['shszt'] = '#000000');
        goto CEDt8;
        tFLz3:
        RzIgq:
        goto IAMHH;
        nkOVQ:
        T2y3h:
        goto yuVfz;
        UlNYt:
        $detail['rankdbzt'] ?: ($detail['rankdbzt'] = '#ffffff');
        goto Xiodq;
        PLTL6:
        if (!$meal['status']) {
            goto Jx0pP;
        }
        goto bLMqK;
        wVW0T:
        if (!$setmealstatus) {
            goto BqN5g;
        }
        goto wpm27;
        EnKBM:
        $issetmeal = pdo_tableexists('silence_vote_setmeal');
        goto PgIRE;
        IAMHH:
        $i++;
        goto UyJqi;
        RiaRq:
        xoJCV:
        goto xTEox;
        untJ2:
        $rpercental = $_GPC['rpercental'];
        goto P3Gp9;
        LZxNB:
        $addata = @iserializer($addata);
        goto lTvjc;
        F2fbx:
        $detail['navbarxzbj'] ?: ($detail['navbarxzbj'] = '#FF75B3');
        goto XCUTF;
        C7eSs:
        $applydata = @iserializer($applydata);
        goto D1DSl;
        vbGVF:
        $setmealmsg = '套餐已过期，请联系管理员开通，QQ：7367595';
        goto ykCqK;
        DENPv:
        if (!($percental[$i] == 0)) {
            goto Dh9p_;
        }
        goto hb3ie;
        hOV7H:
        if (!($i < count($rpercental))) {
            goto BuSGB;
        }
        goto BOWyM;
        tr8lx:
        $detail['tabbj'] ?: ($detail['tabbj'] = '#ffffff');
        goto hwCYM;
        G6dx6:
        $i++;
        goto xCeD3;
        To3Gx:
        $res = pdo_insert($this->table_reply, $insert);
        goto PLvcL;
        VAUy2:
        $setmealmsg = $meal['count'] . '个活动套餐已用完，请联系管理员升级套餐，QQ：7367595';
        goto bHviX;
        OZVBC:
        $detail['searchzt'] ?: ($detail['searchzt'] = '#ffffff');
        goto WSVv_;
        XCUTF:
        $detail['dbbt'] ?: ($detail['dbbt'] = '#fff100');
        goto grt1H;
        xCeD3:
        goto TV2n0;
        goto RiaRq;
        xTEox:
        $i = 0;
        goto D8zTL;
        AYojS:
        goto T2y3h;
        goto f1F1A;
        v_F86:
        $setmealmsg = '套餐已禁用，请联系管理员开通，QQ：7367595';
        goto vLZsb;
        BTJ6b:
        $detail['navbarzt'] ?: ($detail['navbarzt'] = '#0F4196');
        goto F2fbx;
        Fjotp:
        $indexpicbtn = json_encode($_GPC['indexpicbtn']);
        goto DJ8dh;
        pDB6j:
        goto mODd8;
        goto Uts50;
        rxGth:
        BqN5g:
        goto rg3fw;
        KWHjm:
        $ral = array();
        goto H2Uja;
        isdP8:
        $arewardpercent = serialize($ral);
        goto KarUJ;
        naA00:
        $detail['tpbtnbj'] ?: ($detail['tpbtnbj'] = '#ff75b3');
        goto GyL0r;
        lb_Gt:
        $ral[$rpercental[$i]] = $rewal[$i];
        goto tFLz3;
        YWNu_:
        $reply_id = $rid;
        goto P7GAH;
        BjrCA:
        ljboN:
        goto dsTiz;
        UryIb:
        $detail['dbxfxszt'] ?: ($detail['dbxfxszt'] = '#42b9fe');
        goto GcVE3;
        snalH:
        unset($insert['createtime']);
        goto XI9qV;
        zcP3E:
        if (empty($id)) {
            goto EKUon;
        }
        goto snalH;
        qVG5O:
        RDXy9:
        goto oKQqv;
        fKNsQ:
        $detail['sybj1'] ?: ($detail['sybj1'] = '#f5c9dd');
        goto pg0NT;
        r743Q:
        global $_W, $_GPC;
        goto bHNuq;
        hwCYM:
        $detail['tabxzbj'] ?: ($detail['tabxzbj'] = '#feff5d');
        goto boLUL;
        lbUBo:
        Dh9p_:
        goto Z8fxT;
        UhtES:
        $style = @iserializer(array("template" => $_POST['template'], "setstyle" => $_POST['setstyle']));
        goto vKxtz;
        ifRvP:
        EKUon:
        goto EnKBM;
        npB9v:
        RXIMD:
        goto uW0jP;
        SQPit:
        message('按等级招募返佣时,经纪人等级不能为0');
        goto rjDdu;
        vLZsb:
        Jx0pP:
        goto DwRBS;
        Qy_0I:
        if (!($mrjjrfx + $mrjjrxs > 100)) {
            goto EOzTC;
        }
        goto NVrkw;
        O2WQo:
        goto Wm27O;
        goto SPm1P;
        HUN6V:
        $mrjjrfx = intval($_GPC['levelonepercent']) + intval($_GPC['leveltwopercent']) + intval($_GPC['levelthreepercent']);
        goto vMdBH;
        mpp2L:
        $detail['jzgdbj'] ?: ($detail['jzgdbj'] = '#ff75b3');
        goto V4s9K;
        ZdU40:
        $meal = pdo_get($this->tablesetmeal, array("userid" => $_W['user']['uid']), array("count", "starttime", "endtime", "status"));
        goto Tyjrb;
        p_IDw:
        $url = 'http://token.aijiam.com' . '/index/vote/checkauth';
        goto HDhgX;
        cVVkd:
        foreach ($agentlist as $userfan) {
            goto kVj6K;
            kVj6K:
            if (!$userfan) {
                goto kEUKH;
            }
            goto oObdn;
            uCfry:
            kEUKH:
            goto HwJTa;
            Fyj_K:
            $d = $acc->sendTplNotice($userfan['openid'], $cfg['OPENTM201303555'], $postdata, $re_url, $topcolor = '#FF683F');
            goto uCfry;
            oObdn:
            $postdata = array("first" => array("value" => "收到一条新活动通知", "color" => "#173177"), "keyword1" => array("value" => $_GPC['title'], "color" => "#173177"), "keyword2" => array("value" => date('Y-m-d H:i:s', $_W['timestamp']), "color" => "#173177"), "remark" => array("value" => "点击查看活动详情", "color" => "#173177"));
            goto Fyj_K;
            HwJTa:
            JMsIY:
            goto p2EM_;
            p2EM_:
        }
        goto vpuQW;
        y82fU:
        $setmealstatus = 1;
        goto RRYEI;
        vxGX3:
        $serdetail = serialize($detail);
        goto V2EZ8;
        m0hot:
        $detail['ranknumzt'] ?: ($detail['ranknumzt'] = '#42b9fe');
        goto H5fZx;
        HDhgX:
        $this->check_ticket($cfg, $url);
        goto uxKfT;
        BOWyM:
        if (!($rpercental[$i] == 0)) {
            goto Uxfkf;
        }
        goto SQPit;
        fMGGC:
        EOzTC:
        goto Oh2s2;
        P7GAH:
        $re_url = $_W['siteroot'] . 'app/' . $this->createMobileUrl('index', array("rid" => $reply_id, "op" => "originurl"));
        goto iJqFi;
        VcVNJ:
        BuSGB:
        goto HUN6V;
        vMdBH:
        $mrjjrxs = intval($_GPC['rewardagentpercent']);
        goto Qy_0I;
        bHviX:
        fUFN5:
        goto Ex41v;
        GcVE3:
        $detail['dbxfqyzt'] ?: ($detail['dbxfqyzt'] = '#000000');
        goto FTaMi;
        uW0jP:
        D_gsV:
        goto xdjUT;
        uCJjb:
        $al[$percental[$i]]['l2'] = $levelt[$i];
        goto x50e7;
        RRYEI:
        if (!$meal['count']) {
            goto fUFN5;
        }
        goto VAUy2;
        KaksE:
        $alevelpercent = serialize($al);
        goto isdP8;
        vKxtz:
        $giftdata = @iserializer($giftdata);
        goto cNG6m;
        cNG6m:
        $k = 0;
        goto O7GSs;
        GdYye:
        $_GPC['agentlevel'] = $_GPC['agentlevel'] ?: 0;
        goto cRQ9v;
        DwRBS:
        if (!($meal['starttime'] > time())) {
            goto ljboN;
        }
        goto TYaQd;
        rRWOY:
        $detail['sybj3'] ?: ($detail['sybj3'] = '#f5f5f5');
        goto OZVBC;
        D1DSl:
        $percental = $_GPC['percental'];
        goto oks1Y;
        O5nDF:
        $detail['tpbtnzt'] ?: ($detail['tpbtnzt'] = '#ffffff');
        goto naA00;
        Uts50:
        TqlS7:
        goto niCig;
        o6JBo:
        MChJu:
        goto htvTo;
        utsDD:
        $detail['votebtnbj'] ?: ($detail['votebtnbj'] = '#ff75b3');
        goto cjkaz;
        D8zTL:
        I0USF:
        goto hOV7H;
        Xiodq:
        $detail['rankdbbj'] ?: ($detail['rankdbbj'] = '#42b9fe');
        goto inGZU;
        Sqi5j:
        $setmealstatus = 1;
        goto nZ2Eo;
        PgIRE:
        if (!($issetmeal && empty($_W['isfounder']))) {
            goto UyZh8;
        }
        goto AlsK0;
        inGZU:
        $detail['ranktabzt'] ?: ($detail['ranktabzt'] = '#666666');
        goto cgSyi;
        P3Gp9:
        $rewal = $_GPC['rewal'];
        goto XEEYC;
        ysk6n:
        if (!($i < count($percental))) {
            goto xoJCV;
        }
        goto DENPv;
        O7GSs:
        mODd8:
        goto BK0OW;
        n6ykG:
        $totalrid = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename($this->table_reply) . ' WHERE   uniacid = :uniacid  ', array(":uniacid" => $_W['uniacid']));
        goto to95S;
        lmXZs:
        $detail['ybzt'] ?: ($detail['ybzt'] = '#42b9fe');
        goto BCH05;
        ABasG:
    }
    public function ruleDeleted($rid)
    {
        goto w0ADB;
        teHyh:
        ksort($data_token);
        goto SJ6QQ;
        AADxp:
        pdo_delete($this->tablecount, array("rid" => $rid));
        goto bImXx;
        bImXx:
        pdo_delete($this->tableredpack, array("rid" => $rid));
        goto ZWIRf;
        g9NRU:
        $data_token['time'] = $data['time'] = time();
        goto teHyh;
        gzNS9:
        $url = 'http://player.aijiam.com/index/vote/delrobot';
        goto YHbFp;
        YHbFp:
        $data_token['ticket'] = $data['ticket'] = $cfg['ticket'];
        goto kKk1M;
        k5qQg:
        $cfg = $this->module['config'];
        goto gzNS9;
        ZWIRf:
        pdo_delete($this->tabledomainlist, array("rid" => $rid));
        goto kvRUB;
        w0ADB:
        pdo_delete($this->table_reply, array("rid" => $rid));
        goto WvH0y;
        cnGsm:
        pdo_delete($this->tablegift, array("rid" => $rid));
        goto AADxp;
        P0dhP:
        load()->func('communication');
        goto HgRl_;
        s43gB:
        if (!($content['code'] != 200)) {
            goto jzOKT;
        }
        goto mqRkC;
        kvRUB:
        pdo_delete($this->modulename . '_mirrorvote', array("rid" => $rid));
        goto pPsrX;
        SJ6QQ:
        $data['token'] = md5(sha1(implode('', $data_token)));
        goto P0dhP;
        HgRl_:
        $content = ihttp_post($url, $data);
        goto s43gB;
        qJlD9:
        pdo_delete($this->tablevotedata, array("rid" => $rid));
        goto cnGsm;
        pPsrX:
        $data['rid'] = $rid;
        goto k5qQg;
        kKk1M:
        $data_token['module_id'] = $data['module_id'] = 3;
        goto g9NRU;
        YOW_w:
        jzOKT:
        goto htdoV;
        htdoV:
        $result = json_decode($content['content'], true);
        goto bjj92;
        mqRkC:
        return false;
        goto YOW_w;
        WvH0y:
        pdo_delete($this->tablevoteuser, array("rid" => $rid));
        goto qJlD9;
        bjj92:
    }
    public function settingsDisplay($settings)
    {
        goto I0rIT;
        DkvXe:
        message('证书保存失败, 请保证 /addons/silence_voicekey/template/certdata/ 目录可写');
        goto RHgih;
        f2cOh:
        if (!($remote['type'] == ATTACH_COS)) {
            goto DZ3gY;
        }
        goto MUa8O;
        AGbDY:
        if (!empty($remote['qiniu']['secretkey'])) {
            goto wUbFY;
        }
        goto XrMn9;
        RYmd3:
        $dat = array("certkey" => $_GPC['certkey'], "isopenweixin" => $_GPC['isopenweixin'], "key" => $_GPC['key'], "agentkey" => $_GPC['agentkey'], "mchid" => $_GPC['mchid'], "apikey" => $_GPC['apikey'], "remote" => $remote, "isagentrecommend" => $_GPC['isagentrecommend'], "israkeback" => $_GPC['israkeback'], "robotstatus" => $_GPC['robotstatus'], "ticket" => trim($_GPC['ticket']), "OPENTM406187050" => $_GPC['OPENTM406187050'], "TM00351" => $_GPC['TM00351'], "zcagentstatus" => $_GPC['zcagentstatus'], "minwithdraws" => (int) $_GPC['minwithdraws'], "zcxsstatus" => $_GPC['zcxsstatus'], "OPENTM201303555" => $_GPC['OPENTM201303555'], "OPENTM406762250" => $_GPC['OPENTM406762250'], "OPENTM409997271" => $_GPC['OPENTM409997271'], "ischeatshow" => $_GPC['ischeatshow'], "diytech" => $_GPC['diytech'], "OPENTM412230652" => $_GPC['OPENTM412230652'], "OPENTM412230652send" => $_GPC['OPENTM412230652send']);
        goto ozHux;
        KClo_:
        if (!(trim($remote['alioss']['secret']) == '')) {
            goto oWXFj;
        }
        goto DokiW;
        cHWfS:
        JzXW0:
        goto Gsb2s;
        VRLln:
        $url = trim($_GPC['custom']['url'], '/');
        goto ellfB;
        U3SZS:
        tlN1M:
        goto HqMaT;
        MUa8O:
        if (!empty($remote['cos']['appid'])) {
            goto dhMUY;
        }
        goto hS0Uq;
        AHRap:
        if (!is_error($buckets)) {
            goto TxFBH;
        }
        goto Wy9AM;
        B9297:
        if ($r) {
            goto Rv3DI;
        }
        goto DkvXe;
        LsFX9:
        if (!(strexists($remote['cos']['url'], '.cos.myqcloud.com') && !strexists($url, '//' . $remote['cos']['bucket'] . '-'))) {
            goto JbZhE;
        }
        goto VV9ps;
        gO0Rg:
        $remote['cos']['url'] = 'http://' . $remote['cos']['bucket'] . '-' . $remote['cos']['appid'] . '.cos.myqcloud.com';
        goto nimyq;
        Lmzda:
        if ($remote['type'] == ATTACH_QINIU) {
            goto tlN1M;
        }
        goto f2cOh;
        d4heB:
        if (!empty($_GPC['ticket'])) {
            goto cKV03;
        }
        goto T60Ao;
        Y4USp:
        $item['giftcount'] = !empty($item['giftcount']) ? $item['giftcount'] : 0;
        goto FbMHN;
        RXb9C:
        ll4rl:
        goto zgzN2;
        I0rIT:
        global $_W, $_GPC;
        goto n3Jiz;
        Ps3WD:
        X0F6z:
        goto hEWAL;
        pJuHP:
        bd6qt:
        goto rryMv;
        u039P:
        cKV03:
        goto MjV1q;
        ns01X:
        $oldcertroot = MODULE_ROOT . '/template/certdata/' . $_W['uniacid'] . '/' . $this->module['config']['certkey'];
        goto OsEq9;
        wV_cL:
        $item['dailygiftcount'] = pdo_fetchcolumn('SELECT sum(fee) FROM ' . tablename($this->tablegift) . ' WHERE   uniacid = :uniacid AND ispay=1 AND openid != \'addgift\' ' . $dailytimes, array(":uniacid" => $_W['uniacid']));
        goto Vlo1v;
        GdhnF:
        list($remote['alioss']['bucket'], $remote['alioss']['url']) = explode('@@', $_GPC['alioss']['bucket']);
        goto d1upF;
        Wy9AM:
        message('OSS-Access Key ID 或 OSS-Access Key Secret错误，请重新填写');
        goto YRIPM;
        hkLch:
        LPtyl:
        goto B9297;
        bJ2tU:
        message('FTP服务器地址为必填项.');
        goto kDPlV;
        PiQWs:
        if (!(!empty($remote['alioss']['key']) && !empty($remote['alioss']['secret']))) {
            goto EFZRl;
        }
        goto iWIJm;
        tLZX2:
        oWXFj:
        goto ldzKe;
        YCyjp:
        goto WronQ;
        goto sepVs;
        iWIJm:
        $buckets = attachment_alioss_buctkets($remote['alioss']['key'], $remote['alioss']['secret']);
        goto w7dWP;
        IeA70:
        message('请填写bucket', referer(), 'info');
        goto dpqcq;
        py_dk:
        if (empty($remote['cos']['url'])) {
            goto bklD1;
        }
        goto LsFX9;
        ZdS4z:
        JzdJq:
        goto AGbDY;
        Zp9Pl:
        xsLBY:
        goto v5eDG;
        m6bqf:
        PXepm:
        goto LDy8c;
        ee3mu:
        Ts4Fn:
        goto KClo_;
        VXzYu:
        $r = mkdirs($certroot);
        goto SmhrW;
        TmVkP:
        if ($remote['type'] == ATTACH_FTP) {
            goto VnX0o;
        }
        goto Lmzda;
        F0MrL:
        SJLx3:
        goto oMw0j;
        K_9mi:
        dhMUY:
        goto Pb_AP;
        hS0Uq:
        message('请填写APPID', referer(), 'info');
        goto K_9mi;
        A6TcO:
        h72fP:
        goto g7YWp;
        wn09N:
        z1ZrM:
        goto cBmVL;
        oMw0j:
        $remote = $settings['remote'];
        goto PiQWs;
        MithR:
        Duqiv:
        goto RewVS;
        ftoij:
        $bucket_datacenter = attachment_alioss_datacenters();
        goto YF0eL;
        Xmk0J:
        goto I3aCv;
        goto U3SZS;
        Tds2e:
        message('阿里云OSS-Access Key ID不能为空');
        goto ee3mu;
        hDccr:
        if (empty($_GPC['custom']['url'])) {
            goto Duqiv;
        }
        goto VRLln;
        tqJPE:
        $item['giftcount'] = pdo_fetchcolumn('SELECT sum(fee) FROM ' . tablename($this->tablegift) . ' WHERE   uniacid = :uniacid AND ispay=1 AND openid != \'addgift\' ', array(":uniacid" => $_W['uniacid']));
        goto BfdR1;
        MjV1q:
        if (!((int) $_GPC['minwithdraws'] <= 0)) {
            goto X0F6z;
        }
        goto ZEhas;
        M48t0:
        cIqxe:
        goto VXzYu;
        hWGYz:
        $item['dailyvotetotal'] = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename($this->tablevotedata) . ' WHERE   uniacid = :uniacid AND votetype=0 ' . $dailytimes, array(":uniacid" => $_W['uniacid']));
        goto wV_cL;
        fnV_p:
        pdo_query($sql);
        goto JckZ8;
        WxQb_:
        message($auth['message'], referer(), 'info');
        goto N_sXK;
        iMhtE:
        goto uh95x;
        goto pJuHP;
        DUMUS:
        $item['votetotal'] = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename($this->tablevotedata) . ' WHERE   uniacid = :uniacid AND votetype=0 ', array(":uniacid" => $_W['uniacid']));
        goto tqJPE;
        A7Tuc:
        message('保存成功', 'refresh');
        goto F0MrL;
        YF0eL:
        b0Rut:
        goto gHc46;
        lGpln:
        message('FTP帐号为必填项.');
        goto wn09N;
        YlHrO:
        p7GFo:
        goto py_dk;
        nEt5m:
        $dailytimes .= ' AND createtime <=' . $dailyendtime;
        goto iMhtE;
        JN0tE:
        if (!checksubmit()) {
            goto SJLx3;
        }
        goto yk8wD;
        H3CQA:
        $endtime = strtotime($_GPC['datelimit']['end']) + 86399;
        goto mJ37N;
        xmhf4:
        uh95x:
        goto FeXLh;
        FeXLh:
        $item['dailyjointotal'] = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename($this->tablevoteuser) . ' WHERE   uniacid = :uniacid  ' . $dailytimes, array(":uniacid" => $_W['uniacid']));
        goto hWGYz;
        nimyq:
        WronQ:
        goto Uh67k;
        RoKjg:
        JbZhE:
        goto nqbA8;
        N_sXK:
        f6OE4:
        goto ZqNPw;
        ellfB:
        if (!(!strexists($url, 'http://') && !strexists($url, 'https://'))) {
            goto PXepm;
        }
        goto m767_;
        MobYq:
        $item['jointotal'] = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename($this->tablevoteuser) . ' WHERE   uniacid = :uniacid  ', array(":uniacid" => $_W['uniacid']));
        goto DUMUS;
        m767_:
        $url = 'http://' . $url;
        goto m6bqf;
        hEWAL:
        if (!($_GPC['robotstatus'] == 0)) {
            goto QUzkr;
        }
        goto DY1pa;
        wdsW2:
        JJVmJ:
        goto B67qE;
        S9HAe:
        if (empty($_GPC['apiclient_key'])) {
            goto LPtyl;
        }
        goto pXGgk;
        cBmVL:
        if (!empty($remote['ftp']['password'])) {
            goto h_zlf;
        }
        goto ygPWO;
        Pb_AP:
        if (!empty($remote['cos']['secretid'])) {
            goto ll4rl;
        }
        goto xyQTD;
        ozHux:
        $this->saveSettings($dat);
        goto A7Tuc;
        aMjhf:
        if ($remote['type'] == ATTACH_OSS) {
            goto xsLBY;
        }
        goto TmVkP;
        RewVS:
        EaIlB:
        goto d4heB;
        MjxLl:
        goto JzXW0;
        goto ma8oL;
        VV9ps:
        $remote['cos']['url'] = 'http://' . $remote['cos']['bucket'] . '-' . $remote['cos']['appid'] . '.cos.myqcloud.com';
        goto RoKjg;
        NU45F:
        $certroot = MODULE_ROOT . '/template/certdata/' . $_W['uniacid'] . '/' . $_GPC['certkey'];
        goto k2h2b;
        BWY3V:
        message('Bucket不存在或是已经被删除');
        goto REmTT;
        zEZz3:
        $dailytimes .= ' AND createtime >=' . $dailystarttime;
        goto nEt5m;
        BfdR1:
        $item['pvtotal'] = pdo_fetchcolumn('SELECT sum(pv_total) FROM ' . tablename($this->tablecount) . ' WHERE uniacid = :uniacid ', array(":uniacid" => $_W['uniacid']));
        goto Y4USp;
        YRIPM:
        TxFBH:
        goto GdhnF;
        ZEhas:
        message('最低提现金额必须大于0');
        goto Ps3WD;
        xyQTD:
        message('请填写SECRETID', referer(), 'info');
        goto RXb9C;
        ygPWO:
        message('FTP密码为必填项.');
        goto F_z_0;
        yk8wD:
        load()->func('file');
        goto NU45F;
        rryMv:
        $starttime = strtotime($_GPC['datelimit']['start']);
        goto H3CQA;
        iVBtx:
        cBe1r:
        goto W2OA1;
        t4sPV:
        if (empty($remote['qiniu']['url'])) {
            goto JJVmJ;
        }
        goto gi1uw;
        W2OA1:
        I3aCv:
        goto MjxLl;
        LDy8c:
        $remote['alioss']['url'] = $url;
        goto MithR;
        zgzN2:
        if (!empty($remote['cos']['secretkey'])) {
            goto Eq8RT;
        }
        goto ksQ4d;
        Qfg_G:
        if (!is_error($auth)) {
            goto cBe1r;
        }
        goto rTt37;
        Eiyw5:
        if (!empty($remote['cos']['bucket'])) {
            goto p7GFo;
        }
        goto Crdsm;
        w7dWP:
        EFZRl:
        goto uafjG;
        nqbA8:
        $remote['cos']['url'] = strexists($remote['cos']['url'], 'http') ? trim($remote['cos']['url'], '/') : 'http://' . trim($remote['cos']['url'], '/');
        goto YCyjp;
        G1hUF:
        message($message, referer(), 'info');
        goto iVBtx;
        DY1pa:
        $sql = 'update ' . tablename('silence_vote_robotstatus') . "set mode1 = 0,mode2 =0,mode3 =0,mode4 = 0 where uniacid = {$_W['uniacid']}";
        goto fnV_p;
        YBNIb:
        if (!empty($remote['qiniu']['bucket'])) {
            goto g5Cno;
        }
        goto IeA70;
        YTPiD:
        $dailyendtime = mktime(23, 59, 59);
        goto E3SXD;
        LHpFT:
        Eq8RT:
        goto Eiyw5;
        k2h2b:
        if (!($this->module['config']['certkey'] != $_GPC['certkey'] && !empty($this->module['config']['certkey']))) {
            goto cIqxe;
        }
        goto ns01X;
        mJ37N:
        $dailytimes .= ' AND createtime > ' . $starttime . ' AND createtime < ' . $endtime;
        goto xmhf4;
        OsEq9:
        rename($oldcertroot, $certroot);
        goto M48t0;
        Gsb2s:
        goto EaIlB;
        goto Zp9Pl;
        MkoTT:
        $remote = array("type" => intval($_GPC['type']), "ftp" => array("ssl" => intval($_GPC['ftp']['ssl']), "host" => $_GPC['ftp']['host'], "port" => $_GPC['ftp']['port'], "username" => $_GPC['ftp']['username'], "password" => strexists($_GPC['ftp']['password'], '*') ? $_W['setting']['remote']['ftp']['password'] : $_GPC['ftp']['password'], "pasv" => intval($_GPC['ftp']['pasv']), "dir" => $_GPC['ftp']['dir'], "url" => $_GPC['ftp']['url'], "overtime" => intval($_GPC['ftp']['overtime'])), "alioss" => array("key" => $_GPC['alioss']['key'], "secret" => strexists($_GPC['alioss']['secret'], '*') ? $_W['setting']['remote']['alioss']['secret'] : $_GPC['alioss']['secret'], "bucket" => $_GPC['alioss']['bucket']), "qiniu" => array("accesskey" => trim($_GPC['qiniu']['accesskey']), "secretkey" => strexists($_GPC['qiniu']['secretkey'], '*') ? $_W['setting']['remote']['qiniu']['secretkey'] : trim($_GPC['qiniu']['secretkey']), "bucket" => trim($_GPC['qiniu']['bucket']), "district" => intval($_GPC['qiniu']['district']), "url" => trim($_GPC['qiniu']['url']), "qn_queuename" => trim($_GPC['qiniu']['qn_queuename']), "watermark" => trim($_GPC['qiniu']['watermark'])), "cos" => array("appid" => trim($_GPC['cos']['appid']), "secretid" => trim($_GPC['cos']['secretid']), "secretkey" => strexists(trim($_GPC['cos']['secretkey']), '*') ? $_W['setting']['remote']['cos']['secretkey'] : trim($_GPC['cos']['secretkey']), "bucket" => trim($_GPC['cos']['bucket']), "url" => trim($_GPC['cos']['url']), "local" => trim($_GPC['cos']['local'])));
        goto aMjhf;
        DokiW:
        message('阿里云OSS-Access Key Secret不能为空');
        goto tLZX2;
        maqEM:
        $remote['alioss']['ossurl'] = $buckets[$remote['alioss']['bucket']]['location'] . '.aliyuncs.com';
        goto hDccr;
        gHc46:
        include $this->template('setting');
        goto tl53E;
        pXGgk:
        $ret = file_put_contents($certroot . '/apiclient_key.pem', trim($_GPC['apiclient_key']));
        goto F7PxB;
        rTt37:
        $message = $auth['message']['error'] == 'bad token' ? 'Accesskey或Secretkey填写错误， 请检查后重新提交' : 'bucket填写错误或是bucket所对应的存储区域选择错误，请检查后重新提交';
        goto G1hUF;
        vrFo7:
        $item['dailygiftcount'] = !empty($item['dailygiftcount']) ? $item['dailygiftcount'] : 0;
        goto MobYq;
        ksQ4d:
        message('请填写SECRETKEY', referer(), 'info');
        goto LHpFT;
        SmhrW:
        if (empty($_GPC['apiclient_cert'])) {
            goto ZYrzM;
        }
        goto Z6ibw;
        v5eDG:
        if (!(trim($remote['alioss']['key']) == '')) {
            goto Ts4Fn;
        }
        goto Tds2e;
        ma8oL:
        VnX0o:
        goto G4Psj;
        HqMaT:
        if (!empty($remote['qiniu']['accesskey'])) {
            goto JzdJq;
        }
        goto UqCR2;
        B67qE:
        message('请填写url', referer(), 'info');
        goto A6TcO;
        dpqcq:
        g5Cno:
        goto t4sPV;
        UqCR2:
        message('请填写Accesskey', referer(), 'info');
        goto ZdS4z;
        fK7JU:
        if (!empty($remote['ftp']['username'])) {
            goto z1ZrM;
        }
        goto lGpln;
        d1upF:
        if (!empty($buckets[$remote['alioss']['bucket']])) {
            goto lEgXg;
        }
        goto BWY3V;
        S6J6p:
        $remote['alioss']['url'] = 'http://' . $remote['alioss']['bucket'] . '.' . $buckets[$remote['alioss']['bucket']]['location'] . '.aliyuncs.com';
        goto maqEM;
        jaEGO:
        ZYrzM:
        goto S9HAe;
        sepVs:
        bklD1:
        goto gO0Rg;
        Crdsm:
        message('请填写BUCKET', referer(), 'info');
        goto YlHrO;
        F_z_0:
        h_zlf:
        goto cHWfS;
        REmTT:
        lEgXg:
        goto S6J6p;
        E3SXD:
        $dailytimes = '';
        goto zEZz3;
        rW5SV:
        if (!is_error($auth)) {
            goto f6OE4;
        }
        goto WxQb_;
        uafjG:
        if (!empty($_GPC['datelimit'])) {
            goto bd6qt;
        }
        goto pqnqM;
        RHgih:
        Rv3DI:
        goto MkoTT;
        FbMHN:
        if (!(IMS_VERSION >= 0.8)) {
            goto b0Rut;
        }
        goto ftoij;
        Z6ibw:
        $ret = file_put_contents($certroot . '/apiclient_cert.pem', trim($_GPC['apiclient_cert']));
        goto Ljgcj;
        F7PxB:
        $r = $r && $ret;
        goto hkLch;
        ldzKe:
        $buckets = attachment_alioss_buctkets($remote['alioss']['key'], $remote['alioss']['secret']);
        goto AHRap;
        Vlo1v:
        $item['dailygiftnum'] = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename($this->tablegift) . ' WHERE   uniacid = :uniacid AND ispay=1 ' . $dailytimes, array(":uniacid" => $_W['uniacid']));
        goto vrFo7;
        OCh6N:
        goto h72fP;
        goto wdsW2;
        g7YWp:
        $auth = attachment_qiniu_auth($remote['qiniu']['accesskey'], $remote['qiniu']['secretkey'], $remote['qiniu']['bucket'], $remote['qiniu']['district']);
        goto Qfg_G;
        T60Ao:
 //       message('请填写授权码', referer(), 'info');
        goto u039P;
        XrMn9:
        message('secretkey', referer(), 'info');
        goto gm82p;
        gi1uw:
        $remote['qiniu']['url'] = strexists($remote['qiniu']['url'], 'http') ? trim($remote['qiniu']['url'], '/') : 'http://' . trim($remote['qiniu']['url'], '/');
        goto OCh6N;
        Uh67k:
        $auth = attachment_cos_auth($remote['cos']['bucket'], $remote['cos']['appid'], $remote['cos']['secretid'], $remote['cos']['secretkey'], $remote['cos']['local']);
        goto rW5SV;
        G4Psj:
        if (!empty($remote['ftp']['host'])) {
            goto dEQRP;
        }
        goto bJ2tU;
        kDPlV:
        dEQRP:
        goto fK7JU;
        gm82p:
        wUbFY:
        goto YBNIb;
        ZqNPw:
        DZ3gY:
        goto Xmk0J;
        JckZ8:
        QUzkr:
        goto RYmd3;
        n3Jiz:
        load()->model('attachment');
        goto JN0tE;
        pqnqM:
        $dailystarttime = mktime(0, 0, 0);
        goto YTPiD;
        Ljgcj:
        $r = $r && $ret;
        goto jaEGO;
        tl53E:
    }
    public function tpl_setinput($arrayvalue = array())
    {
        goto ODv8a;
        NEmxY:
        foreach (@$arrayvalue as $row) {
            $html .= '
					<div  style="margin-left:-15px;">
					  <div class="col-sm-10" style="margin-bottom:10px">
						<div class="input-group">
						  <input type="text" class="form-control" name="infoname[]" value="' . $row['infoname'] . '" placeholder="请输入表单名称">
						  <span class="input-group-addon"></span>
						  <select  class="form-control" name="infotype[]">
							<option value="">请选择输入类型</option>
							<option value="realname"' . ($row['infotype'] == 'realname' ? 'selected ="selected"' : '') . '  >真实姓名</option>
							<option value="mobile" ' . ($row['infotype'] == 'mobile' ? 'selected ="selected"' : '') . ' >手机号码</option>
							<option value="email" ' . ($row['infotype'] == 'email' ? 'selected ="selected"' : '') . ' >电子邮箱</option>
							<option value="sex" ' . ($row['infotype'] == 'sex' ? 'selected ="selected"' : '') . ' >性别</option>
							<option value="qq" >QQ号</option>
							<option value="birthyear"' . ($row['infotype'] == 'birthyear' ? 'selected ="selected"' : '') . ' >出生生日</option>
							<option value="telephone"' . ($row['infotype'] == 'telephone' ? 'selected ="selected"' : '') . ' >固定电话</option>
							<option value="idcard" ' . ($row['infotype'] == 'idcard' ? 'selected ="selected"' : '') . '>证件号码</option>
							<option value="address" ' . ($row['infotype'] == 'address' ? 'selected ="selected"' : '') . '>邮寄地址</option>
							<option value="zipcode"' . ($row['infotype'] == 'zipcode' ? 'selected ="selected"' : '') . ' >邮编</option>
							<option value="nationality" ' . ($row['infotype'] == 'nationality' ? 'selected ="selected"' : '') . '>国籍</option>
							<option value="resideprovince"' . ($row['infotype'] == 'resideprovince' ? 'selected ="selected"' : '') . ' >居住地址</option>
							<option value="graduateschool" ' . ($row['infotype'] == 'graduateschool' ? 'selected ="selected"' : '') . '>毕业学校</option>
							<option value="company"' . ($row['infotype'] == 'company' ? 'selected ="selected"' : '') . ' >公司</option>
							<option value="education" ' . ($row['infotype'] == 'education' ? 'selected ="selected"' : '') . '>学历</option>
							<option value="occupation" ' . ($row['infotype'] == 'occupation' ? 'selected ="selected"' : '') . '>职业</option>
							<option value="position" ' . ($row['infotype'] == 'position' ? 'selected ="selected"' : '') . '>职位</option>
							<option value="revenue" ' . ($row['infotype'] == 'revenue' ? 'selected ="selected"' : '') . '>年收入</option>
							<option value="affectivestatus" ' . ($row['infotype'] == 'affectivestatus' ? 'selected ="selected"' : '') . '>情感状态</option>
							<option value="lookingfor"' . ($row['infotype'] == 'lookingfor' ? 'selected ="selected"' : '') . ' > 交友目的</option>
							<option value="bloodtype"' . ($row['infotype'] == 'bloodtype' ? 'selected ="selected"' : '') . ' >血型</option>
							<option value="height"' . ($row['infotype'] == 'height' ? 'selected ="selected"' : '') . ' >身高</option>
							<option value="weight" ' . ($row['infotype'] == 'weight' ? 'selected ="selected"' : '') . '>体重</option>
							<option value="alipay" ' . ($row['infotype'] == 'alipay' ? 'selected ="selected"' : '') . '>支付宝帐号</option>
							<option value="taobao"' . ($row['infotype'] == 'taobao' ? 'selected ="selected"' : '') . ' >阿里旺旺</option>
							<option value="vqqcom"' . ($row['infotype'] == 'vqqcom' ? 'selected ="selected"' : '') . ' >腾讯视频</option>
							<option value="site"' . ($row['infotype'] == 'site' ? 'selected ="selected"' : '') . ' >主页</option>
							<option value="bio" ' . ($row['infotype'] == 'bio' ? 'selected ="selected"' : '') . '>自我介绍</option>
							<option value="interest" ' . ($row['infotype'] == 'interest' ? 'selected ="selected"' : '') . '>兴趣爱好</option>

						  </select>
							 <div class="input-group-btn" style="width:95px">
								<select  class="form-control" name="notnull[]">
												<option value="1" ' . ($row['notnull'] == '1' ? 'selected ="selected"' : '') . ' >必填</option>
												<option value="0" ' . ($row['notnull'] == '0' ? 'selected ="selected"' : '') . ' >非必填</option>
								</select>
							 </div>
							 <div class="input-group-btn" style="width:130px">
								<select  class="form-control" name="isshow[]">
												<option value="0" ' . ($row['isshow'] == '0' ? 'selected ="selected"' : '') . ' >前台不显示</option>
												<option value="1" ' . ($row['isshow'] == '1' ? 'selected ="selected"' : '') . ' >前台显示</option>
								</select>
							 </div>
						</div>
					  </div>
					  <div class="col-sm-1 del_box" style="margin-top:5px" ><a href="javascript:;" ><i class="fa fa-times-circle"></i></a></div>
					</div>				
				';
            ExVIK:
        }
        goto A9BHe;
        wANCS:
        return $html;
        goto ReMKl;
        A9BHe:
        A4tp3:
        goto Jt1EC;
        ODv8a:
        if (!is_array($arrayvalue)) {
            goto WF8rT;
        }
        goto NEmxY;
        Jt1EC:
        WF8rT:
        goto wANCS;
        ReMKl:
    }
    public function welcomeDisplay()
    {
        goto ty7mc;
        RXXCJ:
        die;
        goto d72yj;
        ty7mc:
        ob_end_clean();
        goto lnxKb;
        lnxKb:
        @header('Location: ' . $this->createWebUrl('manage'));
        goto RXXCJ;
        d72yj:
    }
    public function createRandomStr($length)
    {
        goto r47ma;
        r47ma:
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        goto EOMoy;
        GJqas:
        $str .= $str;
        goto XpSpn;
        FH2mt:
        Yy8rk:
        goto kKvCk;
        vqh1D:
        $str = str_shuffle($str);
        goto T2wdS;
        XpSpn:
        $strlen += 26;
        goto X5gfW;
        Qa0zp:
        tuSsz:
        goto d0OlM;
        YvPgw:
        gwO2D:
        goto vqh1D;
        X5gfW:
        goto tuSsz;
        goto bsTYy;
        d0OlM:
        if ($length <= $strlen) {
            goto gwO2D;
        }
        goto GJqas;
        bsTYy:
        goto Yy8rk;
        goto YvPgw;
        EOMoy:
        $strlen = 26;
        goto Qa0zp;
        T2wdS:
        return substr($str, 0, $length);
        goto FH2mt;
        kKvCk:
    }
    public function tplmobile()
    {
        goto rOvkE;
        rOvkE:
        global $_W;
        goto SQU0g;
        ITw07:
        return $template;
        goto tYdMZ;
        SQU0g:
        $template = array("default_new" => array("title" => "默认模板", "icon" => "icon.jpg", "style" => array("default" => array("css" => "index", "color" => "#ccc"), "yellow" => array("css" => "default_yellow", "color" => "#fff900"), "blue" => array("css" => "default_blue", "color" => "#04b0f5"), "purple" => array("css" => "default_purple", "color" => "#c400d0"))));
        goto ITw07;
        tYdMZ:
    }
    public function check_ticket($cfg, $url, $type = "")
    {
        goto uQ9Vw;
        o1NWW:
        $post_data['token'] = md5(sha1(implode('', $post_data)));
        goto Nx7Vf;
        TC9y2:
        return true;
        goto Lb6HU;
        IhRV8:
//        message('授权错误，请联系客服！', 'referer', 'error');
        goto N4Eqj;
        rj1nT:
        lBx4d:
        goto SLuxK;
        cVShQ:
        $content = ihttp_post($url, $post_data);
        goto s99O8;
        Lb6HU:
        IZ2AN:
        goto KKTcd;
        nqXvl:
        FCFoK:
        goto W11I0;
        Nx7Vf:
        load()->func('communication');
        goto cVShQ;
        W11I0:
        exit(json_encode($result));
        goto rj1nT;
        s99O8:
        $result = json_decode($content['content'], true);
        goto AZZua;
        SLuxK:
        goto IZ2AN;
        goto QWuQM;
        N4Eqj:
        goto lBx4d;
        goto nqXvl;
        uQ9Vw:
        $post_data = array("time" => time(), "ticket" => $cfg['ticket'], "module_id" => 3);
        goto gB1VS;
        AZZua:
        if ($result['sta']) {
            goto NjBVo;
        }
        goto BCPyA;
        BCPyA:
        if ($type == 'ajax') {
            goto FCFoK;
        }
        goto IhRV8;
        QWuQM:
        NjBVo:
        goto TC9y2;
        gB1VS:
        ksort($post_data);
        goto o1NWW;
        KKTcd:
    }
}