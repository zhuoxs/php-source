<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>网站设置</legend>
        </fieldset>

        <div class="layui-form-item">
            <label class="layui-form-label">网站状态</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="site_status"  lay-skin="switch" lay-text="开启|关闭" {if condition="$config['site_status'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">站点关闭后客户界面将不能访问</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">手机网站</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="wap_site_status" lay-skin="switch" lay-text="开启|关闭" {if condition="$config['wap_site_status'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">如果有手机网站，请设置为开启状态，否则只显示PC网站</div>
        </div>

        <!--<div class="layui-form-item">
            <label class="layui-form-label">是否开启伪静态</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="wap_site_status" lay-skin="switch" lay-text="开启|关闭" {if condition="$config['wap_site_status'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">开启的情况下，可以支持html等后缀的访问形式</div>
        </div>-->

        <div class="layui-form-item">
            <label class="layui-form-label">网站LOGO</label>
            <div class="layui-input-inline upload">
                <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload"  id="upload_logo_chose_btn"">{if condition="empty($config['site_logo'])"}请上传网站Logo{else}更改Logo{/if}</button>
                <input type="hidden" class="upload-input" name="site_logo" id="site_logo" value="{$config['site_logo']}">
                <img src="{$config['site_logo']}" id="img_logo" onmouseover="imgTips(this,{width:400,className:'imgTips',bgColor:'#fff'})" style="display:block;border-radius:5px;border:1px solid #ccc;max-width: 200px;min-width: 200px;margin-top:5px;">
            </div>
            <div class="layui-form-mid layui-word-aux"> 网站LOGO图片</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">手机站LOGO</label>
            <div class="layui-input-inline upload">
                <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload"  id="upload_logo_chose_mobile_btn"">{if condition="empty($config['site_logo_mobile'])"}请上传手机站Logo{else}更改Logo{/if}</button>
                <input type="hidden" class="upload-input" name="site_logo_mobile" id="site_logo_mobile" value="{$config['site_logo_mobile']}">
                <img src="{$config['site_logo_mobile']}" id="img_logo_mobile" onmouseover="imgTips(this,{width:400,className:'imgTips',bgColor:'#fff'})" style="display:block;border-radius:5px;border:1px solid #ccc;max-width: 200px;min-width: 200px;margin-top:5px;">
            </div>
            <div class="layui-form-mid layui-word-aux"> 推荐尺寸:210x70px(宽x高)</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">网站收藏图标</label>
            <div class="layui-input-inline upload">
                <button type="button" name="upload" class="layui-btn layui-btn-primary layui-upload"  id="upload_ico_chose_btn">{if condition="empty($config['site_favicon'])"}请上传网站图标{else}更改图标{/if}</button>
                <input type="hidden" class="upload-input" name="site_favicon" id="site_favicon" value="{$config['site_favicon']}">
                <img id="img_ico" onmouseover="imgTips(this,{width:100,className:'imgTips'})" src="{$config['site_favicon']}" style="border-radius:5px;border:1px solid #ccc" width="36" height="36">
            </div>
            <div class="layui-form-mid layui-word-aux"> 又叫网站收藏夹图标，它显示位于浏览器的地址栏或者标题前面，<strong class="red">.ico格式</strong>，<a href="https://www.baidu.com/s?ie=UTF-8&amp;wd=favicon" target="_blank">点此了解网站图标</a></div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">网站标题</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="site_title" value="{$config['site_title']}" autocomplete="off" placeholder="请填写网站标题">
            </div>
            <div class="layui-form-mid layui-word-aux">网站标题是体现一个网站的主旨，要做到主题突出、标题简洁、连贯等特点，建议不超过28个字</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">网站关键词</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="site_keywords" value="{$config['site_keywords']}" autocomplete="off" placeholder="请填写网站关键词">
            </div>
            <div class="layui-form-mid layui-word-aux">网页内容所包含的核心搜索关键词，多个关键字请用英文逗号","分隔</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">网站描述</label>
            <div class="layui-input-inline">
                <textarea rows="6" class="layui-textarea" name="site_description" autocomplete="off" placeholder="请填写网站描述"  >{$config['site_description']}</textarea>
            </div>
            <div class="layui-form-mid layui-word-aux">网页的描述信息，搜索引擎采纳后，作为搜索结果中的页面摘要显示，建议不超过80个字</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">客服QQ</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="site_qq" value="{$config['site_qq']}" autocomplete="off" placeholder="请填写客服QQ">
            </div>
            <div class="layui-form-mid layui-word-aux">站点客服QQ，方便用户咨询</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">ICP备案信息</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="site_icp" value="{$config['site_icp']}" autocomplete="off" placeholder="请填写ICP备案信息">
            </div>
            <div class="layui-form-mid layui-word-aux">请填写ICP备案号，用于展示在网站底部，ICP备案官网：<a href="http://www.miibeian.gov.cn" target="_blank">http://www.miibeian.gov.cn</a></div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">站点统计代码</label>
            <div class="layui-input-inline">
                <textarea rows="6" class="layui-textarea" name="site_statis" autocomplete="off" placeholder="请填写站点统计代码"  >{$config['site_statis']}</textarea>
            </div>
            <div class="layui-form-mid layui-word-aux">第三方流量统计代码，前台调用时请先用 htmlspecialchars_decode函数转义输出</div>
        </div>

        <fieldset class="layui-elem-field layui-field-title">
            <legend>金币设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">金币汇率</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="gold_exchange_rate" value="{$config['gold_exchange_rate']}" autocomplete="off" placeholder="金币跟人民币的比率">
            </div>
            <div class="layui-form-mid layui-word-aux">1元人民币可兑换的金币个数,如1元可兑换10金币则填写10</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">是否允许提现</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="is_withdrawals"  lay-skin="switch" lay-text="开启|关闭" {if condition="$config['is_withdrawals'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">是否允许金币提现</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">提现频率</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="withdrawals_frequency" value="{$config['withdrawals_frequency']}" autocomplete="off" placeholder="输入间隔小时">
            </div>
            <div class="layui-form-mid layui-word-aux">单位小时：提交了提现申请之后多久可以再次申请</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">提现最低限额</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="min_withdrawals" value="{$config['min_withdrawals']}" autocomplete="off" placeholder="输入最低提现金币数">
            </div>
            <div class="layui-form-mid layui-word-aux">申请提现最低提现金币数</div>
        </div>


        <fieldset class="layui-elem-field layui-field-title">
            <legend>奖励设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">注册奖励</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="register_reward" value="{$config['register_reward']}" autocomplete="off" placeholder="请填写奖励金币数">
            </div>
            <div class="layui-form-mid layui-word-aux">新用户注册奖励多少金币，可空</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登录奖励</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="login_reward" value="{$config['login_reward']}" autocomplete="off" placeholder="请填写奖励金币数">
            </div>
            <div class="layui-form-mid layui-word-aux">用户当天首次登录奖励多少金币，可空</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">签到奖励</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="sign_reward" value="{$config['sign_reward']}" autocomplete="off" placeholder="请填写奖励金币数">
            </div>
            <div class="layui-form-mid layui-word-aux">用户签到奖励多少金币，可空</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">宣传奖励</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="propaganda_reward" value="{$config['propaganda_reward']}" autocomplete="off" placeholder="请填写奖励金币数">
            </div>
            <div class="layui-form-mid layui-word-aux">用户宣传奖励多少金币，可空</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">宣传次数</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="share_num" value="{$config['share_num']}" autocomplete="off" placeholder="请填写用户宣传可获取奖励金币次数">
            </div>
            <div class="layui-form-mid layui-word-aux">用户宣传可获取奖励金币次数</div>
        </div>
        <fieldset class="layui-elem-field layui-field-title">
            <legend>评论设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">评论功能</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="comment_on"   lay-skin="switch" lay-text="开启|关闭"  {if condition="$config['comment_on'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">是否开启评论功能</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">评论审核</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="comment_examine_on"   lay-skin="switch" lay-text="开启|关闭"  {if condition="$config['comment_examine_on'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">评论是否需要审核</div>
        </div>

        <fieldset class="layui-elem-field layui-field-title">
            <legend>资源审核设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">新增资源审核</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="resource_examine_on"   lay-skin="switch" lay-text="需要|不用"  {if condition="$config['resource_examine_on'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">客户上传了新资源（视频、图册、小说）是否需要审核</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">视频</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="video_reexamination"   lay-skin="switch" lay-text="需要|不用"  {if condition="$config['video_reexamination'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">客户编辑视频信息后是否需要重新审核，如修改了标题，标签，视频地址等</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="image_reexamination"   lay-skin="switch" lay-text="需要|不用"  {if condition="$config['image_reexamination'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">客户上传了新的图片或者修改了图册信息后是否需要重新审核</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">小说</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="novel_reexamination"   lay-skin="switch" lay-text="需要|不用"  {if condition="$config['novel_reexamination'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">客户编辑资讯信息后是否需要重新审核，如修改了标题，标签，小说内容等</div>
        </div>

        <fieldset class="layui-elem-field layui-field-title">
            <legend>其他设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">注册校验</label>
            <div class="layui-input-inline">
                <select name="register_validate" class="field-role_id" type="select"   lay-skin="switch" lay-filter="look_at_measurement"  >
                    <option value="0"  {if condition="$config['register_validate'] eq 0"}selected="selected"{/if} >不需要校验</option>
                    <option value="1"  {if condition="$config['register_validate'] eq 1"}selected="selected"{/if}  >邮箱校验</option>
                    <option value="2"  {if condition="$config['register_validate'] eq 2"}selected="selected"{/if}>手机短信校验</option>
                </select>
            </div>
            <div class="layui-form-mid layui-word-aux">注册账号校验方式</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">消费有效期</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="message_validity" value="{$config['message_validity']}" autocomplete="off" placeholder="输入间隔小时">
            </div>
            <div class="layui-form-mid layui-word-aux">单位小时：例如，视频付费了之后，多长时间内可以免费观看</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">打赏排行</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="reward_num" value="{$config['reward_num']}" autocomplete="off" placeholder="输入显示名次">
            </div>
            <div class="layui-form-mid layui-word-aux">首页打赏排行显示名次：例如首页排行榜显示前五名</div>
        </div>

 <div class="layui-form-item">
            <label class="layui-form-label">首页内容个数</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="homepage_resource_num" value="{$config['homepage_resource_num']}" autocomplete="off" placeholder="首页内容个数">
            </div>
            <div class="layui-form-mid layui-word-aux">首页上每个栏目内容的显示个数</div>
        </div>
			 <div class="layui-form-item">
            <label class="layui-form-label">卡密购买地址</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="buy_cardpassword_uri" value="{$config['buy_cardpassword_uri']}" autocomplete="off" placeholder="购买卡密链接地址">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">验证码</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="verification_code_on"   lay-skin="switch" lay-text="开启|关闭"  {if condition="$config['verification_code_on'] eq 1"}checked=""{/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">是否开启验证码</div>
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



<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/plupload-2.3.6/js/plupload.full.min.js"></script><script src="/static/plupload-2.3.6/js/i18n/zh_CN.js"></script>
<script src="/static/xuploader/webServerUploader.js"></script>
<script src="/static/js/XCommon.js"></script>

<script>
    function afterUpLogo(resp){
        $('#img_logo').attr('src',resp.filePath);
        $('#site_logo').val(resp.filePath);
        layer.msg('上传Logo完成',{time:500});
    }

    function afterUpIcon(resp){
        $('#img_ico').attr('src',resp.filePath);
        $('#site_favicon').val(resp.filePath);
        layer.msg('上传图标完成',{time:500});
    }

    function afterUpLogoMobile(resp){
        $('#img_logo_mobile').attr('src',resp.filePath);
        $('#site_logo_mobile').val(resp.filePath);
        layer.msg('上传Logo完成',{time:500});
    }

    $(function(){
        //函数调用说明  createWebUploader(选择上传的对象id,上传按钮id,指定文件名称,文件类型,上传完成回调)
        createWebUploader('upload_logo_chose_btn','','','image',afterUpLogo);
        createWebUploader('upload_logo_chose_mobile_btn','','','image',afterUpLogoMobile);
        createWebUploader('upload_ico_chose_btn','','','ico',afterUpIcon);
    });
</script>