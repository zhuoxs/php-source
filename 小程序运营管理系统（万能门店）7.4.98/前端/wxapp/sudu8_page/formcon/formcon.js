var app = getApp();

Page({
    data: {
        page: 1
    },
    onPullDownRefresh: function() {
        this.getFormCon(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "我的表单提交详情页"
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        }));
        t.id && a.setData({
            id: t.id
        }), a.getBase(), app.util.getUserInfo(a.getinfos, e);
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
                }), a.getFormCon();
            }
        });
    },
    imgYu: function(t) {
        var a = t.currentTarget.dataset.src, e = t.currentTarget.dataset.list;
        wx.previewImage({
            current: a,
            urls: e
        });
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
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
    getFormCon: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/GetFormCon",
            data: {
                id: a.data.id
            },
            success: function(t) {
                a.setData({
                    formcon: t.data.data
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