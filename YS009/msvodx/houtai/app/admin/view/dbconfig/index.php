<div class="layui-tab-item layui-show">
    <!--
    +----------------------------------------------------------------------
    | 添加修改实例模板，可直接复制以下代码使用
    | select元素需要加type="select"
    | 所有可编辑的表单元素需要按以下格式添加class名：class="field-字段名"
    +----------------------------------------------------------------------
    -->

    <form class="layui-form layui-form-pane" action="{:url()}" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>数据库配置</legend>
        </fieldset>
        <form class="layui-form layui-form-pane" action="?step=4" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label">服务器地址</label>
                <div class="layui-input-inline w200">
                    <input type="text" class="layui-input" name="hostname" lay-verify="title" value="{$config['hostname']}">
                </div>
                <div class="layui-form-mid layui-word-aux">数据库服务器地址，一般为127.0.0.1</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">数据库端口</label>
                <div class="layui-input-inline w200">
                    <input type="text" class="layui-input" name="hostport" lay-verify="title" value="{$config['hostport']}">
                </div>
                <div class="layui-form-mid layui-word-aux">系统数据库端口，一般为3306</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">数据库名称</label>
                <div class="layui-input-inline w200">
                    <input type="text" class="layui-input" name="database" lay-verify="title" value="{$config['database']}" >
                </div>
                <div class="layui-form-mid layui-word-aux">系统数据库名,必须包含字母</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">数据库账号</label>
                <div class="layui-input-inline w200">
                    <input type="text" class="layui-input" name="username" lay-verify="title" value="{$config['username']}"  autocomplete="off" >
                </div>
                <div class="layui-form-mid layui-word-aux">连接数据库的用户名</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">数据库密码</label>
                <div class="layui-input-inline w200">
                    <input type="password" class="layui-input" name="password" lay-verify="title"  value=""  autocomplete="off" >
                </div>
                <div class="layui-form-mid layui-word-aux">连接数据库的密码</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">数据库前缀</label>
                <div class="layui-input-inline w200">
                    <input type="text" class="layui-input" name="prefix" lay-verify="title" value="{$config['prefix']}">
                </div>
                <div class="layui-form-mid layui-word-aux">建议使用默认,数据库前缀必须带 '_'</div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <input type="hidden" class="field-id" name="id">
                    <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
                </div>
            </div>
    </form>
</div>
<div class="layui-tab-item">
    <style type="text/css">
    .site-demo-code{
    left: 0;
    top: 0;
    width: 100%;
    height: 600px;
    border: none;
    padding: 10px;
    font-size: 12px;
    background-color: #F7FBFF;
    color: #881280;
    font-family: Courier New;}
    </style>
    <textarea class="layui-border-box site-demo-text site-demo-code" spellcheck="false" readonly>
<!--
+----------------------------------------------------------------------
| 添加修改实例模板，Ctrl+A 可直接复制以下代码使用
| select元素需要加type="select"
| 所有可编辑的表单元素需要按以下格式添加class名：class="field-字段名"
+----------------------------------------------------------------------
-->
<div class="layui-collapse page-tips">
  <div class="layui-colla-item">
    <h2 class="layui-colla-title">温馨提示</h2>
    <div class="layui-colla-content">
      <p>此页面为后台[添加/修改]标准模板，您可以直接复制使用修改</p>
    </div>
  </div>
</div>
<script>
/* 修改模式下需要将数据放入此变量 */
var formData = {literal}{:json_encode($data_info)};{/literal}
// 会员选择回调函数
function func(data) {
    var $ = layui.jquery;
    $('input[name="member"]').val('['+data[0]['id']+']'+data[0]['username']);
}
layui.use(['upload'], function() {
    var $ = layui.jquery, layer = layui.layer, upload = layui.upload;
    /**
     * 附件上传url参数说明
     * @param string $from 来源
     * @param string $group 附件分组,默认sys[系统]，模块格式：m_模块名，插件：p_插件名
     * @param string $water 水印，参数为空默认调用系统配置，no直接关闭水印，image 图片水印，text文字水印
     * @param string $thumb 缩略图，参数为空默认调用系统配置，no直接关闭缩略图，如需生成 500x500 的缩略图，则 500x500多个规格请用";"隔开
     * @param string $thumb_type 缩略图方式
     * @param string $input 文件表单字段名
     */
    upload.render({
        elem: '.layui-upload'
        ,url: '{literal}{:url("admin/annex/upload?water=&thumb=&from=&group=")}{/literal}'
        ,method: 'post'
        ,before: function(input) {
            layer.msg('文件上传中...', {time:3000000});
        },done: function(res, index, upload) {
            var obj = this.item;
            if (res.code == 0) {
                layer.msg(res.msg);
                return false;
            }
            layer.closeAll();
            var input = $(obj).parents('.upload').find('.upload-input');
            if ($(obj).attr('lay-type') == 'image') {
                input.siblings('img').attr('src', res.data.file).show();
            }
            input.val(res.data.file);
        }
    });
});
</script>

    </textarea>
</div>

<script>
/* 修改模式下需要将数据放入此变量 */
var formData = {"id":1,"role_id":1,"nick":"\u8d85\u7ea7\u7ba1\u7406\u5458","email":"chenf4hua12@qq.com","mobile":13888888888,"status":0};
// 会员选择回调函数
function func(data) {
    var $ = layui.jquery;
    $('input[name="member"]').val('['+data[0]['id']+']'+data[0]['username']);
}

<script src="__ADMIN_JS__/footer.js"></script>