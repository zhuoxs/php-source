<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:98:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/cdistributionset/set.html";i:1556181880;s:90:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit2.html";i:1553823404;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layui</title>
    <link rel="stylesheet" href="/addons/yztc_sun/public/static/bower_components/layui/src/css/layui.css">
    <script src="/addons/yztc_sun/public/static/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/addons/yztc_sun/public/static/bower_components/layui/src/layui.js"></script>

    <link href="/addons/yztc_sun/public/static/bower_components/select2/dist/css/select2.css" rel="stylesheet" />
    <script src="/addons/yztc_sun/public/static/custom/pinyin.js"></script>

    <link href="/web/resource//css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="/web/resource//css/font-awesome.min.css" rel="stylesheet">-->
    <link href="/web/resource//css/common.css" rel="stylesheet">
    <script>

        window.sysinfo = {
            'siteroot': '<?php echo isset($_W['siteroot'])?$_W['siteroot']:''; ?>',
            'siteurl': '<?php echo isset($_W['siteurl'])?$_W['siteurl']:''; ?>',
            'attachurl': '<?php echo isset($_W['attachurl'])?$_W['attachurl']:''; ?>',
            'attachurl_local': '<?php echo isset($_W['attachurl_local'])?$_W['attachurl_local']:''; ?>',
            'attachurl_remote': '<?php echo isset($_W['attachurl_remote'])?$_W['attachurl_remote']:''; ?>',
            'cookie' : {'pre': '<?php echo isset($_W['config']['cookie']['pre'])?$_W['config']['cookie']['pre']:''; ?>'},
            'account' : <?php  echo json_encode($_W['account']) ?>
        };
    </script>
    <script src="/web/resource//js/app/util.js"></script>
    <script src="/web/resource//js/app/common.min.js"></script>
    <script>var require = { urlArgs: 'v=20161011' };</script>
    <script src="/web/resource//js/require.js"></script>
    <script src="/web/resource//js/app/config.js"></script>
    <script>
        requireConfig.baseUrl = "/web/resource/js/app";
        requireConfig.paths.select2 = "/addons/yztc_sun/public/static/bower_components/select2/dist/js/select2";
        require.config(requireConfig);

        require(['select2','bootstrap'], function () {
            $.fn.select2.defaults.set("matcher",function(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                if (data.keywords && data.keywords.indexOf(params.term) > -1 || data.text.indexOf(params.term) > -1) {
                    return data;
                }
                return null;
            });
        });
    </script>
    <style>
        body{
            min-width: 0px !important;
        }
        .select2{
            width: 100%;
        }
        .select2 .select2-selection{
            height: 38px;
            border-radius: 2px;
            /*border-color: rgb(230,230,230);*/
        }
        .select2 .select2-selection__rendered{
            line-height: 38px!important;
        }
        .select2 .select2-selection__arrow{
            height: 36px!important;
        }

        .layui-form-item .layui-form-label{
            width: 180px;
        }
        .layui-form-item .layui-input-block{
            margin-left: 210px;
        }
        .layui-form-item .layui-input-inline{
            margin-left: 30px;
        }
    </style>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div style="padding: 15px;">
        <form class="layui-form" method="post" action="<?php echo adminurl('save'); ?>">
            <input type="hidden" name="id" value="<?php echo isset($info['id'])?$info['id']:''; ?>">
            


