var app = getApp();

Page({
    data: {
        qitaboor: !0,
        xiangmuval: "",
        xiangmu: []
    },
    selxaingmu: function(t) {
        var a = t.currentTarget.dataset.txt, o = t.currentTarget.dataset.xm_id, n = t.currentTarget.dataset.jc_jgtype, e = t.currentTarget.dataset.p_id, i = getCurrentPages(), r = i[i.length - 2];
        console.log(e, o), app.util.request({
            url: "entry/wxapp/Gtonly",
            data: {
                erjid: e,
                jxopenid: wx.getStorageSync("openid"),
                xm_id: o
            },
            success: function(t) {
                console.log(t);
            }
        }), r.setData({
            txt: a,
            xm_id: o,
            jc_jgtype: n
        }), wx.navigateBack({
            delta: 1
        });
    },
    qitabtns: function() {
        this.setData({
            qitaboor: !1
        });
    },
    closemodal: function() {
        this.setData({
            qitaboor: !0
        });
    },
    submitform: function(t) {
        var a = t.detail.value.xmname;
        "" == a ? wx.showToast({
            title: "请输入项目名称"
        }) : (console.log(a), wx.navigateBack({})), console.log(a);
    },
    restform: function() {
        this.setData({
            qitaboor: !0,
            xiangmuval: ""
        });
    },
    onLoad: function(t) {
        var a = t.p_id;
        console.log(a);
        var o = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o
        }), this.setData({
            p_id: a
        });
    },
    onReady: function() {
        this.getAlljcxm();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    getAlljcxm: function() {
        var i = this, t = i.data.p_id;
        app.util.request({
            url: "entry/wxapp/Alljcxm",
            data: {
                p_id: t
            },
            success: function(t) {
                var a = t.data.data;
                console.log(t);
                for (var o = a.length, n = 0; n < o; n++) for (var e = n + 1; e < o; e++) a[n].jc_type == a[e].jc_type && (a.splice(n, 1), 
                e--, o--);
                console.log(a), i.setData({
                    xiangmu: a
                });
            }
        });
    }
});