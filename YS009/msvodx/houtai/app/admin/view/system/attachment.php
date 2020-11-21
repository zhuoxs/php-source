<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" id="attachment_setting" name="attachment_setting" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">图片存储方式</label>
            <div class="layui-input-inline">
                <select class="field-role_id" lay-verify="checkSaveType" name="image_save_server_type" id="image_save_server_type"  lay-skin="switch" lay-filter="image_save_server_type"  >
                    <option value="web_server" {if condition="$config['image_save_server_type'] eq 'web_server'"}selected{/if}>web服务器</option>
                    <option value="qiniuyun" {if condition="$config['image_save_server_type'] eq 'qiniuyun'"}selected{/if}>七牛云存储</option>
                    <option value="aliyunoss" {if condition="$config['image_save_server_type'] eq 'aliyunoss'"}selected{/if}>阿里云存储</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">视频存储方式</label>
            <div class="layui-input-inline">
                <select class="field-role_id" lay-verify="checkSaveType" name="video_save_server_type" id="video_save_server_type"  lay-skin="switch" lay-filter="video_save_server_type"  >
                    <option value="web_server" {if condition="$config['video_save_server_type'] eq 'web_server'"}selected{/if}>web服务器</option>
                    <option value="qiniuyun" {if condition="$config['video_save_server_type'] eq 'qiniuyun'"}selected{/if}>七牛云存储</option>
                    <option value="aliyunoss" {if condition="$config['video_save_server_type'] eq 'aliyunoss'"}selected{/if}>阿里云存储</option>
                </select>
            </div>
        </div>

        <fieldset class="layui-elem-field layui-field-title">
            <legend>Web服务器设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">Web服务器URL</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="web_server_url" id="web_server_url" value="{$config['web_server_url']}" autocomplete="off" placeholder="请填写Web服务器URL">
            </div>
            <div class="layui-form-mid layui-word-aux">直接填写Web服务器(您的前端网站)的「url」(<b style="color:red;">应包括端口号，应包含http/https协议头</b>)</div>
        </div>

        <fieldset class="layui-elem-field layui-field-title">
            <legend>七牛云存储设置</legend>
        </fieldset>

        <div class="layui-form-item">
            <label class="layui-form-label">存储区域</label>
            <div class="layui-input-inline">
                <select  name="qiniu_upload_server" id="qiniu_upload_server" lay-skin="switch" lay-filter="qiniu_upload_server"  >
                    <option value="华东" {if condition="$config['qiniu_upload_server'] eq '华东'"}selected{/if} >华东(z0)</option>
                    <option value="华北" {if condition="$config['qiniu_upload_server'] eq '华北'"}selected{/if} >华北(z1)</option>
                    <option value="华南" {if condition="$config['qiniu_upload_server'] eq '华南'"}selected{/if} >华南(z2)</option>
                    <option value="北美" {if condition="$config['qiniu_upload_server'] eq '北美'"}selected{/if} >北美(na0)</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">外链默认域名</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="qiniu_resource_default_domain" id="qiniu_resource_default_domain" value="{$config['qiniu_resource_default_domain']|default=''}" autocomplete="off" placeholder="请填写七牛外链默认域名">
            </div>
            <div class="layui-form-mid layui-word-aux">七牛官网申请，<a target="_blank" href="https://www.qiniu.com">点击申请</a></div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">AccessKey</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="qiniu_accesskey" id="qiniu_accesskey" value="{$config['qiniu_accesskey']}" autocomplete="off" placeholder="请填写七牛AccessKey">
            </div>
            <div class="layui-form-mid layui-word-aux">七牛官网申请，<a target="_blank" href="https://www.qiniu.com">点击申请</a></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">SecretKey</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="qiniu_secretkey" id="qiniu_secretkey" value="{$config['qiniu_secretkey']}" autocomplete="off" placeholder="请填写七牛AccessKey">
            </div>
            <div class="layui-form-mid layui-word-aux">七牛官网申请，<a target="_blank" href="https://www.qiniu.com">点击申请</a></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">Bucket</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="qiniu_bucket" id="qiniu_bucket" value="{$config['qiniu_bucket']}" autocomplete="off" placeholder="请填写七牛AccessKey">
            </div>
            <div class="layui-form-mid layui-word-aux">你的七牛云存储仓库名称</div>
        </div>

        <!--杭州、上海、青岛、北京、张家口、深圳、香港、硅谷、弗吉尼亚、新加坡、悉尼、日本、法兰克福、迪拜-->
        <fieldset class="layui-elem-field layui-field-title">
            <legend>阿里云存储(OSS)设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">存储服务器地址</label>
            <div class="layui-input-inline">
                <select  name="aliyun_oss_city" id="aliyun_oss_city" lay-skin="switch" lay-filter="aliyun_oss_city"  >
                    <option value="深圳" {if condition="$config['aliyun_oss_city'] eq '深圳'"}selected{/if}>深圳</option>
                    <option value="杭州" {if condition="$config['aliyun_oss_city'] eq '杭州'"}selected{/if}>杭州</option>
                    <option value="上海" {if condition="$config['aliyun_oss_city'] eq '上海'"}selected{/if}>上海</option>
                    <option value="青岛" {if condition="$config['aliyun_oss_city'] eq '青岛'"}selected{/if}>青岛</option>
                    <option value="北京" {if condition="$config['aliyun_oss_city'] eq '北京'"}selected{/if}>北京</option>
                    <option value="张家" {if condition="$config['aliyun_oss_city'] eq '张家口'"}selected{/if}>张家口</option>
                    <option value="香港" {if condition="$config['aliyun_oss_city'] eq '香港'"}selected{/if}>香港</option>
                    <option value="硅谷" {if condition="$config['aliyun_oss_city'] eq '硅谷'"}selected{/if}>硅谷</option>
                    <option value="弗吉尼亚" {if condition="$config['aliyun_oss_city'] eq '弗吉尼亚'"}selected{/if}>弗吉尼亚</option>
                    <option value="新加坡" {if condition="$config['aliyun_oss_city'] eq '新加坡'"}selected{/if}>新加坡</option>
                    <option value="悉尼" {if condition="$config['aliyun_oss_city'] eq '悉尼'"}selected{/if}>悉尼</option>
                    <option value="日本" {if condition="$config['aliyun_oss_city'] eq '日本'"}selected{/if}>日本</option>
                    <option value="法兰克福" {if condition="$config['aliyun_oss_city'] eq '法兰克福'"}selected{/if}>法兰克福</option>
                    <option value="迪拜" {if condition="$config['aliyun_oss_city'] eq '迪拜'"}selected{/if}>迪拜</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">AccessKeyId</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="aliyun_accesskey" id="aliyun_accesskey" value="{$config['aliyun_accesskey']}" autocomplete="off" placeholder="请填写AccessKeyId">
            </div>
            <div class="layui-form-mid layui-word-aux">阿里云官网申请，<a target="_blank" href="https://wanwang.aliyun.com">点击申请</a></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">AccessKeySecret</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="aliyun_secretkey" id="aliyun_secretkey" value="{$config['aliyun_secretkey']}" autocomplete="off" placeholder="请填写AccessKeySecret">
            </div>
            <div class="layui-form-mid layui-word-aux">阿里云官网申请，<a target="_blank" href="https://wanwang.aliyun.com">点击申请</a></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">Bucket</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="aliyun_bucket"  id="aliyun_bucket" value="{$config['aliyun_bucket']}" autocomplete="off" placeholder="请填写Bucket">
            </div>
            <div class="layui-form-mid layui-word-aux">你的阿里云存储仓库名称</div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit lay-filter="formSubmit">提交</button>
            </div>
        </div>

    </form>
