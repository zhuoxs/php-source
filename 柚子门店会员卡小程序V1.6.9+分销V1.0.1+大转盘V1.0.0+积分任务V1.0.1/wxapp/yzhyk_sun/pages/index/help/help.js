var _Page;

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        showModalStatus: !1,
        order: [],
        ig: [],
        img: [],
        isHelp: !1
    },
    onLoad: function(e) {
        var a = this;
        wx.getUserInfo({
            success: function(t) {
                a.setData({
                    thumb: t.userInfo.avatarUrl,
                    nickname: t.userInfo.nickName
                });
            }
        }), app.get_imgroot().then(function(t) {
            a.setData({
                imgroot: t
            });
        }), app.get_user_info().then(function(t) {
            a.setData({
                user: t,
                cut_id: e.id
            }), a.updatePageData();
        }), e.d_user_id && app.distribution.distribution_parsent(app, e.d_user_id);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    order: function(t) {},
    bargain: function(t) {}
}, "onShareAppMessage", function() {}), _defineProperty(_Page, "powerDrawer", function(a) {
    var i = this, t = i.data.cut_info.id, e = i.data.user;
    app.util.request({
        url: "entry/wxapp/HelpCut",
        cachetime: "0",
        data: {
            cut_id: t,
            user_id: e.id
        },
        success: function(t) {
            if (0 == t.data.code) {
                i.setData({
                    cut_price: t.data.price
                });
                var e = a.currentTarget.dataset.statu;
                i.util(e), i.setData({
                    isHelp: !0
                }), i.updatePageData();
            } else wx.showModal({
                title: "提示",
                content: t.data.msg
            });
        }
    });
}), _defineProperty(_Page, "powerDrawer2", function(t) {
    var e = this, a = t.currentTarget.dataset.statu;
    e.util(a), e.setData({
        isHelp: !0
    }), e.updatePageData();
}), _defineProperty(_Page, "util", function(t) {
    var e = wx.createAnimation({
        duration: 200,
        timingFunction: "linear",
        delay: 0
    });
    (this.animation = e).opacity(0).height(0).step(), this.setData({
        animationData: e.export()
    }), setTimeout(function() {
        e.opacity(1).height("468rpx").step(), this.setData({
            animationData: e
        }), "close" == t && this.setData({
            showModalStatus: !1
        });
    }.bind(this), 200), "open" == t && this.setData({
        showModalStatus: !0
    });
}), _defineProperty(_Page, "help", function(t) {
    wx.updateShareMenu({
        withShareTicket: !0,
        success: function() {}
    });
}), _defineProperty(_Page, "toDetail", function(t) {
    var e = this.data.cut_info.storecutgoods_id;
    wx.navigateTo({
        url: "../bardet/bardet?id=" + e
    });
}), _defineProperty(_Page, "updatePageData", function() {
    var o = this, t = o.data.cut_id, e = o.data.user;
    app.util.request({
        url: "entry/wxapp/GetCutGoodsByCutID",
        cachetime: "0",
        data: {
            cut_id: t,
            user_id: e.id
        },
        success: function(t) {
            0 != t.data.cut_price && o.setData({
                isHelp: !0,
                cut_price: t.data.cut_price
            });
            var e = t.data.cut_info, a = t.data.list, i = t.data.info, n = JSON.parse(i.pics);
            i.imgUrls = n, i.detail = i.content, o.setData({
                goods: i,
                cut_list: a,
                cut_info: e
            });
        }
    });
}), _defineProperty(_Page, "toIndex", function(t) {
    wx.redirectTo({
        url: "/yzhyk_sun/pages/index/index"
    });
}), _Page));