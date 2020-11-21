var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: []
    },
    getMore: function() {
        var o = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var e = o.data.user.id, t = o.data.pindex, a = o.data.psize;
        _request2.default.get("explog", {
            op: "getmore",
            userid: e,
            pindex: t,
            psize: a
        }).then(function(e) {
            var t = o.data.list;
            1 == o.data.pindex && (t = []);
            var a = e;
            a.length < o.data.psize ? o.setData({
                list: t.concat(a),
                hasMore: !1
            }) : o.setData({
                list: t.concat(a),
                hasMore: !0,
                pindex: o.data.pindex + 1
            }), wx.hideToast();
        });
    },
    delItem: function(e) {
        var t = e.target.dataset.id, a = this.data.user.id;
        _request2.default.get("explog", {
            op: "delete",
            id: t,
            userid: a
        }).then(function(e) {
            wx.showModal({
                title: "提示信息",
                content: "支付记录删除成功！",
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../exp/explog"
                    });
                }
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../exp/explog"
                    });
                }
            });
        });
    },
    onLoad: function(e) {
        var t = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        this.setData({
            param: t,
            user: a
        }), null == a && wx.redirectTo({
            url: "../login/login"
        }), this.getMore();
    },
    onReady: function() {
        app.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.data.pindex = 1, this.getMore();
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getMore() : wx.showToast({
            title: "没有更多数据"
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});