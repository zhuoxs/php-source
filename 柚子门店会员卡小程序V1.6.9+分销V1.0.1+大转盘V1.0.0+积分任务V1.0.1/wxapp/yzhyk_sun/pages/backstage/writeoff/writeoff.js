var app = getApp();

Page({
    data: {
        navTile: "订单详情",
        order: {
            uname: "李星和",
            phone: 13e7,
            remark: "留言",
            ordernum: "123215678469463",
            times: "2018-06-06 10:10:10",
            status: 2
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
        isIpx: app.globalData.isIpx
    },
    onLoad: function(o) {
        var t = this;
        app.get_imgroot().then(function(n) {
            app.util.request({
                url: "entry/wxapp/GetOrderInfoByCode",
                data: {
                    code: o.code
                },
                success: function(o) {
                    t.setData({
                        imgroot: n,
                        order: o.data
                    });
                }
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    Dialog: function(o) {
        console.log(o), wx.makePhoneCall({
            phoneNumber: o.currentTarget.dataset.phone
        });
    },
    toConfirm: function(o) {
        var n = this.data.order.id;
        app.util.request({
            url: "entry/wxapp/ConfirmOrder",
            fromcache: !1,
            data: {
                id: n
            },
            success: function(o) {
                0 == o.data.code ? wx.showModal({
                    title: "提示",
                    content: "核销成功",
                    showCancel: !1,
                    success: function(o) {
                        wx.navigateBack({});
                    }
                }) : wx.showModal({
                    title: "提示",
                    content: "核销失败",
                    showCancel: !1
                });
            }
        });
    },
    toOrderlist: function(o) {
        wx.navigateBack({});
    }
});