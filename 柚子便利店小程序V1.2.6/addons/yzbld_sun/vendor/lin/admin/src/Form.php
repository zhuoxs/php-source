<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/14
 * Time: 15:33.
 */

namespace Encore\Admin;

use Closure;
use Encore\Admin\Form\Builder;
use Encore\Admin\Form\Field;
use Encore\Admin\Form\Tab;
use Overtrue\Validation\Translator;
use Overtrue\Validation\Factory as ValidatorFactory;

/**
 * Class Form.
 *
 * @method Field\Text           text($column, $label = '')
 * @method Field\Checkbox       checkbox($column, $label = '')
 * @method Field\Radio          radio($column, $label = '')
 * @method Field\Select         select($column, $label = '')
 * @method Field\MultipleSelect multipleSelect($column, $label = '')
 * @method Field\Textarea       textarea($column, $label = '')
 * @method Field\Hidden         hidden($column, $label = '')
 * @method Field\Id             id($column, $label = '')
 * @method Field\Ip             ip($column, $label = '')
 * @method Field\Url            url($column, $label = '')
 * @method Field\Color          color($column, $label = '')
 * @method Field\Email          email($column, $label = '')
 * @method Field\Mobile         mobile($column, $label = '')
 * @method Field\Slider         slider($column, $label = '')
 * @method Field\Map            map($latitude, $longitude, $label = '')
 * @method Field\Editor         editor($column, $label = '')
 * @method Field\File           file($column, $label = '')
 * @method Field\Image          image($column, $label = '')
 * @method Field\Date           date($column, $label = '')
 * @method Field\Datetime       datetime($column, $label = '')
 * @method Field\Time           time($column, $label = '')
 * @method Field\Year           year($column, $label = '')
 * @method Field\Month          month($column, $label = '')
 * @method Field\DateRange      dateRange($start, $end, $label = '')
 * @method Field\DatetimeRange  datetimeRange($start, $end, $label = '')
 * @method Field\TimeRange      timeRange($start, $end, $label = '')
 * @method Field\Number         number($column, $label = '')
 * @method Field\Currency       currency($column, $label = '')
 * @method Field\HasMany        hasMany($relationName, $callback)
 * @method Field\SwitchField    switch ($column, $label = '')
 * @method Field\Display        display($column, $label = '')
 * @method Field\Rate           rate($column, $label = '')
 * @method Field\Divide         divide()
 * @method Field\Password       password($column, $label = '')
 * @method Field\Decimal        decimal($column, $label = '')
 * @method Field\Html           html($html, $label = '')
 * @method Field\Tags           tags($column, $label = '')
 * @method Field\Icon           icon($column, $label = '')
 * @method Field\Embeds         embeds($column, $label = '')
 * @method Field\MultipleImage  multipleImage($column, $label = '')
 * @method Field\MultipleFile   multipleFile($column, $label = '')
 * @method Field\Captcha        captcha($column, $label = '')
 * @method Field\Listbox        listbox($column, $label = '')
 */
class Form
{
    /**
     * Eloquent model of the form.
     *
     * @var Model
     */
    protected $model;

    protected $validator;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Submitted callback.
     *
     * @var Closure
     */
    protected $submitted;

    /**
     * Saving callback.
     *
     * @var Closure
     */
    protected $saving;

    /**
     * Saved callback.
     *
     * @var Closure
     */
    protected $saved;

    /**
     * Data for save to current model from input.
     *
     * @var array
     */
    protected $updates = [];

    /**
     * Data for save to model's relations from input.
     *
     * @var array
     */
    protected $relations = [];

    /**
     * Input data.
     *
     * @var array
     */
    protected $inputs = [];

    /**
     * Available fields.
     *
     * @var array
     */
    public static $availableFields = [];

    /**
     * Ignored saving fields.
     *
     * @var array
     */
    protected $ignored = [];

    /**
     * Collected field assets.
     *
     * @var array
     */
    protected static $collectedAssets = [];

    /**
     * @var Form\Tab
     */
    protected $tab = null;

    /**
     * Remove flag in `has many` form.
     */
    const REMOVE_FLAG_NAME = '_remove_';

    /**
     * Field rows in form.
     *
     * @var array
     */
    public $rows = [];

    /**
     * Create a new form instance.
     *
     * @param $model
     * @param \Closure $callback
     */
    public function __construct($model, \Closure $callback)
    {
        $this->model = $model;

        $this->builder = new Builder($this);

        $callback($this);
    }

