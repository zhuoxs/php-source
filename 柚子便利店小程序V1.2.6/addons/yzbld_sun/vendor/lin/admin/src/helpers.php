<?php
use Illuminate\Support\Arr;

function old($key, $default)
{
    return \Encore\Admin\Session::getOldInput($key, $default);
}
function csrf_token()
{
    return \Encore\Admin\Str::random(40);
}
function trans($name)
{
    $name = substr($name,6);
    $lang =  [
        'online'                => '在线',
        'login'                 => '登录',
        'logout'                => '登出',
        'setting'               => '设置',
        'name'                  => '名称',
        'username'              => '用户名',
        'password'              => '密码',
        'password_confirmation' => '确认密码',
        'remember_me'           => '记住我',
        'user_setting'          => '用户设置',
        'avatar'                => '头像',

        'list'         => '列表',
        'new'          => '新增',
        'create'       => '创建',
        'delete'       => '删除',
        'remove'       => '移除',
        'edit'         => '编辑',
        'view'         => '查看',
        'browse'       => '浏览',
        'reset'        => '撤销',
        'export'       => '导出',
        'batch_delete' => '批量删除',
        'save'         => '保存',
        'refresh'      => '刷新',
        'order'        => '排序',
        'expand'       => '展开',
        'collapse'     => '收起',
        'filter'       => '筛选',
        'close'        => '关闭',
        'show'         => '显示',
        'entries'      => '条',
        'captcha'      => '验证码',

        'action'            => '操作',
        'title'             => '标题',
        'description'       => '简介',
        'back'              => '返回',
        'back_to_list'      => '返回列表',
        'submit'            => '提交',
        'menu'              => '菜单',
        'input'             => '输入',
        'succeeded'         => '成功',
        'failed'            => '失败',
        'delete_confirm'    => '确认删除?',
        'delete_succeeded'  => '删除成功 !',
        'delete_failed'     => '删除失败 !',
        'update_succeeded'  => '更新成功 !',
        'save_succeeded'    => '保存成功 !',
        'refresh_succeeded' => '刷新成功 !',
        'login_successful'  => '登录成功 !',

        'choose'       => '选择',
        'choose_file'  => '选择文件',
        'choose_image' => '选择图片',

        'more' => '更多',
        'deny' => '无权访问',

        'administrator' => '管理员',
        'roles'         => '角色',
        'permissions'   => '权限',
        'slug'          => '标识',

        'created_at' => '创建时间',
        'updated_at' => '更新时间',

        'alert' => '注意',

        'parent_id' => '父级菜单',
        'icon'      => '图标',
        'uri'       => '路径',

        'operation_log'       => '操作日志',
        'parent_select_error' => '父级选择错误',

        'pagination' => [
            'range' => '从 :first 到 :last ，总共 :total 条',
        ],

        'role'       => '角色',
        'permission' => '权限',
        'route'      => '路由',
        'confirm'    => '确认',
        'cancel'     => '取消',

        'http' => [
            'method' => 'HTTP方法',
            'path'   => 'HTTP路径',
        ],
        'all_methods_if_empty' => '为空默认为所有方法',

        'all'           => '全部',
        'current_page'  => '当前页',
        'selected_rows' => '选择的行',

        'upload'     => '上传',
        'new_folder' => '新建文件夹',
        'time'       => '时间',
        'size'       => '大小',

        'listbox' => [
            'text_total'         => '总共 {0} 项',
            'text_empty'         => '空列表',
            'filtered'           => '{0} / {1}',
            'filter_clear'       => '显示全部',
            'filter_placeholder' => '过滤',
        ],
    ];

    return $lang[$name];
}

if (! function_exists('array_add')) {
    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $value
     * @return array
     */
    function array_add($array, $key, $value)
    {
        return Arr::add($array, $key, $value);
    }
}

if (! function_exists('array_collapse')) {
    /**
     * Collapse an array of arrays into a single array.
     *
     * @param  array  $array
     * @return array
     */
    function array_collapse($array)
    {
        return Arr::collapse($array);
    }
}

if (! function_exists('array_divide')) {
    /**
     * Divide an array into two arrays. One with keys and the other with values.
     *
     * @param  array  $array
     * @return array
     */
    function array_divide($array)
    {
        return Arr::divide($array);
    }
}

