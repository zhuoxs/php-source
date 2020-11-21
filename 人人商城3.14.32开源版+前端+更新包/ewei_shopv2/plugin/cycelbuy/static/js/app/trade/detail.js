define(['core', 'tpl','biz/member/favorite'], function (core, tpl, favorite) {
    var modal = {};
    modal.init = function (params) {
        modal.canbuy = params.canbuy;
        modal.goodsid = params.goodsid;
        modal.storeid = params.storeid;
        modal.total = 1;
        modal.attachurl_local = params.attachurl_local;
        modal.attachurl_remote = params.attachurl_remote;

        modal.need_timeslice = params.need_timeslice;
        modal.need_arrival = params.need_arrival;
        modal.need_username = params.need_username;
        modal.need_mobile = params.need_mobile;
        modal.need_address = params.need_address;
        modal.need_trade = params.need_trade;
        modal.need_id = params.need_id;
        modal.need_number = params.need_number;
        modal.occ = params.occ;//服务人员职业

        modal.ttime = params.ttime;
        modal.tmonth = params.tmonth;
        modal.tdate = params.tdate;
        modal.optime = params.optime;
        modal.peopleid = 0;

        $('#chosestore').click(function () {
            location.href = core.getUrl('newstore/stores/chosestore',{goodsid:modal.goodsid,istrade:1})
        });

        if (!modal.canbuy) {
            return;
        }

        modal.getPeople();
        modal.getDetail();

        $('.chose-day').click(function(){
            modal.getDateList();
        })

        $('.date-chose-close').click(function(){
            $('.date-alert').removeClass('show')
        })

        $('.chose-time').click(function(){
            modal.getTimeList();
        })

        $('.time-chose-close').click(function(){
            $('.time-alert').removeClass('show');
        })

        $('.chose-people').click(function(){
            modal.getPeopleList();
        })

        $('.people-chose-close').click(function(){
            $('.people-alert').removeClass('show')
        })

        $('.day_item').not("#other_day").unbind('click').click(function () {

        $('.day_item').removeClass('active');
        $(this).removeClass('active').addClass('active');
            // if($(this).attr('data-status') == '1'){
            //     return;
            // }

            modal.tdate = $(this).attr('data-id');
            var datestr = $(this).attr('data-date');
            $('#date').html(datestr);
            $('#datepicker').html();
            // $('.chose-time').click();
            modal.getTime();
        })

        $('.time_item').not("#other_time").unbind('click').click(function () {

            $('.time_item').removeClass('active');
            $(this).removeClass('active').addClass('active');
            modal.optime = $(this).attr('data-id');
            $('#time').html(modal.optime);
            modal.getPeople();
        })

        $(".fui-navbar .btn").click(function () {

            if (modal.ttime == '') {
                FoxUI.toast.show('选择日期');
                return
            }

            if (modal.need_timeslice && modal.optime == '') {
                FoxUI.toast.show('选择预约时间');
                return
            }


            if( modal.need_trade ==1 && modal.peopleid ==0)
            {
                FoxUI.toast.show('选择预约'+params.occ);
                return
            }

            $.router.load(core.getUrl('newstore.trade.create', {
                id: modal.goodsid,
                storeid: modal.storeid,
                ttime: modal.ttime,
                tdate: modal.tdate,
                optime: modal.optime,
                peopleid: modal.peopleid

            }), false)
        });

        $('.favorite-item').click(function () {
            var self = $(this);
            if (self.attr('submit') == '1') {
                return
            }
            self.attr('submit', 1);
            var isfavorite = self.attr('data-isfavorite') == '1';
            var icon = self.find('.icon');
            icon.removeClass('icon-like').removeClass('icon-likefill');
            isfavorite && icon.addClass('icon-like');
            !isfavorite && icon.addClass('icon-likefill');
            self.toggleClass('active');
            if (!isfavorite) {
                icon.addClass('fav').transitionEnd(function () {
                    icon.removeClass('fav')
                })
            }
            isfavorite = self.attr('data-isfavorite') == '1' ? 0 : 1;
            favorite.toggle(modal.goodsid, isfavorite, function (is) {
                self.removeAttr('submit').attr("data-isfavorite", is ? "1" : 0)
            })
        });
        if (core.isWeixin()) {
            $('#btn-share').click(function () {
                $('#cover').fadeIn(200)
            });
            $('#cover').click(function () {
                $('#cover').hide()
            })
        } else {
            $('#btn-share').click(function () {
                if (core.ish5app()) {
                    return
                }
                FoxUI.alert("请复制链接发送给好友")
            })
        }

    };

    modal.getDateList = function () {
        $.ajax({
            url:core.getUrl('newstore.trade.picker.date_list'),
            type:'get',
            data:{goodsid:modal.goodsid,storeid:modal.storeid,ttime:modal.ttime,tmonth:modal.tmonth,tdate:modal.tdate},
            success:function (data) {
                $('#datepicker').html(data);
                $('#date'+modal.tdate).removeClass('active').addClass('active');
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
                    modal.tdate = $(this).attr('data-id');
                    // modal.ttime = $(this).attr('data-time');
                    var datestr = $(this).attr('data-date');
                    $('#date').html(datestr);
                    $('#datepicker').html();
                    $('.date-alert').removeClass('show');

                    $('.day_item').removeClass('active');
                    // 如果选择的日期不在列表上则选中其他
                    if($('#date_'+modal.tdate).length>0)
                    {
                        $('#date_'+modal.tdate).removeClass('active').addClass('active');
                    }else{
                        $('#other_day').addClass('active');
                    }
                    // $('.chose-time').click();
                })
            }
        });
    };

    modal.getPeople = function () {
        $.ajax({
            url:core.getUrl('newstore.trade.picker.people'),
            type:'get',
            data:{goodsid:modal.goodsid,storeid:modal.storeid,optime:modal.optime,tdate:modal.tdate},
            success:function (data) {
                $('#peoplepicker').html(data);
                $('#time').html(modal.optime);
                $('.people-group').not('#other_people').unbind('click').click(function () {
                    modal.peopleid = $(this).attr('data-id');
                    $('.people-group').removeClass('active');
                    $('#people').html(this.childNodes[3].outerText);
                    $(this).addClass('active');
                })

                $('.chose-people').unbind('click').click(function(){
                    modal.getPeopleList();
                })
            }
        });
    };

    modal.getPeopleList = function () {
        $.ajax({
            url:core.getUrl('newstore.trade.picker.people_list'),
            type:'get',
            data:{goodsid:modal.goodsid,storeid:modal.storeid,optime:modal.optime,tdate:modal.tdate},
            success:function (data) {
                $('#peoplelistpicker').html(data);

                if (modal.peopleid > 0) {
                    $('#people_list_'+modal.peopleid).addClass('active');
                }

                $('.people-alert').addClass('show');

                $('.people-group').not('#other_people').unbind('click').click(function () {
                    modal.peopleid = $(this).attr('data-id');
                    $('.people-group').removeClass('active');
                    $('#people').html(this.childNodes[3].outerText);
                    $(this).addClass('active');
                    $('#people_'+modal.peopleid).addClass('active');
                    $('.people-alert').removeClass('show');
                })
            }
        });
    };

    modal.getTime = function () {
        $.ajax({
            url:core.getUrl('newstore.trade.picker.time'),
            type:'get',
            data:{goodsid:modal.goodsid,storeid:modal.storeid,ttime:modal.ttime,tmonth:modal.tmonth,tdate:modal.tdate},
            success:function (data) {
                $('#optimelist').html(data);
                $('.time_item').not("#other_time").unbind('click').click(function () {
                    $('.time_item').removeClass('active');
                    $(this).removeClass('active').addClass('active');
                    modal.optime = $(this).attr('data-id');
                    modal.getPeople();
                })
                $('.chose-time').unbind('click').click(function(){
                    modal.getTimeList();
                })

                $('#peoplepicker').html('<div class="fui-cell-info" style="height: 3rem; font-size: 0.7rem;"><p style="margin: 1rem 0;">请选择时间</p></div>');

            }
        });
    };

    modal.getTimeList = function () {
        $.ajax({
            url:core.getUrl('newstore.trade.picker.time_list'),
            type:'get',
            data:{goodsid:modal.goodsid,storeid:modal.storeid,ttime:modal.ttime,tmonth:modal.tmonth,tdate:modal.tdate},
            success:function (data) {
                $('#timepicker').html(data);
                $('#optime'+modal.optime.replace(/:/, "_")).removeClass('active').addClass('active');
                $('.time-alert').addClass('show');
                $('.optime').unbind('click').click(function () {
                    $('.time_item').removeClass('active');
                    modal.optime = $(this).attr('data-id');
                    // 如果选择的时间不在列表上则选中其他
                    if($('#op_time'+modal.optime.replace(/:/, "_")).length>0)
                    {
                        $('#op_time'+modal.optime.replace(/:/, "_")).removeClass('active').addClass('active');
                    }else{
                        $('#other_time').addClass('active');
                    }
                    $('#time').html(modal.optime);
                    $('#timepicker').html();
                    modal.getPeople();
                    $('.time-alert').removeClass('show');
                })
            }
        });
    };

    modal.getDetail = function () {
        $.ajax({
            url:core.getUrl('newstore.trade.detail.get_detail'),
            type:'get',
            data:{id:modal.goodsid},
            success:function (data) {
                $('.content-images-inner').html(data);
            }
        });
    };

    modal.showDetail = function () {
        $('.basic-block').hide();
        modal.getDetail();
        $('.detail-block').transition(300).addClass('in').transitionEnd(function () {
            $('.detail-block').transition('')
        })
    };
    modal.hideDetail = function () {
        $('.basic-block').show();
        $('.detail-block').transition(300).removeClass('in').transitionEnd(function () {
            $('.detail-block').transition('')
        })
    };
    return modal
});