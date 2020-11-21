define(['biz'], function (biz) {
    var model = {};

    model.task = '';//当前任务JSON字符串
    model.open = true;//类型选择器是否打开

    //初始值
    model.verbStyle = 'border: 1px solid #E5E6E7;';
    model.reward = {goods:[],coupon:[]};
    model.followreward = {coupon:[]};
    model.reward2 = {coupon:[]};
    model.reward3 = {coupon:[]};
    model.page = 1;
    //初始化
    model.init = function (task,reward,followreward) {
        model.reward.coupon = $('textarea[name="rewardcoupon"]').html();
        model.reward.coupon = JSON.parse(model.reward.coupon);
        model.reward2.coupon = $('textarea[name="rewardcoupon2"]').html();
        model.reward2.coupon = JSON.parse(model.reward2.coupon);
        model.reward3.coupon = $('textarea[name="rewardcoupon3"]').html();
        model.reward3.coupon = JSON.parse(model.reward3.coupon);
        model.followreward.coupon = $('textarea[name="followrewardcoupon"]').html();
        model.followreward.coupon = JSON.parse(model.followreward.coupon);
        if (!model.followreward.coupon) model.followreward.coupon = [];
        model.rewardInit();
        //当前任务对象
        if (!task){
            model.task = {};
        }else{
            var taskObj = $('a[data-name='+task+']');
            if(taskObj){
                task = taskObj.attr('data-type');
                model.task = JSON.parse(task);
            }else{
                alert('任务不存在');return;
            }
        }
        //生成任务对象成功,关闭选择器,否则打开选择器重新选任务
        if (model.task.id) {
            model.open = false;
        }
        model.select();

        //选择任务类型
        $('.widget').click(function () {
            model.task = JSON.parse($(this).attr('data-type'));
            model.open = false;
            //已选择
            model.select();
        });

        //修改任务类型
        $('#open').click(function () {
            model.open = true;
            model.select();
        });
        //截止时间
        model.stopType();
        $('input[name="stoptype"]').click(function () {
            model.stopType();
        });
        //重复领取
        model.repeatType();
        $('input[name="repeattype"]').click(function () {
            model.repeatType();
        });
        //选择了无需自动接任务
        model.globalpickup();
        $("input[name='picktype']").click(function () {
            model.globalpickup();
        });
        //奖励
        // try {
        //     //预处理奖励数据
        //     if (reward != undefined && reward.length>0) model.reward = JSON.parse(reward);
        //     if (model.task.type_key == 'poster' && followreward) model.followreward = JSON.parse(followreward);
        //     //清空变量防止重复初始化
        //     reward = undefined;
        //     followreward = undefined;
        //     //奖励初始化
        //     model.rewardInit();
        // }
        //点击选择器
        $('a[data-target="#selector"]').click(function () {
            model.getpage(1,$(this).attr('data-type'));
        });
        //翻页
        $(document).on('click','.pageselector',function(){
            model.getpage($(this).attr('data-page'),model.pageType);
        });

        //选择商品或优惠券
        $(document).on('click','.selectit',function () {
            //获取数据
            var data = {};
            var id = parseInt( $(this).attr('data-id') );
            if (id != undefined) data.id = id;
            var num = parseInt( $(this).parent().parent().find('.num').val());
            if (num != undefined) data.num = isNaN(num) ? 1 : num;
            var price = parseFloat( $(this).parent().parent().find('.price').val());
            if (model.pageType == 'goods'&& price != undefined)
                data.price = isNaN(price) ? parseFloat($(this).attr('data-price')):price;
            var title = $(this).parent().parent().find('.title').val();
            if (model.pageType == 'goods'&& title != undefined) {
                data.title = title.trim() == ''? $(this).attr('data-title'): title;
                data.title = data.title.substring(0,10);
            }
            var couponname = $(this).parent().parent().find('.couponname').val();
            if (model.pageType != 'goods'&& couponname != undefined){
                data.couponname = couponname.trim() == '' ? $(this).attr('data-couponname'): couponname;
                data.couponname = data.couponname.substring(0,10);
            }
            if ($(this).hasClass('selected')){
                //退选这一项
                model.selectCancel(data);
                $(this).removeClass('selected').text('选择');
            }else{
                //选择这一项
                model.selectit(data);
            }
        })
    };
    //退选这个
    model.selectCancel = function (data) {
        var isDel = false;
        if (model.pageType == 'goods'){
            if (model.reward.goods != undefined)
                $.each(model.reward.goods,function (i,goods) {
                    if (goods.id == data.id){
                        model.reward.goods.splice(i,1);
                        return false;
                    }
                });
        }else if (model.pageType == 'coupon'){
            if (model.reward.coupon != undefined)
                $.each(model.reward.coupon,function (i,goods) {
                    if (goods.id == data.id){
                        model.reward.coupon.splice(i,1);
                        return false;
                    }
                });
        }else if (model.pageType == 'coupon2'){
            if (model.reward2.coupon != undefined)
                $.each(model.reward2.coupon,function (i,goods) {
                    if (goods.id == data.id){
                        model.reward2.coupon.splice(i,1);
                        return false;
                    }
                });
        }else if (model.pageType == 'coupon3'){
            if (model.reward3.coupon != undefined)
                $.each(model.reward3.coupon,function (i,goods) {
                    if (goods.id == data.id){
                        model.reward3.coupon.splice(i,1);
                        return false;
                    }
                });
        }else if(model.pageType == 'followcoupon'){
            if (model.followreward.coupon != undefined)
                $.each(model.followreward.coupon,function (i,goods) {
                    if (goods.id == data.id){
                        model.followreward.coupon.splice(i,1);
                        return false;
                    }
                });
        }
        //操作dom
        model.rewardInit();
    }
    //选择这个
    model.selectit = function (data) {
        //保存数据 model.reward
        var isPush = true;
        if (model.pageType == 'goods'){
            //商品
            if (model.reward.goods != undefined)
            $.each(model.reward.goods,function (i,goods) {
                if (goods.id == data.id){
                    isPush = false;
                    return false;
                }
            });
            if (isPush) model.reward.goods.push(data);
        }else if (model.pageType == 'coupon'){
            //优惠券
            if (model.reward.coupon != undefined)
            $.each(model.reward.coupon,function (i,coupon) {
                if (coupon.id == data.id){
                    isPush = false;
                    return false;
                }
            });
            if (isPush) model.reward.coupon.push(data);
        }else if (model.pageType == 'followcoupon'){
            //关注优惠券
            if (model.followreward.coupon != undefined)
                $.each(model.followreward.coupon,function (i,coupon) {
                    if (coupon.id == data.id){
                        isPush = false;
                        return false;
                    }
                });
            if (isPush) model.followreward.coupon.push(data);
        }else if (model.pageType == 'coupon2'){
            //优惠券
            if (model.reward2.coupon != undefined)
                $.each(model.reward2.coupon,function (i,coupon) {
                    if (coupon.id == data.id){
                        isPush = false;
                        return false;
                    }
                });
            if (isPush) model.reward2.coupon.push(data);
        }else if (model.pageType == 'coupon3'){
            //优惠券
            if (model.reward3.coupon != undefined)
                $.each(model.reward3.coupon,function (i,coupon) {
                    if (coupon.id == data.id){
                        isPush = false;
                        return false;
                    }
                });
            if (isPush) model.reward3.coupon.push(data);
        }
        //操作dom
        model.rewardInit();
    },
    
    //打开选择器
    model.select = function () {
        if (model.open){
            $('#select').removeClass('hide');
            $('#post').addClass('hide');
        }else{
            $('#select').addClass('hide');
            $('#post').removeClass('hide');
        }
        //设置任务类型名字
        if (model.task.id){
            $(".taskname").text(model.task.type_name);
            $("input[name='type']").val(model.task.type_key); 
            if (model.task.type_key =='child_agent') {
                $("#see").show();
            }
            //设置任务需求样式
            model.require();
        }
    };

    //截止时间隐藏项显示
    model.stopType = function () {
        var stopType = $('input[name="stoptype"]');
        $.each(stopType,function () {
            var value = $(this).val();
            $('#stoptype'+value).hide();
            if($(this).is(':checked')){
                $('#stoptype'+value).show();
            }
        });
    };

    //重复领取隐藏项显示
    model.repeatType = function () {
        var repeatType = $('input[name="repeattype"]');
        $.each(repeatType,function () {
            var value = $(this).val();
            $('#repeattype'+value).hide();
            if($(this).is(':checked')){
                $('#repeattype'+value).show();
            }
        });
    };

    //任务需求
    model.require = function () {
        $('#verb').text(model.task.verb);
        if (model.task.unit.length<1){
            $('#unit').hide();
        }else{
            $('#unit').text(model.task.unit);
            $('#unit').show();
        }
        if (model.task.numeric >0){
            $('#number').show();
            $('#verb').attr('style',false);
        }else{
            $('#number').hide();
            $('#verb').attr('style',model.verbStyle);
        }
        //指定商品选项
        if (model.task.goods == 1){
            $('#requiregoods').show();
        }else{
            $('#requiregoods').hide();
        }
        if (model.task.type_key == 'poster'){
            $('.justposter').show();
            $('#scannotice').show();
        }else{
            $('.justposter').hide();
            $('#scannotice').hide();
        }
    };

    //接取方式为无需接取global任务时
    model.globalpickup = function () {
        if ($('#globalpickup').is(':checked')){
            $('#repeat').hide();
            $('#stop').hide();
        }else{
            $('#repeat').show();
            $('#stop').show();
        }
    };
    //奖励数据初始化
    model.rewardInit = function(){
        if (model.reward) {
            if (model.reward.goods) {
                var rewardGoods = model.reward.goods;
                $('#goodsreward').empty();
                $.each(rewardGoods, function (i, g) {
                    var item = '<div class="form-group" data-id="goodsreward' + g.id + '">' +
                        '<label class="col-sm-2 control-label"></label>' +
                        '<div class="col-sm-9 col-xs-12">' +
                        '<span class="form-control">' +
                        '<span class="label label-danger">特价商品</span> ' +
                        '<span class="label label-primary"><span class="num">' + g.num + '</span>次</span> ' +
                        '<span class="label label-warning"><span class="price">' + g.price + '</span>元</span>' +
                        '<span class="title"> ' + g.title + '</span>' +
                        '</span>' +
                        '</div>' +
                        '</div>';
                    $('#goodsreward').append(item);
                    //数据填充
                    var tr = $('#goodsreward'+g.id);
                    tr.find('.selectit').addClass('selected').text('已选择');
                    tr.find('.price').val(g.price);
                    tr.find('.num').val(g.num);
                    tr.find('.title').val(g.title.substring(0,10));
                });
                // $('textarea[name="rewardgoods"]').text(JSON.stringify(model.reward.goods));
            }


            if (model.reward.coupon) {
                var rewardCoupon = model.reward.coupon;
                $('#couponreward').empty();
                $.each(rewardCoupon, function (i, g) {
                    var item = '<div class="form-group" data-id="goodsreward' + g.id + '">' +
                        '<label class="col-sm-2 control-label"></label>' +
                        '<div class="col-sm-9 col-xs-12">' +
                        '<span class="form-control">' +
                        '<span class="label label-danger">优惠券</span> ' +
                        '<span class="label label-primary"><span class="num">' + g.num + '</span>张</span>' +
                        '<span class="title"> ' + g.couponname + '</span>' +
                        '</span>' +
                        '</div>' +
                        '</div>';
                    $('#couponreward').append(item);
                    //数据填充
                    var tr = $('#couponreward'+g.id);
                    tr.find('.selectit').addClass('selected').text('已选择');
                    tr.find('.num').val(g.num);
                    tr.find('.couponname').val(g.couponname.substring(0,10));
                });
                $('textarea[name="rewardcoupon"]').text(JSON.stringify(model.reward.coupon));
            }
        }
        if (model.followreward.coupon){
            var followrewardCoupon = model.followreward.coupon;
            $('#couponfollowreward').empty();
            $.each(followrewardCoupon,function (i,g) {
                var item = '<div class="form-group" data-id="goodsreward'+g.id+'">'+
                    '<label class="col-sm-2 control-label"></label>'+
                    '<div class="col-sm-9 col-xs-12">'+
                    '<span class="form-control">'+
                    '<span class="label label-danger">优惠券</span> '+
                    '<span class="label label-primary"><span class="num">'+g.num+'</span>张</span> '+
                    '<span class="title">'+g.couponname+'</span>'+
                    '</span>'+
                    '</div>'+
                    '</div>';
                $('#couponfollowreward').append(item);
                //数据填充

                var tr = $('#couponfollowreward'+g.id);
                tr.find('.selectit').addClass('selected').text('已选择');
                tr.find('.num').val(g.num);
                tr.find('.couponname').val(g.couponname.substring(0,10));
            });
            $('textarea[name="followrewardcoupon"]').text(JSON.stringify(model.followreward.coupon));
        }
        if (model.reward2.coupon) {
            var rewardCoupon = model.reward2.coupon;
            $('#couponreward_2').empty();
            $.each(rewardCoupon, function (i, g) {
                var item = '<div class="form-group" data-id="goodsreward' + g.id + '">' +
                    '<label class="col-sm-2 control-label"></label>' +
                    '<div class="col-sm-9 col-xs-12">' +
                    '<span class="form-control">' +
                    '<span class="label label-danger">优惠券</span> ' +
                    '<span class="label label-primary"><span class="num">' + g.num + '</span>张</span>' +
                    '<span class="title"> ' + g.couponname + '</span>' +
                    '</span>' +
                    '</div>' +
                    '</div>';
                $('#couponreward_2').append(item);
                //数据填充
                var tr = $('#couponreward_2'+g.id);
                tr.find('.selectit').addClass('selected').text('已选择');
                tr.find('.num').val(g.num);
                tr.find('.couponname').val(g.couponname.substring(0,10));
            });
            $('textarea[name="rewardcoupon2"]').text(JSON.stringify(model.reward2.coupon));
        }
        if (model.reward3.coupon) {
            var rewardCoupon = model.reward3.coupon;
            $('#couponreward_3').empty();
            $.each(rewardCoupon, function (i, g) {
                var item = '<div class="form-group" data-id="goodsreward' + g.id + '">' +
                    '<label class="col-sm-2 control-label"></label>' +
                    '<div class="col-sm-9 col-xs-12">' +
                    '<span class="form-control">' +
                    '<span class="label label-danger">优惠券</span> ' +
                    '<span class="label label-primary"><span class="num">' + g.num + '</span>张</span>' +
                    '<span class="title"> ' + g.couponname + '</span>' +
                    '</span>' +
                    '</div>' +
                    '</div>';
                $('#couponreward_3').append(item);
                //数据填充
                var tr = $('#couponreward_3'+g.id);
                tr.find('.selectit').addClass('selected').text('已选择');
                tr.find('.num').val(g.num);
                tr.find('.couponname').val(g.couponname.substring(0,10));
            });
            $('textarea[name="rewardcoupon3"]').text(JSON.stringify(model.reward3.coupon));
        }

    };
    //获取url
    model.url = function (routes, params, merch) {
        if (merch) {
            var url = './merchant.php?c=site&a=entry&m=ewei_shopv2&do=web&r=' + routes.replace(/\//ig, '.')
        } else {
            var url = './index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=' + routes.replace(/\//ig, '.')
        }
        if (params) {
            if (typeof(params) == 'object') {
                url += "&" + $.toQueryString(params)
            } else if (typeof(params) == 'string') {
                url += "&" + params
            }
        }
        return url
    };
    //分页获取数据
    model.getpage = function (page,type) {
        if (type == 'goods' || type== 1){
            var $type = 1;
        }else{
            var $type = 0;
        }
        model.pageType = type;
        url = model.url('task.selectlist');
        $('#selectorlist').empty();
        $.ajax({
            url:url,
            type:'get',
            data:{page:page,type:$type},
            success:function (data) {
                var obj = JSON.parse(data);
                if (obj.status >0){
                    delete obj.result.url;
                    $.each(obj.result,function (i,item) {
                        //表头
                        model.thSelector($type);
                        if ($type == 1){//商品
                            model.goodsSelector(item);
                        }else {//优惠券
                            model.couponSelector(item);
                        }
                        //分页
                        model.pageSelector(obj.status,page);
                    })
                }else{
                    //没有数据
                }
                model.rewardInit();
            },
            error:function () {
                alert('请求失败,请刷新重试');
            }
        });
    };


    //处理商品
    model.goodsSelector = function(item){
        $('#selectorlist').append('<tr id="goodsreward'+item.id+'">'+
            '<td>'+item.id+'</td>'+
            '<td><img src="" alt="" height="25px" width="25px"> '+item.title+'</td>'+
            '<td>'+item.marketprice+'</td>'+
            '<td>'+item.total+'</td>'+
            '<td><input type="number" min="1" class="form-control price"></td>'+
            '<td><input type="number" class="form-control num"></td>'+
            '<td><input type="text" class="form-control title" maxlength="10"></td>'+
            '<td><a class="btn btn-sm btn-primary selectit" data-id="'+item.id+'" data-price="'+item.marketprice+'" data-title="'+item.title+'">选择</a></td>'+
            '</tr>'
        );
    };
    //处理优惠券
    model.couponSelector = function (item) {
        if (model.pageType == 'coupon') {
            var prev = 'couponreward';
        }else if(model.pageType == 'followcoupon'){
            var prev = 'couponfollowreward';
        }else if(model.pageType == 'coupon2'){
            var prev = 'couponreward_2';
        }else if(model.pageType == 'coupon3'){
            var prev = 'couponreward_3';
        }

        $('#selectorlist').append('<tr id="'+prev+item.id+'">'+
            '<td>'+item.id+'</td>'+
            '<td style="text-align: left;"> '+item.couponname+'</td>'+
            '<td><input type="number" class="form-control num" min="1" style="width: 80px"></td>'+
            '<td><input type="text" class="form-control couponname" maxlength="10"></td>'+
            '<td><a class="btn btn-sm btn-primary selectit" data-id="'+item.id+'" data-couponname="'+item.couponname+'">选择</a></td>'+
            '</tr>'
        );
    };
    //处理分页
    model.pageSelector = function (count,page) {
        if (count<10){
            $('#selectpager').empty();
            return false;
        }
        var psize = 10;

        var html = '<ul class="pagination pagination-centered">';
        var nowpage = page-1;
        if (page != 1) html += '<li><a class="pager-nav pageselector" data-page="1">首页</a></li>'+
            '<li><a class="pageselector" class="pager-nav pageselector" data-page="'+nowpage+'">«上一页</a></li>';
        var num = parseInt(count/psize);
        for (var i = 1;i <= num;i++){
            html += '<li><a class="pageselector" data-page="'+i+'">'+i+'</a></li>';
        }
        if (count%psize >0){
            num++;
            html += '<li><a class="pageselector" data-page="'+num+'">'+num+'</a></li>';
        }
        if (page != num){
            var nowpage = parseInt(page)+1;
            html +='<li><a class="pager-nav pageselector" data-page="'+nowpage+'">下一页»</a></li>'+
            '<li><a class="pager-nav pageselector" data-page="'+num+'">尾页</a></li>';
        }
        html += '</ul>';
        $('#selectpager').empty().html(html);
    };
    //处理表头
    model.thSelector = function (type) {
        if (type == 1){//商品
            var html = '<tr>'+
                '<th style="width: 80px">ID</th>'+
                '<th style="width: 140px">商品名称</th>'+
                '<th>原价</th>'+
                '<th>库存</th>'+
                '<th>现价</th>'+
                '<th>数量</th>'+
                '<th style="width: 130px">商品别名</th>'+
                '<th>操作</th>'+
                '</tr>';
        }else{
            var html = '<tr>'+
                '<th style="width: 80px">ID</th>'+
                '<th style="text-align: left;width: 150px">优惠券名称</th>'+
                '<th style="width: 100px">数量</th>'+
                '<th style="width: 150px">优惠券别名</th>'+
                '<th style="width: 100px">操作</th>'+
                '</tr>';
        }
        $('#selectorth').empty().html(html);
    }
    return model
});