<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        <div class="layui-collapse page-tips">
            <div class="layui-colla-item">
                <h2 class="layui-colla-title">温馨提示<i class="layui-icon layui-colla-icon"></i></h2>
                <div class="layui-colla-content layui-show">
                    <p>1. 本功能可将云转码转码后的视频自动入库。</p>
                    <p>2. 在使用自动入库前请确认 <span style="color:red;">附件设置->云转码服务器地址</span> 已配置正确，否则自动入库将会失败。</p>
                    <p>3. 请在云转码后台设置 <span style="color:red;">系统设置->系统设置->API通知</span>为： <b style="background-color: #000;color:#FFF;border-radius: 5px;padding:5px;">http://您的域名/video/syncAddVideo</b> </p>
                </div>
            </div>
        </div>

        <fieldset class="layui-elem-field layui-field-title">
            <legend>云转码相关设置</legend>
        </fieldset>

        <div class="layui-form-item">
            <label class="layui-form-label">播放域名</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="yzm_video_play_domain" value="{$config['yzm_video_play_domain']}" autocomplete="off" placeholder="播放域名">列子：http://127.0.0.1:2100/
            </div>
            <div class="layui-form-mid layui-word-aux">同云转码后台:系统设置->域名设置->播放域名、播放端口号(<b style="color:red;">云转码版本小于4.0的请不要填写端口号，否则应包括播放端口号</b>)</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">API密钥</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="yzm_api_secretkey" value="{$config['yzm_api_secretkey']}" autocomplete="off" placeholder="请填写API密钥">
            </div>
            <div class="layui-form-mid layui-word-aux">同云转码后台： 系统设置->系统设置->API密钥</div>
        </div>

        <fieldset class="layui-elem-field layui-field-title">
            <legend>视频入库相关设置</legend>
        </fieldset>

        <div class="layui-form-item">
            <label class="layui-form-label">入库到分类</label>
            <div class="layui-input-inline">
                    <div class="layui-input-inline">
                        <select name="sync_add_video_classid" class="field-pid" type="select" lay-filter="pai">
                            {volist name="classlist" id="v" }
                            <option value="{$v['id']}" level="{$v['id']}" {if $v['id']==$config['sync_add_video_classid']}selected="selected"{/if}>|-{$v['name']}</option>
                            {volist name="v['childs']" id="vv" }
                            <option value="{$vv['id']}"  {if $vv['id']==$config['sync_add_video_classid']}selected{/if} level="{$vv['id']}">&nbsp;&nbsp;&nbsp;&nbsp;|-{$vv['name']}</option>
                            {/volist}
                            {/volist}
                        </select>
                    </div>
            </div>
            <div class="layui-form-mid layui-word-aux">同云转码后台： 系统设置->域名设置->播放域名</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否需要审核</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="sync_add_video_need_review"  lay-skin="switch" lay-text="审核|不审" {if condition="$config['sync_add_video_need_review'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">不审核：视频将在入库后便可观看，否则审核后才能观看</div>
        </div>


        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" class="field-id" name="id">
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

    });
</script>