    /**
     * Register builtin fields.
     */
    public static function registerBuiltinFields()
    {
        $map = [
            'button' => \Encore\Admin\Form\Field\Button::class,
            'checkbox' => \Encore\Admin\Form\Field\Checkbox::class,
            'color' => \Encore\Admin\Form\Field\Color::class,
            'currency' => \Encore\Admin\Form\Field\Currency::class,
            'date' => \Encore\Admin\Form\Field\Date::class,
            'dateRange' => \Encore\Admin\Form\Field\DateRange::class,
            'datetime' => \Encore\Admin\Form\Field\Datetime::class,
            'dateTimeRange' => \Encore\Admin\Form\Field\DatetimeRange::class,
            'datetimeRange' => \Encore\Admin\Form\Field\DatetimeRange::class,
            'decimal' => \Encore\Admin\Form\Field\Decimal::class,
            'display' => \Encore\Admin\Form\Field\Display::class,
            'divider' => \Encore\Admin\Form\Field\Divide::class,
            'divide' => \Encore\Admin\Form\Field\Divide::class,
            'embeds' => \Encore\Admin\Form\Field\Embeds::class,
            'editor' => \Encore\Admin\Form\Field\Editor::class,
            'email' => \Encore\Admin\Form\Field\Email::class,
            'file' => \Encore\Admin\Form\Field\File::class,
            'hasMany' => \Encore\Admin\Form\Field\HasMany::class,
            'hidden' => \Encore\Admin\Form\Field\Hidden::class,
            'id' => \Encore\Admin\Form\Field\Id::class,
            'image' => \Encore\Admin\Form\Field\Image::class,
            'ip' => \Encore\Admin\Form\Field\Ip::class,
            'map' => \Encore\Admin\Form\Field\Map::class,
            'mobile' => \Encore\Admin\Form\Field\Mobile::class,
            'month' => \Encore\Admin\Form\Field\Month::class,
            'multipleSelect' => \Encore\Admin\Form\Field\MultipleSelect::class,
            'number' => \Encore\Admin\Form\Field\Number::class,
            'password' => \Encore\Admin\Form\Field\Password::class,
            'radio' => \Encore\Admin\Form\Field\Radio::class,
            'rate' => \Encore\Admin\Form\Field\Rate::class,
            'select' => \Encore\Admin\Form\Field\Select::class,
            'slider' => \Encore\Admin\Form\Field\Slider::class,
            'switch' => \Encore\Admin\Form\Field\SwitchField::class,
            'text' => \Encore\Admin\Form\Field\Text::class,
            'textarea' => \Encore\Admin\Form\Field\Textarea::class,
            'time' => \Encore\Admin\Form\Field\Time::class,
            'timeRange' => \Encore\Admin\Form\Field\TimeRange::class,
            'url' => \Encore\Admin\Form\Field\Url::class,
            'year' => \Encore\Admin\Form\Field\Year::class,
            'html' => \Encore\Admin\Form\Field\Html::class,
            'tags' => \Encore\Admin\Form\Field\Tags::class,
            'icon' => \Encore\Admin\Form\Field\Icon::class,
            'multipleFile' => \Encore\Admin\Form\Field\MultipleFile::class,
            'multipleImage' => \Encore\Admin\Form\Field\MultipleImage::class,
            'captcha' => \Encore\Admin\Form\Field\Captcha::class,
            'listbox' => \Encore\Admin\Form\Field\Listbox::class,
        ];

        foreach ($map as $abstract => $class) {
            static::extend($abstract, $class);
        }
    }

    public function pushField(Field $field)
    {
        $field->setForm($this);

        $this->builder->fields()->push($field);

        return $this;
    }

