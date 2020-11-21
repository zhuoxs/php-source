<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/14
 * Time: 15:37.
 */

namespace Encore\Admin\Form;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Renderable;
use Encore\Admin\Session;
use Encore\Admin\Template;

/**
 * Class Field
 * @package Encore\Admin\Form
 */
class Field implements Renderable
{
    /**
     *
     */
    const FILE_DELETE_FLAG = '_file_del_';
    /**
     * Css required by this field.
     *
     * @var array
     */
    protected static $css = [];
    /**
     * Js required by this field.
     *
     * @var array
     */
    protected static $js = [];
    /**
     * Element id.
     *
     * @var array|string
     */
    protected $id;
    /**
     * Element value.
     *
     * @var mixed
     */
    protected $value;
    /**
     * Field original value.
     *
     * @var mixed
     */
    protected $original;
    /**
     * Field default value.
     *
     * @var mixed
     */
    protected $default;
    /**
     * Element label.
     *
     * @var string
     */
    protected $label = '';
    /**
     * Column name.
     *
     * @var string|array
     */
    protected $column = '';
    /**
     * Form element name.
     *
     * @var string
     */
    protected $elementName = [];
    /**
     * Form element classes.
     *
     * @var array
     */
    protected $elementClass = [];
    /**
     * Variables of elements.
     *
     * @var array
     */
    protected $variables = [];
    /**
     * Options for specify elements.
     *
     * @var array
     */
    protected $options = [];
    /**
     * Validation rules.
     *
     * @var string|\Closure
     */
    protected $rules = '';
    /**
     * @var callable
     */
    protected $validator;
    /**
     * Validation messages.
     *
     * @var array
     */
    protected $validationMessages = [];
    /**
     * Script for field.
     *
     * @var string
     */
    protected $script = '';

    /**
     * Element attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Parent form.
     *
     * @var Form
     */
    protected $form = null;

    /**
     * View for field to render.
     *
     * @var string
     */
    protected $view = '';

    /**
     * Help block.
     *
     * @var array
     */
    protected $help = [];

    /**
     * Key for errors.
     *
     * @var mixed
     */
    protected $errorKey;

    /**
     * Placeholder for this field.
     *
     * @var string|array
     */
    protected $placeholder;

    /**
     * Width for label and field.
     *
     * @var array
     */
    protected $width = [
        'label' => 2,
        'field' => 8,
    ];

    /**
     * If the form horizontal layout.
     *
     * @var bool
     */
    protected $horizontal = true;

    /**
     * @var array
     */
    protected $extra_data = [];

    /**
     * Field constructor.
     *
     * @param $column
     * @param array $arguments
     */
    public function __construct($column, $arguments = [])
    {
        $this->column = $column;
        $this->label = $this->formatLabel($arguments);
        $this->id = $this->formatId($column);
    }

    /**
     * Format the label value.
     *
     * @param array $arguments
     *
     * @return string
     */
    protected function formatLabel($arguments = [])
    {
        $column = is_array($this->column) ? current($this->column) : $this->column;

        $label = isset($arguments[0]) ? $arguments[0] : ucfirst($column);

        return $label;
        //return str_replace(['.', '_'], ' ', $label);
    }

    /**
     * Format the field element id.
     *
     * @param string|array $column
     *
     * @return string|array
     */
    protected function formatId($column)
    {
        return str_replace('.', '_', $column);
    }

    /**
     * @return string
     */
    public function label()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Set width for field and label.
     *
     * @param int $field
     * @param int $label
     *
     * @return $this
     */
    public function setWidth($field = 8, $label = 2)
    {
        $this->width = [
            'label' => $label,
            'field' => $field,
        ];

        return $this;
    }

    /**
     * Set the field as readonly mode.
     *
     * @return Field
     */
    public function readOnly()
    {
        return $this->attribute('disabled', true);
    }

    /**
     * @return array|string
     */
    public function column()
    {
        return $this->column;
    }

    /**
     * @param array|string $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }

    /**
     * @return string
     */
    public function render()
    {
        Admin::script($this->script);
        $variables = $this->variables();
        if (!empty($this->extra_data)) {
            $variables = array_merge($variables, $this->extra_data);
        }
        //dd($variables);
        return Template::view("form/{$this->getView()}", $variables);
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        if (is_array($this->rules) && in_array('required', $this->rules)) {
            return true;
        }
        if (is_string($this->rules) && false !== strpos($this->rules, 'required')) {
            return true;
        }

        return false;
    }

