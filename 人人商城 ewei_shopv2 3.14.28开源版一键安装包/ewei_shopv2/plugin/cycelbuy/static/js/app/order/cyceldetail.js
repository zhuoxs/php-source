define(['core', 'tpl'], function (core, tpl) {
    var modal = {params: {}};
    modal.isall = 0;
    modal.receipttime=0;//当前收货日期
    modal.period_index=0;//第几期
    modal.cycelbuy_periodic=0;//周期订单的周期信息 (天数，单位1天2周3月，期数)
    modal.select_receipttime=0;//选择的日期
    modal.init = function (params) {

        $('.fui-cycle-group .cycle-card').on('click',function () {
            $(this).addClass('active').siblings().removeClass('active');
            var num = $(this).find('.num').html();
            $('.cycel-detail').each(function(){
                if($(this).attr('data-num') == num){
                    $(this).css('display','block');
                    $(this).prevAll('.cycel-detail').css('display','none');
                    $(this).nextAll('.cycel-detail').css('display','none');
                    modal.select_receipttime=0;
                }
            });
        })

        $('.update-date').click(function(){
            modal.isall = $(this).attr('data-id');
            modal.cycelbuy_periodic=$(this).attr('data-cycelbuy_periodic');//周期订单的周期信息 (天数，单位1天2周3月，期数)
            modal.receipttime=$(this).attr("data-receipttime");//当前收货日期
            modal.period_index=$(this).attr("data-period_index");//第几期
            modal.tmonth=0;
            modal.getDateList();
            modal.nowDate();
            $('.order-date-picker').css('display','block');

        })

        $('.date-btn-cancel').click(function(){
            $('.order-date-picker').css('display','none');
        })

        $('.date-btn-confirm').click(function(){
            var time = $('.day.active').data('id');
            var url  =core.getUrl('cycelbuy/order/deferred/do_deferred');
            $.ajax({
                url:url,
                type:'get',
                data:{orderid:params.orderid,isall:modal.isall,time:time},
                success:function(res){
                    var showRes = JSON.parse(res);
                    if(showRes.status == 0){
                        FoxUI.toast.show(showRes.result.message);
                        return;
                    }else if(showRes.status == 1){
                        FoxUI.toast.show(showRes.result.message);
                        $('.order-date-picker').css('display','none');
                        location.reload();
                        return;
                    }
                }
            })
        });

        $('.confirm_receipt').click(function(){
            var url = core.getUrl('cycelbuy/order/confirm_receipt');
            var id = $(this).data('id');
            var orderid = $(this).data('orderid');
            $.ajax({
                url:url,
                type:'get',
                data:{id:id,orderid:orderid},
                success:function(res){
                    var showRes = JSON.parse(res);
                    if(showRes.status == 0){
                        FoxUI.toast.show(showRes.result.message);
                        return;
                    }else if(showRes.status == 1){
                        FoxUI.toast.show(showRes.result.message);
                        location.reload();
                        return;
                    }
                }
            });
        });
    };

    modal.nowDate = function(){
        var dates = new Date();
        dates.getFullYear(); //获取完整的年份(4位,1970-????)
        dates.getMonth(); //获取当前月份(0-11,0代表1月)
        dates.getDate(); //获取当前日(1-31)
        dates.getDay(); //获取当前星期X(0-6,0代表星期天)
        var newYear = dates.getFullYear();
        var newMonth  = dates.getMonth();
        var newDay = dates.getDate();
        var week = dates.getDay()

        switch(week)
        {
            case 0:
                var newWeekDay = '周日';
                break;
            case 1:
                var newWeekDay = '周一';
                break;
            case 2:
                var newWeekDay = '周二';
                break;
            case 3:
                var newWeekDay = '周三';
                break;
            case 4:
                var newWeekDay = '周四';
                break;
            case 5:
                var newWeekDay = '周五';
                break;
            case 6:
                var newWeekDay = '周六';
                break;
        }

        var newMonth = parseInt(newMonth+1) < 10 ? '0'+parseInt(newMonth+1):parseInt(newMonth+1) ;
        var newDate = parseInt(newDay) < 10 ? '0'+ parseInt(newDay):parseInt(newDay);
        var showDate = newYear+'年'+newMonth+'月'+newDate+'日 '+newWeekDay;
        // modal.tmonth = parseInt(dates.getMonth()) -1;
        // modal.tdate = newDate;
        modal.ttime = dates;

    }


    modal.getDateList = function () {
        $.ajax({
            url:core.getUrl('cycelbuy/trade/picker/date_list'),
            type:'get',
            data:{
                ttime:modal.ttime,
                tmonth:modal.tmonth,
                tdate:modal.tdate,
                from:'update',
                receipttime:modal.receipttime,//当前收货日期
                period_index:modal.period_index,//第几期
                cycelbuy_periodic:modal.cycelbuy_periodic,//周期订单的周期信息 (天数，单位1天2周3月，期数)
                select_receipttime:modal.select_receipttime,//选择的日期
                isall:modal.isall
            },
            success:function (data) {
                $('#datepicker').html(data);
                if(modal.isall!=1) {
                    $('#date'+modal.tdate).removeClass('active').addClass('active');
                }
                $('.date-alert').addClass('show');


                $('#month-left').click(function () {
                    modal.tmonth--;
                    modal.getDateList();
                })

                $('#month-right').click(function () {
                    modal.tmonth++;
                    modal.getDateList();
                })

                $('.day').unbind('click').click(function () {
                    if($(this).attr('data-status') == '1'){
                        return;
                    }
                    var cycelday = $('.spec-item .btn-danger').attr('data-day');
                    modal.tdate = $(this).attr('data-id');
                    modal.select_receipttime=$(this).attr('data-id');

                    var datestr = $(this).attr('data-date');
                    $('#date').html(datestr);
                    $('#datepicker').html();


                    $('.day_item').removeClass('active');

                    $(this).addClass('active');
                    $('.spec-item-time').html($(this).attr('data-date')).addClass('btn-danger').attr('data-date',$(this).attr('data-id'));
                    $(this).prevAll().removeClass('active');
                    $(this).nextAll().removeClass('active');


                    if(modal.isall==1){
                        var cycelbuy_periodic=modal.cycelbuy_periodic.split(","); //字符分割 ;
                        var period=cycelbuy_periodic[2]-modal.period_index;//剩余期数
                        var time_unit=[1,7,30];
                        var number=cycelbuy_periodic[0]*time_unit[cycelbuy_periodic[1]];//间隔
                        var datelist=$(this).nextAll();

                        for (var i = 1; i <period; i++) {
                            if(datelist[i*number-1]!=undefined){
                                $(datelist[i*number-1]).removeClass('active').addClass('active');
                            }else{
                                return;
                            }
                        }
                    }
                })
            }
        });
    };

    return modal
});