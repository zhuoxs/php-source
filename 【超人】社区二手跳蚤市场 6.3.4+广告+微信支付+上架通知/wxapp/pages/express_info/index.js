var app = getApp(), Toast = require("../../libs/zanui/toast/toast");

Page({
    data: {
        expressList: [ {
            name: "顺丰速运",
            code: "SF"
        }, {
            name: "百世快递",
            code: "HTKY"
        }, {
            name: "中通快递",
            code: "ZTO"
        }, {
            name: "申通快递",
            code: "STO"
        }, {
            name: "圆通速递",
            code: "YTO"
        }, {
            name: "韵达速递",
            code: "YD"
        }, {
            name: "邮政快递",
            code: "YZPY"
        }, {
            name: "EMS",
            code: "EMS"
        }, {
            name: "天天快递",
            code: "HHTT"
        }, {
            name: "京东快递",
            code: "JD"
        }, {
            name: "优速快递",
            code: "UC"
        }, {
            name: "德邦快递",
            code: "DBL"
        }, {
            name: "宅急送",
            code: "ZJS"
        }, {
            name: "TNT快递",
            code: "TNT"
        }, {
            name: "UPS",
            code: "UPS"
        }, {
            name: "DHL",
            code: "DHL"
        } ]
    },
    onLoad: function(e) {
        var a = this, o = wx.getStorageSync("loading_img");
        o ? a.setData({
            loadingImg: o
        }) : a.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), e.orderid && a.getExpressInfo(e.orderid);
    },
    getExpressInfo: function(e) {
        var s = this;
        app.util.request({
            url: "entry/wxapp/order",
            cachetime: "0",
            data: {
                act: "express_info",
                orderid: e,
                m: "superman_hand2"
            },
            success: function(e) {
                if (e.data.errno) s.showIconToast(e.data.errmsg); else {
                    for (var a = e.data.data.Traces, o = e.data.data.order, t = s.data.expressList, n = 0; n < t.length; n++) t[n].code == o.express_company && (o.express_company = t[n].name);
                    s.setData({
                        info: a && 0 < a.length ? a.reverse() : [],
                        order: o,
                        completed: !0
                    });
                }
            },
            fail: function(e) {
                s.setData({
                    completed: !0
                }), s.showIconToast(e.data.errmsg);
            }
        });
    },
    showIconToast: function(e) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: a,
            message: e,
            selector: "#zan-toast"
        });
    }
});