<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <ul class="layui-tab-title">
        <li class="layui-this">分销层级</li>
        <li>分销条件</li>
        <li>提现设置</li>
        <li>其他设置</li>

    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div class="layui-form-item">
                <label class="layui-form-label">分销层级</label>
                <div class="layui-input-block">
                    <input type="radio" name="level" value="0" title="不开启" <?php echo $info['level']==0?"checked":""; ?>>
                    <input type="radio" name="level" value="1" title="一级分销" <?php echo $info['level']==1?"checked":""; ?>>
                    <input type="radio" name="level" value="2" title="二级分销" <?php echo $info['level']==2?"checked":""; ?>>
                    <input type="radio" name="level" value="3" title="三级分销" <?php echo $info['level']==3?"checked":""; ?>>
                </div>
            </div>
            <div class="layui-form-item commissiontype">
                <label class="layui-form-label">分销佣金类型</label>
                <div class="layui-input-block">
                    <input type="radio" name="commissiontype" value="1" title="百分比" <?php echo $info['commissiontype']==1||!$info['commissiontype']?"checked":""; ?>>
                    <input type="radio" name="commissiontype" value="2" title="固定金额" <?php echo $info['commissiontype']==2?"checked":""; ?>>
                </div>
            </div>

            <div class="layui-form-item first">
                <div class="layui-inline">
                    <label class="layui-form-label">一级</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="first_name" placeholder="请输入分销等级名称" class="layui-input" value="<?php echo isset($info['first_name'])?$info['first_name']:''; ?>">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">一级佣金</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="first_money" placeholder="" class="layui-input" value="<?php echo isset($info['first_money'])?$info['first_money']:''; ?>">
                        <label class="commissiontype_1">%</label><label class="commissiontype_2">元</label>
                    </div>
                </div>
            </div>

            <div class="layui-form-item second">
                <div class="layui-inline">
                    <label class="layui-form-label">二级</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="second_name" placeholder="请输入分销等级名称" class="layui-input" value="<?php echo isset($info['second_name'])?$info['second_name']:''; ?>">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">二级佣金</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="second_money" placeholder="" class="layui-input" value="<?php echo isset($info['second_money'])?$info['second_money']:''; ?>">
                        <label class="commissiontype_1">%</label><label class="commissiontype_2">元</label>
                    </div>
                </div>
            </div>

            <div class="layui-form-item third">
                <div class="layui-inline">
                    <label class="layui-form-label">三级</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="third_name" placeholder="请输入分销等级名称" class="layui-input" value="<?php echo isset($info['third_name'])?$info['third_name']:''; ?>">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">三级佣金</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="third_money" placeholder="" class="layui-input" value="<?php echo isset($info['third_money'])?$info['third_money']:''; ?>">
                        <label class="commissiontype_1">%</label><label class="commissiontype_2">元</label>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">分销内购</label>
                <div class="layui-input-block">
                    <input type="radio" name="inapp_buy" value="0" title="关闭" <?php echo $info['inapp_buy']==0?"checked":""; ?>>
                    <input type="radio" name="inapp_buy" value="1" title="开启" <?php echo $info['inapp_buy']==1?"checked":""; ?>>
                </div>
            </div>
        </div>
        <div class="layui-tab-item">
            <div class="layui-form-item">
                <label class="layui-form-label">成为下线条件</label>
                <div class="layui-input-block">
                    <input type="radio" name="lower_condition" value="1" title="首次点击分享链接" <?php echo $info['lower_condition']==1?"checked":""; ?>>
                    <input type="radio" name="lower_condition" value="2" title="首次购买（付款）" <?php echo $info['lower_condition']==2?"checked":""; ?>>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">成为分销商条件</label>
                <div class="layui-input-block">
                    <input type="radio" name="distribution_condition" value="1" title="无条件" <?php echo $info['distribution_condition']==1?"checked":""; ?>>
                    <input type="radio" name="distribution_condition" value="2" title="申请" <?php echo $info['distribution_condition']==2?"checked":""; ?>>
                    <input type="radio" name="distribution_condition" value="3" title="消费金额" <?php echo $info['distribution_condition']==3?"checked":""; ?>>
                    <!--    <input type="radio" name="distribution_condition" value="4" title="购买商品" <?php echo $info['distribution_condition']==4?"checked":""; ?>>-->
                    <input type="radio" name="distribution_condition" value="5" title="成为会员" <?php echo $info['distribution_condition']==5?"checked":""; ?>>
                </div>
            </div>

            <div class="layui-form-item consumption_money">
                <div class="layui-inline">
                    <label class="layui-form-label">消费金额</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="consumption_money" placeholder="" class="layui-input" value="<?php echo isset($info['consumption_money'])?$info['consumption_money']:''; ?>">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">是否需要审核</label>
                <div class="layui-input-block">
                    <input type="radio" name="is_check" value="1" title="需要" <?php echo $info['is_check']==1?"checked":""; ?>>
                    <input type="radio" name="is_check" value="0" title="不需要" <?php echo $info['is_check']==0?"checked":""; ?>>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">商家可设置分销</label>
                <div class="layui-input-block">
                    <input type="radio" name="store_setting" value="1" title="是" <?php echo $info['store_setting']==1?"checked":""; ?>>
                    <input type="radio" name="store_setting" value="0" title="否" <?php echo $info['store_setting']==0?"checked":""; ?>>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">分销佣金扣款</label>
                <div class="layui-input-block">
                    <input type="radio" name="withhold" value="1" title="平台" <?php echo $info['withhold']==1?"checked":""; ?>>
                    <input type="radio" name="withhold" value="2" title="商家" <?php echo $info['withhold']==2?"checked":""; ?>>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">参与分销模块</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="join_module[]" value="1" <?php if(in_array(1,$info['join_module_z'])) echo "checked"; ?> title="普通商品">
                    <input type="checkbox" name="join_module[]" value="2" <?php if(in_array(2,$info['join_module_z'])) echo "checked"; ?> title="抢购商品">
                    <input type="checkbox" name="join_module[]" value="3" <?php if(in_array(3,$info['join_module_z'])) echo "checked"; ?> title="拼团商品">
                    <input type="checkbox" name="join_module[]" value="4" <?php if(in_array(4,$info['join_module_z'])) echo "checked"; ?> title="会员卡">
                    <input type="checkbox" name="join_module[]" value="5" <?php if(in_array(5,$info['join_module_z'])) echo "checked"; ?> title="预约">
                </div>
            </div>
        </div>
        <div class="layui-tab-item">
            <div class="layui-form-item">
                <label class="layui-form-label">提现方式</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="withdraw_type[]" value="1" <?php if(in_array(1,$info['withdraw_type_z'])) echo "checked"; ?> title="微信">
                  <!--  <input type="checkbox" name="withdraw_type[]" value="2" <?php if(in_array(2,$info['withdraw_type_z'])) echo "checked"; ?> title="支付宝">
                    <input type="checkbox" name="withdraw_type[]" value="3" <?php if(in_array(3,$info['withdraw_type_z'])) echo "checked"; ?> title="银行卡">-->
                </div>
            </div>


            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">免审金额</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="pass_money" placeholder="仅支持微信提现" class="layui-input" value="<?php echo isset($info['pass_money'])?$info['pass_money']:''; ?>">
                        <label>元</label>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">提现手续费</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="withdraw_fee" placeholder="请输入提现手续费" class="layui-input" value="<?php echo isset($info['withdraw_fee'])?$info['withdraw_fee']:''; ?>">
                        <label>%</label>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">最小提现额度</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="min_withdraw" placeholder="请输入最小提现额度" class="layui-input" value="<?php echo isset($info['min_withdraw'])?$info['min_withdraw']:''; ?>">
                        <label>元</label>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">每日提现上限</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="daymax_withdraw" placeholder="请输入每日提现上限" class="layui-input" value="<?php echo isset($info['daymax_withdraw'])?$info['daymax_withdraw']:''; ?>">
                        <label>元</label>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">提现须知</label>
                <div class="layui-input-block">
                    <?php echo tpl_ueditor('withdraw_notice', $info['withdraw_notice']); ?>
                </div>
            </div>

        </div>
        <div class="layui-tab-item">

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">海报标题</label>
                    <div class="layui-input-block">
                        <input autocomplete="off" type="text" name="poster_title" placeholder="海报标题" class="layui-input" value="<?php echo isset($info['poster_title'])?$info['poster_title']:''; ?>">
                    </div>
                </div>

            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">海报图片</label>
                <div class="layui-input-block">
                    <?php echo tpl_form_field_image('poster_pic', isset($info['poster_pic'])?$info['poster_pic']:'','/web/resource/images/nopic.jpg'); ?>
                    <div class="layui-form-mid layui-word-aux">建议尺寸：710*410</div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">申请合伙人banner</label>
                <div class="layui-input-block">
                    <?php echo tpl_form_field_image('banner', isset($info['banner'])?$info['banner']:'','/web/resource/images/nopic.jpg'); ?>
                    <div class="layui-form-mid layui-word-aux">建议尺寸：710*410</div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">专属权利</label>
                <div class="layui-input-block">
                    <?php echo tpl_ueditor('exclusive_rights', $info['exclusive_rights']); ?>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">用户须知</label>
                <div class="layui-input-block">
                    <?php echo tpl_ueditor('user_notice', $info['user_notice']); ?>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">申请协议</label>
                <div class="layui-input-block">
                    <?php echo tpl_ueditor('application', $info['application']); ?>
                </div>
            </div>
        </div>

    </div>
