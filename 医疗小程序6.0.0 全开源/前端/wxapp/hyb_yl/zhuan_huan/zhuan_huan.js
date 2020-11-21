var app = getApp();

Page({
    data: {
        wendaArr: [],
        editCon: "编辑",
        a: !1,
        edit: !1
    },
    swichNav: function(e) {
        var a = this.data.nav;
        a.currentTab = e.currentTarget.dataset.current, this.setData({
            nav: a
        });
    },
    onLoad: function(e) {
        var a = this, t = wx.getStorageSync("color"), n = wx.getStorageSync("openid");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        }), app.util.request({
            url: "entry/wxapp/Alllipei",
            data: {
                openid: n
            },
            success: function(e) {
                console.log(e), a.setData({
                    wendaArr: e.data.data
                });
            }
        }), a.setData({
            backgroundColor: t
        });
    },
    editClick: function() {
        var e = this;
        if (e.data.edit) ; else var a = !1;
        e.setData({
            edit: !e.data.edit,
            a: a
        });
    },
    checkboxChange: function(e) {
        console.log("checkbox发生change事件，携带value值为：", e.detail.value);
        if (0 == e.detail.value.length) var a = !1; else a = !0;
        this.setData({
            a: a
        });
    },
    del: function(e) {
        console.log(e);
        var a = e.currentTarget.dataset.index, t = this.data.wendaArr;
        console.log(t[a].checked), 0 == t[a].checked || null == t[a].checked ? t[a].checked = 1 : t[a].checked = 0, 
        this.setData({
            wendaArr: t
        });
    },
    subClick: function(e) {
        console.log(e);
        var a = this.data.wendaArr, t = e.detail.value.checkBox;
        app.util.request({
            url: "entry/wxapp/Delelip",
            data: {
                lpid: t
            },
            success: function(e) {
                e.data.data;
                console.log(e);
            },
            fail: function(e) {
                console.log(e);
            }
        });
        for (var n = 0, o = a.length; n < o; n++) console.log(a[n]), 1 == a[n].checked && (a.splice(n, 1), 
        n--, o--);
        this.setData({
            wendaArr: a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    lipeils: function(e) {
        console.log(e);
        var a = e.currentTarget.dataset.lpid;
        wx.navigateTo({
            url: "/hyb_yl/patient2/patient2?lpid=" + a
        });
    }
});