if (! function_exists('array_dot')) {
    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param  array   $array
     * @param  string  $prepend
     * @return array
     */
    function array_dot($array, $prepend = '')
    {
        return Arr::dot($array, $prepend);
    }
}

if (! function_exists('array_except')) {
    /**
     * Get all of the given array except for a specified array of items.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    function array_except($array, $keys)
    {
        return Arr::except($array, $keys);
    }
}

if (! function_exists('array_first')) {
    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param  array  $array
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    function array_first($array, callable $callback = null, $default = null)
    {
        return Arr::first($array, $callback, $default);
    }
}

if (! function_exists('array_flatten')) {
    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param  array  $array
     * @param  int  $depth
     * @return array
     */
    function array_flatten($array, $depth = INF)
    {
        return Arr::flatten($array, $depth);
    }
}

if (! function_exists('array_forget')) {
    /**
     * Remove one or many array items from a given array using "dot" notation.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return void
     */
    function array_forget(&$array, $keys)
    {
        return Arr::forget($array, $keys);
    }
}

if (! function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        return Arr::get($array, $key, $default);
    }
}

if (! function_exists('array_has')) {
    /**
     * Check if an item or items exist in an array using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|array  $keys
     * @return bool
     */
    function array_has($array, $keys)
    {
        return Arr::has($array, $keys);
    }
}

if (! function_exists('array_last')) {
    /**
     * Return the last element in an array passing a given truth test.
     *
     * @param  array  $array
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    function array_last($array, callable $callback = null, $default = null)
    {
        return Arr::last($array, $callback, $default);
    }
}

if (! function_exists('array_only')) {
    /**
     * Get a subset of the items from the given array.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    function array_only($array, $keys)
    {
        return Arr::only($array, $keys);
    }
}

if (! function_exists('array_pluck')) {
    /**
     * Pluck an array of values from an array.
     *
     * @param  array   $array
     * @param  string|array  $value
     * @param  string|array|null  $key
     * @return array
     */
    function array_pluck($array, $value, $key = null)
    {
        return Arr::pluck($array, $value, $key);
    }
}

if (! function_exists('array_prepend')) {
    /**
     * Push an item onto the beginning of an array.
     *
     * @param  array  $array
     * @param  mixed  $value
     * @param  mixed  $key
     * @return array
     */
    function array_prepend($array, $value, $key = null)
    {
        return Arr::prepend($array, $value, $key);
    }
}

if (! function_exists('array_pull')) {
    /**
     * Get a value from the array, and remove it.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function array_pull(&$array, $key, $default = null)
    {
        return Arr::pull($array, $key, $default);
    }
}

if (! function_exists('array_set')) {
    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $value
     * @return array
     */
    function array_set(&$array, $key, $value)
    {
        return Arr::set($array, $key, $value);
    }
}

if (! function_exists('array_sort')) {
    /**
     * Sort the array using the given callback.
     *
     * @param  array  $array
     * @param  callable  $callback
     * @return array
     */
    function array_sort($array, callable $callback)
    {
        return Arr::sort($array, $callback);
    }
}

if (! function_exists('array_sort_recursive')) {
    /**
     * Recursively sort an array by keys and values.
     *
     * @param  array  $array
     * @return array
     */
    function array_sort_recursive($array)
    {
        return Arr::sortRecursive($array);
    }
}

if (! function_exists('array_where')) {
    /**
     * Filter the array using the given callback.
     *
     * @param  array  $array
     * @param  callable  $callback
     * @return array
     */
    function array_where($array, callable $callback)
    {
        return Arr::where($array, $callback);
    }
}

if (!function_exists('admin_toastr')) {

    /**
     * Flash a toastr message bag to session.
     *
     * @param string $message
     * @param string $type
     * @param array  $options
     *
     * @return string
     */
    function admin_toastr($message = '', $type = 'success', $options = [])
    {
        $toastr = [
            "message"=>$message,
            "type"=>$type,
            "option" =>$options
        ];
        \Encore\Admin\Session::flash('toastr', $toastr);
    }
}

/**
 * 单词单数转成复数
 * @param $string  单词单数
 */
