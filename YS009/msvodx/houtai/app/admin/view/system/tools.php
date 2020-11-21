<!--刷新前端缓存  begin -->
<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>刷新前端缓存数据</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label" >前端网址</label>
            <div class="layui-input-inline">
                <input type="text"  class="layui-input" id="refresh_cache_domain" autocomplete="off" value="{$web_server_url}" placeholder="格式 http://www.msvodx.com">
            </div>
            <button type="button" class="layui-btn" id="btn_refresh_cache">刷新缓存</button>
        </div>
    </form>
</div>
<style type="text/css">
    .layui-form-item .layui-form-label{width:150px;}
    .layui-form-item .layui-input-inline{max-width:80%;width:auto;min-width:320px;}
    .layui-field-title:not(:first-child){margin: 30px 0}
</style>
<script type="text/javascript">
    layui.use('form', function() {
        var $ = layui.jquery;

        $("#btn_refresh_cache").click(function(){refreshCache()});

        function refreshCache(){
            if($("#refresh_cache_domain").val()=='')
            {
                $("#refresh_cache_domain").focus();
                layer.msg('请填写正确的域名后再试！');
            }else{
                $.post($("#refresh_cache_domain").val()+"/api/refreshCache",{_ajax:true},function(resp){
                    console.log(resp);
                    if(resp.statusCode==0){
                        layer.msg('刷新缓存成功!');
                    }else{
                        layer.msg('刷新缓存失败，请确认您的域名是否正确!');
                    }
                },'JSON');
            }
        }


    });
</script>
<!--刷新前端缓存  end -->

<script type="text/javascript">
    layui.use('form', function() {
        var $ = layui.jquery;

        $("#btn_replace_domain1").click(function(){
            layer.open('aaa',{btns:['确定','取消']});
        });




    });
</script>