    /**
     * add required rule
     * @return Field
     */
    public function addRequired()
    {
        return $this->rules('required');
    }

    /**
     * Get the view variables of this field.
     *
     * @return array
     */
    protected function variables()
    {
        $name = $this->elementName ?: $this->formatName($this->column);
        $err = Session::get('errors', []);
        if (!empty($err)) {
            $error = isset($err[$name]) ? array_values($err[$name])[0] : "";
        } else {
            $error = "";
        }
        $value = $this->value();
        if (is_array($this->column)) {
            $old = "";
        } else {
            $old = old($this->column, $value);
        }

        return array_merge($this->variables, [
            'id' => $this->id,
            'name' => $name,
            'help' => $this->help,
            'class' => $this->getElementClassString(),
            'value' => $value,
            'label' => $this->label,
            'viewClass' => $this->getViewElementClasses(),
            'column' => $this->column,
            'errorKey' => $this->getErrorKey(),
            'attributes' => $this->formatAttributes(),
            'placeholder' => $this->getPlaceholder(),
            'error' => $error,
            'required' => $this->isRequired(),
            'old' => $old
        ]);
    }

    /**
     * Format the name of the field.
     *
     * @param string $column
     *
     * @return array|mixed|string
     */
    protected function formatName($column)
    {
        if (is_string($column)) {
            $name = explode('.', $column);

            if (1 == count($name)) {
                return $name[0];
            }

            $html = array_shift($name);
            foreach ($name as $piece) {
                $html .= "[$piece]";
            }

            return $html;
        }

        if (is_array($this->column)) {
            $names = [];
            foreach ($this->column as $key => $name) {
                $names[$key] = $this->formatName($name);
            }

            return $names;
        }

        return '';
    }

    /**
     * Get element class string.
     *
     * @return mixed
     */
    protected function getElementClassString()
    {
        $elementClass = $this->getElementClass();

        if (self::isAssoc($elementClass)) {
            $classes = [];

            foreach ($elementClass as $index => $class) {
                $classes[$index] = is_array($class) ? implode(' ', $class) : $class;
            }

            return $classes;
        }

        return implode(' ', $elementClass);
    }

    /**
     * Get element class.
     *
     * @return array
     */
    protected function getElementClass()
    {
        if (!$this->elementClass) {
            $name = $this->elementName ?: $this->formatName($this->column);

            $this->elementClass = (array)str_replace(['[', ']'], '_', $name);
        }

        return $this->elementClass;
    }

    /**
     * Determines if an array is associative.
     *
     * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
     *
     * @param array $array
     *
     * @return bool
     */
    public static function isAssoc(array $array)
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

    /**
     * Set or get value of the field.
     *
     * @param null $value
     *
     * @return mixed
     */
    public function value($value = null)
    {
        if (is_null($value)) {
            return is_null($this->value) ? $this->getDefault() : $this->value;
        }

        $this->value = $value;

        return $this;
    }

    /**
     * Get default value.
     *
     * @return mixed
     */
    public function getDefault()
    {
        if ($this->default instanceof \Closure) {
            return call_user_func($this->default, $this->form);
        }

        return $this->default;
    }

    /**
     * @return array
     */
    public function getViewElementClasses()
    {
        $className = $this->formatName($this->column());
        if (is_array($className)) {
            $className = implode("_", $className);
        }
        if ($this->horizontal) {
            return [
                'label' => "col-sm-{$this->width['label']}",
                'field' => "col-sm-{$this->width['field']}",
                'form-group' => 'form-group ' . "form-" . $className,
            ];
        }

        return ['label' => '', 'field' => '', 'form-group' => ''];
    }

    /**
     * Get key for error message.
     *
     * @return string
     */
    public function getErrorKey()
    {
        return $this->errorKey ?: $this->column;
    }

    /**
     * Set key for error message.
     *
     * @param string $key
     *
     * @return $this
     */
    public function setErrorKey($key)
    {
        $this->errorKey = $key;

        return $this;
    }

    /**
     * Format the field attributes.
     *
     * @return string
     */
    protected function formatAttributes()
    {
        $html = [];

        foreach ($this->attributes as $name => $value) {
            $html[] = $name . '="' . htmlspecialchars($value) . '"';
        }

        return implode(' ', $html);
    }

    /**
     * Get placeholder.
     *
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder ?: '请输入 ' . $this->label;
    }

    /**
     * Get view of this field.
     *
     * @return string
     */
    public function getView()
    {
        if (!empty($this->view)) {
            return $this->view;
        }

        $class = explode('\\', get_called_class());

        return strtolower(end($class));
    }

