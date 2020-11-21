禾匠商城 - 核心
=================

目录：

   * [禾匠商城小程序](#禾匠商城小程序)
      * [规范](#规范)
         * [数据库](#数据库)
         * [代码](#代码)
         * [结构](#结构)
            * [Controllers](#controllers)
            * [ModelForms](#modelforms)
            * [Models](#models)
            * [Common](#common)
         * [响应](#响应)
            * [HTTP API](#http-api)
            * [模型验证错误](#模型验证错误)
         * [注释](#注释)
         * [发行版](#发行版)
         * [小程序前端图片](#小程序前端图片)
      * [异常](#异常)
         * [抛出与处理](#抛出与处理)
         * [Sentry](#sentry)
      * [特性](#特性)
         * [调试模式](#调试模式)
         * [环境配置](#环境配置)
         * [Git 分支](#git-分支)
         * [辅助函数](#辅助函数)
         * [缩略图](#缩略图)
         * [数据序列化](#数据序列化)
         * [运行环境](#运行环境)
         * [文件存储](#文件存储)
         * [物流](#物流)
         * [短信](#短信)
         * [事件](#事件)
         * [动作重定向](#动作重定向)
         * [控制器重定向](#控制器重定向)
         * [响应下载](#响应下载)
      * [工具集](#工具集)
         * [Git 仓库总文件数](#git-仓库总文件数)
         * [批量替换数据库字段](#批量替换数据库字段)
      * [已知 Issues](#已知-issues)

## 规范

### 数据库

以下是对 [`MySQL Internals Manual :: 26.1.1 Coding Style`](https://dev.mysql.com/doc/internals/en/coding-style.html) 的强调与补充。

- 禁止设置字段允许 `NULL`，使用默认值代替。

- 能用 Unique 索引限制唯一，则不要用 Index 索引。

- 表、字段 Charset 统一 `utf8`，Collation 统一 `utf8_general_ci`，存储引擎统一 `InnoDB`。

- 类似 `is_delete` 的字段，统一使用 `TINYINT(1)` 类型，且务必建 Index 索引。

- 除非情况特殊，严禁使用 `TEXT` / `LONGTEXT` / `BLOB` / `LONGBLOB` 等类型。

- 图标、超过255字节的文本，尽量不要存进数据库，会引起 [行存储溢出](https://dev.mysql.com/doc/refman/8.0/en/innodb-row-format-overview.html)。

- 对于能够使用 `INNER JOIN` 的场景，尽可能少用 `LEFT JOIN`，且关联的字段务必建索引。

- 数据库升级脚本内，对于 `CREATE TABLE` 等语句，务必加入 `IF NOT EXISTS`，尽可能避免引起异常。

- 对于存储 URL 的字段，必须采用 `VARCHAR` 类型，建议长度：`2048` - `8192`，参见：<https://stackoverflow.com/questions/2659952/maximum-length-of-http-get-request>

- `JOIN ON` 后面只带关联条件，将固定条件移动至 `WHERE` 后。

### 代码

以下是对 `PSR-1`、`PSR-2` 的强调与补充；有关 PSR 公共规范，请参见：<https://github.com/summerblue/psr.phphub.org/tree/master/psrs>。

- 局部变量统一使用小驼峰，例如：`$goodsList`

- foreach 修改数组元素的值，可以使用引用赋值的方式，例如：

    ```php
    foreach($list as $k => $v){
        $list[$k]['foo'] = 'bar';
    }
    ```

    可以优化为：

    ```php
    foreach($list as $k => &$v){
        $v['foo'] = 'bar';
    }
    unset($v); // 建议随手 unset，否则修改 $v 会改变数组末尾元素的值
    ```

- 对于外部不需要访问的属性或方法，尽可能写成 `protected` / `private`，以增强健壮性。

- 对于运行时可能出现的问题（例如类型错误等），尽可能采取「零容忍」态度，且报错越早越好；避免 `return false`，使用 `throw new Exception`。

- 尽可能减少代码冗余，将重复的部分提取凝练到一起，例如：

    ```php
    public function couponInfo()
    {
        $coupon = Coupon::find()->where(['id'=>$this->id])->asArray()->one();
        if($coupon['appoint_type'] == 1){
            $info = Cat::find()->select('id,name')->where(['id'=>json_decode($coupon['cat_id_list'])])->andWhere(['is_delete'=>0,'store_id'=>$this->store_id])->asArray()->all();
        }else if($coupon['appoint_type'] == 2){
            $info = Goods::find()->select('id,name')->where(['id'=>json_decode($coupon['goods_id_list'])])->andWhere(['is_delete'=>0,'store_id'=>$this->store_id])->asArray()->all();
        }else{
            $info = [];
        }
        return [
            'code' => 0,
            'data' => [
                'coupon'=>$coupon,
                'info'=>$info,
            ],
        ];
    }
    ```

    可以优化为：

    ```php
    public function couponInfo()
    {
        $coupon = Coupon::find()->where(['id'=>$this->id])->asArray()->one();
        switch($coupon['appoint_type'])
        {
            case 1:
            $info = Cat::find()->where(['id' => json_decode($coupon['cat_id_list'])]);
            case 2:
            $info = Goods::find()->where(['id' => json_decode($coupon['goods_id_list'])]);
            default:
            $info = null;
        }
        if($info){
            $info = $info->select('id,name')->andWhere(['is_delete' => 0, 'store_id' => $this->store_id])->asArray()->all();
        }
        return [
            'code' => 0,
            'data' => [
                'coupon'=>$coupon,
                'info'=>$info,
            ],
        ];
    }
    ```

    增强代码可读性，降低维护难度。

- 数据库查询出来的原始数据，将格式转换封装进 [模型获取器](https://www.yiiframework.com/doc/guide/2.0/zh-cn/db-active-record#data-transformation) 进行处理。

- `switch` 语句 `return` 后无需使用 `break`。

- `switch` 语句必须带 `default` 子句，如遇不可能值，则抛出异常。

- 对于废弃的函数、语句、变量、类，严禁注释、抛出异常或 `return`，必须删除代码。

- 禁止使用 `rand` 函数，请用 `mt_rand` 代替。

- 禁止使用 `md5` 函数，请用 `sha1` 代替。

- 提取二维数组内某元素的值作为一个单独的数组，建议使用 [`array_map`](https://wi1dcard.github.io/snippets/php-array-map-instead-of-foreach/)。

### 结构

#### Controllers

- 控制器基础的方法名称统一，特殊方法可自定义。
- 控制器中不写逻辑代码,所逻辑代码处理放在 `ModelForm` 中。

- Admin 模块

    - actionIndex (列表显示页面)
    - actionCreate (添加数据页面)
    - actionStore (添加数据)
    - actionEdit (编辑数据页面)  
    - actionUpdate (更新数据)
    - actionDestroy (删除数据)
    - 其它 (自定义名称)

    例：

    ```php
    public function actionIdnex()
    {
        return 'index'
    }

    ...

    public function actionOther()
    {
        return 'other'
    }
    ```

- Api 模块

    - actionIndex (列表数据)
    - actionStore (添加数据)
    - actionEdit (单条数据)  
    - actionUpdate (更新数据)
    - actionDestroy (删除数据)
    - 其它 (自定义名称)

    例：

    ```php
    public function actionIdnex()
    {
        return 'index';
    }

    ...

    public function actionOther()
    {
        return 'other';
    }
    ```

#### ModelForms

- 每一个控制器对应一个 `ModelForm` 目录，目录名称和控制器名称相同。

    ```
    User +
         |- GetUserForm.php
         |- GetUserTypeForm.php
         ...
    ```

- 单一原则，一个方法中只做一件事。

    错误：

    ```php
    public function getUsers()
    {
        $users = User::find()->all();
        
        $data = [];
        foreach($users as $item) {
            $data[] = $item['name'];
            ...
        }
    
        return $data;
    }
    ```

    正确：

    ```php
    public function getUsers()
    {
        $users = User::find()->all();
    
        return $data;
    }

    public function getResetUsers($users)
    {
        $data = [];
        foreach($users as $item) {
            $data[] = $item['name']
            ...
        }
        
        return $data;
    }
    ```

- 需要获取关联数据时，尽可能采用 `hasOne` / `hasMany` 定义模型关系，替代原生的 `leftJoin` 查询；参见：<https://www.yiiframework.com/doc/guide/2.0/zh-cn/db-active-record#relational-data>。

    错误：

    ```php
    User:find()->alias('u')->leftJoin(['g' => Goods::tableName()], 'o.goods_id=u.id')->asArray()->all();
    ```

    正确：

    ```php
    class User extends ActiveRecord 
    {
        public function getGoods()
        {
            return $this->hasMany(Good::className(), ['user_id' => 'id']);
        }
    }

    class UserFormModel extends Model
    {
        public function getUsers()
        {
            $users = User::find()->with('goods')->all();
            
            return $users;
        }
    }
    ```

- 在 `FormModel` 中进行数据查询时，尽量不要使用 `asArray()` 方法。否则导致模型特性消失，无法访问关联模型的数据。

    错误：

    ```php
    User::find()->asArray()->all();
    ```

    正确：

    ```php
    User::find()->all();
    ```

- 在条件查询时，不要出现 `type=1`、`is_delete=0`, `status=2` 等情况。

    错误：

    ```php
    User::find()->where(['type' => 1, 'is_delete' = 0, 'status' => 2])->all();
    ```

    正确：

    ```php
    class User extends ActiveRecord 
    {
        /**
        * 用户类型：管理员
        */
        const USER_TYPE_ADMIN = 1
        
        /**
        * 用户类型：会员
        */
        const USER_TYPE_MEMBER = 2
        
        /**
        * 用户状态：启用
        */
        const USER_STATUS_TRUE = 1
        
        ...
    }

    class UserFormModel extends Model
    {
        public function getUsers()
        {
            $users = User::find()->andWhere(['type' => User::USER_TYPE_ADMIN, 'status' => User::USER_STATUS_TRUE])->all();
            
            return $users;
        }
    }
    ```

#### Models

- 所以关联关系写在对应的模型中（例子在 `ModelForm` 小节）。
- 模型中一个字段有着多种情况，应在模型中定义成常量并标识该字段含义（例子在 `ModelForm` 小节）。

#### Common

- 公共逻辑目录：`core/models/common`。
- 公共逻辑目录分为 `Admin(后台管理)` 和 `Api（小程序接口）`。
- 在编写代码的过程中，如果有部分逻辑代码是通用则可以写在 `Common` 中。例如：创建订单、处理订单、支付等。

### 响应

#### HTTP API

响应格式：

```json
{
  "code": <int>,
  "msg": <string>,
  "data": <array> | <object>
}
```

- 在 Controller 中，可直接返回数组，以输出 JSON 数据：

    ```php
    return ['code' => $code, ...];
    ```

- 在 Filter 中，可直接使用如下方式设置响应数据，并截断执行：

    ```php
    \Yii::$app->response->data = $some_response_data;
    return false; // 参见：<https://www.yiiframework.com/doc/guide/2.0/zh-cn/structure-filters#creating-filters>
    ```

- 在 `api` module 的 Controller 中，应使用如下方式输出结构化响应数据：

    ```php
    return new \app\hejiang\ApiResponse($code, $msg, $data);
    ```

    或：

    ```php
    return new \app\hejiang\BaseApiResponse($array);
    ```
    
    切勿在输出响应时使用废弃的 `json_encode` 和 `renderJson` 方法，将会引发 `app\hejiang\exceptions\InvaildResponseException`。

#### 模型验证错误

- 若模型继承 `app\models\Model`，则可以直接使用 `errorResponse` 属性：

```php
if(!$this->validate()){
    return $this->errorResponse;
}
```

- 其它情况，可使用如下形式输出模型验证错误：

```php
return new \app\hejiang\ValidationErrorResponse($model->errors);
```

切勿在输出响应时使用废弃的 `Model::getModelError` 方法。

### 注释

- IDE 生成的注释记得改名字，例如：

```php
/**
 * Created by PhpStorm.
 * User: <YOUR NAME>
 * Date: 2017/8/14
 * Time: 17:46
 */
```

- 行内注释尽量首部带空格，例如：

```php
// This is a function.
function foo(){
    // do nothing.
}
```

- 对于注释无用代码，尽可能不要将 `//` 打在行首，会引起代码格式化时编辑器误判，例如：

    - 错误：

    ```php
    function foo(){
        $bar = 1000;
    //    $bar = -1000;
        return $bar;
    }
    ```

    - 正确：

    ```php
    function foo(){
        $bar = 1000;
        // $bar = -1000;
        return $bar;
    }
    ```

### 发行版

我们采用 git 的 tag 功能来实现对版本的精准控制。Gitee 自带了发行版（`release`）控制功能（基于 git tag），所以我们直接在 gitee 上使用图形化操作的方式创建即可。

创建发行版链接：<https://gitee.com/zjhj/zjhj_mall/releases>

- 版本命名格式：`v*.*.*`，详细参见：<https://semver.org/lang/zh-CN/>。
- 标题命名格式：`v*.*.* - 20**年**周`。
- 描述采用多数 git 平台通用的 Markdown 文本格式，原生兼容 HTML；通常只需掌握基础用法即可，参见：[Markdown-语法简明介绍](https://gitee.com/zjhj/zjhj_mall/wikis/Markdown-%E8%AF%AD%E6%B3%95%E7%AE%80%E6%98%8E%E4%BB%8B%E7%BB%8D)。

### 小程序前端图片

- 图片目录：`/web/statics/wxapp/images/`
- 代码添加：`/modules/api/models/StoreForm.php`
- 前端应用：小程序图片数组已存入缓存，Key 值：`wxapp_img`；页面调用变量：`__wxapp_img`

## 异常

### 抛出与处理

多数情况，异常（`exception`）对我们可能比较陌生，多数都是框架或系统抛出异常，我们接收并处理。但实际上，如果能够在我们编写的实际业务代码中恰当地抛出异常，将会有意想不到的效果。下面我用几个符合我们实际场景的简明实例来说明。

优化前：

```php
function actionIndex(){
    $result = '';
    $foo = Yii::$app->request->post('foo');
    if(empty($foo)) {
        $result = 'foo error';
    }
    else {
        $bar = Yii::$app->request->post('bar');
        if(empty($bar)) {
            $result = 'bar error';
        }
        $result = 'ok';
    }
    return $result;
}
```

如上可以发现，代码嵌套层数非常多，当然你可以优化成直接 `return` 的方式，但下面这个呢：

```php
function actionIndex(){
    $result = '';
    $foo = getValueByName('foo');
    if($foo === null) {
        return 'foo error';
    }
    $bar = getValueByName('bar');
    if($bar === null) {
        return 'bar error';
    }
    return 'ok';
}

function getValueByName($name){
    $value = Yii::$app->request->post($name);
    if($value === null) {
        return null;
    }
    else if(empty($value)){
        return null;
    }
    return $value;
}
```

如上代码，存在的问题：

- 错误丢失：在 `actionIndex` 内我们只能得到的值是 `null`，无法判断 `getValue` 内部具体错误是什么；虽然可以给 `getValue` 方法多增加一个 `$error` 参数返回具体错误，但在外层也需要多做判断，无疑大大增加代码复杂度，这不是我们想要的。
- 依赖外层判断：在 `getValue` 方法内如果出现错误，例如某个值不存在，而这个值可能导致后续系统运行出现 BUG；如果我们直接返回 `null`，那就无法保证这个错误会在外部被处理，可能在外层代码压根不会有人判断，由此引发更大的隐患。

因此我们将代码进行优化，优化后：

```php
function actionIndex(){
    $result = 'ok';
    try{
        $foo = getValueByName('foo');
        $bar = getValueByName('bar');
    }
    catch(\Exception $e){
        $result = $e->message; // 读取异常的 message 属性
    }
    return $result;
}

function getValueByName($name){
    $value = Yii::$app->request->post($name);
    if($value === null) {
        throw new \Exception('value is null'); // 参数为 message 属性
    }
    else if(empty($value)) {
        throw new \Exception('value is empty'); // 参数为 message 属性
    }
    return $value;
}
```

如上，代码清爽了不少。而且既能在不改变原有函数结构的基础上，将错误信息完整地传递到外层；又可以保证异常一定会被处理，否则就会报错（例如显示 Yii 框架的错误页面）。

其实，异常应该按照类型进行区分，根据不同类型的异常做不同的处理，比较规范的做法应该如下：

```php
function actionIndex(){
    $result = 'ok';
    try{
        $foo = getValueByName('foo');
        $bar = getValueByName('bar');
    }
    catch(\yii\base\UnknownPropertyException $e){
        $result = $e->message . 'is null';
    }
    catch(\yii\base\InvalidValueException $e){
        $result = $e->message . 'is empty';
    }
    return $result;
}

function getValueByName($name){
    $value = Yii::$app->request->post($name);
    if($value === null) {
        throw new \yii\base\UnknownPropertyException($name);
    }
    else if(empty($value)) {
        throw new \yii\base\InvalidValueException($name);
    }
    return $value;
}
```

我们也可以自定义异常类，不过在大多数中小型系统的实际业务场景下，略显麻烦。

更多关于 PHP 异常处理的详细介绍，参见：<http://www.w3school.com.cn/php/php_exception.asp>

### Sentry

目前我已经在框架层面完全集成 Sentry SDK，配置文件位于 `core/config/web.php`。在非 debug 模式下，只要产生未被处理的异常，就会被 Sentry 捕捉并记录到服务器，同时产生一条事件记录，对应此记录的 `Event ID` 将会被显示在页面上：

> ![](https://gitee.com/uploads/images/2018/0523/102424_aa9f22eb_1941091.png)
>
> 注：此页面的 view 位于 `@app/views/error/` 目录下。

同时，你可以主动提交异常（`exception`）或消息（`message`）到 Sentry：

```php
// 提交异常
\Yii::$app->sentry->captureException($ex);

// 高级用法，附带其他数据
\Yii::$app->sentry->captureException($ex, [
    'extra' => [ // extra 必须为数组
        'foo' => 'bar',
        '...' => '...'
    ],
]);

// 提交消息
\Yii::$app->sentry->captureMessage('my log message');

// 高级用法，格式化消息并附带其他数据
// 注意，格式化消息是只有 captureMessage 方法才具备的特性
\Yii::$app->sentry->captureMessage('my %s message', ['log'], [
    'extra' => [ // extra 必须为数组
        'foo' => 'bar',
        '...' => '...'
    ],
    'level' => 'warning' // 默认 error
]);
```

另外，你还可以在某些关键点记录「日常运行产生的数据（`breadcrumbs`）」。这些数据将会在发生异常或消息时，作为附属数据一并被提交到 Sentry；而在运行正常时，是不会提交到 Sentry 的。

```php
\Yii::$app->sentry->breadcrumbs->record([
    'foo' => 'bar',
    '...' => '...',
]);
```

## 特性

### 调试模式

为了区别生产和调试环境，不同环境采用不同的日志级别、异常处理方式。目前，`index.php` 默认被定义为生产环境入口，原有 debug 特性迁移至 `debug.php` 以及 `.env` 文件。

简单来说，需要开启 debug 特性，有两种方法：

1. 在远程调试客户错误时，将 URL 中 `index.php` 修改为 `debug.php` 即可。
2. 开发过程中，本地在 `core` 文件夹下新建名为 `.env` 的文件，并配置环境变量即可（见下方说明）。

### 环境配置

环境配置（`env`）文件位于 `core/.env`；其文件模板位于 `core/.env.example`，根据情况取消注释即可。

业务代码中，可使用 `env($name, $defaultValue)` 函数读取环境变量的值。

### Git 分支

关于新增 dev 分支后，有两种方式将本地改动提交到远程 dev 分支。

- （1）

    ```bash
    git fetch origin dev ## fetch dev分支到本地
    git checkout dev ## 创建并切换到 dev 分支，且关联到远程的 dev 分支
    ```

- （2）

    ```bash
    git fetch origin dev ## fetch dev分支到本地
    git branch --set-upstream-to=origin/dev master ## 将本地 master 分支关联到远程 dev 分支
    ```

### 辅助函数

请查看：`core/helpers.php`。

### 缩略图

将图片地址修改如下即可：

`https://<DOMAIN>/<PATH_TO_CORE>/web/thumb.php?src=<IMG_PATH>&size=<WIDTH>x<HEIGHT>&zoom=1`

- DOMAIN：域名
- PATH_TO_CORE：指向 `core` 目录的 URL 地址
- IMG_PATH：服务器上的图片绝对路径（务必确保是路径而非 URL）
- WIDTH：预期宽度
- HEIGHT：预期高度

更多详细说明，请参见：<https://github.com/wi1dcard/thumb-php>

### 数据序列化

目前我已经将数据序列化写成 Yii Component，请使用：

```php
\Yii::$app->serializer->encode($data);
\Yii::$app->serializer->decode($data);
```

替代原有：

```php
serialize();
unserialize();
```

### 运行环境

运行 `core/web/tester.php` 即可，将会检查所需扩展是否安装、配置是否正常。

例如（点击链接查看示例图片）：

- [检查通过](https://gitee.com/uploads/images/2018/0531/101552_b76d9a4e_1941091.png)
- [检查不通过（`GD 扩展` 和 `Imagick 扩展` 均未安装）](https://gitee.com/uploads/images/2018/0531/101414_0f6f8c1e_1941091.png)

### 文件存储

用法参见：<https://github.com/wi1dcard/yii2-hejiang-storage>。

在本项目内，可使用如下方式获取 `StorageComponent` 实例；其余操作与扩展包文档一致。

```php
$storage = \Yii::$app->storage; // 获取 StorageComponent
// 或
$storage = \Yii::$app->storageTemp; // 获取用于存储临时文件的 StorageComponent
```

### 物流

用法参见：<https://github.com/wi1dcard/yii2-hejiang-express>。

### 短信

用法参见：<https://github.com/wi1dcard/yii2-hejiang-sms>。

### 事件

用法参见：<https://github.com/wi1dcard/yii2-hejiang-event>。

在本项目内，可使用如下方式获取 `EventDispatcher` 实例；其余操作与扩展包文档一致。

```php
$ed = \Yii::$app->eventDispatcher;
```

### 动作重定向

在 Controller 内，将某 Action 改为内部调用其它 Action，此种行为被称作 `动作重定向`。

在本项目内，可使用如下方式实现：

```php
class Controller
{
    public function actions()
    {
        return [
            'foo' => new \app\utils\RedirectAction('bar'), // 访问 `module/controller/foo` 将会被重定向至 `actionBar`
            // ...
        ];
    }

    public function actionBar()
    {
        return 'bar';
    }
}
```

### 控制器重定向

参见：<https://wi1dcard.github.io/tutorials/yii2-redirect-controller-in-module/>

本项目已集成至 `app\modules\mch\Module`，在此类的实例内，可使用如下方式实现：

```php
$this->redirectController('bar', 'foo'); // 将 foo（虚拟控制器）重定向至 bar（实际控制器）

// 或者批量方式...

$map = [
    'foo' => 'bar',
    'foo/bar' => 'bar/foo'
];
array_walk($map, [$this, 'redirectController']);
```

### 响应下载

参见：<https://wi1dcard.github.io/snippets/yii2-response-send-file/>

## 工具集

如无特别说明，以下列出均为 Linux 命令；Windows 下可以使用 Git Bash 运行。

### Git 仓库总文件数

```bash
git ls-tree -r --name-only HEAD | wc -l
```

### 批量替换数据库字段

参见：<https://wi1dcard.github.io/snippets/mysql-replace-text-in-all-fields/>

### 检查 Code-Standard

执行检查：

```bash
composer check-cs <DIR_OR_FILE>
```

尝试自动修复：

```bash
composer fix-cs <DIR_OR_FILE>
```

## 已知 Issues

- WDCP 面板 Nginx + Apache 无法检测 HTTPS

    修改 `/www/wdlinux/nginx/conf/naproxy.conf`，新增一行 `proxy_set_header X-Forwarded-Proto $scheme;` 即可。

- 宝塔面板上传文件 `sha1_file` 失败

    `sha1_file(): open_basedir restriction in effect. File(/www/wwwroot/tmp/***) is not within the allowed path(s): (***)`

    宝塔面板创建站点时默认添加 `.user.ini`，文件内包含 `open_basedir` 环境变量，参见<https://blog.csdn.net/fdipzone/article/details/54562656>。解决方案有二：

    1. 删除 `.user.ini` 文件。
    2. 在 `open_basedir=***` 后追加 `:` + 报错信息内文件所在目录，例如 `/www/wwwroot/tmp/***`。

- AMH 面板重复加载 MySQL 扩展

    `PHP Warning:  Module 'mysql' already loaded in Unknown on line 0`

    解决方案：

    打开对应环境的 `php.ini` 配置文件（通常位于 `/home/wwwroot/<ENV>/etc/amh-php.ini`），使用 `#` 或 `;` 注释 `extension=mysql.so` 此行即可。