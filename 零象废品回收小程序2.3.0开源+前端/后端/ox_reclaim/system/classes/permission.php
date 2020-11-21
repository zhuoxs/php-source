<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/25
 * Time: 15:52
 */
class Permission
{
    public static  $instance;
    public static  function Instance(){
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    static public $allPerms = array();
    static public $getLogTypes = array();
    static public $formatPerms = array();
    public function allPerms()
    {
        if (empty(self::$allPerms))
        {
            $perms = include_once IA_ROOT . '/addons/'.MODEL_NAME.'/config/permission.php';
            self::$allPerms = $perms;
        }
        return self::$allPerms;
    }
    public function check_edit($permtype = '', $item = array())
    {
        if (empty($permtype))
        {
            return false;
        }
        if (!($this->check_perm($permtype)))
        {
            return false;
        }
        if (empty($item['id']))
        {
            $add_perm = $permtype . '.add';
            if (!($this->check($add_perm)))
            {
                return false;
            }
            return true;
        }
        $edit_perm = $permtype . '.edit';
        if (!($this->check($edit_perm)))
        {
            return false;
        }
        return true;
    }
    public function check_perm($permtypes = '') {
        global $_W;
        $check = true;
        if (empty($permtypes)) {
            return false;
        }
        if (!strexists($permtypes, '&') && !strexists($permtypes, '|')) {
            $check = $this->check($permtypes);
        } else if (strexists($permtypes, '&')) {
            $pts = explode('&', $permtypes);
            foreach ($pts as $pt) {
                $check = $this->check($pt);
                if ($check) {
                    continue;
                }
                break;
            }
        } else if (strexists($permtypes, '|')) {
            $pts = explode('|', $permtypes);
            foreach ($pts as $pt) {
                $check = $this->check($pt);
                if (!($check)) {
                    continue;
                }
                break;
            }
        }
        return $check;
    }
    private function check($permtype = '')
    {
        global $_W;
        global $_GPC;
        if (($_W['role'] == 'manager') || ($_W['role'] == 'founder') || ($_W['role'] == 'owner'))
        {
            return true;
        }
        $uid = $_W['uid'];
        if (empty($permtype))
        {
            return false;
        }
        $user = pdo_fetch('select u.status as userstatus,r.status as rolestatus,u.perms2 as userperms,r.perms2 as roleperms,u.roleid from ' . tablename(MODEL_NAME.'_perm_user') . ' u ' . ' left join ' . tablename(MODEL_NAME.'_perm_role') . ' r on u.roleid = r.id ' . ' where u.uid=:uid limit 1 ', array(':uid' => $uid));
        if (empty($user) || empty($user['userstatus']))
        {
            return false;
        }
        if (!(empty($user['roleid'])) && empty($user['rolestatus']))
        {
            return false;
        }
        $role_perms = explode(',', $user['roleperms']);
        $user_perms = explode(',', $user['userperms']);
        $perms = array_merge($role_perms, $user_perms);
        if (empty($perms))
        {
            return false;
        }
        $is_xxx = $this->check_xxx($permtype);
        if ($is_xxx)
        {
            if (!(in_array($is_xxx, $perms)))
            {
                return false;
            }
        }
        else if (!(in_array($permtype, $perms)))
        {
            return false;
        }
        return true;
    }
    public function check_xxx($permtype)
    {
        if ($permtype)
        {
            $allPerm = $this->allPerms();
            $permarr = explode('.', $permtype);
            if (isset($permarr[3]))
            {
                $is_xxx = ((isset($allPerm[$permarr[0]][$permarr[1]][$permarr[2]]['xxx'][$permarr[3]]) ? $allPerm[$permarr[0]][$permarr[1]][$permarr[2]]['xxx'][$permarr[3]] : false));
            }
            else if (isset($permarr[2]))
            {
                $is_xxx = ((isset($allPerm[$permarr[0]][$permarr[1]]['xxx'][$permarr[2]]) ? $allPerm[$permarr[0]][$permarr[1]]['xxx'][$permarr[2]] : false));
            }
            else if (isset($permarr[1]))
            {
                $is_xxx = ((isset($allPerm[$permarr[0]]['xxx'][$permarr[1]]) ? $allPerm[$permarr[0]]['xxx'][$permarr[1]] : false));
            }
            else
            {
                $is_xxx = false;
            }
            if ($is_xxx)
            {
                $permarr = explode('.', $permtype);
                array_pop($permarr);
                $is_xxx = implode('.', $permarr) . '.' . $is_xxx;
            }
            return $is_xxx;
        }
        return false;
    }
    public function check_com($comname = '')
    {
        global $_W;
        global $_GPC;
        $permset = $this->getPermset();
        if (empty($permset))
        {
            return true;
        }
        if (($_W['role'] == 'founder') || empty($_W['role']))
        {
            return true;
        }
        $isopen = $this->isopen($comname, true);
        if (!($isopen))
        {
            return false;
        }
        $allow = true;
        $acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
        if (!($allow))
        {
            return false;
        }
        return true;
    }
    public function getLogName($type = '', $logtypes = NULL)
    {
        if (!($logtypes))
        {
            $logtypes = $this->getLogTypes();
        }
        foreach ($logtypes as $t )
        {
            while ($t['value'] == $type)
            {
                return $t['text'];
            }
        }
        return '';
    }
    public function getLogTypes($all = false)
    {
        if (empty(self::$getLogTypes))
        {
            $perms = $this->allPerms();
            $array = array();
            foreach ($perms as $key => $value )
            {
                if (is_array($value))
                {
                    foreach ($value as $ke => $val )
                    {
                        if (!(is_array($val)))
                        {
                            if ($all)
                            {
                                if ($ke == 'text')
                                {
                                    $text = str_replace('-log', '', $value['text']);
                                }
                                else
                                {
                                    $text = str_replace('-log', '', $value['text'] . '-' . $val);
                                }
                                $array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke));
                            }
                            else if (strexists($val, '-log'))
                            {
                                $text = str_replace('-log', '', $value['text'] . '-' . $val);
                                if ($ke == 'text')
                                {
                                    $text = str_replace('-log', '', $value['text']);
                                }
                                $array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke));
                            }
                        }
                        if (is_array($val) && ($ke != 'xxx'))
                        {
                            foreach ($val as $k => $v )
                            {
                                if (!(is_array($v)))
                                {
                                    if ($all)
                                    {
                                        if ($ke == 'text')
                                        {
                                            $text = str_replace('-log', '', $value['text'] . '-' . $val['text']);
                                        }
                                        else
                                        {
                                            $text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v);
                                        }
                                        $array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke . '.' . $k));
                                    }
                                    else if (strexists($v, '-log'))
                                    {
                                        $text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v);
                                        if ($k == 'text')
                                        {
                                            $text = str_replace('-log', '', $value['text'] . '-' . $val['text']);
                                        }
                                        $array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke . '.' . $k));
                                    }
                                }
                                if (is_array($v) && ($k != 'xxx'))
                                {
                                    foreach ($v as $kk => $vv )
                                    {
                                        if (!(is_array($vv)))
                                        {
                                            if ($all)
                                            {
                                                if ($ke == 'text')
                                                {
                                                    $text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v['text']);
                                                }
                                                else
                                                {
                                                    $text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v['text'] . '-' . $vv);
                                                }
                                                $array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke . '.' . $k . '.' . $kk));
                                            }
                                            else if (strexists($vv, '-log'))
                                            {
                                                if (empty($val['text']))
                                                {
                                                    $text = str_replace('-log', '', $value['text'] . '-' . $v['text'] . '-' . $vv);
                                                }
                                                else
                                                {
                                                    $text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v['text'] . '-' . $vv);
                                                }
                                                if ($kk == 'text')
                                                {
                                                    $text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v['text']);
                                                }
                                                $array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke . '.' . $k . '.' . $kk));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            self::$getLogTypes = $array;
        }
        return self::$getLogTypes;
    }
    public function formatPerms()
    {
        if (empty(self::$formatPerms))
        {
            $perms = $this->allPerms();
            $array = array();
            foreach ($perms as $key => $value )
            {
                if (is_array($value))
                {
                    foreach ($value as $ke => $val )
                    {
                        if (!(is_array($val)))
                        {
                            $array['parent'][$key][$ke] = $val;
                        }
                        if (is_array($val) && ($ke != 'xxx'))
                        {
                            foreach ($val as $k => $v )
                            {
                                if (!(is_array($v)))
                                {
                                    $array['son'][$key][$ke][$k] = $v;
                                }
                                if (is_array($v) && ($k != 'xxx'))
                                {
                                    foreach ($v as $kk => $vv )
                                    {
                                        if (!(is_array($vv)))
                                        {
                                            $array['grandson'][$key][$ke][$k][$kk] = $vv;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            self::$formatPerms = $array;
        }
        return self::$formatPerms;
    }
}