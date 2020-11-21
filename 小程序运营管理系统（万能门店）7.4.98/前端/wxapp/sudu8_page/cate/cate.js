var app = getApp();

Page({
    data: {
        baseinfo: [],
        index: 0,
        page_signs: "/sudu8_page/cate/cate",
        curNav: 0
    },
    onLoad: function() {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.getSystemInfo({
            success: function(t) {
                a.setData({
                    h: t.windowHeight - 55 + "px"
                });
            }
        }), a.getBase(), a.getAllCate(), wx.setNavigationBarTitle({
            title: "商品分类"
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/base",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            },
            fail: function(t) {}
        });
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    catelists: function(t) {
        wx.navigateTo({
            url: "" + t.currentTarget.dataset.url
        });
    },
    getAllCate: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/allCatep",
            cachetime: "30",
            success: function(t) {
                a.setData({
                    catelist: t.data.data.list,
                    cateson: t.data.data.son
                });
            },
            fail: function(t) {}
        });
    },
    switchRightTab: function(t) {
        var a = this, e = t.target.dataset.id, s = parseInt(t.target.dataset.index);
        app.util.request({
            url: "entry/wxapp/getcateson",
            cachetime: "30",
            data: {
                id: e
            },
            success: function(t) {
                a.setData({
                    cateson: t.data.data
                });
            },
            fail: function(t) {}
        }), this.setData({
            curNav: s,
            index: s
        });
    }
});