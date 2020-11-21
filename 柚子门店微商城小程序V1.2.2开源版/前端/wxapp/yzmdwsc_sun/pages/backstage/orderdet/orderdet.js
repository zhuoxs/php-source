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
        showModel: !1,
        express: [ "中通", "顺丰", "圆通", "申通", "韵达", "EMS", "邮政", "德邦", "天天", "宅急送", "优速", "汇通", "速尔", "全峰" ],
        index: 0,
        code: ""
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), t.setData({
            url: wx.getStorageSync("url")
        });
        var o = e.order_id;
        t.setData({
            id: o
        });
        var a = e.uid;
        app.util.request({
            url: "entry/wxapp/getOrderDetail",
            cachetime: "0",
            data: {
                id: o,
                uid: a
            },
            success: function(e) {
                console.log(e.data.data), e.data.data.order_status, t.setData({
                    order: e.data.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindPickerChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            index: e.detail.value
        });
    },
    showModel: function(e) {
        this.setData({
            showModel: !this.data.showModel
        });
    },
    getCode: function(e) {
        this.setData({
            code: e.detail.value
        });
    },
    formSubmit: function(e) {
        var t = this, o = t.data.id, a = e.detail.value.shipname, n = e.detail.value.shipnum;
        "" != n ? app.util.request({
            url: "entry/wxapp/setOrderFahuo",
            cachetime: "0",
            data: {
                id: o,
                express_delivery: a,
                express_orderformid: n
            },
            success: function(e) {
                0 == e.data.errcode && wx.showToast({
                    title: e.data.errmsg,
                    icon: "success",
                    duration: 2e3,
                    success: function() {},
                    complete: function() {
                        var e = t.data.order;
                        e.order_status = 2, t.setData({
                            showModel: !1,
                            order: e
                        });
                    }
                });
            }
        }) : wx.showToast({
            title: "请输入快递单号",
            icon: "none"
        });
    },
    Dialog: function(e) {
        wx.makePhoneCall({
            phoneNumber: e.currentTarget.dataset.phone
        });
    }
});