<div class="layui-tab-item layui-show">
    <form class="layui-form layui-form-pane" action="{:url('')}" id="editForm" method="post">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>提成设置</legend>
        </fieldset>

        <div class="layui-form-item">
            <label class="layui-form-label">视频提成</label>
            <div class="layui-input-inline">
                <input type="number" min="1" max="10" class="layui-input" name="video_commission" value="{$config['video_commission']}" autocomplete="off" placeholder="请填写1-100的数字">
            </div>
            <div class="layui-form-mid layui-word-aux">填写1-100的数字，如填写1则上传者获取的提成为(1%)视频观看费用</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片提成</label>
            <div class="layui-input-inline">
                <input type="number" min="1" max="10" class="layui-input" name="atlas_commission" value="{$config['atlas_commission']}" autocomplete="off" placeholder="请填写1-100的数字">
            </div>
            <div class="layui-form-mid layui-word-aux">填写1-100的数字，如填写1则上传者获取的提成为(1%)图片观看费用</div>
        、</div>
        <div class="layui-form-item">
            <label class="layui-form-label">资讯提成</label>
            <div class="layui-input-inline">
                <input type="number" min="1" max="10" class="layui-input" name="novel_commission" value="{$config['novel_commission']}" autocomplete="off" placeholder="请填写1-100的数字">
            </div>
            <div class="layui-form-mid layui-word-aux">填写1-100的数字，如填写1则上传者获取的提成为(1%)资讯观看费用</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">代理商提成（%）</label>
            <div class="layui-input-inline">
                <input type="number" min="1" max="100" class="layui-input" name="agent_commission" value="{$config['agent_commission']}" autocomplete="off" placeholder="请填写1-100的数字">
            </div>
            <div class="layui-form-mid layui-word-aux"> 填写1-100的数字，当客户在代理商网站上充值的时候，代理商可获取充值金额*（提成数%）的提成金额</div>
        </div>
        <blockquote class="layui-elem-quote layui-text">
            <p>分销分成说明：必须申请成为代理商才能获得分销分成，当客户在代理商的域名下注册成为会员后，该新会员就成为当前域名（如a1.msvodx.com）代理商的下线。</br>如现存在三个代理商A,B,C以及客户D;A是B的上线，B是C的上线,C是D的上线，当客户D充值的时候，D的上线C（三级分销商）以及C的上线B（二级分销商）以及B的上线A（一级分销商）可以获取到分销提成 </p>
            <img src="/static/images/msvodx_fenxiaoshiyitu.jpg" />
        </blockquote>

        <div class="layui-form-item">
            <label class="layui-form-label">一级分销商提成</label>
            <div class="layui-input-inline">
                <input type="number" min="1" max="100" class="layui-input" name="one_level_distributor" value="{$config['one_level_distributor']}" autocomplete="off" placeholder="请填写1-100的数字">
            </div>
            <div class="layui-form-mid layui-word-aux"> 填写1-100的数字，可获取充值金额*（提成数%）的提成金额</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">二级分销商提成</label>
            <div class="layui-input-inline">
                <input type="number" min="1" max="100" class="layui-input" name="second_level_distributor" value="{$config['second_level_distributor']}" autocomplete="off" placeholder="请填写1-100的数字">
            </div>
            <div class="layui-form-mid layui-word-aux"> 填写1-100的数字，可获取充值金额*（提成数%）的提成金额</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">三级分销商提成</label>
            <div class="layui-input-inline">
                <input type="number" min="1" max="100" class="layui-input" name="three_level_distributor" value="{$config['three_level_distributor']}" autocomplete="off" placeholder="请填写1-100的数字">
            </div>
            <div class="layui-form-mid layui-word-aux"> 填写1-100的数字，可获取充值金额*（提成数%）的提成金额</div>
        </div>
        <blockquote class="layui-elem-quote layui-text">
            <p>三级分销商同时满足分销条件，并且满足代理分成条件的时候，三级分销商是否拿分销提成</br>（即：客户B是在代理商A的域名下注册，当客户B在代理商A的代理域名商进行充值的时候，代理商A就同时满足分销分成条件，以及代理分成条件）</p>
        </blockquote>
        <div class="layui-form-item">
            <label class="layui-form-label">三级分销商提成</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="three_level_distributor_on" lay-skin="switch" lay-text="可拿|不能" {if
                       condition="$config['three_level_distributor_on'] eq 1" }checked="" {/if}>
            </div>
            <div class="layui-form-mid layui-word-aux">三级分销商是否与代理商提成可同时获取</div>
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
