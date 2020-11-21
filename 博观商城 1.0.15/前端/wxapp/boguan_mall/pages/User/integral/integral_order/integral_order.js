var a = require("../../../../utils/base.js"), t = require("../../../../../api.js"), e = new a.Base();

Page({
    data: {
        page: 1,
        size: 20,
        loadmore: !0,
        loadnot: !1,
        integral: []
    },
    onLoad: function(a) {
        console.log(a), this.setData({
            vipIntegral: a.vipIntegral
        }), this.getIntagral();
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getIntagral(), console.log("loadmore=>", this.data.loadmore);
    },
    getIntagral: function() {
        var a = this, o = {
            url: t.default.integral_detail,
            data: {
                page: this.data.page,
                size: this.data.size
            },
            method: "get"
        };
        e.getData(o, function(t) {
            console.log(t), 1 == t.errorCode ? (a.data.integral.push.apply(a.data.integral, t.data.data), 
            a.setData({
                integral: a.data.integral
            }), t.data.data.length < a.data.size && a.setData({
                loadmore: !1,
                loadnot: !0
            })) : a.setData({
                loadmore: !1,
                loadnot: !0
            });
        });
    }
});