var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        navTile: "订单详情",
        order: {
            uname: "李星和",
            phone: 13e7,
            remark: "留言",
            order_number: "123215678469463",
            time: "2018-06-06 10:10:10",
            status: 2,
            pay_amount: 100,
            take_address: "地址啊啊啊啊"
        },
        address: "厦门市集美区",
        shopPhone: 13e8,
        goods: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            goodsThumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "2.50",
            specConn: "s",
            num: "1"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            goodsThumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "2.50",
            specConn: "套餐1",
            num: "1"
        } ],
        is_hx: 0,
        is_dis: 0
    },
    onLoad: function(e) {
        var o = this;
        wx.setNavigationBarTitle({
            title: o.data.navTile
        });
        var t = e.sn, n = e.dis || 0;
        _request2.default.get("getOrderDetail", {
            order_sn: t
        }).then(function(e) {
            console.log(e);
            var t = 0;
            40 == e.order.status && (t = 1), o.setData({
                order: e.order,
                goods: e.goods,
                store: e.store,
                is_hx: t,
                is_dis: n
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    Dialog: function(e) {
        console.log(e), wx.makePhoneCall({
            phoneNumber: e.currentTarget.dataset.phone
        });
    },
    toConfirm: function(e) {
        var t = this.data.order.sn;
        1 == this.data.is_dis ? _request2.default.post("disOrderFinish", {
            dis_order_sn: t
        }).then(function(e) {
            console.log(e), wx.showToast({
                title: "成功核销订单",
                icon: "success",
                duration: 1e3,
                success: function(e) {
                    wx.redirectTo({
                        url: "../../user/dorder/dorder?index=2"
                    });
                }
            });
        }) : _request2.default.get("adminVerifyOrder", {
            order_sn: t
        }).then(function(e) {
            console.log(e), wx.showToast({
                title: "成功核销订单",
                icon: "success",
                duration: 1e3,
                success: function(e) {
                    wx.redirectTo({
                        url: "../index/index"
                    });
                }
            });
        });
    },
    toOrderlist: function(e) {
        wx.navigateBack({});
    }
});