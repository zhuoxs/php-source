<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="#" id="editForm" method="post">
        <div class="layui-collapse page-tips">
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">设置规则<i class="layui-icon layui-colla-icon"></i></h2>
                <div class="layui-colla-content layui-show">
                    <p>1. 每行一条友情链接,以回车链换行</p>
                    <p>2. 单条规则：链接名称|网址,例：<span style="background-color: #000;color:#FFF;border-radius: 5px;padding:2px 5px;">YM源码|https://www.ymyuanma.com</span></p>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">友情链接</label>
            <div>
                <textarea class="layui-input" name="friend_link" style="height:300px;">{$config['friend_link']}</textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" style="margin-left: -108px;" lay-filter="formSubmit">保存</button>
            </div>
        </div>
    </form>

</div>
<style type="text/css">
    .layui-form-item .layui-form-label{width:150px;}
    .layui-form-item .layui-input-inline{max-width:80%;width:auto;min-width:320px;}
    .layui-field-title:not(:first-child){margin: 30px 0}
</style>
<script>
    layui.use('form', function(){
        var $ = layui.jquery;
        var form = layui.form;

    });
</script>
