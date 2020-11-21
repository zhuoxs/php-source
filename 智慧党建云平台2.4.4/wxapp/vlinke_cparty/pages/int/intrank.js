var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var start_clientX, end_clientX, app = getApp(), myDate = new Date();

Page({
    data: {
        itype: "iyear",
        ivalue: myDate.getFullYear(),
        itypestr: "年",
        iyeararr: [],
        iseasonarr: [],
        imontharr: [],
        list: [],
        iyearval: myDate.getFullYear(),
        windowWidth: wx.getSystemInfoSync().windowWidth
    },
    touchstart: function(t) {
        start_clientX = t.changedTouches[0].clientX;
    },
    touchend: function(t) {
        120 < (end_clientX = t.changedTouches[0].clientX) - start_clientX ? this.setData({
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        }) : 0 < start_clientX - end_clientX && this.setData({
            display: "none",
            translate: ""
        });
    },
    showview: function(t) {
        var e = t.currentTarget.dataset.itype;
        this.setData({
            itype: e,
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
        var e = t.currentTarget.dataset.iyearval;
        this.setData({
            iyearval: e
        });
    },
    goRank: function(t) {
        var e = t.currentTarget.dataset.itype, a = t.currentTarget.dataset.ivalue;
        this.setData({
            itype: e,
            ivalue: a
        }), this.getRank(), this.hideview();
    },
    getRank: function() {
        var e = this, t = e.data.itype, a = e.data.ivalue, i = e.data.user.branchid;
        _request2.default.get("intrank", {
            op: "getrank",
            itype: t,
            ivalue: a,
            branchid: i
        }).then(function(t) {
            e.setData({
                itype: t.itype,
                ivalue: t.ivalue,
                itypestr: t.itypestr,
                iyeararr: t.iyeararr,
                iseasonarr: t.iseasonarr,
                imontharr: t.imontharr,
                list: t.list
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
        var e = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        this.setData({
            param: e,
            user: a
        }), null == a && wx.redirectTo({
            url: "../login/login"
        }), this.getRank();
    },
    onReady: function() {
        app.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});