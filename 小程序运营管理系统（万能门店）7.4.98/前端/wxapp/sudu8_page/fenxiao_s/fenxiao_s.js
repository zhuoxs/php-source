var app = getApp();

Page({
    data: {
        page_signs: "/sudu8_page/fenxiao_s/fenxiao_s"
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var e = this, t = 0;
        a.fxsid && (t = a.fxsid, e.setData({
            fxsid: a.fxsid
        }));
        var s = a.type, n = "";
        app.util.request({
            url: "entry/wxapp/huoqfxsgz",
            success: function(a) {
                var t = a.data.data;
                1 == s && (n = "感谢您的支持，请等待审核"), 2 == s && (n = "审核提交成功，请等待审核"), 3 == s && (n = "消费金额达到" + t.fxs_sz_val + "元额度后将自动成为分销商"), 
                4 == s && (n = "消费次数达到" + t.fxs_sz_val + "次后将自动成为分销商"), e.setData({
                    str: n
                });
            }
        }), app.util.request({
            url: "entry/wxapp/BaseMin",
            data: {
                vs1: 1
            },
            success: function(a) {
                e.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(e.getinfos, t);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = a.data;
                e.setData({
                    openid: t
                });
            }
        });
    },
    getguiz: function() {
        var a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/sqcwfxsbase",
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data.gz;
                wx.setNavigationBarTitle({
                    title: "申请成为" + t.fxs_name
                });
            }
        });
    },
    return_index: function() {
        wx.redirectTo({
            url: "/sudu8_page/index/index"
        });
    }
});