function pluralize( $string )   {
    $plural = array(
        array( '/(quiz)$/i',              "$1zes"   ),
        array( '/^(ox)$/i',               "$1en"    ),
        array( '/([m|l])ouse$/i',         "$1ice"   ),
        array( '/(matr|vert|ind)ix|ex$/i',"$1ices"  ),
        array( '/(x|ch|ss|sh)$/i',        "$1es"    ),
        array( '/([^aeiouy]|qu)y$/i',     "$1ies"   ),
        array( '/([^aeiouy]|qu)ies$/i',   "$1y"     ),
        array( '/(hive)$/i',              "$1s"     ),
        array( '/(?:([^f])fe|([lr])f)$/i',"$1$2ves" ),
        array( '/sis$/i',                 "ses"     ),
        array( '/([ti])um$/i',            "$1a"     ),
        array( '/(buffal|tomat)o$/i',     "$1oes"   ),
        array( '/(bu)s$/i',               "$1ses"   ),
        array( '/(alias|status)$/i',      "$1es"    ),
        array( '/(octop|vir)us$/i',       "$1i"     ),
        array( '/(ax|test)is$/i',         "$1es"    ),
        array( '/s$/i',                   "s"       ),
        array( '/$/',                     "s"       )
    );

    $singular = array(
        array("/s$/",               ""),
        array("/(n)ews$/",          "$1ews"),
        array("/([ti])a$/",         "$1um"),
        array("/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/",    "$1$2sis"),
        array("/(^analy)ses$/",     "$1sis"),
        array("/([^f])ves$/",       "$1fe"),
        array("/(hive)s$/",         "$1"),
        array("/(tive)s$/",         "$1"),
        array("/([lr])ves$/",       "$1f"),
        array("/([^aeiouy]|qu)ies$/","$1y"),
        array("/(s)eries$/",        "$1eries"),
        array("/(m)ovies$/",        "$1ovie"),
        array("/(x|ch|ss|sh)es$/",  "$1"),
        array("/([m|l])ice$/",      "$1ouse"),
        array("/(bus)es$/",         "$1"),
        array("/(o)es$/",           "$1"),
        array("/(shoe)s$/",         "$1"),
        array("/(cris|ax|test)es$/","$1is"),
        array("/([octop|vir])i$/",  "$1us"),
        array("/(alias|status)es$/","$1"),
        array("/^(ox)en/",          "$1"),
        array("/(vert|ind)ices$/",  "$1ex"),
        array("/(matr)ices$/",      "$1ix"),
        array("/(quiz)zes$/",       "$1")
    );

    $irregular = array(
        array( 'move',   'moves'    ),
        array( 'sex',    'sexes'    ),
        array( 'child',  'children' ),
        array( 'man',    'men'      ),
        array( 'person', 'people'   )
    );

    $uncountable = array(
        'sheep',
        'fish',
        'series',
        'species',
        'money',
        'rice',
        'information',
        'equipment'
    );

    if ( in_array( strtolower( $string ), $uncountable ) )   return $string;

    foreach ( $irregular as $noun ){
        if ( strtolower( $string ) == $noun[0] )
            return $noun[1];
    }

    foreach ( $plural as $pattern ){
        if ( preg_match( $pattern[0], $string ) )
            return preg_replace( $pattern[0], $pattern[1], $string );
    }
    $string;
}

/**
 * 下划线转驼峰
 * 思路:
 * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
 * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
 */
function camelize($uncamelized_words,$separator='_')
{
    $uncamelized_words = $separator. str_replace($separator, " ", strtolower($uncamelized_words));
    return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator );
}

/**
 * 驼峰命名转下划线命名
 * 思路:
 * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
 */
function uncamelize($camelCaps,$separator='_')
{
    return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
}


/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param  array|string  $key
 * @param  mixed  $default
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return \Encore\Admin\Config::class;
    }

    if (is_array($key)) {
        return \Encore\Admin\Config::set($key);
    }

    return \Encore\Admin\Config::get($key, $default);
}

/**
 * @param $path
 * @return bool
 */
function isValidUrl($path)
{
    if (! preg_match('~^(#|//|https?://|mailto:|tel:)~', $path)) {
        return filter_var($path, FILTER_VALIDATE_URL) !== false;
    }

    return true;
}