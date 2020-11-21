var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = getApp();

Page({
    data: {
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: []
    },
    getMore: function() {
        var e = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var a = e.data.user.id, o = e.data.pindex, n = e.data.psize;
        t.default.get("explog", {
            op: "getmore",
            userid: a,
            pindex: o,
            psize: n
        }).then(function(t) {
            var a = e.data.list;
            1 == e.data.pindex && (a = []);
            var o = t;
            o.length < e.data.psize ? e.setData({
                list: a.concat(o),
                hasMore: !1
            }) : e.setData({
                list: a.concat(o),
                hasMore: !0,
                pindex: e.data.pindex + 1
            }), wx.hideToast();
        });
    },
    delItem: function(e) {
        var a = this, o = e.target.dataset.id, n = a.data.user.id;
        t.default.get("explog", {
            op: "delete",
            id: o,
            userid: n
        }).then(function(t) {
            wx.showModal({
                title: "提示信息",
                content: "支付记录删除成功！",
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../exp/explog"
                    });
                }
            });
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../exp/explog"
                    });
                }
            });
        });
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("param") || null, o = wx.getStorageSync("user") || null;
        e.setData({
            param: a,
            user: o
        }), null == o && wx.redirectTo({
            url: "../login/login"
        }), e.getMore();
    },
    onReady: function() {
        e.util.footer(this);
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
        var t = this;
        return {
            title: t.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: t.data.param.wxappshareimageurl
        };
    }
});