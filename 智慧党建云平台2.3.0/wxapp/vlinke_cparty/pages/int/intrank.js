var t, a, e = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), i = getApp(), n = new Date();

Page({
    data: {
        itype: "iyear",
        ivalue: n.getFullYear(),
        itypestr: "年",
        iyeararr: [],
        iseasonarr: [],
        imontharr: [],
        list: [],
        iyearval: n.getFullYear(),
        windowWidth: wx.getSystemInfoSync().windowWidth
    },
    touchstart: function(a) {
        t = a.changedTouches[0].clientX;
    },
    touchend: function(e) {
        (a = e.changedTouches[0].clientX) - t > 120 ? this.setData({
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        }) : t - a > 0 && this.setData({
            display: "none",
            translate: ""
        });
    },
    showview: function(t) {
        var a = t.currentTarget.dataset.itype;
        this.setData({
            itype: a,
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        });
    },
    hideview: function() {
        this.setData({
            display: "none",
            translate: ""
        });
    },
    changeIyearval: function(t) {
        var a = t.currentTarget.dataset.iyearval;
        this.setData({
            iyearval: a
        });
    },
    goRank: function(t) {
        var a = this, e = t.currentTarget.dataset.itype, i = t.currentTarget.dataset.ivalue;
        this.setData({
            itype: e,
            ivalue: i
        }), a.getRank(), a.hideview();
    },
    getRank: function() {
        var t = this, a = t.data.itype, i = t.data.ivalue, n = t.data.user.branchid;
        e.default.get("intrank", {
            op: "getrank",
            itype: a,
            ivalue: i,
            branchid: n
        }).then(function(a) {
            t.setData({
                itype: a.itype,
                ivalue: a.ivalue,
                itypestr: a.itypestr,
                iyeararr: a.iyeararr,
                iseasonarr: a.iseasonarr,
                imontharr: a.imontharr,
                list: a.list
            });
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../int/intrank"
                    });
                }
            });
        });
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        a.setData({
            param: e,
            user: i
        }), null == i && wx.redirectTo({
            url: "../login/login"
        }), a.getRank();
    },
    onReady: function() {
        i.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this;
        return {
            title: t.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: t.data.param.wxappshareimageurl
        };
    }
});