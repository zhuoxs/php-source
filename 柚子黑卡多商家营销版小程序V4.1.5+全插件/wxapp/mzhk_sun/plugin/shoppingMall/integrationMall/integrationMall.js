/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        variable: !0,
        is_modal_Hidden: !0,
        page: 1,
        pageSize: 10,
        id: "",
        list: []
    },
    onLoad: function(t) {
        app.wxauthSetting();
        t.id;
        this.getGoods()
    },
    onShow: function() {
        app.func.islogin(app, this)
    },
    getGoods: function() {
        var e = this,
            t = e.data.id,
            o = e.data.page,
            i = e.data.list;
        console.log(wx.getStorageSync("users")), app.util.request({
            url: "entry/wxapp/getGoodsList",
            data: {
                m: app.globalData.Plugin_scoretask,
                page: o,
                pagesize: e.data.pagesize,
                id: t
            },
            showLoading: !1,
            success: function(t) {
                console.log(t.data.other);
                t.data.data.length, e.data.pagesize;
                if (1 == o) i = t.data.data;
                else for (var a in t.data.data) i.push(t.data.data[a]);
                o += 1, console.log(t.data.data), e.setData({
                    listArray: i,
                    imgroot: t.data.other.img_root,
                    page: o
                })
            }
        })
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getArticleList() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        })
    },
    lower: function(t) {
        this.data.hasMore ? this.getArticleList() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        })
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh()
    },
    productDetails: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../details/details?id=" + a
        }), console.log(a)
    },
    home: function() {
        wx.redirectTo({
            url: "../home/home"
        })
    },
    assignment: function() {
        wx.redirectTo({
            url: "../assignment/assignment"
        })
    },
    me: function() {
        wx.redirectTo({
            url: "../me/me"
        })
    },
    updateUserInfo: function(t) {
        app.wxauthSetting()
    }
});