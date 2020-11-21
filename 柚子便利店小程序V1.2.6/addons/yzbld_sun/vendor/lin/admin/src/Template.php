<?php


namespace Encore\Admin;


/**
 * Class Template
 * @package Encore\Admin
 */
class Template
{
    /**
     * @return null|\Smarty
     */
    public static function instance()
    {
        global $_W;
        static $instance = null;
        if (is_null($instance)) {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/views');
            $twig = new \Twig_Environment($loader, array(
                'cache' => config('template_cache_dir'),
                'debug' => true
            ));

            $css = Admin::css();
            foreach ($css as &$item) {
                $item = assets($item);
            }
            $twig->addGlobal('css', $css);
            $js = Admin::js();
            foreach ($js as &$item) {
                $item = assets($item);
            }
            $twig->addGlobal('js', $js);
            $twig->addGlobal('assets_path', '../addons/yzbld_sun/assets');
            $menu = Admin::menu();
            foreach ($menu as &$item) {
                if (isset($item["children"])) {
                    foreach ($item["children"] as &$subItem) {
                        $subItem["active"] = isCurrent($subItem["url"]);
                    }
                }

                $item["active"] = isCurrent($item["url"]);

            }
            $twig->addGlobal('menu', $menu);

            $twig->addGlobal('_W', $_W);
            $twig->addGlobal('IMS_VERSION', IMS_VERSION);

            $instance = $twig;
        }
        return $instance;
    }

    /**
     * @param $tpl
     * @param $data
     * @return string
     * @throws \SmartyException
     */
    public static function view($tpl, $data)
    {
        $view = self::instance();
        $script = Admin::script();
        //dd($script);
        if (\Encore\Admin\Session::has('toastr')) {
            array_push($script, \Encore\Admin\Session::getToastr('toastr'));
        }
        $view->addGlobal('script', $script);

        //$view->assign($data);
        return $view->render($tpl . ".twig", $data);
    }

    public static function viewFormCustom($viewPath, $tpl, $data)
    {
        $loader = new \Twig_Loader_Filesystem($viewPath);
        $twig = new \Twig_Environment($loader, array(
            'cache' => config('template_cache_dir'),
            'debug' => true
        ));
        return $twig->render($tpl . ".twig", $data);

    }


}