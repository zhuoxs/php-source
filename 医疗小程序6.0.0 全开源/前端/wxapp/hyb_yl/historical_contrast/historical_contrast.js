var app = getApp();

Page({
    data: {
        contrastArr: [],
        chooseId: []
    },
    onLoad: function(t) {
        var o = this, a = t.hzid, n = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: n
        }), o.setData({
            backgroundColor: n,
            hzid: a
        });
        for (var e = o.data.contrastArr, r = 0; r < e.length; r++) e[r].checked = !1;
        o.setData({
            contrastArr: e
        });
    },
    chooseContrast: function(t) {
        var o = this, a = o.data.contrastArr, n = o.data.chooseId, e = t.currentTarget.dataset.bg_id, r = t.currentTarget.dataset.index;
        a[r].checked ? n.splice(o.getSubscript(n, e), 1) : n.push(e), a[r].checked = !a[r].checked, 
        console.log(n, a), o.setData({
            chooseId: n,
            contrastArr: a
        });
    },
    getSubscript: function(t, o) {
        for (var a = 0, n = t.length; a < n; a++) if (t[a] == o) return a;
    },
    contrastResults: function() {
        var t = this.data.chooseId, o = JSON.stringify(t);
        t.length < 2 ? wx.showToast({
            title: "至少选择两项"
        }) : wx.navigateTo({
            url: "/hyb_yl/contrast_results/contrast_results?chooseId=" + o
        });
    },
    onReady: function() {
        this.getAllhosbaogao();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getAllhosbaogao: function() {
        var a = this, t = a.data.hzid;
        app.util.request({
            url: "entry/wxapp/Alltijianbaogao",
            data: {
                useropenid: wx.getStorageSync("openid"),
                hzid: t
            },
            success: function(t) {
                console.log(t);
                var o = t.data.data;
                a.setData({
                    contrastArr: o
                });
            }
        });
    }
});