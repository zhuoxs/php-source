var app = getApp();

Page({
    data: {
        id: wx.getStorageSync("mlogin"),
        miniNum: null,
        allMoney: null,
        tixianType: ""
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onShow: function() {
        this._getMyzh(this.data.id);
    },
    onHide: function() {
        this._getMyzh(this.data.id);
    },
    onLoad: function(a) {
        this._getMyzh(this.data.id);
        var t = this, i = 0;
        a.fxsid && (i = a.fxsid, t.setData({
            fxsid: a.fxsid
        }));
        var n = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: n,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(a) {
                a.data.data;
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(t.getinfos, i);
    },
    _getMyzh: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/getMoney",
            data: {
                id: wx.getStorageSync("mlogin")
            },
            success: function(a) {
                t.setData({
                    money: a.data.data.allMoney
                }), t.data.allMoney = a.data.data.allMoney, t.data.miniNum = a.data.data.miniNum, 
                t.data.tixianType = a.data.data.tixiantype;
            }
        });
    },
    goSzjl: function(a) {
        wx.navigateTo({
            url: "../manage_szjl/manage_szjl?" + this.data.id
        });
    },
    goTxjl: function(a) {
        wx.navigateTo({
            url: "../manage_txjl/manage_txjl?" + this.data.id
        });
    },
    goTx: function(a) {
        wx.navigateTo({
            url: "../manage_gotixian/manage_gotixian?allMoney=" + this.data.allMoney + "&miniNum=" + this.data.miniNum + "&tixianType=" + this.data.tixianType
        });
    }
});