    /**
     * Add html attributes to elements.
     *
     * @param array|string $attribute
     * @param mixed $value
     *
     * @return $this
     */
    public function attribute($attribute, $value = null)
    {
        if (is_array($attribute)) {
            $this->attributes = array_merge($this->attributes, $attribute);
        } else {
            $this->attributes[$attribute] = (string)$value;
        }

        return $this;
    }

    /**
     * Set default value for field.
     *
     * @param $default
     *
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Set help block for current field.
     *
     * @param string $text
     * @param string $icon
     *
     * @return $this
     */
    public function help($text = '', $icon = 'fa-info-circle')
    {
        $this->help = compact('text', 'icon');

        return $this;
    }

    /**
     * Set field placeholder.
     *
     * @param string $placeholder
     *
     * @return Field
     */
    public function placeholder($placeholder = '')
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * 添加额外数据.
     *
     * @param $data
     *
     * @return $this
     */
    public function AddExtraData($data)
    {
        $this->extra_data = array_merge($this->extra_data, $data);

        return $this;
    }

    /**
     * Add the element class.
     *
     * @param $class
     *
     * @return $this
     */
    public function addElementClass($class)
    {
        if (is_array($class) || is_string($class)) {
            $this->elementClass = array_merge($this->elementClass, (array)$class);

            $this->elementClass = array_unique($this->elementClass);
        }

        return $this;
    }

    /**
     * Remove element class.
     *
     * @param $class
     *
     * @return $this
     */
    public function removeElementClass($class)
    {
        $delClass = [];

        if (is_string($class) || is_array($class)) {
            $delClass = (array)$class;
        }

        foreach ($delClass as $del) {
            if (($key = array_search($del, $this->elementClass))) {
                unset($this->elementClass[$key]);
            }
        }

        return $this;
    }

    /**
     * Get element class selector.
     *
     * @return string
     */
    protected function getElementClassSelector()
    {
        $elementClass = $this->getElementClass();

        if (self::isAssoc($elementClass)) {
            $classes = [];

            foreach ($elementClass as $index => $class) {
                $classes[$index] = '.' . (is_array($class) ? implode('.', $class) : $class);
            }

            return $classes;
        }

        return '.' . implode('.', $elementClass);
    }

    /**
     * Get assets required by this field.
     *
     * @return array
     */
    public static function getAssets()
    {
        return [
            'css' => static::$css,
            'js' => static::$js,
        ];
    }

    /**
     * Set the field options.
     *
     * @param array $options
     *
     * @return $this
     */
    public function options($options = [])
    {
        /* if ($options instanceof Arrayable) {
             $options = $options->toArray();
         }*/

        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @param Form $form
     *
     * @return $this
     */
    public function setForm(Form $form = null)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Fill data to the field.
     *
     * @param array $data
     */
    public function fill($data)
    {
        // Field value is already setted.
        if (!is_null($this->value)) {
            return;
        }

        if (is_array($this->column)) {
            foreach ($this->column as $key => $column) {
                $this->value[$key] = array_get($data, $column);
            }

            return;
        }

        $this->value = array_get($data, $this->column);
    }

    /**
     * Set original value to the field.
     *
     * @param array $data
     */
    public function setOriginal($data)
    {
        if (is_array($this->column)) {
            foreach ($this->column as $key => $column) {
                $this->original[$key] = array_get($data, $column);
            }

            return;
        }

        $this->original = array_get($data, $this->column);
    }

    /**
     * Get or set rules.
     *
     * @param null $rules
     * @param array $messages
     *
     * @return $this
     */
    public function rules($rules = null, $messages = [])
    {
        //dd($rules);
        if ($rules instanceof \Closure) {
            $this->rules = $rules;
        }

        if (is_array($rules)) {
            $thisRuleArr = array_filter(explode('|', $this->rules));

            $this->rules = array_merge($thisRuleArr, explode('|', $this->rules));
        } elseif (is_string($rules)) {
            $rules = array_filter(explode('|', "{$this->rules}|$rules"));

            $this->rules = implode('|', $rules);
        }

        $this->validationMessages = $messages;

        return $this;
    }

    /**
     * @return \Closure|string
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @return array
     */
    public function getRulesAndMessage()
    {
        return [$this->rules, $this->validationMessages];
    }

    /**
     * Prepare for a field value before update or insert.
     *
     * @param $value
     *
     * @return mixed
     */
    public function prepare($value)
    {
        return $value;
    }
}
