<style>
    .layui-form-pane .layui-input-inline{
        margin:10px;
        height: 250px;
        width: 220px;
        border:2px solid #e1e1e1;
        overflow: hidden;
        text-align: center;
    }

    .layui-form-pane .layui-input-inline:hover{
        border:2px solid #FF5722;
    }

    .description{
        height:70px;
        overflow-y:auto;
        overflow-x:hidden;
        padding:0 15px;
        line-height: 1.5em;
        text-align: left;

    }

    .description::-webkit-scrollbar {
        width: 8px;
        background-color: #c1c1c1;
    }

    .description::-webkit-scrollbar-thumb {
        background-color:#ff4400;
        -webkit-border-radius: 2em;
        -moz-border-radius: 2em;
        border-radius:2em;
    }

    .view{
        position: absolute;bottom:2px;right:2px;border-radius: 12px;border:1px solid #c5c5c5;padding:2px 12px;
        background-color:#c1c1c1;
    }
    .view:hover{background-color: #ff4400;}
    .view a{color:#fff;}
    .view a:hover{color:#fff;}

</style>
<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('replaceResourceUrl')}" id="editForm" method="post">
        <div class="layui-form-item">
            {if is_array($themeList)}
            {volist name='themeList' id='theme'}
            <div class="layui-input-inline">
                <div class="view"><a href="{$webUrl}?t={$theme['basename']}" target="_blank">预览</a></div>
                <input type="radio" {if $theme['basename']==$curTheme}checked{/if} class="layui-checkbox checkbox-ids" name="theme_basename" title="{$theme['title']}" value="{$theme['basename']}">
                <a href="{$theme['thumb']}" target="_blank" title="点击查看大图"> <img src="{$theme['thumb']}" style="max-height: 200px;max-width: 200px;" /> </a>
                <div class="description">{$theme['description']}</div>
            </div>
            {/volist}
            {else/}
            <span style="color:red;">当前无主题可切换.</span>
            {/if}
        </div>
        <button type="button" data-href="#" class="layui-btn layui-btn-danger j-page-btns confirm" id="btn_replace_domain">保存</button>
    </form>
</div>
<script type="text/javascript">
    layui.use('form', function() {
        var $ = layui.jquery;

        $("#btn_replace_domain1").click(function(){
            layer.open('aaa',{btns:['确定','取消']});
        });




    });
</script>