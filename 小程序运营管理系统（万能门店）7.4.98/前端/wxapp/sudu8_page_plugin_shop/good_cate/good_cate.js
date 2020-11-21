var app = getApp();

Page({
    data: {
        title: [],
        baseinfo: [],
        id: "0"
    },
    onPullDownRefresh: function() {
        var a = this;
        a.getList(a.data.id), a.getBase(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        this.data.id = a.id;
        var t = this;
        t.getList(t.data.id), t.getBase();
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getBase: function() {
        var t = this, a = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: a,
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    handleTap: function(a) {
        var t = this;
        t.data.id = a.currentTarget.id.slice(1), t.getList(t.data.id);
    },
    getList: function(s) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/goodscate",
            cachetime: "30",
            data: {
                cid: s
            },
            success: function(a) {
                for (var t = a.data.data[1], e = a.data.data[0], i = 0; i < e.length; i++) if (e[i].id == s) var n = e[i].name;
                wx.setNavigationBarTitle({
                    title: n
                }), o.setData({
                    cateinfo: e,
                    cate_list: t,
                    id: s
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.cateinfo.name + "-" + this.data.baseinfo.name
        };
    }
});