<?php
goto dkPcw;
LJQ_0:
require IA_ROOT . '/addons/xiaof_toupiao/class/util.class.php';
goto n9xmk;
i9izv:
require IA_ROOT . '/addons/xiaof_toupiao/class/cloud.class.php';
goto LJQ_0;
wiXoM:
require IA_ROOT . '/addons/xiaof_toupiao/global.php';
goto i9izv;
dkPcw:
defined('IN_IA') or exit('Access Denied');
goto wiXoM;
qNEMQ:
load()->func('file');
goto qEK00;
n9xmk:
require IA_ROOT . '/addons/xiaof_toupiao/class/errno.class.php';
goto qNEMQ;
qEK00:
class Xiaof_toupiaoModuleSite extends WeModuleSite
{
    protected static $_stores = array();
    protected static $_setting = null;
    protected static $_userinfo = array();
    protected static $gift_admin = null;
    protected static $_edition = null;
    private function _init()
    {
        goto U94Ir;
        Qd_xJ:
        XuYxo:
        goto AvwfG;
        CeNRq:
        if (!$_W['IN_WEB']) {
            goto H7rCC;
        }
        goto EDIth;
        Z3cOS:
        H7rCC:
        goto vwxYQ;
        U94Ir:
        global $_W;
        goto PHVjA;
        AvwfG:
        $this->_background_running();
        goto g0qfV;
        baQNe:
        Ee1AB:
        goto jA3wf;
        vwxYQ:
        goto XuYxo;
        goto baQNe;
        EDIth:
        $this->_init_web();
        goto Z3cOS;
        PHVjA:
        if ($_W['IN_MOBILE']) {
            goto Ee1AB;
        }
        goto CeNRq;
        jA3wf:
        $this->_init_app();
        goto Qd_xJ;
        g0qfV:
    }
    private function _background_running()
    {
        $this->_cloud_report();
    }
    private function _init_app()
    {
        $this->_set_resource();
        $this->_xiaof_toupiao_add_cookie();
    }
    private function _init_modules()
    {
        goto HTxFv;
        gs0W7:
        if (empty($module)) {
            goto CxT2I;
        }
        goto zpoDS;
        Kjdd0:
        return false;
        goto uuLZg;
        UgML0:
        CxT2I:
        goto Kjdd0;
        HTxFv:
        $module = pdo_get('modules', array("name" => "xiaof_toupiao_plugin_ad"));
        goto gs0W7;
        zpoDS:
        return true;
        goto UgML0;
        uuLZg:
    }
    private function _init_modules_supermanx_tpm($sid)
    {
        goto GsySI;
        uFVte:
        Xe10Y:
        goto GEsI2;
        hJ1zz:
        $activity = pdo_get('xiaof_toupiao_admin', array("uniacid" => $_W['uniacid'], "openid" => $openid));
        goto tBzPi;
        EZF0e:
        if ($activity['sid'] == $sid) {
            goto VSZjB;
        }
        goto QxTO_;
        t7OnJ:
        if (empty($module)) {
            goto kn8SE;
        }
        goto B_cZh;
        vGEGg:
        $module = pdo_get('modules', array("name" => "supermanx_tpm"));
        goto t7OnJ;
        PZIA5:
        goto Xe10Y;
        goto mR2DL;
        JGD2T:
        if (empty($activity['sid'])) {
            goto qKONc;
        }
        goto EZF0e;
        kjwB9:
        VSZjB:
        goto owGgf;
        owGgf:
        return true;
        goto ZUoPD;
        nj81k:
        goto Yw82V;
        goto kjwB9;
        ZUoPD:
        Yw82V:
        goto PZIA5;
        FVbpb:
        return false;
        goto z9e4u;
        mR2DL:
        qKONc:
        goto Wez9P;
        tBzPi:
        if (empty($activity)) {
            goto cwFg6;
        }
        goto JGD2T;
        Wez9P:
        return true;
        goto uFVte;
        GsySI:
        global $_W;
        goto vGEGg;
        QxTO_:
        return false;
        goto nj81k;
        GEsI2:
        cwFg6:
        goto uXBXi;
        B_cZh:
        $openid = self::getUserinfo('openid');
        goto hJ1zz;
        uXBXi:
        kn8SE:
        goto FVbpb;
        z9e4u:
    }
    private function _get_ad_data($sid)
    {
        goto AQZny;
        mhXm3:
        $adlist = pdo_get('xiaof_toupiaoad', array("uniacid" => $_W['uniacid'], "sid" => $sid));
        goto Tnylg;
        AQZny:
        global $_W;
        goto mhXm3;
        Tnylg:
        return $adlist;
        goto GeNS6;
        GeNS6:
    }
    private function _xiaof_toupiao_add_cookie()
    {
        goto PCyfU;
        s1u7d:
        return;
        goto VS0Bk;
        EGTqx:
        if (empty($adlist)) {
            goto fKFV9;
        }
        goto OOVFX;
        rMU05:
        BRwGT:
        goto j5MQb;
        UY9vx:
        $_SESSION['first_screen_a'] = false;
        goto CuB0L;
        CuB0L:
        if (!empty($_GPC['sid'])) {
            goto iZ2u6;
        }
        goto Yqoqz;
        OOVFX:
        if (empty($_GPC['xiaof_toupiao_ad_' . $_GPC['sid']])) {
            goto AJkhy;
        }
        goto aFyr5;
        b1udF:
        $modules = $this->_init_modules();
        goto zYRdt;
        AcGnW:
        AJkhy:
        goto jSvEF;
        aFyr5:
        $_SESSION['first_screen_a'] = false;
        goto aUFEY;
        Bmqjx:
        $_SESSION['first_screen_a'] = true;
        goto rMU05;
        ThIxv:
        $adlist = pdo_get('xiaof_toupiaoad', array("uniacid" => $_W['uniacid'], "sid" => $_GPC['sid']));
        goto EGTqx;
        zwQvG:
        iZ2u6:
        goto b1udF;
        aUFEY:
        goto cGVga;
        goto AcGnW;
        j5MQb:
        cGVga:
        goto T3gGZ;
        Yqoqz:
        return;
        goto zwQvG;
        T3gGZ:
        fKFV9:
        goto Y98O1;
        jSvEF:
        if (!($adlist['isopen'] && time() <= strtotime($adlist['stoptime']) && time() >= strtotime($adlist['starttime']))) {
            goto BRwGT;
        }
        goto Bmqjx;
        PCyfU:
        global $_W, $_GPC;
        goto UY9vx;
        VS0Bk:
        RkqPi:
        goto ThIxv;
        zYRdt:
        if (!empty($modules)) {
            goto RkqPi;
        }
        goto s1u7d;
        Y98O1:
    }
    private function _init_web()
    {
        goto nINYK;
        ZS_5K:
        $this->_check_gift_admin();
        goto D3GkM;
        D3GkM:
        $this->_cloud_authorize();
        goto zRkt_;
        nINYK:
        $this->_update_edition();
        goto ZS_5K;
        zRkt_:
    }
    private function _update_edition()
    {
        goto ywHNU;
        AHHcJ:
        self::$_edition = null;
        goto BGrs9;
        EinR8:
        self::$_edition = iserializer(self::$_edition);
        goto OHxa0;
        axvWe:
        self::$_edition = array(0 => array("module" => "xiaof_toupiao", "entry" => "menu", "title" => "活动列表", "do" => "settinglists", "displayorder" => 255), 1 => array("module" => "xiaof_toupiao", "entry" => "menu", "title" => "财务管理", "do" => "paylog", "displayorder" => 99), 2 => array("module" => "xiaof_toupiao", "entry" => "menu", "title" => "统计报表", "do" => "overview", "displayorder" => 95), 3 => array("module" => "xiaof_toupiao", "entry" => "menu", "title" => "投诉记录", "do" => "reportlog", "displayorder" => 58), 4 => array("module" => "xiaof_toupiao", "entry" => "menu", "title" => "获取粉丝信息", "do" => "getunionid", "displayorder" => 60), 5 => array("module" => "xiaof_toupiao", "entry" => "menu", "title" => "诊断修复工具", "do" => "tool", "displayorder" => 40), 6 => array("module" => "xiaof_toupiao", "entry" => "menu", "title" => "系统工具", "do" => "systemtool", "displayorder" => 35));
        goto EinR8;
        BGrs9:
        goto sUpxb;
        goto FbkHH;
        FbkHH:
        WmR50:
        goto axvWe;
        ywHNU:
        global $_W, $_GPC;
        goto pejbI;
        OHxa0:
        sUpxb:
        goto Rm20X;
        pejbI:
        if ($_GPC['edition'] == 'web/' || !isset($_GPC['edition'])) {
            goto WmR50;
        }
        goto AHHcJ;
        Rm20X:
    }
    private function _check_gift_admin()
    {
        goto MaJ22;
        VKcj_:
        if ($_W['isfounder']) {
            goto snevD;
        }
        goto XvNoT;
        kAlwM:
        self::$gift_admin = true;
        goto tzo1k;
        DUjmc:
        if (!in_array($_GPC['sid'], $item['sid'])) {
            goto ze4T1;
        }
        goto NEuC4;
        muzIS:
        vpjZa:
        goto PMMFu;
        MaJ22:
        global $_W, $_GPC;
        goto EQotb;
        A7U5y:
        snevD:
        goto kAlwM;
        Ym0A2:
        $item = pdo_get('xiaof_toupiao_gift_admin', array("uniacid" => $_W['uniacid'], "uid" => $_W['user']['uid']));
        goto qmb1w;
        HjtKV:
        ze4T1:
        goto VPZ1y;
        PMMFu:
        goto braij;
        goto A7U5y;
        NEuC4:
        self::$gift_admin = true;
        goto HjtKV;
        qmb1w:
        if (empty($item)) {
            goto DVK46;
        }
        goto CaDbQ;
        EQotb:
        self::$gift_admin = false;
        goto VKcj_;
        VPZ1y:
        DVK46:
        goto muzIS;
        XvNoT:
        $limits = SupermanToupiaoUtil::getmemberlimits($_W['user']['uid']);
        goto J0FJO;
        tzo1k:
        braij:
        goto h0T8D;
        J0FJO:
        if (!$limits) {
            goto vpjZa;
        }
        goto Ym0A2;
        CaDbQ:
        $item['sid'] = iunserializer($item['sid']);
        goto DUjmc;
        h0T8D:
    }

