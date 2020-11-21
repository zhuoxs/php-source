<?php

namespace Encore\Admin;

use Closure;
use Encore\Admin\Form\Field\WangEditor;
use Encore\Admin\Layout\Content;
use Encore\Admin\Model as EloquentModel;

/**
 * Class Admin.
 */
class Admin
{
    /**
     * @var Navbar
     */
    protected $navbar;

    /**
     * @var array
     */
    public static $script = [];

    /**
     * @var array
     */
    public static $css = [];

    /**
     * @var array
     */
    public static $js = [];

    /**
     * @var array
     */
    public static $extensions = [];

    /**
     * @param $model
     * @param Closure $callable
     *
     * @return \Encore\Admin\Grid
     */
    public function grid($model, Closure $callable)
    {
        return new Grid($this->getModel($model), $callable);
    }

    /**
     * @param $model
     * @param Closure $callable
     *
     * @return \Encore\Admin\Form
     */
    public function form($model, Closure $callable)
    {
        return new Form($this->getModel($model), $callable);
    }

    /**
     * Build a tree.
     *
     * @param $model
     *
     * @return \Encore\Admin\Tree
     */
    public function tree($model, Closure $callable = null)
    {
        return new Tree($this->getModel($model), $callable);
    }

    /**
     * @param Closure $callable
     *
     * @return \Encore\Admin\Layout\Content
     */
    public function content(Closure $callable = null)
    {
        return new Content($callable);
    }

    /**
     * @param $model
     *
     * @return mixed
     */
    public function getModel($model)
    {
        if ($model instanceof EloquentModel) {
            return $model;
        }

        if (is_string($model) && class_exists($model)) {
            return $this->getModel(new $model());
        }

        throw new \Exception("$model is not a valid model");
    }

    /**
     * @param null $css
     * @return string|void
     */
    public static function css($css = null)
    {
        if (!is_null($css)) {
            self::$css = array_merge(self::$css, (array) $css);

            return;
        }

        $form_css = Form::collectFieldAssets();
        $css = isset($form_css["css"]) ? $form_css["css"] : [];

        static::$css = array_merge(static::$css, $css);

        return  array_unique(static::$css);

       /* return Template::view("partials/css",
            ['css' => array_unique(static::$css)]);*/
    }


    /**
     * @param null $js
     * @return string|void
     */
    public static function js($js = null)
    {
        if (!is_null($js)) {
            self::$js = array_merge(self::$js, (array) $js);

            return;
        }

        $form_js = Form::collectFieldAssets();
        $js = isset($form_js["js"]) ? $form_js["js"] : [];

        static::$js = array_merge(static::$js, $js);


      /*  return Template::view("partials/js",
            ['js' => array_unique(static::$js)]);*/
        return  array_unique(static::$js);

    }


    /**
     * @param string $script
     * @return string|void
     */
    public static function script($script = '')
    {
        if (!empty($script)) {
            self::$script = array_merge(self::$script, (array) $script);

           return;
        }
      /*  return Template::view("partials/script",
            ['script' => array_unique(self::$script)]);*/
      return array_unique(self::$script);

    }




    /**
     * Extend a extension.
     *
     * @param string $name
     * @param string $class
     *
     * @return void
     */
    public static function extend($name, $class)
    {
        static::$extensions[$name] = $class;
    }

    /**
     * Left sider-bar menu.
     *
     * @return array
     */
    public static function menu()
    {
        return getMenu();
    }

    /**
     * 初始化
     */
    public static function bootstrap()
    {
        Form::registerBuiltinFields();
        Form::extend('editor', WangEditor::class);
        Form::collectFieldAssets();
        Grid::registerColumnDisplayer();
        Config::load();
    }
}
