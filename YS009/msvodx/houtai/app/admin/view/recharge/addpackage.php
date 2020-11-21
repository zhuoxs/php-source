<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>添加充值套餐</legend>
        </fieldset>


        <div class="layui-form-item">
            <label class="layui-form-label">套餐名字</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="name" autocomplete="off" placeholder="请填写套餐名字">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">是否是永久套餐</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="permanent"  lay-skin="switch" lay-text="是|否" lay-filter='permanent' >
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>

        <div class="layui-form-item" id="days" style="display: block">
            <label class="layui-form-label">套餐天数</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="days" autocomplete="off" placeholder="请填写套餐天数">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="sort" autocomplete="off" placeholder="请填写排序值">
            </div>
            <div class="layui-form-mid layui-word-aux">数值越大越靠前</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">价格</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="price" autocomplete="off" placeholder="请填写套餐价格">
            </div>
            <div class="layui-form-mid layui-word-aux">元</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-inline">
                <textarea rows="6" class="layui-textarea" name="info" autocomplete="off" placeholder="请填写描述"></textarea>
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
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
        form.on('switch(permanent)', function(data){
//            console.log(this.checked);
            if(this.checked == true){
                $('#days').hide();
            }else{
                $('#days').show();
            }

        });
    });
</script>
