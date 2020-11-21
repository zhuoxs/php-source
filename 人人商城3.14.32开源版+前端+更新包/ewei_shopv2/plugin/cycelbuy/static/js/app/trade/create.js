define(['core', 'tpl'], function (core, tpl) {
    var modal = {};
    modal.init = function (params) {

        modal.goodsid = params.goodsid;
        modal.storeid = params.storeid;
        modal.trade_time = params.trade_time;
        modal.optime = params.optime;
        modal.peopleid = params.peopleid;
        modal.tdate = params.tdate;

        modal.need_timeslice = params.need_timeslice;
        modal.need_arrival = params.need_arrival;
        modal.need_username = params.need_username;
        modal.need_mobile = params.need_mobile;
        modal.need_address = params.need_address;
        modal.need_trade = params.need_trade;
        modal.need_id = params.need_id;
        modal.addressid=params.addressid;
        // modal.need_number = params.need_number;

        // alert(modal.need_timeslice);


        var loadAddress = false;
        if (typeof(window.selectedAddressData) !== 'undefined') {
            loadAddress = window.selectedAddressData
        } else if (typeof(window.editAddressData) !== 'undefined') {
            loadAddress = window.editAddressData;
            loadAddress.address = loadAddress.areas.replace(/ /ig, '') + ' ' + loadAddress.address
        }

        if (loadAddress) {
            modal.addressid = loadAddress.id;
            $('#addressInfo .realname').html(loadAddress.realname);
            $('#addressInfo .mobile').html(loadAddress.mobile);
            $('#addressInfo .address').html(loadAddress.address);
            $('#addressInfo a').attr('href', core.getUrl('member/address/selector'));
            $('#listaddress').show();
            $('#addaddress').hide();
            $('#addressInfo a').click(function () {
                window.orderSelectedAddressID = loadAddress.id
            })
        }

        $(".preview_btn .btn").click(function () {
            modal.submit(this, params.token)
        });
    };

    modal.submit = function (obj, token) {
        var $this = $(obj);

        if ($this.attr('stop')) {
            return
        }

        // alert(modal.need_username);


        if (modal.need_address == 1) {
            if (modal.addressid == 0) {
                FoxUI.toast.show('请选择收货地址');
                return
            }
        }

        if (modal.need_username == 1) {
            if ($(':input[name=carrier_realname]').isEmpty()) {
                FoxUI.toast.show('请填写预约人');
                return
            }
        }
        if (modal.need_mobile == 1) {
            if ($(':input[name=carrier_mobile]').isEmpty()) {
                FoxUI.toast.show('请填写手机号');
                return
            }
            if (!$(':input[name=carrier_mobile]').isMobile()) {
                FoxUI.toast.show('联系电话格式有误');
                return
            }
        }

        if (modal.need_id == 1) {
            if (!$(':input[name=carrier_id]').isIDCard()) {
                FoxUI.toast.show('请填写正确身份证号码');
                return
            }
        }
        if (modal.need_number == 1) {
            if (!$(':input[name=carrier_number]').isNumber()) {
                FoxUI.toast.show('请填写预约人数');
                return
            }
        }

        $this.attr('stop', 1);

        var data = {};
        data['goodsid'] = modal.goodsid;
        data['storeid'] = modal.storeid;
        data['trade_time'] = modal.trade_time;
        data['peopleid'] = modal.peopleid;
        data['optime'] = modal.optime;
        data['tdate'] = modal.tdate;
        data['addressid'] = modal.addressid;

        data['remark'] = $("#remark").val();

        // data['carrier_realname'] = $(':input[name=carrier_realname]').val();
        // data['carrier_mobile'] = $(':input[name=carrier_mobile]').val();
        data['submit'] = true;
        data['token'] = token;

        data['carriers'] = {
            'carrier_realname': $(':input[name=carrier_realname]').val(),
            'carrier_mobile': $(':input[name=carrier_mobile]').val(),
            'carrier_id': $(':input[name=carrier_id]').val(),
            'carrier_number': $(':input[name=carrier_number]').val()
        }


        FoxUI.loader.show('正在创建订单...', 'icon icon-add');
        core.json('newstore/trade/create/submit', data, function (ret) {
            $this.removeAttr('stop', 1);
            if (ret.status == 0 ) {
                FoxUI.loader.hide();
                FoxUI.toast.show(ret.result.message);
                return;
            }
            if (ret.status == -1 ) {
                FoxUI.loader.hide();
                FoxUI.alert(ret.result.message);
                return;
            }
            location.href =  core.getUrl('order/pay',{id: ret.result.orderid});
        }, false, true)
    };

    return modal
});