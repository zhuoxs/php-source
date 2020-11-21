<form class="layui-form layui-form-pane" action="{:url()}" method="post" id="editForm">
    <div class="layui-form-item">
        <label class="layui-form-label">公告标题</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="title"  value="{$info['title']}"   autocomplete="off" placeholder="请输入公告标题" style="width: 650px;padding-right:10px; ">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">展示方式</label>
        <div class="layui-input-inline">
            <select name="type" class="field-role_id" type="select"   lay-skin="switch" lay-filter="type"  >
                <option value="1" >弹出层展示</option>
                <option value="2" >新页面展示</option>
            </select>
        </div>
        <div class="layui-form-mid layui-word-aux">内容展示方式，当用户点击公告标题后的内容展示形式选择</div>
    </div>

    <div class="layui-form-item" id='content'>
        <label class="layui-form-label">展示内容</label>
        <div class="layui-input-inline">
            <textarea rows="6" class="layui-textarea" name="content" autocomplete="off" placeholder="请填写弹出层展示的内容"  style="width: 650px;padding-right:10px; ">
            {$info['content']}
            </textarea>
        </div>
    </div>
    <div class="layui-form-item" id='url' style="display: none">
        <label class="layui-form-label">外链网址</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="url" value="{$info['url']}"    autocomplete="off" placeholder="请输入外链网址" style="width: 650px;padding-right:10px; ">
        </div>
    </div>
    <script>
        layui.use('form', function(){
            var $ = layui.jquery;
            var form = layui.form;
            form.on('select(type)', function(data){
                if(data.value == 1){
                    $('#url').hide();
                    $('#content').show();
                }else{
                    $('#url').show();
                    $('#content').hide();
                }
            });
        });
    </script>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-username" name="sort" value="{$info['sort']}"    autocomplete="off" placeholder="请输入排序编号">
        </div>
        <div class="layui-form-mid layui-word-aux">数值越小越靠前</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">公告有效期</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input field-expire_time" name="out_time"  value="{$info['out_time']}"  autocomplete="off" placeholder="请设置公告有效期" onclick="layui.laydate({elem: this,format:'YYYY-MM-DD'})" readonly>
        </div>
        <div class="layui-form-mid layui-word-aux">过期后公告将不再显示</div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        <input type="hidden" name="id" value="{$info['id']}">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
            <a href="{:url('index')}" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
        </div>
    </div>
</form>
<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/plupload-2.3.6/js/plupload.full.min.js"></script><script src="/static/plupload-2.3.6/js/i18n/zh_CN.js"></script>
<script src="/static/xuploader/webServerUploader.js"></script>
<script src="/static/js/XCommon.js"></script>
<script>
var formData = {:json_encode($data_info)};

layui.use(['jquery', 'laydate'], function() {
    var $ = layui.jquery, laydate = layui.laydate;
    laydate.render({
        elem: '.field-expire_time',
        min:'0'
    });

    $('#reset_expire').on('click', function(){
        $('input[name="expire_time"]').val(0);
    });
});
</script>
<script src="__ADMIN_JS__/footer.js"></script>