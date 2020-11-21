var app = getApp(), wxbarcode = require("../../../../../zhy/resource/js/index.js");

Page({
    data: {
        downTime: 0,
        payType: [ {
            name: "微信支付",
            pic: "../../../../../zhy/resource/images/wx.png"
        }, {
            name: "余额支付",
            pic: "../../../../../zhy/resource/images/local.png"
        } ],
        curPay: 1,
        alert: !1,
        ajax: !1
    },
    onLoad: function(t) {
        this.setData({
            id: t.id,
            store_id: t.store_id
        }), this.onLoadData();
    },
    onLoadData: function() {
        var e = this, a = this, t = wx.getStorageSync("userInfo");
        if (t) {
            this.setData({
                uInfo: t
            });
            var i = {
                order_num: this.data.id,
                store_id: this.data.store_id
            };
            app.api.getCpinOrdernumFind(i).then(function(t) {
                e.data.store_id == t.data.info.store_id ? e.setData({
                    info: t.data,
                    imgRoot: t.other.img_root,
                    show: !0
                }) : wx.showModal({
                    title: "提示",
                    content: "不是本店商品！",
                    showCancel: !1,
                    success: function(t) {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }).catch(function(t) {
                t.code, app.tips(t.msg);
            });
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var e = encodeURIComponent("/sqtg_sun/pages/plugin/spell/checkorder/checkorder?id=" + a.data.id);
                    clearInterval(this.timer), app.reTo("/sqtg_sun/pages/home/login/login?id=" + e);
                } else t.cancel && (clearInterval(this.timer), app.lunchTo("/sqtg_sun/pages/home/index/index"));
            }
        });
    },
    onBtnTab: function() {
        var e = this;
        wx.getStorageSync("userInfo");
        wx.showModal({
            title: "提示",
            content: "确定核销该订单？",
            success: function(t) {
                t.confirm && app.api.getCpinUseOrd({
                    oid: e.data.info.info.id,
                    user_id: e.data.info.info.user_id,
                    store_id: e.data.store_id
                }).then(function(t) {
                    app.tips("核销成功"), setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }, 1e3);
                }).catch(function(t) {
                    t.code, app.tips(t.msg);
                });
            }
        });
    }
});