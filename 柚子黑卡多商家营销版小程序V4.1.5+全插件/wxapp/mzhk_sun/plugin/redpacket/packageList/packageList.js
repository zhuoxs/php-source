/*   time:2019-08-09 13:18:40*/
var app = getApp();
Page({
    data: {
        currenttab: "0",
        list: [],
        usenums: 0,
        nousenums: 0,
        page: [1, 1]
    },
    onLoad: function(a) {
        var t = this,
            e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getUserRedpacket",
            showLoading: !1,
            data: {
                type: 0,
                openid: e,
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                console.log(a.data), 1 == a.data[0].isok ? t.setData({
                    list: a.data,
                    usenums: a.data[0].usenums,
                    nousenums: a.data[0].nousenums
                }) : t.setData({
                    usenums: a.data[0].usenums,
                    nousenums: a.data[0].nousenums,
                    list: []
                })
            }
        })
    },
    onRedPackage: function(a) {
        var t = this,
            e = a.currentTarget.dataset.tabid,
            n = wx.getStorageSync("openid");
        t.data.list;
        app.util.request({
            url: "entry/wxapp/getUserRedpacket",
            showLoading: !1,
            data: {
                type: e,
                openid: n,
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                console.log(a.data), 1 == a.data[0].isok ? t.setData({
                    currenttab: e,
                    list: a.data,
                    usenums: a.data[0].usenums,
                    nousenums: a.data[0].nousenums
                }) : t.setData({
                    currenttab: e,
                    usenums: a.data[0].usenums,
                    nousenums: a.data[0].nousenums,
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
        var e = this,
            n = e.data.currenttab,
            a = wx.getStorageSync("openid"),
            s = e.data.list,
            u = e.data.page,
            o = u[n];
        app.util.request({
            url: "entry/wxapp/getUserRedpacket",
            cachetime: "10",
            data: {
                type: n,
                openid: a,
                page: o,
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                if (2 == a.data[0].isok) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                });
                else {
                    var t = a.data;
                    s = s.concat(t), u[n] = o + 1, e.setData({
                        list: s,
                        page: u
                    })
                }
            }
        })
    },
    toDetail: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/mzhk_sun/plugin/redpacket/packageUse/packageUse?id=" + t
        })
    }
});