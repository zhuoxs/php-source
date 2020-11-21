var app = getApp(), wxbarcode = require("../../../../../../zhy/resource/js/index.js");

Page({
    data: {
        show: !1,
        curPay: 1,
        isRequest: 0
    },
    onLoad: function(a) {
        this.setData({
            id: a.id,
            store_id: a.store_id
        });
        var t = wx.getStorageSync("userInfo");
        t ? this.setData({
            uInfo: t
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var t = encodeURIComponent("/sqtg_sun/pages/zkx/pages/merchants/confirmverification/confirmverification?id=" + id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else a.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        }), this.loadData();
    },
    loadData: function() {
        var t = this, e = t.data.store_id;
        app.ajax({
            url: "Corder|getOrderDetail",
            data: {
                order_id: t.data.id
            },
            success: function(a) {
                a.data.store_id != e && (setTimeout(function() {
                    app.tips("不能核销其他商户的订单");
                }, 500), wx.navigateBack({})), t.setData({
                    goods: a.data,
                    imgroot: a.other.img_root,
                    show: !0
                });
            }
        });
    },
    confirmOrder: function(a) {
        var t = this, e = t.data.goods, s = t.data.store_id;
        app.ajax({
            url: "Corder|confirmOrder2",
            data: {
                store_id: s,
                order_id: t.data.id
            },
            success: function(a) {
                console.log(a), e.order_status = 3, t.setData({
                    goods: e
                }), wx.showToast({
                    icon: "success",
                    duration: 2e3,
                    title: "核销成功"
                }), setTimeout(function() {
                    t.timer();
                }, 2e3);
            }
        });
    },
    timer: function() {
        wx.navigateBack({});
    },
    changePayType: function(a) {
        this.setData({
            curPay: a.currentTarget.dataset.index
        });
    },
    toClassifyDetail: function(a) {
        var t = a.currentTarget.dataset.id;
        app.navTo("/sqtg_sun/pages/hqs/pages/classifydetail/classifydetail?id=" + t);
    }
});