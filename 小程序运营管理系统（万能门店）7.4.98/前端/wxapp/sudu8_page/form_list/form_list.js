var app = getApp();

Page({
    data: {
        page: 1
    },
    onPullDownRefresh: function() {
        this.setData({
            page: 1
        }), this.getFormList(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "我的表单提交列表"
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), a.getBase(), app.util.getUserInfo(a.getinfos, e);
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                }), a.getFormList();
            }
        });
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
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
    getFormList: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/GetFormList",
            data: {
                openid: a.data.openid,
                page: a.data.page
            },
            success: function(t) {
                a.setData({
                    formset: t.data.data
                });
            },
            fail: function(t) {}
        });
    },
    onReachBottom: function() {
        var a = this, e = a.data.page + 1;
        app.util.request({
            url: "entry/wxapp/GetFormList",
            data: {
                openid: a.data.openid,
                page: e
            },
            success: function(t) {
                a.setData({
                    page: e,
                    formset: a.data.formset.concat(t.data.data)
                });
            },
            fail: function(t) {}
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onShareAppMessage: function() {}
});