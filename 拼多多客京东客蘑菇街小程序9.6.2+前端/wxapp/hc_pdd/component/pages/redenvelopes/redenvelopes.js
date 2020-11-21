var app = getApp();

Page({
    data: {
        hbmoney: 0
    },
    onLoad: function(a) {
        var t = a.hbmoney, n = a.avatarUrl, o = a.nickName;
        this.setData({
            hbmoney: t,
            nickName: o,
            avatarUrl: n
        }), this.shangpin();
    },
    jinru: function() {
        wx.reLaunch({
            url: "../../../pages/index/index"
        });
    },
    tyai: function() {
        wx.navigateTo({
            url: "../../pages/changtu/changtu"
        });
    },
    onReady: function() {},
    shangpin: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Goodslist",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list;
                a.data.data.toplist;
                n.setData({
                    goodsist: t
                }), console.log("商品列表", t);
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    details: function(a) {
        var t = a.currentTarget.dataset.id;
        a.currentTarget.dataset.jump, a.currentTarget.dataset.hui;
        console.log(t, "goods_id为", t), "" != t && wx.navigateTo({
            url: "../../../pages/details/details?goods_id=" + t + "&user_id=" + app.globalData.user_id
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});