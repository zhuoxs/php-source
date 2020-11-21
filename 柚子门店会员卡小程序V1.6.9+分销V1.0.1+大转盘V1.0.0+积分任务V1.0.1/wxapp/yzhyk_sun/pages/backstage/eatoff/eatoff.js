var app = getApp();

Page({
    data: {
        navTile: "大转盘奖品核销",
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
        var n = this;
        console.log(o), app.get_imgroot().then(function(t) {
            app.util.request({
                url: "entry/wxapp/GetOrderInfoByEat",
                data: {
                    id: o.id
                },
                success: function(o) {
                    n.setData({
                        imgroot: t,
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
        var t = this.data.order.id, n = Date.parse(new Date()) / 1e3;
        this.data.order.extime < n ? wx.showModal({
            title: "提示",
            content: "核销失败，时间已过！",
            showCancel: !1,
            success: function(o) {
                wx.navigateBack({});
            }
        }) : (console.log(2), app.util.request({
            url: "entry/wxapp/ConfirmEatOrder",
            fromcache: !1,
            data: {
                id: t
            },
            success: function(o) {
                0 == o.data ? wx.showModal({
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
        }));
    },
    toOrderlist: function(o) {
        wx.navigateBack({});
    }
});