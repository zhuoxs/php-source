var app = getApp();

Page({
    data: {
        navTile: "我的车友卡",
        isMember: !0,
        bg: "../../../style/images/bg.png",
        cardsBg: app.globalData.cardsBg,
        weblogo: "../../../style/images/logo.png",
        nav: [ "专属特权", "使用须知", "购卡福利" ],
        curIndex: 2,
        welfare: [],
        curPage: 1,
        pagesize: 3,
        isIpx: app.globalData.isIpx,
        imgroot: wx.getStorageSync("imgroot")
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = wx.getStorageSync("setting");
        a ? wx.setNavigationBarColor({
            frontColor: a.fontcolor,
            backgroundColor: a.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), app.get_imgroot().then(function(a) {
            app.get_qz_cards(!0).then(function(t) {
                t.background = t.background ? a + t.background : t.background, e.setData({
                    imgroot: a,
                    qzCards: t,
                    cardsBg: t.background || e.data.cardsBg
                });
            }), app.get_setting().then(function(t) {
                e.setData({
                    setting: t
                });
            });
        }), app.get_user_vip().then(function(t) {
            e.setData({
                vipType: t
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.get_user_info(!0).then(function(t) {
            a.setData({
                user: t
            });
        }), a.get_welfare_list();
    },
    get_welfare_list: function() {
        var n = this, o = n.data.curPage, i = n.data.list;
        app.util.request({
            url: "entry/wxapp/getActivity",
            cachetime: "0",
            data: {
                gkfl_status: 1,
                page: o,
                pagesize: n.data.pagesize
            },
            success: function(t) {
                var a = t.data.length == n.data.pagesize;
                if (1 == o) i = t.data; else for (var e in t.data) i.push(t.data[e]);
                o += 1, n.setData({
                    list: i,
                    curPage: o,
                    hasMore: a
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        this.data.hasMore ? this.get_welfare_list() : wx.showToast({
            title: "没有更多福利活动啦~",
            icon: "none"
        });
    },
    onShareAppMessage: function() {},
    bTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    },
    toJoinmember: function(t) {
        wx.navigateTo({
            url: "joinmember/joinmember"
        });
    },
    toActivedet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/parentingdet/parentingdet?id=" + a
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "../index/index"
        });
    },
    updateUserInfo: function(t) {
        var a = wx.getStorageSync("user") || [];
        this.setData({
            user: a
        });
    }
});