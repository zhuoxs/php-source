var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var n = t.fuwu_name;
        wx.setNavigationBarTitle({
            title: n
        }), void 0 !== t.huzopenid ? this.setData({
            huzopenid: t.huzopenid
        }) : console.log("22");
    },
    onReady: function() {
        this.getCategoryf1();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getCategoryf1: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Allfeilei",
            success: function(t) {
                n.setData({
                    items: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    comeone: function(t) {
        var n = t.currentTarget.dataset.data, e = t.currentTarget.dataset.name, a = t.currentTarget.dataset.icon, o = t.currentTarget.dataset.ksdesc;
        if (this.data.huzopenid) var i = this.data.huzopenid;
        wx.navigateTo({
            url: "/hyb_yl/zinzenglist/zinzenglist?id=" + n + "&name=" + e + "&icon=" + a + "&ksdesc=" + o + "&huzopenid=" + i
        });
    }
});