</div>
<style type="text/css">
    .layui-form-item .layui-form-label{width:150px;}
    .layui-form-item .layui-input-inline{max-width:80%;width:auto;min-width:400px;}
    .layui-field-title:not(:first-child){margin: 30px 0}
</style>
<script>
    layui.use('form', function(){
        var $ = layui.jquery;
        var form = layui.form;

        form.verify({
            checkSaveType:function(value,item){
                if(value=='') return '储存方式不能为空！';

                //根据其值判断对应的设置是否有效
                if(value=='yunzhuanma'){
                    if($('#yzm_upload_url').val()=='' || $('#yzm_play_secretkey').val()==''){
                        $("#yzm_upload_url").focus();
                        return "请完善云转码配置！"
                    }
                }

                if(value=='qiniuyun'){
                    if($('#qiniu_accesskey').val()=='' || $('#qiniu_secretkey').val()=='' || $('#qiniu_bucket').val()==''){
                        $("#qiniu_accesskey").focus();
                        return "请完善七牛存储配置！"
                    }
                }

                if(value=='aliyunoss'){
                    if($('#aliyun_accesskey').val()=='' || $('#aliyun_secretkey').val()=='' || $('#aliyun_bucket').val()==''){
                        $("#aliyun_accesskey").focus();
                        return "请完善阿里云存储配置！"
                    }
                }

            },


        });


        form.on('submit(formSubmit)',function(data){
            console.log(data);
            //return true;
        });
    });
</script>
