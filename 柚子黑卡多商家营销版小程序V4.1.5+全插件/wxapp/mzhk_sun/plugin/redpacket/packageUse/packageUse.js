/*   time:2019-08-09 13:18:40*/
var app = getApp();
Page({
    data: {
        content: [],
        list: [],
        page: 1,
        id: ""
    },
    onLoad: function(a) {
        var t = this,
            o = a.id;
        app.util.request({
            url: "entry/wxapp/getDetail",
            showLoading: !1,
            data: {
                id: o,
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                console.log(a.data), 2 != a.data ? t.setData({
                    content: a.data,
                    list: a.data.goods,
                    id: o
                }) : t.setData({
                    content: [],
                    list: []
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var o = this,
            e = o.data.page,
            a = o.data.id,
            n = o.data.list;
        app.util.request({
            url: "entry/wxapp/getDetail",
            cachetime: "0",
            data: {
                id: a,
                page: e,
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                if (console.log(a.data), console.log(a.data.goods), null != a.data.goods && 0 < a.data.goods.length) {
                    var t = a.data.goods;
                    n = n.concat(t), o.setData({
                        list: n,
                        page: e + 1
                    })
                } else wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                })
            }
        })
    },
    toDetail: function(a) {
        var t = a.currentTarget.dataset.lid,
            o = a.currentTarget.dataset.gid;
        1 == t ? wx.navigateTo({
            url: "../../../pages/index/goods/goods?gid=" + o
        }) : 2 == t ? wx.navigateTo({
            url: "../../../pages/index/bardet/bardet?id=" + o
        }) : 3 == t ? wx.navigateTo({
            url: "../../../pages/index/groupdet/groupdet?id=" + o
        }) : 5 == t ? wx.navigateTo({
            url: "../../../pages/index/package/package?id=" + o
        }) : 12 == t && wx.navigateTo({
            url: "/mzhk_sun/plugin2/secondary/detail/detail?id=" + o
        })
    },
    updateUserInfo: function(a) {
        console.log("授权操作更新");
        app.wxauthSetting()
    },
    onAnchorPoint: function() {
        wx.pageScrollTo({
            scrollTop: 440,
            duration: 500
        })
    }
});