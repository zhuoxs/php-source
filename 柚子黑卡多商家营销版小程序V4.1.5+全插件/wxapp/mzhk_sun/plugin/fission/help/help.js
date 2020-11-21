/*   time:2019-08-09 13:18:40*/
var app = getApp();
Page({
    data: {
        dimg: "../../resource/images/my.png"
    },
    onLoad: function(t) {
        var n = this,
            o = t.fid,
            i = t.bid,
            a = wx.getStorageSync("openid");
        o && i && a && app.util.request({
            url: "entry/wxapp/GetUserFission",
            showLoading: !1,
            data: {
                fid: o,
                bid: i,
                openid: a,
                type: 2,
                m: app.globalData.Plugin_fission
            },
            success: function(t) {
                console.log(t.data), n.setData({
                    activations: t.data.activation,
                    content: t.data,
                    userimg: t.data.activation[0].userimg
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var n = wx.getStorageSync("users"),
            o = this.data.content,
            i = o.fid,
            a = o.bid,
            e = o.activation[0].fname,
            s = o.activation[0].id;
        return "button" === t.from && console.log(t.target), {
            title: e,
            path: "/mzhk_sun/plugin/fission/detail/detail?id=" + i + "&bid=" + a + "&user_id=" + n.id + "&order_id=" + s + "&is_share=1",
            success: function(t) {
                console.log("转发成功")
            },
            fail: function(t) {
                console.log("转发失败")
            }
        }
    },
    toShop: function(t) {
        var n = parseInt(t.currentTarget.dataset.bid);
        wx.navigateTo({
            url: "/mzhk_sun/pages/index/shop/shop?id=" + n
        })
    }
});