<?php
class PluginMobilePage extends MobilePage
{
    /**
     * @var Environment
     */
    protected $twig = NULL;
    public $model = NULL;
    public $set = NULL;
    const DEFAULT_TEMPLATE_SUFFIX = ".twig";
    public function __construct()
    {
        parent::__construct();
        $this->model = m("plugin")->loadModel($GLOBALS["_W"]["plugin"]);
        $this->set = $this->model->getSet();
    }
    public function getSet()
    {
        return $this->set;
    }
    public function qr()
    {
        global $_W;
        global $_GPC;
        $url = trim($_GPC["url"]);
        require IA_ROOT . "/framework/library/qrcode/phpqrcode.php";
        QRcode::png($url, false, QR_ECLEVEL_L, 16, 1);
    }
    /**
     * 解析模板路径参数
     * @param $template
     * @return string
     * @author: Vencenty
     * @time: 2019/5/20 15:43
     */
    protected function resolveTemplatePath($template)
    {
        $template = trim($template);
        $replaceTemplate = str_replace(array(".", "/"), "/", $template);
        $params = explode("/", $replaceTemplate);
        $lastElement = array_pop($params);
        $templateFile = $lastElement . static::DEFAULT_TEMPLATE_SUFFIX;
        array_push($params, $templateFile);
        $relativePath = implode("/", $params);
        return $relativePath;
    }
    /**
     * 渲染模板
     * eg.
     * $this->view('index') 渲染当前插件下 template/mobile/default/index.twig模板
     * $this->view('goods.detail.index') | $this->view('goods/detail/index') 则是渲染当前插件下 template/mobile/default/goods/detail/index.twig 模板
     * @param $template
     * @param array $params
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @author: Vencenty
     * @time: 2019/5/24 14:31
     */
    protected function view($template, $params = array())
    {
        global $_GPC;
        $templateFilePath = $this->resolveTemplatePath($template);
        $routeParams = isset($_GPC["r"]) ? $_GPC["r"] : NULL;
        $routeParams = explode(".", $routeParams);
        $plugin = current($routeParams);
        $pluginTemplatePath = EWEI_SHOPV2_PLUGIN . (string) $plugin . "/template/mobile/default/";
        if ($plugin == "pc") {
            $loader = new Twig\Loader\FilesystemLoader($pluginTemplatePath);
            $this->twig = new Twig\Environment($loader, array("debug" => true));
            $this->addFunction();
            $this->addGlobal();
            $this->addFilter();
        }
        $defaultParams = array("basePath" => EWEI_SHOPV2_LOCAL . "plugin/" . $plugin . "/static", "staticPath" => EWEI_SHOPV2_LOCAL . "static/", "appJsPath" => EWEI_SHOPV2_LOCAL . "static/js/app", "title" => "人人商城");
        if (empty($params)) {
            $params = array();
        }
        $params = array_merge($defaultParams, $params);
        $templateFileRealPath = $pluginTemplatePath . $templateFilePath;
        if (!file_exists($templateFileRealPath)) {
            exit("模板文件 " . $templateFileRealPath . " 不存在");
        }
        return $this->twig->render($templateFilePath, $params);
    }
    /**
     * 添加全局函数
     * @author: Vencenty
     * @time: 2019/5/27 20:45
     */
    private function addFunction()
    {
        $extendFunctions = array("tomedia" => function ($src) {
            return tomedia($src);
        }, "pcUrl" => function ($do, $query = array(), $full = false) {
            return mobileUrl($do, $query, $full);
        }, "time" => function ($format = NULL) {
            if (!empty($format)) {
                return date($format, time());
            }
            return time();
        }, "count" => function ($array = array(), $model = COUNT_NORMAL) {
            return count($array, $model);
        }, "dump" => function ($params) {
            return print_r($params);
        }, "checkLogin" => function () {
            return $this->model->checkLogin();
        });
        foreach ($extendFunctions as $functionName => $callback) {
            $function = new Twig_SimpleFunction($functionName, $callback);
            $this->twig->addFunction($function);
        }
    }
    /**
     * 增加全局变量
     * @author: Vencenty
     * @time: 2019/5/27 20:37
     */
    protected function addGlobal()
    {
        global $_W;
        global $_GPC;
        $params = array("global" => p("pc")->getTemplateGlobalVariables(), "v" => str_replace(".", "", microtime(true)), "params" => json_encode($_GPC), "api" => json_encode(array("addShopCart" => mobileUrl("pc.goods.addShopCart", array(), true), "commentList" => mobileUrl("pc.goods.comment_list", array(), true), "comments" => mobileUrl("pc.goods.comments", array(), true), "calcSpecGoodsPrice" => mobileUrl("pc.goods.calcSpecGoodsPrice", array(), true), "imageUpload" => mobileUrl("pc.foundation.imageUpload", array(), true)), JSON_UNESCAPED_UNICODE));
        foreach ($params as $key => $value) {
            $this->twig->addGlobal($key, $value);
        }
    }
    /**
     * 添加全局过滤器
     * @author: Vencenty
     * @time: 2019/5/27 20:45
     */
    protected function addFilter()
    {
        $extendFilters = array("float" => function ($number) {
            return (double) $number;
        }, "bool" => function ($params) {
            return (bool) $params;
        }, "format" => function ($string) {
            $output = $string;
            if (8 < mb_strlen($output)) {
                $output = mb_substr($output, 0, 8, "utf-8");
            }
            return $output;
        });
        foreach ($extendFilters as $filterName => $extendFilter) {
            $filter = new Twig_SimpleFilter($filterName, $extendFilter);
            $this->twig->addFilter($filter);
        }
    }
}

?>