    private function _cloud_report()
    {
        goto IvLoV;
        mJpD8:
        $content = file_get_contents($file_path);
        goto zH1Tm;
        M18aE:
        if (!$list) {
            goto lNIUk;
        }
        goto fK53X;
        hlPgL:
        $fans_total = pdo_count('mc_mapping_fans', array("uniacid" => $_W['uniacid'], "acid" => $_W['acid']));
        goto j2oJ2;
        UTVSf:
        $file_path = MODULE_ROOT . '/data/site.txt';
        goto mJpD8;
        a7Knm:
        $siteinfo = array("siteid" => $siteid, "secret" => $secret);
        goto Z6kBm;
        hgpB6:
        rqOZG:
        goto M18aE;
        WZneZ:
        $siteid = $site[0];
        goto R6NJs;
        PkEkQ:
        if (!(!$siteid || !$secret)) {
            goto L8cPe;
        }
        goto JKF3o;
        I0pqZ:
        $lists = pdo_fetchall('SELECT * FROM ' . tablename('xiaof_toupiao_setting') . ' WHERE ' . $condition . ' ORDER BY `created_at` DESC ');
        goto Dse2p;
        Dse2p:
        $list = array();
        goto dVRaR;
        teV6r:
        $path = MODULE_ROOT . '/data/' . $_W['uniacid'];
        goto qlL2c;
        HNbkX:
        L8cPe:
        goto teV6r;
        pPxiY:
        if (!$this->_check_running_interval_time($path . '/report.txt', 86400)) {
            goto Gg9V8;
        }
        goto a7Knm;
        JKF3o:
        return;
        goto HNbkX;
        GZh0y:
        Gg9V8:
        goto tajYy;
        vlBNF:
        ba2kM:
        goto TF0YM;
        RIpbR:
        ozKk6:
        goto GZh0y;
        Jk3cc:
        WeUtility::logging('trace', 'cloud.report.index: result=' . var_export($result, true));
        goto RIpbR;
        TF0YM:
        lNIUk:
        goto nZJZC;
        AH0qf:
        $result = $cloud->api('report.index', $data);
        goto GHJhv;
        Z6kBm:
        $cloud = new SupermanCloud($this->module, $siteinfo);
        goto hlPgL;
        R6NJs:
        $secret = $site[1];
        goto PkEkQ;
        IvLoV:
        global $_W;
        goto UTVSf;
        qlL2c:
        mkdirs($path);
        goto pPxiY;
        dVRaR:
        foreach ($lists as $k => $v) {
            goto jEo0h;
            RihZB:
            if ($totals = $this->cacheGet('settinglists_' . $v['id'])) {
                goto tlJXq;
            }
            goto riCDQ;
            mFcLR:
            $totals['vote'] = pdo_fetch('SELECT SUM(click) as clicks, SUM(good) as goods, SUM(share) as shares FROM ' . tablename('xiaof_toupiao') . ' WHERE `sid` = ' . $v['id']);
            goto I7frm;
            jnEju:
            $item['id'] = $v['id'];
            goto KeD4T;
            tmjVg:
            tlJXq:
            goto PQm1r;
            mvGeD:
            O9I1Y:
            goto bCN4A;
            jEo0h:
            $item = array();
            goto jnEju;
            njp5H:
            $this->cacheSet('settinglists_' . $v['id'], $totals, 10);
            goto tmjVg;
            KeD4T:
            $item['created_at'] = $v['created_at'];
            goto RihZB;
            PQm1r:
            $item['totals'] = $totals;
            goto zmGwX;
            riCDQ:
            $totals = array();
            goto N4AX_;
            I7frm:
            $totals['vote']['joins'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('xiaof_toupiao') . ' WHERE `sid` = ' . $v['id']);
            goto njp5H;
            zmGwX:
            $list[] = array_merge($item, unserialize($v['data']));
            goto mvGeD;
            N4AX_:
            $totals['fee'] = pdo_fetchcolumn('SELECT SUM(fee) FROM ' . tablename('xiaof_toupiao_order') . ' WHERE `sid` = ' . $v['id'] . ' AND `status`=\'1\'');
            goto mFcLR;
            bCN4A:
        }
        goto hgpB6;
        fK53X:
        foreach ($list as $li) {
            $mp_extra[] = array("sid" => $li['id'], "rrl" => $this->ruleUrl('index', 'xiaof_toupiao', '', $li['id']), "goods" => $li['totals']['vote']['goods'] ? $li['totals']['vote']['goods'] : 0, "joins" => $li['totals']['vote']['joins'] ? $li['totals']['vote']['joins'] : 0, "fee" => $li['totals']['fee'] ? $li['totals']['fee'] : 0);
            R0P5Q:
        }
        goto vlBNF;
        GHJhv:
        if (!(!$result || $result['errno'] != 0)) {
            goto ozKk6;
        }
        goto Jk3cc;
        nZJZC:
        $data = array("uniacid" => $_W['uniacid'], "title" => $_W['account']['name'], "level" => $_W['account']['level'] ? $_W['account']['level'] : 0, "type" => $_W['account']['type'], "fans_total" => $fans_total, "mp_extra" => iserializer($mp_extra));
        goto AH0qf;
        j2oJ2:
        $mp_extra = array();
        goto iULGx;
        zH1Tm:
        $site = explode('
', $content);
        goto WZneZ;
        iULGx:
        $condition = ' `uniacid` = ' . $_W['uniacid'];
        goto I0pqZ;
        tajYy:
    }
    private function _check_running_interval_time($filename, $interval = 300, $content = "success")
    {
        goto GwSZM;
        XHqwH:
        if (!empty($filename)) {
            goto LQ7iO;
        }
        goto B20DZ;
        fjN6m:
        if (!defined('LOCAL_DEVELOPMENT')) {
            goto Aubr3;
        }
        goto uX62S;
        aLkkl:
        DPZLx:
        goto cfPUU;
        FRBnz:
        UCM8k:
        goto gKtFE;
        JtBRj:
        if (!defined('LOCAL_DEVELOPMENT')) {
            goto knivf;
        }
        goto o7_U9;
        GwSZM:
        $name = substr($filename, strrpos($filename, '/') + 1);
        goto XHqwH;
        ovK2s:
        flock($fp, LOCK_UN);
        goto P7MZk;
        wZccO:
        $lasttime = filemtime($filename);
        goto QYSoQ;
        NluDG:
        tcQUk:
        goto By8LH;
        lyQxj:
        flock($fp, LOCK_UN);
        goto orlmx;
        Mpw_Q:
        LQ7iO:
        goto c8REl;
        xs7J3:
        return false;
        goto NluDG;
        d8q3B:
        return false;
        goto tIMi8;
        PhvyC:
        if (!($diff < $interval)) {
            goto AXurN;
        }
        goto fjN6m;
        ratx0:
        if (!($ret <= 0)) {
            goto HUXhv;
        }
        goto zETwt;
        orlmx:
        fclose($fp);
        goto d8q3B;
        l7OW1:
        if ($fp) {
            goto DPZLx;
        }
        goto roDSJ;
        uX62S:
        Aubr3:
        goto lyQxj;
        QYSoQ:
        $diff = TIMESTAMP - $lasttime;
        goto PhvyC;
        KTOLw:
        $ret = fwrite($fp, $content);
        goto ratx0;
        zETwt:
        WeUtility::logging('fatal', "[_check_running_interval_time:{$name}] file_put_contents failed(2), ret={$ret}");
        goto ovK2s;
        MlS_m:
        ftruncate($fp, 0);
        goto xEbdv;
        KPAzA:
        return false;
        goto aLkkl;
        By8LH:
        if (!($interval > 0)) {
            goto Ky90O;
        }
        goto Gyv6x;
        yGg9T:
        return true;
        goto I9A_3;
        mSDqM:
        return false;
        goto Uosqi;
        O4gMa:
        fclose($fp);
        goto yGg9T;
        tIMi8:
        AXurN:
        goto q_0zn;
        pTZuc:
        return false;
        goto Mpw_Q;
        cfPUU:
        if (flock($fp, LOCK_EX | LOCK_NB)) {
            goto tcQUk;
        }
        goto mtD8_;
        C4B3j:
        flock($fp, LOCK_UN);
        goto O4gMa;
        Gyv6x:
        clearstatcache();
        goto wZccO;
        c8REl:
        if (file_exists($filename)) {
            goto UCM8k;
        }
        goto AJ0NH;
        mtD8_:
        fclose($fp);
        goto xs7J3;
        xEbdv:
        rewind($fp);
        goto KTOLw;
        B20DZ:
        WeUtility::logging('fatal', "[_check_running_interval_time:{$name}] filename is null");
        goto pTZuc;
        P7MZk:
        fclose($fp);
        goto mSDqM;
        AJ0NH:
        $interval = 0;
        goto FRBnz;
        roDSJ:
        WeUtility::logging('fatal', "[_check_running_interval_time:{$name}] fopen failed, filename={$filename}");
        goto KPAzA;
        o7_U9:
        knivf:
        goto C4B3j;
        q_0zn:
        Ky90O:
        goto MlS_m;
        gKtFE:
        $fp = fopen($filename, 'a');
        goto l7OW1;
        Uosqi:
        HUXhv:
        goto JtBRj;
        I9A_3:
    }
    public function __call($name, $arguments)
    {
        goto kAwrn;
        Qe7lj:
        lc2bA:
        goto wL8sL;
        D459M:
        $iname = 'web';
        goto iwolE;
        RGnwL:
        if (!($isWeb || $isMobile)) {
            goto lc2bA;
        }
        goto MFo6W;
        gLD21:
        $_W['IN_WEB'] = true;
        goto W72Gt;
        ODfm1:
        require $file;
        goto WIxvN;
        EMb4Y:
        require $ifile;
        goto NIBF1;
        QL46G:
        exit;
        goto Iz0nF;
        cSdxb:
        goto Ie3Vv;
        goto MtfEF;
        z0AEB:
        Ie3Vv:
        goto VBVuG;
        nHaHi:
        qwTw3:
        goto hGV_C;
        EpOPv:
        if ($isMobile) {
            goto NbZYK;
        }
        goto FlW1o;
        sNSAl:
        if (!is_file($ifile)) {
            goto Qg38o;
        }
        goto EMb4Y;
        yVHW6:
        goto Ie3Vv;
        goto Is2Wi;
        g9jtl:
        $_W['IN_MOBILE'] = true;
        goto yVHW6;
        ppJ6R:
        $dir .= 'mobile/';
        goto eEQnH;
        VBVuG:
        $this->_init();
        goto N1U1L;
        s1d7P:
        if (!method_exists($iobj, $name)) {
            goto FE1F6;
        }
        goto BAPK1;
        oBfVj:
        $ifile = MODULE_ROOT . '/' . $iname . '.php';
        goto sNSAl;
        BAPK1:
        call_user_func_array(array($iobj, $name), $arguments);
        goto SmkqH;
        wszRO:
        $isWeb = stripos($name, 'doWeb') === 0;
        goto aZ3rB;
        JnH2i:
        Qg38o:
        goto Qe7lj;
        dyTNy:
        $file = $dir . $fun . '.inc.php';
        goto MgGu1;
        hGV_C:
        require $file;
        goto QL46G;
        wL8sL:
        trigger_error("访问的方法 {$name} 不存在.", E_USER_WARNING);
        goto gyde2;
        MFo6W:
        $dir = IA_ROOT . '/addons/' . $this->modulename . '/inc/';
        goto EpOPv;
        gyde2:
        return null;
        goto j3r3E;
        Iz0nF:
        R5AZd:
        goto oBfVj;
        nS07j:
        goto R5AZd;
        goto nHaHi;
        bR0V8:
        p1I1x:
        goto nS07j;
        eEQnH:
        $iname = 'app';
        goto raWNB;
        Is2Wi:
        QSqzU:
        goto n1WLq;
        n1WLq:
        $dir .= 'web/';
        goto D459M;
        NIBF1:
        $iobj = new Xiaof_toupiaoModule($this);
        goto s1d7P;
        aZ3rB:
        $isMobile = stripos($name, 'doMobile') === 0;
        goto RGnwL;
        iwolE:
        $fun = strtolower(substr($name, 5));
        goto gLD21;
        KfQLS:
        $dir = str_replace('addons', 'framework/builtin', $dir);
        goto dyTNy;
        Z2dvN:
        if (file_exists($file)) {
            goto qwTw3;
        }
        goto KfQLS;
        kAwrn:
        global $_W;
        goto wszRO;
        W72Gt:
        $this->_update_menu_displayorder();
        goto z0AEB;
        WIxvN:
        exit;
        goto bR0V8;
        qqX9a:
        FE1F6:
        goto JnH2i;
        N1U1L:
        $file = $dir . $fun . '.inc.php';
        goto Z2dvN;
        MtfEF:
        NbZYK:
        goto ppJ6R;
        raWNB:
        $fun = strtolower(substr($name, 8));
        goto g9jtl;
        SmkqH:
        exit;
        goto qqX9a;
        MgGu1:
        if (!file_exists($file)) {
            goto p1I1x;
        }
        goto ODfm1;
        FlW1o:
        if ($isWeb) {
            goto QSqzU;
        }
        goto cSdxb;
        j3r3E:
    }
    public function __get($name)
    {
        goto GlAWw;
        Br3eY:
        if (!is_file($ifile)) {
            goto HI3T0;
        }
        goto LIXs5;
        moQ0S:
        $ifile = MODULE_ROOT . '/func.php';
        goto Br3eY;
        LIXs5:
        require_once $ifile;
        goto GXqX9;
        yr3Li:
        return null;
        goto cAndj;
        to5wL:
        HI3T0:
        goto yr3Li;
        GXqX9:
        return $this->Xiaof = new Xiaof_toupiaoModuleFunc($this);
        goto to5wL;
        GL6e6:
        return null;
        goto bKfFg;
        GlAWw:
        if (!($name != 'Xiaof')) {
            goto m79LE;
        }
        goto GL6e6;
        bKfFg:
        m79LE:
        goto moQ0S;
        cAndj:
    }
    public function payResult($params)
    {
        goto cPkA9;
        BRkEB:
        ZNuqL:
        goto YPzMC;
        siRPN:
        if (empty($order['actions'])) {
            goto EZoZE;
        }
        goto oA8Y4;
        iJOO9:
        wCMGT:
        goto LKpub;
        ypYfQ:
        $messagestatus = $result['errno'] == '支付成功！' ? 'success' : 'error';
        goto ZYtK4;
        fvgy8:
        message('微信支付订单异常，单号：' . $params['uniontid'], self::appUrl('index'), 'error');
        goto P2jYj;
        Y9WI9:
        wXv_z:
        goto ypYfQ;
        jfInI:
        message('支付成功！', self::appUrl('paycheckcredit'), 'success');
        goto eA3oZ;
        UOHLp:
        if ($order['actions'] == 2) {
            goto firA7;
        }
        goto jfInI;
        UNkYm:
        RX513:
        goto pr_Hp;
        cLwWY:
        $this->Xiaof->funcPayGiving($params, $order);
        goto JTKzG;
        oplWb:
        CfQ4G:
        goto siRPN;
        yem7I:
        $result = $this->Xiaof->funcPayJoin($params, $order);
        goto Y9WI9;
        whcVe:
        KvrKU:
        goto UNkYm;
        xTj3s:
        goto wXv_z;
        goto bklcj;
        aVHx7:
        gQNl0:
        goto yem7I;
        bklcj:
        EZoZE:
        goto QHZze;
        HIfMZ:
        firA7:
        goto QqVWA;
        ocwRD:
        message('支付成功！', self::appUrl('show', 'xiaof_toupiao', '&id=' . $paygiving['pid']), 'success');
        goto WloQA;
        YdVh5:
        isset($_SESSION) or WeSession::start($_W['uniacid'], CLIENT_IP);
        goto SEqa4;
        UwRIf:
        $paygiving = iunserializer($order['data']);
        goto zxF3n;
        uVz_f:
        if ($this->Xiaof->funcOrderquery($params['uniontid'])) {
            goto edC04;
        }
        goto eu78H;
        qKkV9:
        goto KvrKU;
        goto BRkEB;
        LDTdK:
        if ($order['actions'] == 1) {
            goto yQ0WR;
        }
        goto UOHLp;
        A0Im_:
        if (!($setting['wechatpay'] == 1 or $params['type'] == 'wechat')) {
            goto CfQ4G;
        }
        goto uVz_f;
        oA8Y4:
        if ($order['actions'] == 2) {
            goto gQNl0;
        }
        goto DRt6p;
        NrRC0:
        Efqdt:
        goto iJOO9;
        ddqmD:
        $_W['uniacid'] = $order['uniacid'];
        goto LDTdK;
        FRecn:
        if (empty($order['actions'])) {
            goto fZwOg;
        }
        goto Efmpp;
        GmSC6:
        load()->classs('wesession');
        goto YdVh5;
        DRt6p:
        $result = $this->Xiaof->funcPayGiving($params, $order);
        goto xTj3s;
        YPzMC:
        if (empty($order['status'])) {
            goto p_UAg;
        }
        goto ddqmD;
        Ps647:
        p_UAg:
        goto TH5MQ;
        cPkA9:
        global $_W, $_GPC;
        goto GmSC6;
        eA3oZ:
        goto YDjSr;
        goto Mgf8g;
        eu78H:
        $_W['uniacid'] = $order['uniacid'];
        goto fvgy8;
        HZ2FG:
        isset($_SESSION['odomain']) && ($_W['siteroot'] = urldecode($_SESSION['odomain']));
        goto Jpy_y;
        aYWpK:
        $_SESSION['sid'] = $order['sid'];
        goto tYZkw;
        JTKzG:
        goto Efqdt;
        goto Tnd1c;
        Efmpp:
        if ($order['actions'] == 2) {
            goto j5HI4;
        }
        goto cLwWY;
        QHZze:
        $result = $this->Xiaof->funcPayCredit($params, $order);
        goto Zg_5j;
        PZR7J:
        $_W['uniacid'] = $order['uniacid'];
        goto bBK6o;
        TH5MQ:
        if ($setting = self::getSetting()) {
            goto WkkX1;
        }
        goto rzAMP;
        Tnd1c:
        fZwOg:
        goto TlV1Y;
        P2jYj:
        edC04:
        goto oplWb;
        breGl:
        goto YDjSr;
        goto HIfMZ;
        QqVWA:
        $paygiving = iunserializer($order['data']);
        goto ocwRD;
        Mgf8g:
        yQ0WR:
        goto UwRIf;
        iMokK:
        WkkX1:
        goto A0Im_;
        LKpub:
        if (!($params['from'] == 'return')) {
            goto RX513;
        }
        goto HZ2FG;
        zxF3n:
        message('支付成功！', self::appUrl('show', 'xiaof_toupiao', '&id=' . $paygiving['pid'] . '&gid=' . $paygiving['givingid'] . '&payresult=success'), 'success');
        goto breGl;
        ZYtK4:
        message($result['errno'], $result['message'], $messagestatus);
        goto whcVe;
        rzAMP:
        message('支付失败,没有找到活动');
        goto iMokK;
        SEqa4:
        $order = pdo_fetch('SELECT * FROM ' . tablename('xiaof_toupiao_order') . ' WHERE tid = :tid limit 1', array(":tid" => $params['tid']));
        goto aYWpK;
        FYqaW:
        goto Efqdt;
        goto YXUHk;
        bBK6o:
        message('支付失败！', self::appUrl('index'), 'error');
        goto qKkV9;
        YXUHk:
        j5HI4:
        goto Ag2uY;
        WloQA:
        YDjSr:
        goto Ps647;
        Jpy_y:
        if ($params['result'] == 'success') {
            goto ZNuqL;
        }
        goto PZR7J;
        tYZkw:
        if (!($params['result'] == 'success' && $params['from'] == 'notify')) {
            goto wCMGT;
        }
        goto FRecn;
        TlV1Y:
        $this->Xiaof->funcPayCredit($params, $order);
        goto FYqaW;
        Ag2uY:
        $this->Xiaof->funcPayJoin($params, $order);
        goto NrRC0;
        Zg_5j:
        goto wXv_z;
        goto aVHx7;
        pr_Hp:
    }
    protected static function appUrl($do, $m = "xiaof_toupiao", $parameter = "")
    {
        goto El27_;
        El27_:
        global $_W, $_GPC;
        goto z7LDt;
        o5k3m:
        isset($_SESSION['sid']) && ($_GPC['sid'] = $_SESSION['sid']);
        goto KVA2v;
        z7LDt:
        if (!empty($_GPC['sid'])) {
            goto vorvD;
        }
        goto Gyx1w;
        Gyx1w:
        load()->classs('wesession');
        goto H235V;
        H235V:
        isset($_SESSION) or WeSession::start($_W['uniacid'], CLIENT_IP);
        goto o5k3m;
        Vxq1k:
        return $_W['siteroot'] . 'app/index.php?c=entry&do=' . $do . '&m=' . $m . '&i=' . $_W['uniacid'] . '&sid=' . $_GPC['sid'] . $parameter . '&wxref=mp.weixin.qq.com#wechat_redirect';
        goto KVLkL;
        KVA2v:
        vorvD:
        goto Vxq1k;
        KVLkL:
    }
    private function appPayUrl($do, $m = "xiaof_toupiao", $parameter = "")
    {
        goto zoIDZ;
        SC99s:
        rgNh_:
        goto OrKg6;
        zoIDZ:
        global $_W, $_GPC;
        goto BrZjw;
        bGPAl:
        isset($_SESSION) or WeSession::start($_W['uniacid'], CLIENT_IP);
        goto E7FAy;
        BrZjw:
        if (!empty($_GPC['sid'])) {
            goto rgNh_;
        }
        goto Th27o;
        E7FAy:
        isset($_SESSION['sid']) && ($_GPC['sid'] = $_SESSION['sid']);
        goto SC99s;
        Th27o:
        load()->classs('wesession');
        goto bGPAl;
        OrKg6:
        return $this->module['config']['paydomain'] . 'app/index.php?c=entry&do=' . $do . '&m=' . $m . '&i=' . $_W['uniacid'] . '&sid=' . $_GPC['sid'] . $parameter . '&wxref=mp.weixin.qq.com#wechat_redirect';
        goto G5T6o;
        G5T6o:
    }
    protected function payUrl($do, $fee, $paygiving = null)
    {
        goto FlQde;
        N08kL:
        $parameter = '&payinfo=' . urlencode($enpayinfo);
        goto girlI;
        KBlCM:
        $payinfo = array();
        goto Xhugb;
        ozcOv:
        isset($_SESSION['sid']) && ($_GPC['sid'] = $_SESSION['sid']);
        goto yc51N;
        girlI:
        return $_W['siteroot'] . 'app/index.php?c=entry&do=' . $do . '&m=xiaof_toupiao&i=' . $_W['uniacid'] . '&sid=' . $_GPC['sid'] . $parameter . '&wxref=mp.weixin.qq.com#wechat_redirect';
        goto CT4Cy;
        yc51N:
        Ynd5C:
        goto KBlCM;
        FlQde:
        global $_W, $_GPC;
        goto Y1T7U;
        tKRfq:
        $enpayinfo = base64_encode(authcode(iserializer($payinfo), 'ENCODE', md5($_W['uniacid'] . $_W['config']['setting']['authkey'] . 'xiaof' . CLIENT_IP)));
        goto N08kL;
        Y1T7U:
        if (!empty($_GPC['sid'])) {
            goto Ynd5C;
        }
        goto jVK6y;
        wTVXZ:
        empty($paygiving) or $payinfo['paygiving'] = $paygiving;
        goto tKRfq;
        v3d1o:
        isset($_SESSION) or WeSession::start($_W['uniacid'], CLIENT_IP);
        goto ozcOv;
        Xhugb:
        $payinfo['fee'] = $fee;
        goto wTVXZ;
        jVK6y:
        load()->classs('wesession');
        goto v3d1o;
        CT4Cy:
    }
    protected function ruleUrl($do, $m = "xiaof_toupiao", $parameter = "", $sid = "")
    {
        goto e1vfC;
        Uf18P:
        $setting = self::getSetting();
        goto XUC3t;
        ctO3s:
        isset($_SESSION) or WeSession::start($_W['uniacid'], CLIENT_IP);
        goto FCSxd;
        GfWtT:
        $siteroot = $setting['sharedomain'];
        goto TmXVK;
        WcgrE:
        $randstr = strtolower(random(6));
        goto HZs5c;
        NR9CC:
        $_GPC['sid'] = $sid;
        goto e1ghT;
        rSeE9:
        $setting['binddomain'] = $this->module['config']['binddomain'];
        goto OIfz0;
        e1ghT:
        RzpUA:
        goto HRtwe;
        MyxKF:
        xT2vR:
        goto lx8JX;
        e1vfC:
        global $_W, $_GPC;
        goto EXYiK;
        OIfz0:
        empty($setting['binddomain']) && ($setting['binddomain'][] = $_W['siteroot']);
        goto MyxKF;
        lx8JX:
        $siteroot = $setting['binddomain'][array_rand($setting['binddomain'])];
        goto o_SvW;
        DP5pG:
        if (!empty($setting['binddomain'])) {
            goto xT2vR;
        }
        goto rSeE9;
        FjAmE:
        return $siteroot . 'addons/xiaof_toupiao/index.php?c=entry&do=' . $do . '&m=' . $m . '&i=' . $_W['uniacid'] . '&sid=' . $_GPC['sid'] . $parameter . '&wxref=mp.weixin.qq.com#wechat_redirect';
        goto Ulbzi;
        HRtwe:
        if (!empty($_GPC['sid'])) {
            goto vq8xf;
        }
        goto YoV96;
        EXYiK:
        if (empty($sid)) {
            goto RzpUA;
        }
        goto NR9CC;
        LXUOT:
        if (empty($setting['sharedomain'])) {
            goto ZLuDq;
        }
        goto GfWtT;
        o_SvW:
        if (!strexists($siteroot, '*')) {
            goto trf5f;
        }
        goto WcgrE;
        XUC3t:
        empty($setting['sharedomain']) && ($setting['sharedomain'] = $this->module['config']['sharedomain']);
        goto LXUOT;
        YoV96:
        load()->classs('wesession');
        goto ctO3s;
        HZs5c:
        $siteroot = str_replace('*', $randstr, $siteroot);
        goto n2ARf;
        FCSxd:
        isset($_SESSION['sid']) && ($_GPC['sid'] = $_SESSION['sid']);
        goto xJWxm;
        n2ARf:
        trf5f:
        goto bkI4J;
        bkI4J:
        vWZLB:
        goto FjAmE;
        Nn9UC:
        ZLuDq:
        goto DP5pG;
        xJWxm:
        vq8xf:
        goto Uf18P;
        TmXVK:
        goto vWZLB;
        goto Nn9UC;
        Ulbzi:
    }
    protected function shareUrl($do, $m = "xiaof_toupiao", $parameter = "")
    {
        goto VfQ9W;
        KM4VM:
        bIOoh:
        goto ybgT0;
        SVTL8:
        isset($_SESSION['sid']) && ($_GPC['sid'] = $_SESSION['sid']);
        goto KM4VM;
        W3TrR:
        isset($_SESSION) or WeSession::start($_W['uniacid'], CLIENT_IP);
        goto SVTL8;
        qmWwG:
        load()->classs('wesession');
        goto W3TrR;
        JG93q:
        if (!empty($_GPC['sid'])) {
            goto bIOoh;
        }
        goto qmWwG;
        ybgT0:
        $setting = self::getSetting();
        goto DDetD;
        wTWgJ:
        return $siteroot . 'addons/xiaof_toupiao/index.php?c=entry&do=' . $do . '&m=' . $m . '&i=' . $_W['uniacid'] . '&sid=' . $_GPC['sid'] . $parameter . '&wxref=mp.weixin.qq.com#wechat_redirect';
        goto Y51k0;
        IMQVI:
        $siteroot = empty($setting['sharedomain']) ? $_W['siteroot'] : $setting['sharedomain'];
        goto wTWgJ;
        DDetD:
        empty($setting['sharedomain']) && ($setting['sharedomain'] = $this->module['config']['sharedomain']);
        goto IMQVI;
        VfQ9W:
        global $_W, $_GPC;
        goto JG93q;
        Y51k0:
    }
    protected function appMenu()
    {
        goto D5g8G;
        Bdu_A:
        isset($_SESSION['sid']) && ($_GPC['sid'] = $_SESSION['sid']);
        goto lJM0r;
        vlFUk:
        load()->classs('wesession');
        goto VwPYt;
        AKxan:
        if (!empty($_GPC['sid'])) {
            goto U0bAL;
        }
        goto vlFUk;
        lJM0r:
        U0bAL:
        goto IubwC;
        zsgN1:
        return $this->Xiaof->funcArraySort($menu, 'sort');
        goto r1mvQ;
        nluUf:
        foreach ($setting['menu'] as $v) {
            goto VYp_M;
            oaIJv:
            goto NdgZo;
            goto QA1kg;
            w02rt:
            fl5Ki:
            goto TApYa;
            Az_K0:
            $v['icon'] = 'fa fa-user';
            goto VRft1;
            VYp_M:
            if (!($v['isshow'] == 1)) {
                goto VNdrW;
            }
            goto eDpO8;
            VQPYz:
            $v['name'] = '我的';
            goto Az_K0;
            fDJn8:
            Di0am:
            goto r2RwP;
            eDpO8:
            $siteroot = $_W['siteroot'];
            goto UWXAJ;
            UaYUn:
            OlM8U:
            goto P7YPY;
            LcLTe:
            if (strexists($v['url'], '&do=join&')) {
                goto yfGF0;
            }
            goto oaIJv;
            yUdoA:
            if (strexists($v['url'], '&do=giving&') && $setting['template'] == 'weui/') {
                goto OlM8U;
            }
            goto LcLTe;
            r2RwP:
            $siteroot = '';
            goto S30k9;
            UWXAJ:
            if (strexists($v['url'], 'http://') or strexists($v['url'], 'https://')) {
                goto ZQd3a;
            }
            goto S0KaU;
            VRft1:
            $v['do'] = 'show';
            goto U6RSp;
            i96V2:
            if (!self::checkjoin()) {
                goto ugpAs;
            }
            goto FMahq;
            SYP3Q:
            NdgZo:
            goto zRGlj;
            QA1kg:
            ZQd3a:
            goto P1W_U;
            h_Bmg:
            goto NdgZo;
            goto UaYUn;
            n0wjq:
            goto NdgZo;
            goto k94qZ;
            U6RSp:
            ugpAs:
            goto SYP3Q;
            S30k9:
            $v['url'] = $v['url'] . '" onclick="opengroup(this)';
            goto rTS96;
            tfiSu:
            goto NdgZo;
            goto fDJn8;
            rTS96:
            $v['istabbar'] = 1;
            goto h_Bmg;
            Jai6n:
            VNdrW:
            goto w02rt;
            zRGlj:
            $v['url'] = $siteroot . str_replace(array("{sid}", "{i}"), array($_GPC['sid'], $_W['uniacid']), $v['url']);
            goto UW6xL;
            k94qZ:
            yfGF0:
            goto i96V2;
            S0KaU:
            if (strexists($v['url'], 'javascript:')) {
                goto Di0am;
            }
            goto yUdoA;
            UW6xL:
            $menu[] = $v;
            goto Jai6n;
            P7YPY:
            $v['url'] = str_replace('&do=giving&', '&do=givingopt&', $v['url']);
            goto n0wjq;
            P1W_U:
            $siteroot = '';
            goto tfiSu;
            FMahq:
            $v['url'] = str_replace('&do=join&', '&do=show&', $v['url']);
            goto VQPYz;
            TApYa:
        }
        goto uFAjJ;
        D5g8G:
        global $_W, $_GPC;
        goto AKxan;
        kGqy0:
        $menu = array();
        goto nluUf;
        uFAjJ:
        zTBq3:
        goto zsgN1;
        VwPYt:
        isset($_SESSION) or WeSession::start($_W['uniacid'], CLIENT_IP);
        goto Bdu_A;
        IubwC:
        $setting = self::getSetting();
        goto kGqy0;
        r1mvQ:
    }
    protected function defaultNavMenu()
    {
        goto DMxhj;
        DMxhj:
        global $_W, $_GPC;
        goto FWiQ5;
        FWiQ5:
        $nav = array("0" => array("sort" => 1, "name" => "首页", "url" => self::appUrl('index', 'xiaof_toupiao', '&sid=' . $_GPC['sid']), "icon" => "fa fa-home", "isshow" => 1, "do" => "index"), "1" => array("sort" => 2, "name" => "抽奖", "url" => self::appUrl('index', 'xiaof_toupiao', '&sid=' . $_GPC['sid']), "icon" => "fa fa-certificate", "isshow" => 1, "do" => "creditdraw"), "2" => array("sort" => 4, "name" => "活动详情", "url" => self::appUrl('detail', 'xiaof_toupiao', '&sid=' . $_GPC['sid']), "isshow" => 1, "do" => "detail"), "3" => array("sort" => 5, "name" => "排行", "url" => self::appUrl('top', 'xiaof_toupiao', '&sid=' . $_GPC['sid']), "icon" => "fa fa-trophy", "isshow" => 1, "do" => "top"), "4" => array("sort" => 9, "name" => "投诉", "url" => self::appUrl('tousu', 'xiaof_toupiao', '&sid=' . $_GPC['sid']), "icon" => "fa fa-warning", "isshow" => 1, "do" => "tousu"));
        goto UeDDn;
        UeDDn:
        return $nav;
        goto PIrV4;
        PIrV4:
    }
    protected function popularityTop()
    {
        goto ixznI;
        w7_PF:
        if ($setting['verify'] == 1) {
            goto KcyvT;
        }
        goto kw1Hc;
        kw1Hc:
        $condition = ' AND `verify`!=:verify';
        goto b2OYS;
        y_jb0:
        $pars[':verify'] = 1;
        goto f6V8x;
        nLdVR:
        $mypopularity = pdo_fetchall('SELECT * FROM ' . tablename('xiaof_toupiao') . ' WHERE `sid` = :sid ' . $condition . ' ORDER BY `share` DESC LIMIT 0,6', $pars);
        goto X6ujF;
        nEwQ5:
        if ($mypopularity = $this->cacheGet('mypopularity' . $setting['id'])) {
            goto wXXA2;
        }
        goto YNfCI;
        naxG6:
        KcyvT:
        goto i6x8s;
        t3gIJ:
        goto ztFhv;
        goto naxG6;
        YNfCI:
        $pars = array(":sid" => $setting['id']);
        goto w7_PF;
        X6ujF:
        $this->cacheSet('mypopularity' . $setting['id'], $mypopularity, 360);
        goto a8pBi;
        f6V8x:
        ztFhv:
        goto nLdVR;
        b2OYS:
        $pars[':verify'] = 2;
        goto t3gIJ;
        i6x8s:
        $condition = ' AND `verify`=:verify';
        goto y_jb0;
        ixznI:
        $setting = self::getSetting();
        goto nEwQ5;
        okMWJ:
        return $mypopularity;
        goto g02h6;
        a8pBi:
        wXXA2:
        goto okMWJ;
        g02h6:
    }
    protected function getThumblink($k)
    {
        goto Ow9dh;
        J0jC1:
        $keywordarr = explode(PHP_EOL, $keywordlist);
        goto PPO1q;
        Ow9dh:
        $setting = self::getSetting();
        goto KeIQ3;
        KeIQ3:
        $keywordlist = trim($setting['thumblink']);
        goto J0jC1;
        PPO1q:
        return isset($keywordarr[$k]) ? $keywordarr[$k] : '';
        goto hMZja;
        hMZja:
    }
    protected static function getSetting()
    {
        goto eZzoo;
        zeWGW:
        Oc6SJ:
        goto bsubS;
        eX3sa:
        $item['thumblinkarr'] = explode(PHP_EOL, trim($data['thumblink']));
        goto RFWpl;
        UCMzb:
        self::setGlobalcookie($xiaofshowidname, '');
        goto zyjpn;
        xY29s:
        if (!empty($sid) && $sid != $_SESSION['sid']) {
            goto rxsbV;
        }
        goto QFOJw;
        xA5LY:
        $_GPC['sid'] = $sid = $_SESSION['sid'];
        goto d2vO5;
        d2vO5:
        goto egkFc;
        goto fIuU_;
        Dovxg:
        $item['id'] = $items['id'];
        goto hAZp_;
        gX5Rw:
        is_array($data['advotepic']) or $item['advotepic'] = array(0 => $data['advotepic']);
        goto eX3sa;
        o_G6w:
        $data['giftname'] = empty($data['giftname']) ? '礼物' : $data['giftname'];
        goto p245t;
        Zd_2T:
        $item['overtime'] = 3600 * 24 * $data['day'] + 3600 * $data['hour'] + 60 * $data['minute'] + $data['second'];
        goto hO78s;
        xlzdN:
        if (!(isset($_COOKIE[$xiaofshowidname]) && !empty($_COOKIE[$xiaofshowidname]))) {
            goto Oc6SJ;
        }
        goto d0St9;
        QFOJw:
        goto egkFc;
        goto qRY2l;
        P_tS9:
        if (!($items = pdo_fetch('SELECT * FROM ' . tablename('xiaof_toupiao_setting') . ' WHERE `id` = :id limit 1', array(":id" => intval($sid))))) {
            goto wCGDZ;
        }
        goto Tp3I3;
        wAZlC:
        self::getUserinfo();
        goto yqHnK;
        A3qAN:
        $item['xiaofvotekey'] = empty($data['votetogood']) ? '票' : '赞';
        goto I7bSD;
        i0ys0:
        $item['groups'] = iunserializer($items['groups']);
        goto D0_Ow;
        yqHnK:
        $xiaofshowidname = 'xiaofshowid' . $items['id'];
        goto xlzdN;
        qRY2l:
        rNCLX:
        goto xA5LY;
        W8wuL:
        global $_GPC, $_W;
        goto LZDTX;
        p245t:
        self::$_setting = array_merge($data, $item);
        goto JXBHi;
        bsubS:
        tv4U3:
        goto s90UO;
        Gx6KV:
        $item['globalsetting'] = $xiaof_config;
        goto Fqmmn;
        d0St9:
        $xiaofshowid = intval($_COOKIE[$xiaofshowidname]);
        goto UCMzb;
        hO78s:
        $item['isrun'] = $items['isrun'];
        goto lxTTh;
        I7bSD:
        $item['xiaofvotekeyact'] = empty($data['votetogood']) ? '投' : '点';
        goto o_G6w;
        Fqmmn:
        $item['xiaofvotekeys'] = empty($data['votetogood']) ? '投票' : '点赞';
        goto A3qAN;
        aKliH:
        wCGDZ:
        goto zbp0t;
        D0_Ow:
        $item['unfollow'] = $items['unfollow'];
        goto kTgJc;
        JXBHi:
        if (!(!isset($_SESSION['xiaofuserinfo' . $items['id']]) or isset($_GET['xiaofopenid']))) {
            goto tv4U3;
        }
        goto wAZlC;
        hAZp_:
        $item['title'] = $items['tit'];
        goto JZf1b;
        s90UO:
        return self::$_setting;
        goto aKliH;
        ffD_U:
        if (empty($sid) && !empty($_SESSION['sid'])) {
            goto rNCLX;
        }
        goto xY29s;
        OKs95:
        $item['accountqrcode'] = $binditem['qrcode'];
        goto lETAi;
        zbp0t:
        return self::$_setting = null;
        goto s9tgb;
        JZf1b:
        $item['uniacid'] = $items['uniacid'];
        goto lM0Y_;
        zyjpn:
        header('location:' . self::appUrl('show', 'xiaof_toupiao', '&id=' . $xiaofshowid . ''));
        goto zeWGW;
        THSXg:
        egkFc:
        goto P_tS9;
        f7425:
        j10DL:
        goto W8wuL;
        lETAi:
        MqUf4:
        goto gX5Rw;
        LZDTX:
        load()->classs('wesession');
        goto C1Rr0;
        ImjmH:
        $sid = intval($_GPC['sid']);
        goto ffD_U;
        lxTTh:
        if (!($binditem = pdo_fetch('SELECT `qrcode` FROM ' . tablename('xiaof_toupiao_acid') . ' WHERE `sid` = :sid AND `acid` = :acid', array(":sid" => $items['id'], ":acid" => $_W['uniacid'])))) {
            goto MqUf4;
        }
        goto OKs95;
        lM0Y_:
        $item['click'] = $items['click'];
        goto i0ys0;
        Tp3I3:
        $data = iunserializer($items['data']);
        goto Dovxg;
        KkNFg:
        $item['created_at'] = $items['created_at'];
        goto Zd_2T;
        Yh90o:
        include MODULE_ROOT . '/inc/config.php';
        goto Gx6KV;
        RFWpl:
        $item['advotelinkarr'] = explode(PHP_EOL, trim($data['advotelink']));
        goto t3WyY;
        kTgJc:
        $item['bottom'] = !empty($data['bottom']) ? $data['bottom'] : $items['bottom'];
        goto KkNFg;
        eZzoo:
        if (empty(self::$_setting)) {
            goto j10DL;
        }
        goto GNwxw;
        t3WyY:
        $xiaof_config = array();
        goto Yh90o;
        fIuU_:
        rxsbV:
        goto sq1uD;
        C1Rr0:
        isset($_SESSION) or WeSession::start($_W['uniacid'], CLIENT_IP);
        goto ImjmH;
        GNwxw:
        return self::$_setting;
        goto f7425;
        sq1uD:
        $_SESSION['sid'] = $sid;
        goto THSXg;
        s9tgb:
    }
    protected function mcOpenid2uid()
    {
        goto tAZNj;
        SARZ2:
        $uid = pdo_fetchcolumn($sql, $pars);
        goto tiyZB;
        nzIo4:
        $sql = 'SELECT uid FROM ' . tablename('mc_mapping_fans') . ' WHERE `openid`=:openid limit 1';
        goto QQnxI;
        tJhlV:
        if (empty($uid)) {
            goto ls0Rm;
        }
        goto jblXU;
        QQnxI:
        $pars = array();
        goto fsazy;
        oFC41:
        $unionid = self::getUserinfo('unionid');
        goto JiwuW;
        KfeTD:
        if (!(empty($uid) && intval($this->module['config']['openweixin']) == '1')) {
            goto KRLnQ;
        }
        goto oFC41;
        Uk_ng:
        if (!(isset($_SESSION[$xiaofuidname]) && !empty($_SESSION[$xiaofuidname]))) {
            goto szsmZ;
        }
        goto Wo5t4;
        fsazy:
        $pars[':openid'] = $openid;
        goto TupPF;
        bpdSF:
        if (!empty($uid)) {
            goto ceyaz;
        }
        goto nzIo4;
        jblXU:
        $_SESSION[$xiaofuidname] = $uid;
        goto yZ5Ft;
        ranYg:
        a7fTa:
        goto z7SpT;
        HNnyr:
        $pars[':unionid'] = $unionid;
        goto SARZ2;
        sq9C4:
        TS6kV:
        goto tJhlV;
        TupPF:
        $uid = pdo_fetchcolumn($sql, $pars);
        goto bDmge;
        z7SpT:
        $uid = mc_openid2uid($openid);
        goto KfeTD;
        Lnopy:
        JGfuh:
        goto EWYnp;
        tAZNj:
        global $_W;
        goto SBTmy;
        Wo5t4:
        return $_SESSION[$xiaofuidname];
        goto bQZ1e;
        IdjZs:
        $xiaofuidname = substr(md5($_W['config']['setting']['authkey'] . 'xiaoftpuid' . $openid), 8, 16);
        goto Uk_ng;
        bD1UT:
        if (empty($_W['member']['uid'])) {
            goto JGfuh;
        }
        goto EngV5;
        EWYnp:
        if (!empty($openid)) {
            goto a7fTa;
        }
        goto k1CqZ;
        JiwuW:
        $sql = 'SELECT uid FROM ' . tablename('mc_mapping_fans') . ' WHERE `uniacid` = :uniacid AND `unionid`=:unionid limit 1';
        goto MF_uS;
        tiyZB:
        KRLnQ:
        goto bpdSF;
        yZ5Ft:
        ls0Rm:
        goto ZEGJC;
        MFv1_:
        goto TS6kV;
        goto Lnopy;
        SBTmy:
        $openid = self::getUserinfo('openid');
        goto IdjZs;
        MF_uS:
        $pars = array();
        goto F7esf;
        bQZ1e:
        szsmZ:
        goto bD1UT;
        EngV5:
        $uid = $_W['member']['uid'];
        goto MFv1_;
        bDmge:
        ceyaz:
        goto sq9C4;
        F7esf:
        $pars[':uniacid'] = $_W['uniacid'];
        goto HNnyr;
        ZEGJC:
        return empty($uid) ? false : $uid;
        goto fiNzj;
        k1CqZ:
        return false;
        goto ranYg;
        fiNzj:
    }
    protected static function setUserinfo($key, $value)
    {
        goto H6pFM;
        TONZA:
        IPESW:
        goto FBM1d;
        QgA89:
        return false;
        goto mhT2u;
        vbunD:
        $_SESSION[$xiaofuserinfo] = iserializer(self::$_userinfo);
        goto sp5fl;
        lFNuC:
        return false;
        goto IYeGC;
        gKC33:
        if (!pdo_update(self::splittingtable('xiaof_relation'), array($key => $value), array("id" => self::$_userinfo['relationid']))) {
            goto zBBpS;
        }
        goto s0aOV;
        XNhD6:
        if (!in_array($key, array("city", "gps_city", "joins"))) {
            goto tbL6W;
        }
        goto kYVFE;
        ZCZQ7:
        if (empty(self::$_userinfo['relationid'])) {
            goto O1YV0;
        }
        goto gKC33;
        FBM1d:
        ZezA7:
        goto ZCZQ7;
        sp5fl:
        return true;
        goto A_sP0;
        YA6or:
        if (!empty(self::$_userinfo['relationid'])) {
            goto ZezA7;
        }
        goto qxpTA;
        LO2I9:
        O1YV0:
        goto h4Fs3;
        kYVFE:
        if (!(!empty($value) or $value === 0)) {
            goto cYVkb;
        }
        goto wdcaG;
        A_sP0:
        zBBpS:
        goto LO2I9;
        qxpTA:
        if (!(isset($_SESSION[$xiaofuserinfo]) && is_serialized($_SESSION[$xiaofuserinfo]))) {
            goto IPESW;
        }
        goto UG_Se;
        IYywR:
        tbL6W:
        goto lFNuC;
        H6pFM:
        global $_W;
        goto RDJZZ;
        wdcaG:
        $xiaofuserinfo = 'xiaofuserinfo' . self::$_setting['id'];
        goto YA6or;
        UG_Se:
        self::$_userinfo = iunserializer($_SESSION[$xiaofuserinfo]);
        goto TONZA;
        h4Fs3:
        cYVkb:
        goto IYywR;
        RDJZZ:
        if (!($_W['container'] != 'wechat' or empty($_W['openid']))) {
            goto wRH6Y;
        }
        goto QgA89;
        mhT2u:
        wRH6Y:
        goto XNhD6;
        s0aOV:
        self::$_userinfo[$key] = $key == 'joins' ? $value : iunserializer($value);
        goto vbunD;
        IYeGC:
    }
    protected static function getUserinfo($key = null)
    {
        goto JYBuW;
        katcu:
        if ($beforeitem = pdo_fetch('SELECT * FROM ' . tablename(self::splittingtable('xiaof_relation')) . ' WHERE ' . $beforecondition . ' limit 1', $beforepars)) {
            goto l9Gfc;
        }
        goto mx00a;
        paF_V:
        Um0qK:
        goto A9a49;
        JiYmQ:
        goto Pb1uE;
        goto agHfE;
        Q5aGf:
        MYjJz:
        goto nsNXt;
        bU4Gl:
        if (!isset($fans['unionid'])) {
            goto rw2cB;
        }
        goto uCAI0;
        tC0ln:
        goto rahz3;
        goto nait3;
        ttIH6:
        $row['follow'] = $fans['follow'];
        goto sWGXw;
        u58p_:
        empty($row['avatar']) or $sql['avatar'] = $row['avatar'];
        goto MZsXY;
        u1tpd:
        goto DlRa9;
        goto IwJ5P;
        NyGNu:
        pdo_update(self::splittingtable('xiaof_relation'), $sql, array("id" => $relationitems['id']));
        goto GjoVW;
        ZjS18:
        lff8T:
        goto zsQbf;
        RFjw7:
        ZOsX5:
        goto NFQ33;
        Wbb6A:
        $updaterelation['rid'] = $beforeitem['rid'];
        goto eNzJj;
        eJW_3:
        if ($_W['account']['level'] == 4 && $_W['uniacid'] == $_SESSION['oauth_acid']) {
            goto J00xN;
        }
        goto tWJfx;
        A4FII:
        if (isset($_SESSION[$xiaofuserinfo]) && is_serialized($_SESSION[$xiaofuserinfo])) {
            goto Xz_f6;
        }
        goto jQ5gY;
        agHfE:
        NCQWN:
        goto mPwP3;
        DtI2C:
        $row['avatar'] = $relationitems['avatar'];
        goto mY3RP;
        qCykA:
        if (!empty(self::$_userinfo['relationid'])) {
            goto tVFE0;
        }
        goto BXHqa;
        jK7Kf:
        c137S:
        goto HV8X2;
        SEbib:
        DlRa9:
        goto yR7CO;
        rGmyO:
        if (!isset($row['follow'])) {
            goto tmq3y;
        }
        goto iTtuy;
        EKJly:
        $sql['avatar'] = $row['avatar'];
        goto p4wMQ;
        VY7Ia:
        if (!($item = pdo_fetch('SELECT * FROM ' . tablename(self::splittingtable('xiaof_relation')) . ' WHERE `id` = :id limit 1', array(":id" => $userinfos['rid'])))) {
            goto fa1TP;
        }
        goto tBxql;
        TXJwW:
        DoSnI:
        goto qCykA;
        S4QhK:
        $access_token = $accObj->fetch_token();
        goto bEHyo;
        GjoVW:
        vxKhw:
        goto VUwOC;
        hbO8M:
        $pars = array(":uniacid" => $_W['uniacid']);
        goto Hz5iJ;
        k8G3V:
        to3zY:
        goto PHB7m;
        BXHqa:
        $relationcondition = ' `oauth_uniacid` = :oauth_uniacid AND `uniacid` = :uniacid AND `oauth_openid` = :oauth_openid ORDER BY `id` DESC ';
        goto RaAuV;
        hJCjq:
        qyYe_:
        goto GYrMl;
        hCEu0:
        isset($data['headimgurl']) && ($row['avatar'] = stripcslashes($data['headimgurl']));
        goto nh_zs;
        yklp7:
        $condition = ' AND `unionid` = :unionid';
        goto J35_M;
        cOl3h:
        $response = ihttp_get($url);
        goto RX1QL;
        IwJ5P:
        hLKXq:
        goto qClX8;
        s_6N2:
        $accObj = WeixinAccount::create($_SESSION['oauth_acid']);
        goto ei0O7;
        z0Aj4:
        if (!empty($row['unionid'])) {
            goto l4uIy;
        }
        goto s_6N2;
        nOTOK:
        U453J:
        goto HT558;
        xkRXm:
        rahz3:
        goto WTMBo;
        MqAZJ:
        isset($data['nickname']) && ($row['nickname'] = stripcslashes($data['nickname']));
        goto H0eU9;
        yAZMw:
        $row['relationid'] = pdo_insertid();
        goto Ml10G;
        RqAZe:
        self::$_userinfo = array();
        goto MVuSA;
        MZsXY:
        empty($row['unionid']) or $sql['unionid'] = $row['unionid'];
        goto Y5E6y;
        J35_M:
        $pars = array(":uniacid" => $_W['uniacid']);
        goto XDRCd;
        RaAuV:
        $relationpars = array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":uniacid" => $_W['uniacid'], ":oauth_openid" => $_SESSION['oauth_openid']);
        goto r3vPq;
        XDRCd:
        $pars[':unionid'] = $row['unionid'];
        goto W3mhl;
        Ml10G:
        goto eTh5i;
        goto paF_V;
        Gz7Nh:
        m4PPT:
        goto rGmyO;
        Ph3f0:
        $row['joins'] = $relationitems['joins'];
        goto ZFD1b;
        bEHyo:
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $access_token . '&openid=' . $row['openid'] . '&lang=zh_CN';
        goto cOl3h;
        Aa69F:
        $beforepars = array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":uniacid" => $_W['uniacid'], ":id" => $userinfos['rid'], ":oauth_openid" => $_SESSION['oauth_openid']);
        goto fmvLU;
        RX1QL:
        $data = @json_decode($response['content'], true);
        goto MqAZJ;
        JaUB2:
        fa1TP:
        goto aBDLH;
        by5Kz:
        khP2k:
        goto JqNmf;
        KaPQz:
        $beforecondition = ' `oauth_uniacid` = :oauth_uniacid AND `uniacid` = :uniacid AND `id` != :id AND `oauth_openid` = :oauth_openid';
        goto Aa69F;
        NNcZe:
        $userinfos = authcode(base64_decode(urldecode($_GPC['xiaofopenid'])), 'DECODE', md5($_SERVER['HTTP_HOST'] . 'xi9aofhaha' . $_W['uniacid'] . $_W['config']['setting']['authkey']));
        goto svKoU;
        ZYNXT:
        if (!(empty($relationitems['fans_city']) && !empty($row['fans_city']))) {
            goto m4PPT;
        }
        goto f6Asf;
        H0eU9:
        isset($data['headimgurl']) && ($row['avatar'] = stripcslashes($data['headimgurl']));
        goto ula6S;
        ZA1P3:
        if (in_array($key, array("city", "gps_city", "joins"))) {
            goto mowY1;
        }
        goto C53Yq;
        pxao_:
        mowY1:
        goto pNfYy;
        C53Yq:
        if (!empty(self::$_userinfo[$key])) {
            goto NCQWN;
        }
        goto mk5Ak;
        nsNXt:
        $row['nickname'] = $relationitems['nickname'];
        goto DtI2C;
        fQfCe:
        if (!($fans = pdo_fetch('SELECT `openid`,`follow` FROM ' . tablename('mc_mapping_fans') . ' WHERE `uniacid` = :uniacid ' . $condition . ' limit 1', $pars))) {
            goto wAo4r;
        }
        goto Cz694;
        g7IV7:
        empty($row['openid']) or $sql['openid'] = $row['openid'];
        goto Cr0fI;
        DdtrG:
        $row['fans_city'] = array("province" => trim($fans['province']), "city" => trim($fans['city']));
        goto DMJO6;
        jWbkD:
        $relationpars = array(":id" => self::$_userinfo['relationid']);
        goto jtV7I;
        pQAhK:
        $row['gps_city'] = iunserializer($relationitems['gps_city']);
        goto HzDI1;
        JYBuW:
        global $_W, $_GPC;
        goto UoNbt;
        zZhrW:
        Z7Kn4:
        goto dD2H4;
        DMJO6:
        $row['avatar'] = $fans['avatar'];
        goto bU4Gl;
        pNfYy:
        return self::$_userinfo[$key];
        goto JiYmQ;
        qKacl:
        goto oBlvV;
        goto yTaid;
        YjkqO:
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $access_token . '&openid=' . $_SESSION['oauth_openid'] . '&lang=zh_CN';
        goto Ls440;
        ZFD1b:
        if (!(!empty(self::$_setting['verifysms']) && empty($relationitems['city']))) {
            goto lff8T;
        }
        goto FGngw;
        oWmaw:
        iMAwS:
        goto SEbib;
        fDcFP:
        tmq3y:
        goto jJSXc;
        D5T2H:
        Z5rbQ:
        goto Ml9hv;
        GIL4L:
        DkN3O:
        goto uEpQ9;
        mY3RP:
        $row['unionid'] = $relationitems['unionid'];
        goto zGCO5;
        B36wI:
        goto ixBqZ;
        goto camzr;
        r3vPq:
        goto L8D6_;
        goto uitKt;
        HKlmL:
        if (is_null($key)) {
            goto Gs1r7;
        }
        goto Udx9B;
        HHQAS:
        goto DlRa9;
        goto e7FQn;
        gM3qg:
        goto DoSnI;
        goto yv0ot;
        paPyh:
        pdo_update(self::splittingtable('xiaof_relation'), $updaterelation, array("id" => $userinfos['rid']));
        goto vP0Tl;
        NBoVd:
        goto t831s;
        goto RFjw7;
        svKoU:
        $userinfos = iunserializer($userinfos);
        goto VY7Ia;
        W3mhl:
        if (!($fans = pdo_fetch('SELECT `openid`,`follow` FROM ' . tablename('mc_mapping_fans') . ' WHERE `uniacid` = :uniacid ' . $condition . ' limit 1', $pars))) {
            goto fWO1N;
        }
        goto ftmnT;
        iTtuy:
        $sql['follow'] = $row['follow'];
        goto fDcFP;
        ASezM:
        $beforepars = array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":uniacid" => $_W['uniacid'], ":oauth_openid" => $_SESSION['oauth_openid']);
        goto katcu;
        HbQHQ:
        if ($item['oauth_openid'] == $_SESSION['oauth_openid']) {
            goto c137S;
        }
        goto vkM2D;
        ftmnT:
        $row['openid'] = $fans['openid'];
        goto ttIH6;
        Udx9B:
        if (in_array($key, array("city", "gps_city", "follow", "joins"))) {
            goto KBc4z;
        }
        goto MBov1;
        d764L:
        return self::$_userinfo[$key];
        goto iYTba;
        aHJVA:
        $sql['openid'] = $row['openid'];
        goto HcfW4;
        lb4El:
        return $row;
        goto moZQZ;
        yG2Pm:
        self::$_userinfo = $row;
        goto oz5Ll;
        DrzaT:
        wTxO2:
        goto xlbai;
        bphoO:
        $row['openid'] = $_W['openid'];
        goto NBoVd;
        UoNbt:
        if (!($_W['container'] != 'wechat' or empty($_W['openid']))) {
            goto wTxO2;
        }
        goto nu3Tf;
        qVS06:
        goto mRK4a;
        goto rKexq;
        yTaid:
        KEtPH:
        goto d764L;
        nu3Tf:
        return false;
        goto DrzaT;
        uvGCG:
        return $row[$key];
        goto S6a8B;
        vkM2D:
        goto tOVfE;
        goto by5Kz;
        rKexq:
        jndnk:
        goto Wbb6A;
        d38CG:
        SuAAF:
        goto rUntk;
        Ug9sM:
        oBlvV:
        goto gM3qg;
        Ui4JZ:
        empty($data['province']) or $row['fans_city'] = array("province" => trim($data['province']), "city" => trim($data['city']));
        goto oWmaw;
        moZQZ:
        WD4QE:
        goto xkRXm;
        jJSXc:
        if (!(count($sql) >= 1)) {
            goto vxKhw;
        }
        goto NyGNu;
        dD2H4:
        $accObj = WeixinAccount::create($_W['acid']);
        goto S4QhK;
        Cz694:
        $row['openid'] = $fans['openid'];
        goto RF0mD;
        S7ej3:
        mRK4a:
        goto pLa7G;
        tBxql:
        if (!($item['uniacid'] == $_W['uniacid'] && $item['oauth_uniacid'] == $_SESSION['oauth_acid'] && $item['openid'] == $userinfos['openid'])) {
            goto DSCKs;
        }
        goto RqAZe;
        ZZN5f:
        $followmode = self::$_setting['followmode'];
        goto izJmZ;
        HT558:
        $beforecondition = ' `oauth_uniacid` = :oauth_uniacid AND `uniacid` = :uniacid AND `oauth_openid` = :oauth_openid  AND `rid` != \'0\' ';
        goto ASezM;
        NFQ33:
        if (empty($row['unionid'])) {
            goto SuAAF;
        }
        goto yklp7;
        f6Asf:
        $sql['fans_city'] = iserializer($row['fans_city']);
        goto Gz7Nh;
        GoIc7:
        return is_null($key) ? $row : $row[$key];
        goto LdsxU;
        vs4MV:
        lNExV:
        goto BaESU;
        YzaE3:
        isset($data['unionid']) && ($row['unionid'] = $data['unionid']);
        goto xYGty;
        mPwP3:
        return self::$_userinfo[$key];
        goto rhrsm;
        jQ5gY:
        goto DoSnI;
        goto ypSkl;
        rhrsm:
        Pb1uE:
        goto y64Uz;
        MVuSA:
        if (empty($item['oauth_openid'])) {
            goto khP2k;
        }
        goto HbQHQ;
        aHu_C:
        $row['nickname'] = $fans['nickname'];
        goto DdtrG;
        Fu2di:
        pdo_insert(self::splittingtable('xiaof_relation'), $sql);
        goto yAZMw;
        GYrMl:
        if (!empty($row['openid'])) {
            goto lNExV;
        }
        goto eJW_3;
        leHGt:
        tOVfE:
        goto ypJ3J;
        yv0ot:
        Xz_f6:
        goto tkd12;
        uCAI0:
        $row['unionid'] = $fans['unionid'];
        goto eTLJR;
        aBDLH:
        unset($_GPC['xiaofopenid']);
        goto D5T2H;
        j_T3N:
        mSnew:
        goto XXV6z;
        FGngw:
        if (!($city = pdo_fetchcolumn('SELECT `city` FROM ' . tablename(self::splittingtable('xiaof_relation')) . ' WHERE `oauth_uniacid` = :oauth_uniacid AND `oauth_openid` = :oauth_openid AND `city` != \'\' limit 1', array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":oauth_openid" => $_SESSION['oauth_openid'])))) {
            goto H0foS;
        }
        goto xOVe6;
        Yw4SQ:
        $sql = array("uniacid" => $_W['uniacid'], "oauth_uniacid" => $_SESSION['oauth_acid'], "oauth_openid" => $_SESSION['oauth_openid']);
        goto g7IV7;
        EqX8R:
        $row['nickname'] = $relationusersinfo['nickname'];
        goto Cks90;
        iYTba:
        goto oBlvV;
        goto CRpgY;
        MVHSS:
        J00xN:
        goto bphoO;
        HzDI1:
        $row['fans_city'] = iunserializer($relationitems['fans_city']);
        goto QJ0Dl;
        Cks90:
        $row['avatar'] = $relationusersinfo['avatar'];
        goto j_T3N;
        CGnc8:
        $row['relationid'] = $relationitems['id'];
        goto BFtoV;
        tWJfx:
        if ($_W['account']['level'] >= 3) {
            goto ZOsX5;
        }
        goto AGohx;
        ypSkl:
        NySbB:
        goto B1i3w;
        B1i3w:
        if (in_array($key, array("city", "gps_city", "joins"))) {
            goto KEtPH;
        }
        goto JSfzn;
        Cr0fI:
        empty($row['nickname']) or $sql['nickname'] = $row['nickname'];
        goto u58p_;
        QJ0Dl:
        if (!(count($sql) >= 1)) {
            goto IQaFq;
        }
        goto OWdPz;
        Rdap4:
        $data = @json_decode($response['content'], true);
        goto Aorq9;
        xYGty:
        l4uIy:
        goto hJCjq;
        vP0Tl:
        goto tOVfE;
        goto jK7Kf;
        hBGsN:
        if (!($relationitems = pdo_fetch('SELECT * FROM ' . tablename(self::splittingtable('xiaof_relation')) . ' WHERE ' . $relationcondition . ' limit 1', $relationpars))) {
            goto BPDLl;
        }
        goto set4Z;
        S6a8B:
        ixBqZ:
        goto tC0ln;
        xlbai:
        $xiaofuserinfo = 'xiaofuserinfo' . self::$_setting['id'];
        goto ahMnl;
        nh_zs:
        empty($data['province']) or $row['fans_city'] = array("province" => trim($data['province']), "city" => trim($data['city']));
        goto YzaE3;
        lsvi1:
        IQaFq:
        goto HKlmL;
        hk2y3:
        return $row[$key];
        goto i9Il2;
        O5Yq3:
        $sql['rid'] = $row['rid'] = $beforeitem['rid'];
        goto GIL4L;
        d1Dcm:
        l9Gfc:
        goto O5Yq3;
        HcfW4:
        vfyrN:
        goto ZYNXT;
        eNzJj:
        $updaterelation['credit'] = $beforeitem['credit'];
        goto qZR9w;
        dw1Ll:
        $sql['nickname'] = $row['nickname'];
        goto SvPeW;
        eTLJR:
        $condition = ' AND `unionid` = :unionid';
        goto hbO8M;
        mfM8w:
        rw2cB:
        goto wFoGw;
        RF0mD:
        $row['follow'] = $fans['follow'];
        goto U6y_i;
        jtV7I:
        L8D6_:
        goto loHKn;
        BB3uj:
        $row['rid'] = $relationitems['rid'];
        goto FoIBZ;
        e65dn:
        if (!(!is_null($key) && $key != 'follow' && isset(self::$_userinfo[$key]))) {
            goto uLVx3;
        }
        goto ZA1P3;
        Vzarl:
        self::$_userinfo = $row;
        goto EIjJD;
        nait3:
        Gs1r7:
        goto mJg7R;
        JqNmf:
        $updaterelation = array("oauth_openid" => $_SESSION['oauth_openid']);
        goto KaPQz;
        b_uIi:
        DSCKs:
        goto JaUB2;
        f9PTp:
        if (!(empty($relationitems['unionid']) && !empty($row['unionid']))) {
            goto to3zY;
        }
        goto HVXW0;
        fmvLU:
        if ($beforeitem = pdo_fetch('SELECT * FROM ' . tablename(self::splittingtable('xiaof_relation')) . ' WHERE ' . $beforecondition . ' limit 1', $beforepars)) {
            goto jndnk;
        }
        goto uK4mb;
        FoIBZ:
        goto MYjJz;
        goto nOTOK;
        I2lJ0:
        H0foS:
        goto ZjS18;
        F_7yu:
        if (empty($relationitems['rid'])) {
            goto U453J;
        }
        goto BB3uj;
        yR7CO:
        if ($relationitems) {
            goto Um0qK;
        }
        goto Yw4SQ;
        BFtoV:
        $row['openid'] = $relationitems['openid'];
        goto F_7yu;
        BW9Ds:
        $_SESSION[$xiaofuserinfo] = iserializer(self::$_userinfo);
        goto Q5aGf;
        uK4mb:
        $updaterelation['rid'] = $userinfos['rid'];
        goto qVS06;
        izJmZ:
        if (!($followmode == 1 or $followmode == 3)) {
            goto qyYe_;
        }
        goto z0Aj4;
        WTMBo:
        BPDLl:
        goto V0o63;
        V0o63:
        load()->classs('weixin.account');
        goto LLn1H;
        Fsv2g:
        if (!empty($row['openid']) && (empty($row['nickname']) or empty($row['avatar']) or empty($row['fans_city']))) {
            goto IKxS_;
        }
        goto u1tpd;
        XXV6z:
        goto iMAwS;
        goto zZhrW;
        VUwOC:
        eTh5i:
        goto A6D_x;
        oz5Ll:
        $_SESSION[$xiaofuserinfo] = iserializer(self::$_userinfo);
        goto lb4El;
        GzhmM:
        $relationcondition = ' `id` = :id';
        goto jWbkD;
        mJg7R:
        if (!(empty(self::$_setting['openoauthuserinfo']) or $_W['isajax'] or !empty($row['nickname']))) {
            goto WD4QE;
        }
        goto yG2Pm;
        qZR9w:
        pdo_update(self::splittingtable('xiaof_relation'), array("credit" => 0), array("id" => $beforeitem['id']));
        goto S7ej3;
        A6D_x:
        isset($row['follow']) or $row['follow'] = 0;
        goto Vzarl;
        Aorq9:
        isset($data['nickname']) && ($row['nickname'] = stripcslashes($data['nickname']));
        goto hCEu0;
        ahMnl:
        if (!isset($_GPC['xiaofopenid'])) {
            goto Z5rbQ;
        }
        goto NNcZe;
        CRpgY:
        IbX0H:
        goto e6IHt;
        BaESU:
        if (!empty(self::$_setting['openoauthuserinfo']) && !$_W['isajax']) {
            goto hLKXq;
        }
        goto Fsv2g;
        x7EuF:
        if (!(empty($relationitems['nickname']) && !empty($row['nickname']))) {
            goto tjVzl;
        }
        goto dw1Ll;
        SvPeW:
        tjVzl:
        goto n3OHH;
        e7FQn:
        IKxS_:
        goto ZgM2q;
        mx00a:
        $sql['rid'] = $row['rid'] = $relationitems['id'];
        goto Q_xum;
        OWdPz:
        pdo_update(self::splittingtable('xiaof_relation'), $sql, array("id" => $relationitems['id']));
        goto lsvi1;
        tkd12:
        self::$_userinfo = iunserializer($_SESSION[$xiaofuserinfo]);
        goto e65dn;
        i9Il2:
        goto ixBqZ;
        goto UFvYW;
        ula6S:
        $row['follow'] = $data['subscribe'];
        goto Ui4JZ;
        set4Z:
        $sql = array();
        goto CGnc8;
        LLn1H:
        load()->func('communication');
        goto ZZN5f;
        Y5E6y:
        empty($row['fans_city']) or $sql['fans_city'] = iserializer($row['fans_city']);
        goto EK8Ly;
        UFvYW:
        K6_vL:
        goto uvGCG;
        ZgM2q:
        if ($_W['account']['level'] >= 3) {
            goto Z7Kn4;
        }
        goto Ng1HE;
        Ls440:
        $response = ihttp_get($url);
        goto Rdap4;
        ei0O7:
        $access_token = $accObj->fetch_token();
        goto YjkqO;
        Q_xum:
        goto DkN3O;
        goto d1Dcm;
        uitKt:
        tVFE0:
        goto GzhmM;
        zsQbf:
        $row['city'] = iunserializer($relationitems['city']);
        goto pQAhK;
        y64Uz:
        uLVx3:
        goto TXJwW;
        EIjJD:
        $_SESSION[$xiaofuserinfo] = iserializer(self::$_userinfo);
        goto GoIc7;
        A9a49:
        $sql = array();
        goto x7EuF;
        rUntk:
        t831s:
        goto vs4MV;
        ypJ3J:
        unset($_SESSION[$xiaofuserinfo]);
        goto b_uIi;
        JSfzn:
        if (!empty(self::$_userinfo[$key])) {
            goto IbX0H;
        }
        goto qKacl;
        loHKn:
        $row = array();
        goto hBGsN;
        zGCO5:
        $row['follow'] = $relationitems['follow'];
        goto Ph3f0;
        mk5Ak:
        goto Pb1uE;
        goto pxao_;
        qClX8:
        if (!(empty($row['nickname']) or empty($row['avatar']) or empty($row['fans_city']))) {
            goto CsFSx;
        }
        goto xMuOx;
        camzr:
        KBc4z:
        goto hk2y3;
        n3OHH:
        if (!(empty($relationitems['avatar']) && !empty($row['avatar']))) {
            goto OpZqC;
        }
        goto EKJly;
        uEpQ9:
        self::$_userinfo['rid'] = $row['rid'];
        goto BW9Ds;
        Ml9hv:
        if (!is_null($key) && $key != 'follow' && isset(self::$_userinfo[$key])) {
            goto NySbB;
        }
        goto A4FII;
        wFoGw:
        CsFSx:
        goto HHQAS;
        EK8Ly:
        $sql['follow'] = $row['follow'] = isset($row['follow']) ? $row['follow'] : 0;
        goto Fu2di;
        pLa7G:
        self::$_userinfo['relationid'] = $userinfos['rid'];
        goto paPyh;
        xOVe6:
        $sql['city'] = $relationitems['city'] = $city;
        goto I2lJ0;
        MBov1:
        if (!empty($row[$key])) {
            goto K6_vL;
        }
        goto B36wI;
        HVXW0:
        $sql['unionid'] = $row['unionid'];
        goto k8G3V;
        AGohx:
        goto t831s;
        goto MVHSS;
        Hz5iJ:
        $pars[':unionid'] = $row['unionid'];
        goto fQfCe;
        e6IHt:
        return self::$_userinfo[$key];
        goto Ug9sM;
        xMuOx:
        $fans = mc_oauth_userinfo();
        goto aHu_C;
        Ng1HE:
        if (!($relationusersinfo = pdo_fetch('SELECT * FROM ' . tablename(self::splittingtable('xiaof_relation')) . ' WHERE `oauth_uniacid` = :oauth_uniacid AND `oauth_openid` = :oauth_openid AND `nickname` != \'\' limit 1', array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":oauth_openid" => $_SESSION['oauth_openid'])))) {
            goto mSnew;
        }
        goto EqX8R;
        U6y_i:
        wAo4r:
        goto mfM8w;
        HV8X2:
        self::$_userinfo['relationid'] = $item['id'];
        goto leHGt;
        p4wMQ:
        OpZqC:
        goto f9PTp;
        PHB7m:
        if (!(empty($relationitems['openid']) && !empty($row['openid']))) {
            goto vfyrN;
        }
        goto aHJVA;
        sWGXw:
        fWO1N:
        goto d38CG;
        LdsxU:
    }
    protected function n2c($x)
    {
        $arr = array("零", "一", "双", "三", "四", "五", "六", "七", "八", "九", "十");
        return $arr[$x];
    }
    protected static function checkjoin()
    {
        goto egL0z;
        TCBPQ:
        return $pid;
        goto daMhB;
        j9j2b:
        global $_W;
        goto vjvu1;
        ebT88:
        $openid = array_filter($openid);
        goto NSw2e;
        vjvu1:
        if (isset($_SESSION['oauth_openid'])) {
            goto fyb0j;
        }
        goto j9d0Q;
        Dp9Ib:
        YkZxs:
        goto j9j2b;
        NSw2e:
        $openid = array_unique($openid);
        goto gbxtx;
        daMhB:
        doSXR:
        goto pgcg5;
        YI_Aa:
        foreach ($relations as $k => $v) {
            $openid[] = $v['openid'];
            YbBw9:
        }
        goto lEN8u;
        nNYaZ:
        fyb0j:
        goto C7YpZ;
        jCmz6:
        return $joins;
        goto Dp9Ib;
        Zk0rJ:
        self::setUserinfo('joins', $pid);
        goto TCBPQ;
        C7YpZ:
        $setting = self::getSetting();
        goto aEEp_;
        aEEp_:
        if (!($relations = pdo_fetchall('SELECT A.* FROM ' . tablename(self::splittingtable('xiaof_relation')) . ' as A, (SELECT MAX(id) as maxid FROM ' . tablename(self::splittingtable('xiaof_relation')) . ' where `oauth_uniacid` = :oauth_uniacid AND `oauth_openid` = :oauth_openid GROUP BY `uniacid`) as B WHERE A.id = B.maxid', array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":oauth_openid" => $_SESSION['oauth_openid'])))) {
            goto Tk5w8;
        }
        goto eU4us;
        eU4us:
        $openid = array();
        goto bjsxp;
        QxPV4:
        return 0;
        goto ISShB;
        egL0z:
        if (!($joins = self::getUserinfo('joins'))) {
            goto YkZxs;
        }
        goto jCmz6;
        j9d0Q:
        return 0;
        goto nNYaZ;
        lEN8u:
        T3UeB:
        goto ebT88;
        gbxtx:
        if (!($pid = pdo_fetchcolumn('SELECT `id` FROM ' . tablename('xiaof_toupiao') . ' WHERE `sid` = \'' . intval($setting['id']) . '\' AND `openid` IN (\'' . implode('\',\'', $openid) . '\') limit 1'))) {
            goto doSXR;
        }
        goto Zk0rJ;
        pgcg5:
        Tk5w8:
        goto QxPV4;
        bjsxp:
        $openid[] = $_W['openid'];
        goto YI_Aa;
        ISShB:
    }
    protected function checkFollow()
    {
        goto LGe29;
        IpJow:
        return false;
        goto qz3YK;
        aGfJ2:
        if ($fansrow = pdo_fetch('SELECT `follow` FROM ' . tablename('mc_mapping_fans') . ' WHERE `uniacid` = :uniacid AND `openid` = :openid limit 1', $pars)) {
            goto d0TZ9;
        }
        goto KGAr5;
        usUm1:
        return true;
        goto Mfcxm;
        aAFsA:
        v7CjL:
        goto PvVNK;
        Mfcxm:
        LinOu:
        goto zx0F6;
        KGAr5:
        if (self::getUserinfo('follow') == 1) {
            goto ydvO7;
        }
        goto WMy36;
        zx0F6:
        return false;
        goto Kz4Li;
        Rz5lB:
        return true;
        goto aAFsA;
        eJQXv:
        ydvO7:
        goto usUm1;
        BwH_A:
        if (!($fansrow['follow'] == 1)) {
            goto v7CjL;
        }
        goto Rz5lB;
        xfSds:
        d0TZ9:
        goto BwH_A;
        WMy36:
        goto LinOu;
        goto xfSds;
        tbMGh:
        if (!empty($openid)) {
            goto fXTH6;
        }
        goto IpJow;
        LTAqM:
        $openid = self::getUserinfo('openid');
        goto tbMGh;
        LGe29:
        global $_W;
        goto LTAqM;
        qz3YK:
        fXTH6:
        goto uK6pR;
        PvVNK:
        goto LinOu;
        goto eJQXv;
        uK6pR:
        $pars = array(":uniacid" => $_W['uniacid'], ":openid" => $openid);
        goto aGfJ2;
        Kz4Li:
    }
    protected function getSettingacid()
    {
        goto WpqXy;
        KGZkK:
        $acids[] = $setting['uniacid'];
        goto DEdnx;
        xQaFd:
        gczmj:
        goto Em7Bt;
        DEdnx:
        $bindacidlists = pdo_fetchall('SELECT * FROM ' . tablename('xiaof_toupiao_acid') . ' WHERE `sid` = :sid', array(":sid" => $setting['id']));
        goto GsJVH;
        GsJVH:
        foreach ($bindacidlists as $v) {
            $acids[] = $v['acid'];
            MRDWV:
        }
        goto xQaFd;
        Em7Bt:
        return array_unique($acids);
        goto ea_dc;
        WpqXy:
        $setting = self::getSetting();
        goto KGZkK;
        ea_dc:
    }
    protected function getAllopenid()
    {
        goto q6aqW;
        qjM01:
        NzW9C:
        goto QAvUh;
        hSG4W:
        if (!($relationopenid = pdo_fetchall('SELECT `openid` FROM ' . tablename(self::splittingtable('xiaof_relation')) . ' WHERE `oauth_uniacid` = :oauth_uniacid AND `unionid` = :unionid', array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":unionid" => $unionid)))) {
            goto DZgxy;
        }
        goto P2Gym;
        LApgz:
        R1ltE:
        goto BD_nS;
        q6aqW:
        $openids = array();
        goto Ucjbs;
        L9jGp:
        return $openids;
        goto pfQ5j;
        W5SSp:
        DZgxy:
        goto KZwUr;
        nNlbT:
        return $openids;
        goto VxSHb;
        QAvUh:
        ybjJc:
        goto OA0sp;
        BD_nS:
        if (!(count($openids) < 1)) {
            goto FSZ9A;
        }
        goto UkE64;
        Ucjbs:
        $followmode = self::$_setting['followmode'];
        goto ZS6Sz;
        VhBX0:
        $unionid = self::getUserinfo('unionid');
        goto ZzMOU;
        jnAqJ:
        N4fFt:
        goto W5SSp;
        BCgTN:
        foreach ($relationopenid as $v) {
            $openids[] = $v['openid'];
            PPB_f:
        }
        goto qjM01;
        VSclx:
        if (!($followmode == 1 or $followmode == 3)) {
            goto R1ltE;
        }
        goto VhBX0;
        ZzMOU:
        if (empty($unionid)) {
            goto XEOrv;
        }
        goto hSG4W;
        pfQ5j:
        Zp1en:
        goto VSclx;
        KZwUr:
        XEOrv:
        goto LApgz;
        P2Gym:
        foreach ($relationopenid as $v) {
            $openids[] = $v['openid'];
            N0ZBA:
        }
        goto jnAqJ;
        ZS6Sz:
        if (isset($_SESSION['oauth_openid'])) {
            goto Zp1en;
        }
        goto L9jGp;
        OA0sp:
        FSZ9A:
        goto nNlbT;
        UkE64:
        if (!($relationopenid = pdo_fetchall('SELECT * FROM ' . tablename(self::splittingtable('xiaof_relation')) . ' WHERE `oauth_uniacid` = :oauth_uniacid AND `oauth_openid` = :oauth_openid', array(":oauth_uniacid" => $_SESSION['oauth_acid'], ":oauth_openid" => $_SESSION['oauth_openid'])))) {
            goto ybjJc;
        }
        goto BCgTN;
        VxSHb:
    }
    protected function checkUseragent()
    {
        goto hRPyE;
        KfWZx:
        $identity = md5(date('ymdh') . $_SERVER['HTTP_USER_AGENT'] . getIp());
        goto JIpk3;
        cdY1C:
        if (isset($_SESSION[$key])) {
            goto FC7qX;
        }
        goto PccSC;
        zisa_:
        I9VUB:
        goto eUj8J;
        sfPVm:
        empty($setting['openwildcarddomain']) && ($setting['openwildcarddomain'] = $this->module['config']['openwildcarddomain']);
        goto G0zBz;
        LMkG7:
        $randstr = strtolower(random(6));
        goto OfT8f;
        Z_A6z:
        if (empty($setting['safedomain'])) {
            goto VHckm;
        }
        goto d09gY;
        CkMxJ:
        B0UbD:
        goto vYArx;
        WjTCL:
        if ($setting = self::getSetting()) {
            goto B0UbD;
        }
        goto kL2kM;
        Cw48M:
        message('错误，只允许通过微信访问，请在微信打开本链接', '', 'error');
        goto E47Qc;
        hVXQo:
        $requesturl = ltrim($_SERVER['REQUEST_URI'], '/');
        goto zisa_;
        lfxCa:
        $requesturl = ltrim(substr($_SERVER['REQUEST_URI'], $pathpos), '/');
        goto AFI9n;
        aJq2a:
        pdo_query('UPDATE ' . tablename('xiaof_toupiao_setting') . ' SET `click` = click+1 WHERE `id` = \'' . $setting['id'] . '\'');
        goto SCAFm;
        G0zBz:
        foreach ($setting['binddomain'] as $v) {
            goto U53zr;
            xv1Na:
            if (!($setting['openwildcarddomain'] == 1 && strexists($v, '*'))) {
                goto pTEz4;
            }
            goto A2V4U;
            kowWi:
            if (!preg_match('/' . $pattern . '/', $_SERVER['HTTP_HOST'])) {
                goto ASrPq;
            }
            goto NdeIu;
            IW3xV:
            pTEz4:
            goto qCPKH;
            H_Xdz:
            $close = false;
            goto qc7Ki;
            qc7Ki:
            goto bBBaf;
            goto PVzCe;
            hUOQL:
            goto bBBaf;
            goto MZ_a3;
            U53zr:
            if (!strexists($v, $_SERVER['HTTP_HOST'])) {
                goto Hln8P;
            }
            goto H_Xdz;
            qCPKH:
            VViCe:
            goto XX_s9;
            PVzCe:
            Hln8P:
            goto xv1Na;
            A2V4U:
            $hosts = parse_url($v, PHP_URL_HOST);
            goto piSz1;
            MZ_a3:
            ASrPq:
            goto IW3xV;
            NdeIu:
            $close = false;
            goto hUOQL;
            piSz1:
            $pattern = str_replace(array("*", "."), array("[a-zA-Z0-9]{6}", "\\."), $hosts);
            goto kowWi;
            XX_s9:
        }
        goto Ztvv5;
        SPPZ2:
        $pathpos = stripos($_SERVER['REQUEST_URI'], '/app/index.php');
        goto a5rsZ;
        qpxos:
        if (empty($setting['closedomain'])) {
            goto cvr_x;
        }
        goto WqdwS;
        bUuUP:
        $_SESSION[$key] = TIMESTAMP;
        goto MzqXF;
        bATIv:
        goto BLU1Z;
        goto CkMxJ;
        eUj8J:
        header('location:' . $host . $requesturl);
        goto Tua62;
        JIpk3:
        if ($_GPC['statistics'] == $identity) {
            goto isIfg;
        }
        goto ljQDt;
        UCpXn:
        VHckm:
        goto qpxos;
        zi45D:
        GTZyl:
        goto H23ml;
        xxo4v:
        isIfg:
        goto bUuUP;
        nnynA:
        message('页面已失效', '', 'error');
        goto G1EsF;
        hOiyv:
        if (!$close) {
            goto GTZyl;
        }
        goto GcdND;
        vYArx:
        if (empty($setting['closeactivity'])) {
            goto Kfxws;
        }
        goto ik5kB;
        SfcxR:
        empty($setting['binddomain']) && ($setting['binddomain'][] = $_W['siteroot']);
        goto dvbAl;
        SCAFm:
        if (!(isset($setting['checkua']) && $setting['checkua'] == 1 && $_W['container'] !== 'wechat')) {
            goto Z04s_;
        }
        goto Cw48M;
        ik5kB:
        message($setting['closeactivity']);
        goto hQ_VY;
        dG6hq:
        if (!strexists($host, '*')) {
            goto nL0DF;
        }
        goto LMkG7;
        d09gY:
        $key = 'xt' . $_W['uniacid'] . $setting['id'] . substr(md5($_W['config']['setting']['authkey'] . $_SERVER['HTTP_USER_AGENT']), 0, 8);
        goto cdY1C;
        E47Qc:
        Z04s_:
        goto PAIf6;
        Tua62:
        exit;
        goto zi45D;
        PAIf6:
        BLU1Z:
        goto uHM2g;
        e3hNn:
        $setting['binddomain'] = $this->module['config']['binddomain'];
        goto SfcxR;
        AFI9n:
        goto I9VUB;
        goto OU9ER;
        sXIfd:
        $close = true;
        goto sfPVm;
        ljQDt:
        message('页面已失效', '', 'error');
        goto h02K8;
        Ztvv5:
        bBBaf:
        goto hOiyv;
        PccSC:
        if (empty($_GPC['statistics'])) {
            goto ccNDp;
        }
        goto KfWZx;
        WqdwS:
        if (!empty($setting['binddomain'])) {
            goto d5PAj;
        }
        goto e3hNn;
        kZl7O:
        FC7qX:
        goto UCpXn;
        Me2sG:
        nL0DF:
        goto SPPZ2;
        OU9ER:
        gNlN3:
        goto hVXQo;
        h02K8:
        goto xOUtq;
        goto xxo4v;
        dvbAl:
        d5PAj:
        goto sXIfd;
        zhQ_U:
        goto POT4n;
        goto k_e9v;
        H23ml:
        cvr_x:
        goto aJq2a;
        OfT8f:
        $host = str_replace('*', $randstr, $host);
        goto Me2sG;
        k_e9v:
        ccNDp:
        goto nnynA;
        MzqXF:
        xOUtq:
        goto zhQ_U;
        kL2kM:
        message('没有获取到活动信息', '', 'error');
        goto bATIv;
        GcdND:
        $host = $setting['binddomain'][array_rand($setting['binddomain'])];
        goto dG6hq;
        a5rsZ:
        if (empty($pathpos)) {
            goto gNlN3;
        }
        goto lfxCa;
        G1EsF:
        POT4n:
        goto kZl7O;
        hRPyE:
        global $_W, $_GPC;
        goto WjTCL;
        hQ_VY:
        Kfxws:
        goto Z_A6z;
        uHM2g:
    }
    protected function setCredit($creditval)
    {
        goto GwDFN;
        CIQWk:
        return error('-1', '积分操作失败！');
        goto krRoo;
        zas0k:
        dgEnm:
        goto Yslan;
        oTkRT:
        if (empty($setting['synccredit'])) {
            goto u0KGN;
        }
        goto Xqc1I;
        b0Cig:
        if ($creditval > 0 || $creditresult >= 0) {
            goto Rpt8T;
        }
        goto EsoMY;
        p0W5O:
        $result = mc_credit_update($uid, 'credit1', $creditval, array(1, $setting['title'] . '活动积分', "xiaof_toupiao"));
        goto F4FYn;
        pPfv3:
        PUXPd:
        goto Xj9xV;
        p1Bre:
        TKA2c:
        goto XKF4V;
        EsoMY:
        return error('-1', '您的积分不够，无法操作。');
        goto wQWow;
        Vsz7r:
        $this->sendCustomNotices(self::getUserinfo('openid'), '您的积分' . $operation . $creditval . '，剩余' . number_format($credit['credit1'], 2));
        goto gS_9O;
        eQZ7C:
        Rpt8T:
        goto DP3LV;
        GtSKz:
        nGL4w:
        goto zas0k;
        V1fqS:
        return true;
        goto fwLJb;
        O_l7Z:
        if (!empty($creditval)) {
            goto PUXPd;
        }
        goto xOG6q;
        Xj9xV:
        if (!($setting = self::getSetting())) {
            goto q9Clh;
        }
        goto oTkRT;
        L7Z5f:
        u0KGN:
        goto Vm4h7;
        rCKo9:
        $operation = $creditval > 0 ? '增加' : '减少';
        goto Vsz7r;
        GwDFN:
        global $_W;
        goto AcUFp;
        F4FYn:
        if (!(!is_error($result) && intval($setting['creditnotice']) >= 1)) {
            goto TKA2c;
        }
        goto boQBV;
        Vm4h7:
        $relationid = self::getUserinfo('relationid');
        goto Jt_EV;
        RGecW:
        ML4d8:
        goto yGSny;
        xlEGb:
        if (empty($unisetting['tplnotice']['credit1']['tpl'])) {
            goto ML4d8;
        }
        goto VJwr1;
        Yslan:
        q9Clh:
        goto CIQWk;
        VPMOj:
        $creditresult = $credit + $creditval;
        goto b0Cig;
        yGSny:
        $credit = mc_credit_fetch($uid);
        goto rCKo9;
        boQBV:
        if (!($_W['account']['level'] >= 3)) {
            goto lhhTT;
        }
        goto tiFkR;
        KPIih:
        goto XKDD_;
        goto RGecW;
        DP3LV:
        if (!pdo_update(self::splittingtable('xiaof_relation'), array("credit" => $creditresult), array("id" => $relationid))) {
            goto mSy_W;
        }
        goto NURjr;
        Jt_EV:
        if (!($credit = $this->getCredit())) {
            goto nGL4w;
        }
        goto VPMOj;
        NURjr:
        if (!(intval($setting['creditnotice']) >= 1 && $_W['account']['level'] >= 3)) {
            goto O4o7w;
        }
        goto e92U9;
        Xqc1I:
        load()->model('mc');
        goto H1F3Z;
        XKF4V:
        return $result;
        goto CI832;
        zpkdj:
        O4o7w:
        goto V1fqS;
        H1F3Z:
        if (!($uid = $this->mcOpenid2uid())) {
            goto d7nJL;
        }
        goto p0W5O;
        tiFkR:
        $unisetting = uni_setting_load();
        goto xlEGb;
        fwLJb:
        mSy_W:
        goto v4VGW;
        CI832:
        d7nJL:
        goto ZaXAo;
        gS_9O:
        XKDD_:
        goto j0JSf;
        wQWow:
        goto MjN4n;
        goto eQZ7C;
        xOG6q:
        return true;
        goto pPfv3;
        v4VGW:
        MjN4n:
        goto GtSKz;
        e92U9:
        $operation = $creditval > 0 ? '增加' : '减少';
        goto pwKKS;
        ZaXAo:
        goto dgEnm;
        goto L7Z5f;
        j0JSf:
        lhhTT:
        goto p1Bre;
        VJwr1:
        mc_notice_credit1(self::getUserinfo('openid'), $uid, $creditval, $setting['title'] . '活动积分变动', '', '谢谢参与');
        goto KPIih;
        AcUFp:
        $creditval = floatval($creditval);
        goto O_l7Z;
        pwKKS:
        $this->sendCustomNotices(self::getUserinfo('openid'), '您的积分' . $operation . $creditval . '，剩余' . number_format($creditresult, 2));
        goto zpkdj;
        krRoo:
    }
    protected function getCredit()
    {
        goto o2zKe;
        S4taS:
        g9IQH:
        goto SYxmW;
        uxBOl:
        return $credit['credit1'];
        goto S4taS;
        n1Z9e:
        if (empty($setting['synccredit'])) {
            goto sYYFL;
        }
        goto tMSSJ;
        chOoz:
        vTVx_:
        goto R5wdv;
        ygRrD:
        if (!($uid = $this->mcOpenid2uid())) {
            goto g9IQH;
        }
        goto cOmKB;
        R5wdv:
        bef0a:
        goto BTKws;
        BTKws:
        qUlhQ:
        goto Ji6jO;
        yAo_I:
        if (!($relationid = self::getUserinfo('relationid'))) {
            goto vTVx_;
        }
        goto gPs55;
        Ji6jO:
        return false;
        goto Efb4A;
        o2zKe:
        if (!($setting = self::getSetting())) {
            goto qUlhQ;
        }
        goto n1Z9e;
        qViTB:
        sYYFL:
        goto yAo_I;
        gPs55:
        return pdo_fetchcolumn('SELECT `credit` FROM ' . tablename(self::splittingtable('xiaof_relation')) . ' WHERE `id` = ' . $relationid);
        goto chOoz;
        tMSSJ:
        load()->model('mc');
        goto ygRrD;
        cOmKB:
        $credit = mc_credit_fetch($uid);
        goto uxBOl;
        SYxmW:
        goto bef0a;
        goto qViTB;
        Efb4A:
    }
    protected function firewall($setting)
    {
        goto hGtXy;
        QbwbK:
        goto EKVW9;
        goto eIkgp;
        bLcRM:
        exit;
        goto kqKD4;
        kqKD4:
        asQrM:
        goto ohJgo;
        vIStq:
        $_SESSION['refresh_times'] += 1;
        goto CrHB3;
        eIkgp:
        ouLlA:
        goto Y3B1d;
        oSjqr:
        $_SESSION['refresh_times'] = 1;
        goto inbz0;
        n0J5q:
        goto Rxj94;
        goto v7YTw;
        NatXI:
        header('HTTP/1.1 301 Moved Permanently');
        goto peWvy;
        inbz0:
        $_SESSION['last_time'] = $cur_time;
        goto aAaez;
        Du8lZ:
        exit;
        goto VfuvS;
        Y3B1d:
        header('HTTP/1.1 301 Moved Permanently');
        goto jZaJx;
        WEv79:
        $record['count'] = 1;
        goto gmqbR;
        hC18d:
        $record['expiration'] = TIMESTAMP;
        goto y9iYq;
        qZCYv:
        goto uev1D;
        goto lWxvw;
        VJitk:
        Uuu6r:
        goto FTa7w;
        y9iYq:
        pdo_insert('xiaof_toupiao_icache', $record);
        goto n0J5q;
        hm14s:
        $_SESSION['refresh_times'] = 0;
        goto X0_xj;
        Bhaq2:
        $record['count'] = $icache['count'] + 1;
        goto qZCYv;
        f5K6B:
        $record['value'] = iserializer($this->ipAddress(CLIENT_IP));
        goto nAVgt;
        uZ5d1:
        empty($_SERVER['HTTP_VIA']) or exit('Access Denied');
        goto VJitk;
        yMlFB:
        $record = array();
        goto j5NL_;
        F6O_z:
        if ($icache['expiration'] <= $outtime) {
            goto BJjRS;
        }
        goto Bhaq2;
        hGtXy:
        if (!empty($setting['disableproxyip'])) {
            goto Uuu6r;
        }
        goto uZ5d1;
        zER0q:
        $record = array();
        goto aUDu3;
        XABZv:
        if ($icache['count'] >= $setting['iprulenum']) {
            goto ouLlA;
        }
        goto yMlFB;
        zHgLB:
        pdo_update('xiaof_toupiao_icache', $record, array("id" => $icache['id']));
        goto QbwbK;
        peWvy:
        header(sprintf('Location:%s', 'http://127.0.0.1'));
        goto bLcRM;
        KTG6A:
        if ($icache = pdo_fetch('SELECT * FROM ' . tablename('xiaof_toupiao_icache') . ' WHERE `id` = :id limit 1', array(":id" => $id))) {
            goto esF7t;
        }
        goto zER0q;
        nAVgt:
        $record['count'] = 1;
        goto hC18d;
        gmqbR:
        $record['expiration'] = TIMESTAMP;
        goto eoo_O;
        eoo_O:
        uev1D:
        goto zHgLB;
        W6Lkg:
        if (isset($_SESSION['last_time'])) {
            goto USEYq;
        }
        goto oSjqr;
        sYt7s:
        USEYq:
        goto vIStq;
        bC3kk:
        goto Z19O6;
        goto VETBc;
        lWxvw:
        BJjRS:
        goto WEv79;
        j5NL_:
        $outtime = TIMESTAMP - $setting['ipruletime'] * 3600;
        goto F6O_z;
        FTa7w:
        $cur_time = time();
        goto W6Lkg;
        aAaez:
        goto W_Hmu;
        goto sYt7s;
        VETBc:
        dTkqi:
        goto iPtQY;
        CrHB3:
        W_Hmu:
        goto J6270;
        aUDu3:
        $record['id'] = $id;
        goto f5K6B;
        v7YTw:
        esF7t:
        goto XABZv;
        iPtQY:
        if (!($_SESSION['refresh_times'] >= $setting['clickrulenum'])) {
            goto asQrM;
        }
        goto NatXI;
        X0_xj:
        $_SESSION['last_time'] = $cur_time;
        goto bC3kk;
        VfuvS:
        EKVW9:
        goto Vo1k_;
        Vo1k_:
        Rxj94:
        goto e3iYN;
        ohJgo:
        Z19O6:
        goto FNLmw;
        J6270:
        if ($cur_time - $_SESSION['last_time'] < $setting['clickruletime']) {
            goto dTkqi;
        }
        goto hm14s;
        FNLmw:
        $id = sprintf('%u', ip2long(CLIENT_IP));
        goto KTG6A;
        jZaJx:
        header(sprintf('Location:%s', 'http://127.0.0.1'));
        goto Du8lZ;
        e3iYN:
    }
    protected static function splittingtable($table)
    {
        goto QMckM;
        QTK8H:
        IHo3x:
        goto pda3v;
        YO1MD:
        HI8Ny:
        goto QTK8H;
        QMckM:
        if (!($setting = self::getSetting())) {
            goto IHo3x;
        }
        goto CDefP;
        Nep2h:
        $table .= '_' . $setting['id'];
        goto YO1MD;
        CDefP:
        if (empty($setting['splittingtable'])) {
            goto HI8Ny;
        }
        goto Nep2h;
        pda3v:
        return $table;
        goto G3zL4;
        G3zL4:
    }
    protected static function setGlobalcookie($name, $value, $expire = 0)
    {
        goto J1vkg;
        IVtZq:
        $domain = parse_url($binddomain, PHP_URL_HOST);
        goto BihGJ;
        IduzP:
        $expire != 0 && ($expire = time() + $expire);
        goto j5qcz;
        j5qcz:
        $binddomain = reset(self::$_setting['binddomain']);
        goto IVtZq;
        y2S91:
        $com = array_pop($domains);
        goto SexAi;
        mwM_A:
        setcookie($name, $value, $expire);
        goto aN8bp;
        aN8bp:
        goto YuA1y;
        goto Otu2t;
        Bys_S:
        setcookie($name, $value, $expire, '/', $newdomain);
        goto MoCMk;
        BihGJ:
        $domains = explode('.', $domain);
        goto y2S91;
        J1vkg:
        if (count(self::$_setting['binddomain']) >= 1) {
            goto ti6qP;
        }
        goto mwM_A;
        j3Brq:
        $newdomain = '.' . $domainname . '.' . $com;
        goto Bys_S;
        Otu2t:
        ti6qP:
        goto IduzP;
        SexAi:
        $domainname = array_pop($domains);
        goto j3Brq;
        MoCMk:
        YuA1y:
        goto Z3uxw;
        Z3uxw:
    }
    protected function getGlobalcookie($name)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : false;
    }
    protected function sendCustomNotices($openid, $data, $acid = null)
    {
        goto a7R3y;
        CuzSP:
        return false;
        goto f1CDr;
        NrSdQ:
        return false;
        goto TBA44;
        ynoxo:
        zjua5:
        goto CuzSP;
        xGWvx:
        $acid = pdo_fetchcolumn('SELECT `acid` FROM ' . tablename('account_wechats') . ' WHERE `uniacid` = ' . $acid);
        goto bW_tM;
        kU2tJ:
        $accObj = WeixinAccount::create($acid);
        goto bOavc;
        a7R3y:
        global $_W;
        goto viGTJ;
        viGTJ:
        is_null($acid) && ($acid = $_W['acid']);
        goto bPwHf;
        bPwHf:
        if (!($_W['account']['level'] >= 3)) {
            goto zjua5;
        }
        goto xGWvx;
        bOavc:
        if (!is_null($accObj)) {
            goto mkfJZ;
        }
        goto NrSdQ;
        E459r:
        return $accObj->sendCustomNotice($custom);
        goto ynoxo;
        bW_tM:
        load()->classs('weixin.account');
        goto kU2tJ;
        TBA44:
        mkfJZ:
        goto KEGNq;
        KEGNq:
        $custom = array("msgtype" => "text", "text" => array("content" => urlencode($data)), "touser" => trim($openid));
        goto E459r;
        f1CDr:
    }

    protected function authenticationName()
    {
        goto Uvqa3;
        GyRRz:
        Oa73Z:
        goto q5dxM;
        kLSZf:
        if (empty($_SERVER['SERVER_ADDR'])) {
            goto T5TAY;
        }
        goto vJGHF;
        JN0sc:
        eSbCa:
        goto Lr7nJ;
        M7DOF:
        $serverip = $_SERVER['SERVER_ADDR'];
        goto immsl;
        immsl:
        UHB5Q:
        goto JN0sc;
        JFgz4:
        T5TAY:
        goto M7DOF;
        taFk0:
        goto eSbCa;
        goto xVNRG;
        vJGHF:
        $serverip = $_SERVER['LOCAL_ADDR'];
        goto oiv6a;
        sFH6x:
        $serverip = @gethostbyname($_SERVER['SERVER_NAME']);
        goto GyRRz;
        bQI_F:
        $serverip = getenv('SERVER_ADDR');
        goto taFk0;
        oiv6a:
        goto UHB5Q;
        goto JFgz4;
        Lr7nJ:
        if (!empty($serverip)) {
            goto Oa73Z;
        }
        goto sFH6x;
        xVNRG:
        Pbq7V:
        goto kLSZf;
        q5dxM:
        return $serverip;
        goto VJAHI;
        Uvqa3:
        if (isset($_SERVER)) {
            goto Pbq7V;
        }
        goto bQI_F;
        VJAHI:
    }
    protected function getTBipaddr($ip)
    {
        goto eYUB2;
        J6kKr:
        $response = ihttp_request('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip, '', array(), '5');
        goto Igaru;
        dH6lS:
        if (!isset($iparr['data']['region'])) {
            goto CPlaj;
        }
        goto xv_d3;
        RWpej:
        return $ipresult;
        goto O5Rwi;
        eYUB2:
        $ipresult = array();
        goto J6kKr;
        xv_d3:
        $ipresult['province'] = $iparr['data']['region'];
        goto WJHSf;
        Igaru:
        $iparr = json_decode($response['content'], true);
        goto dH6lS;
        WJHSf:
        $ipresult['city'] = $iparr['data']['city'];
        goto Pq2EZ;
        Pq2EZ:
        CPlaj:
        goto RWpej;
        O5Rwi:
    }
    protected function getALYipaddr($ip)
    {
        goto NFix8;
        NFix8:
        $ipresult = array();
        goto YSq20;
        aYsz3:
        if (!isset($iparr['data']['region'])) {
            goto lOwAY;
        }
        goto fqQFj;
        YSq20:
        $response = ihttp_request('https://dm-81.data.aliyun.com/rest/160601/ip/getIpInfo.json?ip=' . $ip, '', array("Authorization" => 'APPCODE ' . $this->module['config']['ipappcode']), '5');
        goto KDD5p;
        B2i9g:
        lOwAY:
        goto vYgwP;
        KDD5p:
        $iparr = json_decode($response['content'], true);
        goto aYsz3;
        TOzNk:
        $ipresult['city'] = $iparr['data']['city'];
        goto B2i9g;
        vYgwP:
        return $ipresult;
        goto iu10m;
        fqQFj:
        $ipresult['province'] = $iparr['data']['region'];
        goto TOzNk;
        iu10m:
    }
    protected function getHCipaddr($ip)
    {
        goto jYXP5;
        xnjDq:
        ny7ez:
        goto UX817;
        UX817:
        return $ipresult;
        goto FBjmH;
        eArIj:
        $ipresult['province'] = $iparr['data']['region'];
        goto ieb4V;
        Ew0D6:
        if (!isset($iparr['data']['region'])) {
            goto ny7ez;
        }
        goto eArIj;
        cgtB3:
        $iparr = json_decode($response['content'], true);
        goto Ew0D6;
        AnQ4H:
        $response = ihttp_request('https://api01.aliyun.venuscn.com/ip?ip=' . $ip, '', array("Authorization" => 'APPCODE ' . $this->module['config']['hcipappcode']), '5');
        goto cgtB3;
        jYXP5:
        $ipresult = array();
        goto AnQ4H;
        ieb4V:
        $ipresult['city'] = $iparr['data']['city'];
        goto xnjDq;
        FBjmH:
    }
    protected function getIpaddr($ip)
    {
        goto OVgU4;
        Rg2r3:
        or392:
        goto MC8Et;
        SdPQX:
        if (empty($this->module['config']['hcipappcode'])) {
            goto RKimt;
        }
        goto aJXQU;
        cjdo9:
        R3pxg:
        goto t4GTg;
        Gq4tQ:
        RKimt:
        goto EUtuz;
        EUtuz:
        if (!(!isset($ipresult['province']) && !empty($this->module['config']['ipappcode']))) {
            goto or392;
        }
        goto ve0VG;
        OVgU4:
        load()->func('communication');
        goto SdPQX;
        xeJH2:
        $iparray['city'] = empty($ipresult['city']) ? '未知' : $ipresult['city'];
        goto kpvpJ;
        Nm9hG:
        $iparray['region'] = empty($ipresult['province']) ? '未知' : $ipresult['province'];
        goto xeJH2;
        aJXQU:
        $ipresult = $this->getHCipaddr($ip);
        goto Gq4tQ;
        kpvpJ:
        return $iparray;
        goto VSp13;
        MC8Et:
        if (isset($ipresult['province'])) {
            goto R3pxg;
        }
        goto HWO2O;
        t4GTg:
        $iparray = array();
        goto Nm9hG;
        ve0VG:
        $ipresult = $this->getALYipaddr($ip);
        goto Rg2r3;
        HWO2O:
        $ipresult = $this->getTBipaddr($ip);
        goto cjdo9;
        VSp13:
    }
    protected function ipAddress($ip)
    {
        goto Wyvo3;
        mIe3k:
        goto G6MJ6;
        goto Dg19p;
        uyl_4:
        $this->cacheSet($id, $iparray, 17280000);
        goto GLbg7;
        STMsw:
        goto oBW6U;
        goto W3Gbf;
        E2TAc:
        if ($icache = pdo_fetch('SELECT * FROM ' . tablename('xiaof_toupiao_icache') . ' WHERE `id` = :id limit 1', array(":id" => $id))) {
            goto b9J88;
        }
        goto uFMfY;
        Vlzq0:
        return $iparray;
        goto DgNuW;
        NhC2N:
        oBW6U:
        goto uyl_4;
        XJddl:
        if ($iparray = $this->cacheGet($id)) {
            goto pY3Jk;
        }
        goto E2TAc;
        GLbg7:
        pY3Jk:
        goto mIe3k;
        hHvVE:
        MSOVP:
        goto RCBTG;
        t6q3q:
        pdo_insert('xiaof_toupiao_icache', $record);
        goto STMsw;
        mkn_g:
        pdo_insert('xiaof_toupiao_icache', $record);
        goto MF1tS;
        W3Gbf:
        b9J88:
        goto BDPqw;
        bc99v:
        $record['id'] = $id;
        goto URa0X;
        SjUun:
        $iparray = iunserializer($icache['value']);
        goto hHvVE;
        RCBTG:
        G6MJ6:
        goto Vlzq0;
        j0N5s:
        $record = array();
        goto P3_3j;
        Wyvo3:
        $id = sprintf('%u', ip2long($ip));
        goto k8emN;
        RVvL_:
        $iparray = $this->getIpaddr($ip);
        goto j0N5s;
        Dg19p:
        rmYMG:
        goto FUoGC;
        EMiap:
        $record['expiration'] = TIMESTAMP;
        goto t6q3q;
        uFMfY:
        $iparray = $this->getIpaddr($ip);
        goto ESvk1;
        k8emN:
        if ($this->cachedrive()) {
            goto rmYMG;
        }
        goto XJddl;
        QWBNb:
        R7iwh:
        goto SjUun;
        kxJzN:
        $record['expiration'] = TIMESTAMP;
        goto mkn_g;
        AhBxN:
        $record['value'] = iserializer($iparray);
        goto kxJzN;
        MF1tS:
        goto MSOVP;
        goto QWBNb;
        P3_3j:
        $record['id'] = $id;
        goto AhBxN;
        ESvk1:
        $record = array();
        goto bc99v;
        FUoGC:
        if ($icache = pdo_fetch('SELECT * FROM ' . tablename('xiaof_toupiao_icache') . ' WHERE `id` = :id limit 1', array(":id" => $id))) {
            goto R7iwh;
        }
        goto RVvL_;
        BDPqw:
        $iparray = iunserializer($icache['value']);
        goto NhC2N;
        URa0X:
        $record['value'] = iserializer($iparray);
        goto EMiap;
        DgNuW:
    }
    protected function cachedrive()
    {
        goto vtXBR;
        hj8gm:
        global $_W;
        goto XnGNr;
        wqrEp:
        Wuryz:
        goto hj8gm;
        vtXBR:
        if (!isset($this->cachedrive)) {
            goto Wuryz;
        }
        goto q3UhA;
        q3UhA:
        return $this->cachedrive;
        goto wqrEp;
        XnGNr:
        return $this->cachedrive = $_W['config']['setting']['cache'] == 'mysql' ? true : false;
        goto zsX1Q;
        zsX1Q:
    }
    protected function cacheSet($key, $data, $expiration = 60)
    {
        goto nTyzT;
        YFgAM:
        if ($this->cachedrive()) {
            goto lGfr5;
        }
        goto RQbVi;
        nTyzT:
        if (!(empty($key) || !isset($data))) {
            goto MqqLh;
        }
        goto fKZZr;
        vhOkl:
        $record = array();
        goto WXaH0;
        P8ixU:
        $record['value'] = iserializer($data);
        goto nTQBO;
        PzjBP:
        return cache_write($cachekey, $record);
        goto fG7KU;
        nTQBO:
        $record['expiration'] = time() + $expiration;
        goto YFgAM;
        STgUM:
        MqqLh:
        goto vhOkl;
        fKZZr:
        return false;
        goto STgUM;
        UKnJV:
        lGfr5:
        goto AMEIX;
        rW6uU:
        MEM6C:
        goto JZuAq;
        RQbVi:
        $cachekey = $this->modulename . ':' . $key;
        goto PzjBP;
        AMEIX:
        return pdo_insert($this->modulename . '_cache', $record, true);
        goto rW6uU;
        fG7KU:
        goto MEM6C;
        goto UKnJV;
        WXaH0:
        $record['key'] = $key;
        goto P8ixU;
        JZuAq:
    }
    protected function cacheGet($key)
    {
        goto h7e23;
        WHRJT:
        if (!(time() >= $cache['expiration'])) {
            goto oXMtX;
        }
        goto u1wNX;
        bcBqu:
        if ($cache = cache_read($cachekey)) {
            goto Tkyc0;
        }
        goto F2m13;
        V5kcs:
        if (!isset(self::$_stores[$key])) {
            goto YePjb;
        }
        goto RmOz5;
        F2m13:
        return false;
        goto OhWYx;
        pTaLO:
        YePjb:
        goto ppvh3;
        uMp5B:
        kP6H0:
        goto etzBR;
        eX7vX:
        $cachekey = $this->modulename . ':' . $key;
        goto bcBqu;
        u7DUq:
        return false;
        goto G7Mlt;
        Q223i:
        iHiOY:
        goto V5kcs;
        G7Mlt:
        O82Ye:
        goto e6K1Z;
        OhWYx:
        Tkyc0:
        goto w3LnV;
        VGY2T:
        return false;
        goto Oftmj;
        dcd0A:
        return self::$_stores[$key] = iunserializer($cache['value']);
        goto upvsg;
        w3LnV:
        goto DRQqH;
        goto uMp5B;
        Oftmj:
        oXMtX:
        goto dcd0A;
        ppvh3:
        if ($this->cachedrive()) {
            goto kP6H0;
        }
        goto eX7vX;
        u1wNX:
        $this->cacheDelete($key);
        goto VGY2T;
        e6K1Z:
        DRQqH:
        goto WHRJT;
        etzBR:
        if ($cache = pdo_fetch('SELECT * FROM ' . tablename($this->modulename . '_cache') . ' WHERE `key` = :key', array(":key" => $key))) {
            goto O82Ye;
        }
        goto u7DUq;
        h7e23:
        if (!empty($key)) {
            goto iHiOY;
        }
        goto Gfhvv;
        RmOz5:
        return self::$_stores[$key];
        goto pTaLO;
        Gfhvv:
        return false;
        goto Q223i;
        upvsg:
    }
    protected function cacheDelete($key)
    {
        goto ZqMSS;
        rQyBP:
        T4Gfc:
        goto CO2zA;
        eXuXb:
        goto T4Gfc;
        goto GlShg;
        GlShg:
        ioMt5:
        goto V0QB2;
        ZqMSS:
        if ($this->cachedrive()) {
            goto ioMt5;
        }
        goto tOPY2;
        tOPY2:
        return cache_delete($key);
        goto eXuXb;
        V0QB2:
        return pdo_delete($this->modulename . '_cache', array("key" => $key));
        goto rQyBP;
        CO2zA:
    }
    protected function cacheClean()
    {
        goto NtCoT;
        O7Nbz:
        return pdo_query('DELETE FROM ' . tablename($this->modulename . '_cache'));
        goto KAm3S;
        NtGl2:
        goto bl4Sz;
        goto M1wni;
        KAm3S:
        bl4Sz:
        goto Xndf9;
        NtCoT:
        if ($this->cachedrive()) {
            goto veWkW;
        }
        goto zQyqE;
        zQyqE:
        return cache_clean($this->modulename);
        goto NtGl2;
        M1wni:
        veWkW:
        goto O7Nbz;
        Xndf9:
    }
    protected function isGvingtype($type)
    {
        goto GQUlz;
        tqEQc:
        if (!in_array($type, self::$_setting['getgivingtype'])) {
            goto T6YN0;
        }
        goto vsfgF;
        vsfgF:
        return true;
        goto L7KXX;
        L7KXX:
        T6YN0:
        goto GaQvZ;
        uJc3f:
        return false;
        goto FzDXF;
        GQUlz:
        if (!in_array(self::$_setting['getgivingtype'])) {
            goto XYaFS;
        }
        goto tqEQc;
        GaQvZ:
        XYaFS:
        goto uJc3f;
        FzDXF:
    }
    protected function ajaxMessage($errno, $message)
    {
        goto AHMhC;
        zF9jB:
        echo json_encode($result);
        goto DwaiV;
        wKiyi:
        goto MgNFk;
        goto uB4cJ;
        Xuhpr:
        $result = array_merge($result, $message);
        goto TKEoa;
        uB4cJ:
        rsQeL:
        goto Xuhpr;
        AHMhC:
        $result = array("errno" => $errno);
        goto M_CCn;
        BBfGx:
        $result['message'] = $message;
        goto wKiyi;
        DwaiV:
        exit;
        goto VcGSV;
        M_CCn:
        if (is_array($message)) {
            goto rsQeL;
        }
        goto BBfGx;
        TKEoa:
        MgNFk:
        goto zF9jB;
        VcGSV:
    }
    protected function getGivingvalue($pid)
    {
        goto fn4Ka;
        vgoTy:
        gGjeg:
        goto xSdCD;
        xSdCD:
        return $givingvalue;
        goto d6J6N;
        iKP1B:
        $this->cacheSet('givingvotes' . $pid, $givingvalue, 3);
        goto vgoTy;
        tCHhp:
        $givingvalue = empty($givingvalue) ? 0 : $givingvalue;
        goto iKP1B;
        fn4Ka:
        $givingvalue = $this->cacheGet('givingvotes' . $pid);
        goto B8CyI;
        XY1kZ:
        $givingvalue = pdo_fetchcolumn('SELECT SUM(actual_num) FROM ' . tablename('xiaof_toupiao_giving') . ' WHERE `pid` = \'' . $pid . '\'');
        goto tCHhp;
        B8CyI:
        if (!(!$givingvalue && $givingvalue !== 0)) {
            goto gGjeg;
        }
        goto XY1kZ;
        d6J6N:
    }
    protected function getAllsetting($uniacid = null)
    {
        goto e263T;
        mD3hQ:
        x9mA8:
        goto gDoFj;
        e263T:
        if (!empty($uniacid)) {
            goto x9mA8;
        }
        goto TafHw;
        gDoFj:
        return pdo_fetchall('SELECT * FROM ' . tablename('xiaof_toupiao_setting') . ' WHERE `uniacid` = :uniacid ORDER BY `created_at` DESC', array(":uniacid" => $uniacid));
        goto ivHqh;
        TafHw:
        global $_W;
        goto Hpb9u;
        Hpb9u:
        $uniacid = intval($_W['uniacid']);
        goto mD3hQ;
        ivHqh:
    }
    public static function get_sign($params = array(), $key = "")
    {
        goto aCeAh;
        no2Wk:
        $str = http_build_query($params);
        goto ltmCe;
        ltmCe:
        $str .= '&key=' . $key;
        goto snFih;
        aCeAh:
        ksort($params);
        goto no2Wk;
        snFih:
        return sha1($str);
        goto KV7Us;
        KV7Us:
    }
    protected function template($filename)
    {
        goto l3_uv;
        RfErX:
        $source = IA_ROOT . "/app/themes/default/{$filename}.html";
        goto UVjM_;
        KfIdY:
        $source = IA_ROOT . "/web/themes/{$_W['template']}/{$filename}.html";
        goto wNsFh;
        n1J09:
        Y0vGY:
        goto AWduq;
        wUUgB:
        J6G2O:
        goto Z7wEv;
        d4bCj:
        $source = IA_ROOT . "/app/themes/default/common/{$filename}.html";
        goto S4gBZ;
        joWLy:
        $source = $defineDir . "/template/wxapp/{$filename}.html";
        goto nvAnL;
        za98w:
        $compile = str_replace($paths['filename'], $_W['uniacid'] . '_' . $sid . '_' . $paths['filename'], $compile);
        goto c87D0;
        fDZrW:
        $source = IA_ROOT . "/web/themes/default/{$name}/{$filename}.html";
        goto wUUgB;
        idxIR:
        $source = IA_ROOT . "/web/themes/default/{$filename}.html";
        goto K0o7C;
        Vh6mU:
        $compile = IA_ROOT . "/data/tpl/web/{$_W['template']}/{$name}/{$filename}.tpl.php";
        goto umMUT;
        cSaC0:
        ighI0:
        goto nmNFd;
        bd6mW:
        $filename = "themes/w{$key}/sid{$sid}/{$arr[1]}";
        goto m5tRQ;
        fDE2S:
        if (is_file($source)) {
            goto XhDnd;
        }
        goto q8bGB;
        n3Cum:
        GFHph:
        goto JUlPt;
        nGTek:
        if (!file_exists($path)) {
            goto hIduJ;
        }
        goto bd6mW;
        nmNFd:
        Je2yd:
        goto hWQT4;
        hWQT4:
        $source = $defineDir . "/template/mobile/{$filename}.html";
        goto RvjWY;
        qVICe:
        $key = intval($_W['setting']['site']['key']);
        goto Jws12;
        Z7wEv:
        if (is_file($source)) {
            goto Y0vGY;
        }
        goto sTeYq;
        vme3x:
        goto m_1ga;
        goto Q1JbJ;
        xOCv2:
        $defineDir = dirname($this->__define);
        goto hVBap;
        TJ23S:
        lq92n:
        goto fDE2S;
        Jws12:
        $sid = intval($_GPC['sid']);
        goto eCgqx;
        sTeYq:
        $source = $defineDir . "/template/{$filename}.html";
        goto n1J09;
        LS62k:
        f4uIA:
        goto d4bCj;
        UVjM_:
        goto Vr2RM;
        goto LS62k;
        XAvmx:
        oPYvq:
        goto vme3x;
        j1qvg:
        $path = IA_ROOT . "/addons/xiaof_toupiao/template/mobile/themes/w{$key}/sid{$sid}/{$arr[1]}.html";
        goto nGTek;
        fmpFV:
        $name = strtolower($this->modulename);
        goto xOCv2;
        xHT7k:
        s9CnD:
        goto m7ZwN;
        VRLv1:
        if (is_file($source)) {
            goto F3Zgi;
        }
        goto EZdqM;
        S4gBZ:
        Vr2RM:
        goto XAvmx;
        FJ4tO:
        $source = IA_ROOT . "/app/themes/{$_W['template']}/{$name}/{$filename}.html";
        goto TQpoy;
        euBIh:
        template_compile($source, $compile, true);
        goto n3Cum;
        m7ZwN:
        $paths = pathinfo($compile);
        goto MmZ_0;
        c87D0:
        kTaOI:
        goto Geu7K;
        Geu7K:
        if (!(DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile))) {
            goto GFHph;
        }
        goto euBIh;
        q8bGB:
        if (!is_dir(IA_ROOT . '/addons/xiaof_toupiao/template/mobile/themes/')) {
            goto Je2yd;
        }
        goto qVICe;
        hVBap:
        if (defined('IN_SYS')) {
            goto rez7E;
        }
        goto FJ4tO;
        ZvFjV:
        if (in_array($filename, array("header", "footer", "slide", "toolbar", "message"))) {
            goto f4uIA;
        }
        goto RfErX;
        AWduq:
        if (is_file($source)) {
            goto rnLBV;
        }
        goto KfIdY;
        f4fWs:
        if (is_file($source)) {
            goto AQzLf;
        }
        goto idxIR;
        h0jAs:
        m_1ga:
        goto eP5oR;
        zSACl:
        F3Zgi:
        goto Ktw95;
        yPVIV:
        $source = IA_ROOT . "/web/themes/{$_W['template']}/{$name}/{$filename}.html";
        goto Vh6mU;
        TQpoy:
        $compile = IA_ROOT . "/data/tpl/app/{$_W['template']}/{$name}/{$filename}.tpl.php";
        goto tcPri;
        WXdBv:
        $arr = explode('/', $filename);
        goto j1qvg;
        wNsFh:
        rnLBV:
        goto f4fWs;
        k83JC:
        $source = IA_ROOT . "/app/themes/default/{$name}/{$filename}.html";
        goto TJ23S;
        Q1JbJ:
        rez7E:
        goto yPVIV;
        umMUT:
        if (is_file($source)) {
            goto J6G2O;
        }
        goto fDZrW;
        K5frN:
        Kl8ij:
        goto za98w;
        l3_uv:
        global $_W, $_GPC;
        goto fmpFV;
        JUlPt:
        return $compile;
        goto sIXKF;
        shZSY:
        if (is_file($source)) {
            goto oPYvq;
        }
        goto ZvFjV;
        Ktw95:
        if (is_file($source)) {
            goto SySgC;
        }
        goto xnV9O;
        K0o7C:
        AQzLf:
        goto h0jAs;
        EZdqM:
        $source = $defineDir . "/template/webapp/{$filename}.html";
        goto zSACl;
        zFUFO:
        $compile = str_replace($paths['filename'], $_W['uniacid'] . '_' . $paths['filename'], $compile);
        goto YR_L9;
        eiWrt:
        SySgC:
        goto shZSY;
        nvAnL:
        meDWq:
        goto VRLv1;
        MmZ_0:
        if (isset($sid)) {
            goto Kl8ij;
        }
        goto zFUFO;
        eP5oR:
        if (is_file($source)) {
            goto s9CnD;
        }
        goto Z7WX5;
        xnV9O:
        $source = IA_ROOT . "/app/themes/{$_W['template']}/{$filename}.html";
        goto eiWrt;
        YR_L9:
        goto kTaOI;
        goto K5frN;
        eCgqx:
        if (!($key && $sid)) {
            goto ighI0;
        }
        goto WXdBv;
        RvjWY:
        XhDnd:
        goto bDo_6;
        m5tRQ:
        hIduJ:
        goto cSaC0;
        bDo_6:
        if (is_file($source)) {
            goto meDWq;
        }
        goto joWLy;
        tcPri:
        if (is_file($source)) {
            goto lq92n;
        }
        goto k83JC;
        Z7WX5:
        exit("Error: template source '{$filename}' is not exist!");
        goto xHT7k;
        sIXKF:
    }
    public function _update_menu_displayorder()
    {
        goto iignO;
        FA56y:
        if (!(!empty($list) && $list['0']['displayorder'] != 999)) {
            goto OnY5q;
        }
        goto LLqz0;
        iignO:
        $list = pdo_getall('modules_bindings', array("module" => "xiaof_toupiao"), '', '', 'displayorder DESC');
        goto FA56y;
        TSFhU:
        OnY5q:
        goto mETW_;
        LLqz0:
        foreach ($list as $li) {
            goto FUhZv;
            hPZaK:
            switch ($li['do']) {
                case 'settinglists':
                    $displayorder = 999;
                    goto uQuUd;
                case 'lists':
                    $displayorder = 90;
                    goto uQuUd;
                case 'settingedit':
                    $displayorder = 89;
                    goto uQuUd;
                case 'edit':
                    $displayorder = 88;
                    goto uQuUd;
                case 'batchregister':
                    $displayorder = 87;
                    goto uQuUd;
                case 'votelog':
                    $displayorder = 85;
                    goto uQuUd;
                case 'sharelog':
                    $displayorder = 85;
                    goto uQuUd;
                case 'paylog':
                    $displayorder = 80;
                    goto uQuUd;
                case 'safe':
                    $displayorder = 75;
                    goto uQuUd;
                case 'charts':
                    $displayorder = 70;
                    goto uQuUd;
                case 'drawlists':
                    $displayorder = 65;
                    goto uQuUd;
                case 'givinglog':
                    $displayorder = 60;
                    goto uQuUd;
                case 'reportlog':
                    $displayorder = 58;
                    goto uQuUd;
                case 'getunionid':
                    $displayorder = 50;
                    goto uQuUd;
                case 'tool':
                    $displayorder = 40;
                    goto uQuUd;
                case 'ua':
                    $displayorder = 38;
                    goto uQuUd;
                case 'systemtool':
                    $displayorder = 35;
                    goto uQuUd;
            }
            goto r3c8Q;
            FUhZv:
            $displayorder = 0;
            goto hPZaK;
            r3c8Q:
            d6Y2b:
            goto RgKtw;
            ReAEz:
            I8ZF5:
            goto LRouC;
            x_hRA:
            pdo_update('modules_bindings', array("displayorder" => $displayorder), array("eid" => $li['eid']));
            goto ReAEz;
            RgKtw:
            uQuUd:
            goto x_hRA;
            LRouC:
        }
        goto Y9hJM;
        Y9hJM:
        v7TtE:
        goto TSFhU;
        mETW_:
    }
    protected function _widgets_default_data()
    {
        $widget = array("0" => array("type" => "qrcode", "top" => "442px", "left" => "231px", "width" => 83, "height" => 83, "color" => "#333333", "fontsize" => "14px", "imgpath" => ""), "1" => array("type" => "playerno", "top" => "433px", "left" => "51px", "width" => "", "height" => "", "color" => "#3d4145", "fontsize" => "16px", "imgpath" => ""), "2" => array("type" => "image", "top" => "211px", "left" => "110px", "width" => 154, "height" => 169, "color" => "#333333", "fontsize" => "14px", "imgpath" => ""), "3" => array("type" => "nickname", "top" => "151px", "left" => "267px", "width" => "", "height" => "", "color" => "#3d4145", "fontsize" => "16px", "imgpath" => ""), "4" => array("type" => "share", "top" => "593px", "left" => "111px", "width" => "", "height" => "", "color" => "#3d4145", "fontsize" => "16px", "imgpath" => ""));
        return $widget;
    }
    private function _set_resource()
    {
        goto ne002;
        ISDMx:
        $this->superman_main_js = '<script src="' . MODULE_URL . 'min/index.php?g=main-js&debug=1&' . $_version . '"></script>';
        goto lr520;
        Vuo6m:
        $this->superman_global_js = '<script src="' . MODULE_URL . 'min/index.php?g=global-js&debug=1&' . $_version . '" charset="utf-8"></script>';
        goto ISDMx;
        U8QBQ:
        $this->superman_main_js = '<script src="' . MODULE_URL . 'min/index.php?g=main-js&' . $_version . '"></script>';
        goto BAUJU;
        zIGPw:
        goto UOYTk;
        goto aqeL2;
        oFSZs:
        y11tA:
        goto zIGPw;
        K6uRs:
        $this->superman_global_js = '<script src="' . MODULE_URL . 'min/index.php?g=global-js&debug=1&' . $_version . '" charset="utf-8"></script>';
        goto U8QBQ;
        qtVQu:
        if (defined('LOCAL_DEVELOPMENT') && !SupermanToupiaoUtil::is_we7_encrypt(MODULE_ROOT . '/site.php')) {
            goto WGJde;
        }
        goto FL2XU;
        ne002:
        $_version = str_replace('.', '', $this->module['version']);
        goto qtVQu;
        FL2XU:
        if (file_exists(MODULE_ROOT . '/template/mobile/cache/css.css') && !file_exists(IA_ROOT . '/online-dev.lock')) {
            goto a4fF8;
        }
        goto VBu3R;
        izb7A:
        a4fF8:
        goto pyxXi;
        pyxXi:
        $this->superman_css = '<link rel="stylesheet" href="' . MODULE_URL . '/template/mobile/cache/css.css?' . $_version . '">';
        goto wYBgt;
        aqeL2:
        WGJde:
        goto i0Ifd;
        VBu3R:
        $this->superman_css = '<link rel="stylesheet" href="' . MODULE_URL . 'min/index.php?g=css&' . $_version . '">';
        goto K6uRs;
        OOSzs:
        $this->superman_main_js = '<script src="' . MODULE_URL . 'template/mobile/cache/main.js?' . $_version . '"></script>';
        goto oFSZs;
        lr520:
        UOYTk:
        goto rA02B;
        BAUJU:
        goto y11tA;
        goto izb7A;
        wYBgt:
        $this->superman_global_js = '<script src="' . MODULE_URL . '/template/mobile/cache/global.js?' . $_version . '" charset="utf-8"></script>';
        goto OOSzs;
        i0Ifd:
        $this->superman_css = '<link rel="stylesheet" href="' . MODULE_URL . 'min/index.php?g=css&debug=1&' . $_version . '">';
        goto Vuo6m;
        rA02B:
    }
}