    public function render()
    {
        try {
            return $this->builder->render();
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Generate a Field object and add to form builder if Field exists.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return Field|void
     */
    public function __call($method, $arguments)
    {

        if ($className = static::findFieldClass($method)) {
            $column = array_get($arguments, 0, ''); //[0];
            //var_dump($column);
            $element = new $className($column, array_slice($arguments, 1));
            //var_dump($element);
            $this->pushField($element);

            return $element;
        }
    }

    /**
     * Find field class.
     *
     * @param string $method
     *
     * @return bool|mixed
     */
    public static function findFieldClass($method)
    {
        $class = array_get(static::$availableFields, $method);

        if (class_exists($class)) {
            return $class;
        }

        return false;
    }

    /**
     * Register custom field.
     *
     * @param string $abstract
     * @param string $class
     */
    public static function extend($abstract, $class)
    {
        static::$availableFields[$abstract] = $class;
    }

    /**
     * Collect assets required by registered field.
     *
     * @return array
     */
    public static function collectFieldAssets()
    {
        if (!empty(static::$collectedAssets)) {
            return static::$collectedAssets;
        }

        $css = [];
        $js = [];

        foreach (static::$availableFields as $field) {
            if (!method_exists($field, 'getAssets')) {
                continue;
            }

            $assets = call_user_func([$field, 'getAssets']);

            if (isset($assets['css'])) {
                $css = array_merge($css, $assets['css']);
            }
            if (isset($assets['js'])) {
                $js = array_merge($js, $assets['js']);
            }
        }

        return static::$collectedAssets = [
            'css' => array_unique($css),
            'js' => array_unique($js),
        ];
    }

    /**
     * Render the contents of the form when casting to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Get Tab instance.
     *
     * @return Tab
     */
    public function getTab()
    {
        if (is_null($this->tab)) {
            $this->tab = new Tab($this);
        }

        return $this->tab;
    }

    /**
     * Use tab to split form.
     *
     * @param string  $title
     * @param Closure $content
     *
     * @return $this
     */
    public function tab($title, \Closure $content, $active = false)
    {
        $this->getTab()->append($title, $content, $active);

        return $this;
    }

    /**
     * Tools setting for form.
     *
     * @param Closure $callback
     */
    public function tools(Closure $callback)
    {
        $class = $callback->bindTo($this);
        call_user_func($class,$this->builder->getTools());
        //$callback->call($this, $this->builder->getTools());
    }

    /**
     * @return Builder
     */
    public function builder()
    {
        return $this->builder;
    }

    /**
     * Set action for form.
     *
     * @param string $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->builder()->setAction($action);

        return $this;
    }

    /**
     * Remove ignored fields from input.
     *
     * @param array $input
     *
     * @return array
     */
    protected function removeIgnoredFields($input)
    {
        array_forget($input, $this->ignored);

        return $input;
    }

    /**
     * Prepare input data for insert or update.
     *
     * @param array $data
     *
     * @return mixed
     */
    protected function prepare($data = [])
    {
        $this->callSubmitted();

        $this->inputs = $this->removeIgnoredFields($data);

        $this->callSaving();

        $this->updates = $this->inputs;
    }

    public function handleFile($data)
    {
        foreach ($_FILES as $key => $value) {
            if (is_array($value['name']) && count($value['name']) > 0
                && !empty($value['name'][0])) {
                $data[$key] = $value;
            } elseif (is_string($value['name']) && !empty($value['name'])) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    public function handleValidator($data)
    {
        $messages = [];
        $rules = [];
        foreach ($this->builder->fields() as $field) {
            list($rule, $message) = $field->getRulesAndMessage();
            $messages = array_merge($messages, $message);
            if (!empty($rule)) {
                $rules = array_merge($rules, [$field->column() => $rule]);
            }
        }

        $messages = require_once __DIR__.'/validation.php';

        //初始化工厂对象
        $factory = new ValidatorFactory(new Translator($messages));

        $validator = $factory->make($data, $rules);

        return $validator;
    }

    public function getValidatorError($validator)
    {
        $all = [];
        $messages = $validator->messages()->getMessages();
        foreach ($messages as $key => $message) {
            $all = array_merge($all, [$key => $message]);
        }

        return $all;
    }

    public function store()
    {
        // The request is using the POST method
        $data = array_except($_POST, '_token');

        $data = $this->handleFile($data);

        $validator = $this->handleValidator($data);
        //判断验证是否通过
        if (!$validator->passes()) {
            //未通过
            Session::flash('errors', $this->getValidatorError($validator));
            Session::withInput();
            ob_start();
            return redirect($_SERVER['HTTP_REFERER']);
        }

        $this->prepare($data);
        $inserts = $this->prepareInsert($this->updates);

        foreach ($inserts as $column => $value) {
            $this->model->setAttribute($column, $value);
        }

        $this->model->save();
        $this->complete($this->saved);

        return $this->redirectAfterStore();
    }

    /**
     * Find field object by column.
     *
     * @param $column
     *
     * @return mixed
     */
    protected function getFieldByColumn($column)
    {
        return $this->builder->fields()->first(
            function (Field $field) use ($column) {
                if (is_array($field->column())) {
                    return in_array($column, $field->column());
                }

                return $field->column() == $column;
            }
        );
    }

    /**
     * Prepare input data for insert.
     *
     * @param $inserts
     *
     * @return array
     */
    protected function prepareInsert($inserts)
    {
        foreach ($inserts as $column => $value) {
            if (is_null($field = $this->getFieldByColumn($column))) {
                unset($inserts[$column]);
                continue;
            }

            $inserts[$column] = $field->prepare($value);
        }

        $prepared = [];

        foreach ($inserts as $key => $value) {
            array_set($prepared, $key, $value);
        }

        return $prepared;
    }

    public function resource()
    {
        $class = get_class($this->model);
        $model = explode('\\', $class);
        $controller = uncamelize(end($model));

        return $controller;
    }

    protected function redirectAfterStore()
    {
        admin_toastr(trans('admin.save_succeeded'));

        $url = Url::index($this->resource());

        return redirect($url);
    }

    /**
     * Generate a edit form.
     *
     * @param $id
     *
     * @return $this
     */
    public function edit($id)
    {
        $this->builder->setMode(Builder::MODE_EDIT);
        $this->builder->setResourceId($id);

        $this->setFieldValue($id);

        return $this;
    }

    /**
     * Set all fields value in form.
     *
     * @param $id
     */
    protected function setFieldValue($id)
    {
        $this->model = $this->model->findOrFail($id);
        $data = $this->model->toArray();

        $this->builder->fields()->each(function (Field $field) use ($data) {
            $field->fill($data);
        });
    }

    /**
     * Set original data for each field.
     */
    protected function setFieldOriginalValue()
    {
        $values = $this->model->toArray();

        $this->builder->fields()->each(function (Field $field) use ($values) {
            $field->setOriginal($values);
        });
    }

    /**
     * Check if request is from editable.
     *
     * @param array $input
     *
     * @return bool
     */
    protected function isEditable(array $input = [])
    {
        return array_key_exists('_editable', $input);
    }

    public function update($id, $data = null)
    {
        $data = ($data) ?: array_except($_POST, ['_token', '_method']);

        $data = $this->handleFile($data);

        $isEditable = $this->isEditable($data);

        $data = $this->handleEditable($data);
        $data = $this->handleFileDelete($data);

        if ($this->handleOrderable($id, $data)) {

            header('Content-type: application/json');
            return json_encode([
                'status' => true,
                'message' => trans('admin.update_succeeded'),
            ]);
        }

        if (!$isEditable && !$this->isAjax()) {
            //validation
            $validator = $this->handleValidator($data);

            //判断验证是否通过
            if (!$validator->passes() && !$this->isAjax()) {
                //未通过
                Session::flash('errors', $this->getValidatorError($validator));
                Session::withInput();
                ob_start();
                return redirect($_SERVER['HTTP_REFERER']);

            }
        }

        $this->model = $this->model->findOrFail($id);

        $this->setFieldOriginalValue();

        $this->prepare($data);
        $inserts = $this->prepareUpdate($this->updates);

        foreach ($inserts as $column => $value) {
            $this->model->setAttribute($column, $value);
        }

        $this->model->save();

        $this->complete($this->saved);

        if ($response = $this->ajaxResponse(trans('admin.update_succeeded'))) {

            return $response;
        }

        return $this->redirectAfterUpdate();
    }

    /**
     * Handle editable update.
     *
     * @param array $input
     *
     * @return array
     */
    protected function handleEditable(array $input = [])
    {
        if (array_key_exists('_editable', $input)) {
            $name = $input['name'];
            $value = $input['value'];

            array_forget($input, ['pk', 'value', 'name']);
            array_set($input, $name, $value);
        }

        return $input;
    }

    private function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            return true;
        }

        return false;
    }

    protected function ajaxResponse($message)
    {
        if ($this->isAjax()) {
            header('Content-type: application/json');
            return json_encode([
                'status' => true,
                'message' => $message,
            ]);
        }

        return false;
    }

    /**
     * Prepare input data for update.
     *
     * @param array $updates
     * @param bool  $oneToOneRelation If column is one-to-one relation.
     *
     * @return array
     */
    protected function prepareUpdate(array $updates, $oneToOneRelation = false)
    {
        $prepared = [];

        foreach ($this->builder->fields() as $field) {
            $columns = $field->column();

            // If column not in input array data, then continue.
            if (!array_has($updates, $columns)) {
                continue;
            }

            $value = $this->getDataByColumn($updates, $columns);

            $value = $field->prepare($value);

            if (is_array($columns)) {
                foreach ($columns as $name => $column) {
                    array_set($prepared, $column, $value[$name]);
                }
            } elseif (is_string($columns)) {
                array_set($prepared, $columns, $value);
            }
        }

        return $prepared;
    }

    /**
     * @param array        $data
     * @param string|array $columns
     *
     * @return array|mixed
     */
    protected function getDataByColumn($data, $columns)
    {
        if (is_string($columns)) {
            return array_get($data, $columns);
        }

        if (is_array($columns)) {
            $value = [];
            foreach ($columns as $name => $column) {
                if (!array_has($data, $column)) {
                    continue;
                }
                $value[$name] = array_get($data, $column);
            }

            return $value;
        }
    }

    /**
     * @param array $input
     *
     * @return array
     */
    protected function handleFileDelete(array $input = [])
    {
        if (array_key_exists(Field::FILE_DELETE_FLAG, $input)) {
            $input[Field::FILE_DELETE_FLAG] = $input['key'];
            $_REQUEST[Field::FILE_DELETE_FLAG] = $input['key'];
            unset($input['key']);
            unset($_REQUEST['key']);
        }

        return $input;
    }

    public function redirectAfterUpdate()
    {
        admin_toastr(trans('admin.update_succeeded'));
        $url = Url::index($this->resource());

        return redirect($url);
    }

    /**
     * Destroy data entity and remove files.
     *
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        $ids = explode(',', $id);

        foreach ($ids as $id) {
            if (empty($id)) {
                continue;
            }

            (new $this->model())->find($id)->delete();
        }
        return true;
    }

    /**
     * @return Model
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Set saving callback.
     *
     * @param Closure $callback
     */
    public function saving(Closure $callback)
    {
        $this->saving = $callback;
    }

    /**
     * Set saved callback.
     *
     * @param callable $callback
     */
    public function saved(Closure $callback)
    {
        $this->saved = $callback;
    }

    /**
     * Call submitted callback.
     *
     * @return mixed
     */
    protected function callSubmitted()
    {
        if ($this->submitted instanceof Closure) {
            return call_user_func($this->submitted, $this);
        }
    }

    /**
     * Call saving callback.
     *
     * @return mixed
     */
    protected function callSaving()
    {
        if ($this->saving instanceof Closure) {
            return call_user_func($this->saving, $this);
        }
    }

    /**
     * Callback after saving a Model.
     *
     * @param Closure|null $callback
     *
     * @return mixed|null
     */
    protected function complete(Closure $callback = null)
    {
        if ($callback instanceof Closure) {
            return $callback($this);
        }
    }

    /**
     * Handle orderable update.
     *
     * @param int   $id
     * @param array $input
     *
     * @return bool
     */
    protected function handleOrderable($id, array $input = [])
    {
        if (array_key_exists('_orderable', $input)) {
            $model = $this->model->find($id);

            //if ($model instanceof Sortable)
            {
                //$input['_orderable'] == 1 ? $model->moveOrderUp() : $model->moveOrderDown();
                switch ($input['_orderable']) {
                    case -2: //end
                        {
                            $model->moveToEnd();
                            break;
                        }
                    case -1: //start
                        {
                            $model->moveToStart();
                            break;
                        }
                    case 0: {
                        $model->moveOrderDown();
                        break;
                    }
                    case 1: {
                        $model->moveOrderUp();
                        break;
                    }
                }
                return true;
            }
        }

        return false;
    }

    /**
     * Ignore fields to save.
     *
     * @param string|array $fields
     *
     * @return $this
     */
    public function ignore($fields)
    {
        $this->ignored = array_merge($this->ignored, (array) $fields);

        return $this;
    }

    /**
     * Getter.
     *
     * @param string $name
     *
     * @return array|mixed
     */
    public function __get($name)
    {
        return $this->input($name);
    }

    /**
     * Setter.
     *
     * @param string $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->input($name, $value);
    }

    /**
     * Get or set input data.
     *
     * @param string $key
     * @param null   $value
     *
     * @return array|mixed
     */
    public function input($key, $value = null)
    {
        if (is_null($value)) {
            return array_get($this->inputs, $key);
        }

        return array_set($this->inputs, $key, $value);
    }

    /**
     * Disable form submit.
     *
     * @return $this
     */
    public function disableSubmit()
    {
        $this->builder()->options(['enableSubmit' => false]);

        return $this;
    }

    /**
     * Disable form reset.
     *
     * @return $this
     */
    public function disableReset()
    {
        $this->builder()->options(['enableReset' => false]);

        return $this;
    }
}
