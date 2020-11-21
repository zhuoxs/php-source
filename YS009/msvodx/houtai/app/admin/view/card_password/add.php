<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>添加卡密</legend>
        </fieldset>


        <div class="layui-form-item">
            <label class="layui-form-label">卡密价格</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="price" autocomplete="off" placeholder="请填写卡密价格" lay-verify="required|number">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开卡数量</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="number" autocomplete="off" placeholder="请填写要生成的多少张卡密" lay-verify="required|number">
            </div>
            <div class="layui-form-mid layui-word-aux"> PS : 最多 1 次只能生成 1000 张</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">充值有效期</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" name="out_day" autocomplete="off" placeholder="请填写卡密有效天数" lay-verify="required|number">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">卡密类型</label>
            <div class="layui-input-inline">
                <select name="card_type" class="field-role_id" type="select"  lay-skin="switch" lay-filter="card_type"  >
                    <option value="1">会员卡</option>
                    <option value="2" >金币卡</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item" id="vip_box" style="display: block">
            <div class="layui-form-item">
                <label class="layui-form-label">是否是永久套餐</label>
                <div class="layui-input-inline">
                    <input type="checkbox" name="permanent"  lay-skin="switch" lay-text="是|否" lay-filter='permanent' >
                </div>
                <div class="layui-form-mid layui-word-aux"></div>
            </div>

            <div class="layui-form-item" id="days" style="display: block">
                <label class="layui-form-label">会员天数</label>
                <div class="layui-input-inline">
                    <input type="text"  class="layui-input" name="vip_time" autocomplete="off" placeholder="请填写会员天数" >
                </div>
            </div>
        </div>
        <div class="layui-form-item" id="gold_box" style="display: none">
                <label class="layui-form-label">金币数量</label>
                <div class="layui-input-inline">
                    <input type="text"  class="layui-input" name="gold" autocomplete="off" placeholder="请填写金币数量" >
                </div>
        </div>
        <!--
        <div class="layui-form-item">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-inline">
                <textarea rows="6" class="layui-textarea" name="info" autocomplete="off" placeholder="请填写描述"></textarea>
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>-->
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
    .layui-form-pane .layui-input-block {margin-left: 150px;}
</style>
<script>
    layui.use('form', function(){
        var $ = layui.jquery;
        var form = layui.form;
        form.on('switch(permanent)', function(data){
            if(this.checked == true){
                $('#days').hide();
            }else{
                $('#days').show();
            }
        });
        form.on('select(card_type)', function(data){
            if(data.value == 2){
                $('#gold_box').show();
                $('#vip_box').hide();
            }else{
                $('#vip_box').show();
                $('#gold_box').hide();
            }
        });
    });
</script>