</div>





<script>
    require(['select2'], function () {
      /*  $('.select2').select2();
        $.get("<?php echo adminurl('select'); ?>", function (ret) {
            if (typeof ret == "string"){
                ret = JSON.parse(ret);
            }
        //    ret.unshift({id: '', text: '请选择上级分类'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if(obj.id == "<?php echo isset($info['id'])?$info['id']:''; ?>"){
                    obj.selected = true;
                }
                return obj;
            });
            $('#prints_id').select2({
                data: ret,
            })
        })*/
    })

    setshow();
    setcommissiontypeshow();
    setconditionshow();
    function setshow(){
        var  smstype= $('[name=level]:checked').val();
        if(smstype==0){
            $('.commissiontype').hide();
            $('.first').hide();
            $('.second').hide();
            $('.third').hide();
        }else if(smstype==1){
            $('.commissiontype').show();
            $('.first').show();
            $('.second').hide();
            $('.third').hide();
        }else if(smstype==2){
            $('.commissiontype').show();
            $('.first').show();
            $('.second').show();
            $('.third').hide();
        }else if(smstype==3){
            $('.commissiontype').show();
            $('.first').show();
            $('.second').show();
            $('.third').show();
        }
    }
    function setcommissiontypeshow(){
        var  commissiontype= $('[name=commissiontype]:checked').val();
        if(commissiontype==1){
           $('.commissiontype_1').show();
           $('.commissiontype_2').hide();
        }else if(commissiontype==2){
           $('.commissiontype_1').hide();
           $('.commissiontype_2').show();
        }else{
           $('.commissiontype_1').hide();
           $('.commissiontype_2').hide();
        }
    }
    function  setconditionshow(){
        var condition= $('[name=distribution_condition]:checked').val();
        if(condition==3){
            $('.consumption_money').show();
        }else{
            $('.consumption_money').hide();
        }
    }
    layui.use(['table','form'],function () {
        var table = layui.table;
        var form = layui.form;
        form.on('radio', function (data) {
            if ($(data.elem).is('[name=level]')) {
                setshow();
            }
            if ($(data.elem).is('[name=commissiontype]')) {
                setcommissiontypeshow();
            }
            if ($(data.elem).is('[name=distribution_condition]')) {
                setconditionshow();
            }

        });
    })
</script>


            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="">立即提交</button>
                    <!--<button class="layui-btn layui-btn-primary" id="btnCancel">取消</button>-->
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use(['element','form'], function(){
        var element = layui.element;
        var form = layui.form;
        
        // 新增界面、保存、取消事件
        form.on('submit', function(data){
            if(!$(data.elem).is('button')){
                return false;
            }
            var data = data.field;
            var url = "<?php echo adminurl('save'); ?>";
            $.post(url,data,function(res){
                if (typeof res == 'string'){
                    res = $.parseJSON(res);
                }
                if (res.code == 0) {
                    layer.msg('保存成功',{icon: 6,anim: 6});
                    location.reload();
                }else{
                    layer.msg(res.msg,{icon: 5,anim: 6});
                }
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
        

        $('#btnCancel').click(function(e){
            var index=parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        })
    })
</script>
</body>
</html>