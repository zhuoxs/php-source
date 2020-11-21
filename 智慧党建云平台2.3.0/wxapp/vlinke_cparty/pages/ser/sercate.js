var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = getApp();

Page({
    data: {
        cateid: 0,
        cate: [],
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
        var a = e.data.cateid, n = e.data.pindex, i = e.data.psize;
        t.default.get("sercate", {
            op: "getmore",
            cateid: a,
            pindex: n,
            psize: i
        }).then(function(t) {
            var a = e.data.list;
            1 == e.data.pindex && (a = []);
            var n = t;
            n.length < e.data.psize ? e.setData({
                list: a.concat(n),
                hasMore: !1
            }) : e.setData({
                list: a.concat(n),
                hasMore: !0,
                pindex: e.data.pindex + 1
            }), wx.hideToast();
        });
    },
    onLoad: function(e) {
        var a = this, n = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        a.setData({
            param: n,
            user: i
        }), null == i && wx.redirectTo({
            url: "../login/login"
        });
        var o = e.cateid;
        a.setData({
            cateid: o
        }), t.default.get("sercate", {
            cateid: o
        }).then(function(t) {
            a.setData({
                cate: t.cate
            }), a.getMore();
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../ser/serhome"
                    });
                }
            });
        });
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