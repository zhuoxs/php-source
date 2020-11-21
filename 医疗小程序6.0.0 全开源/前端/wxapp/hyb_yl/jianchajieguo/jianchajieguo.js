var app = getApp();

Page({
    data: {
        modal: !0,
        dex: 0,
        numszhi: "",
        resultindex: null,
        xuanzekuang: !1,
        selresult: [],
        result: []
    },
    disscroll: function() {},
    closemodal: function() {
        this.setData({
            modal: !0
        });
    },
    inputdanwei: function(t) {
        console.log(t.currentTarget.dataset.index), this.setData({
            resultindex: t.currentTarget.dataset.index,
            modal: !1
        });
    },
    resetform: function() {
        this.setData({
            numszhi: "",
            modal: !0
        });
    },
    formsubmit: function(t) {
        var a = this, e = a.data.result, s = a.data.resultindex, n = t.detail.value;
        a.data.erjid;
        "" == n.nums ? wx.showToast({
            title: "请输入数值"
        }) : (e[s].dwnum = n.nums + n.jc_danwei, a.setData({
            numszhi: "",
            modal: !0,
            result: e
        }));
    },
    danweisel: function() {
        this.setData({
            xuanzekuang: !0
        });
    },
    submit: function() {
        var t = this, a = t.data.xm_id, e = (t.data.result, t.data.erjid);
        console.log(t.data.selresult), 0 !== t.data.selresult.length ? void 0 !== t.data.jcx_id ? (console.log(t.data.jcx_id), 
        app.util.request({
            url: "entry/wxapp/Savejcjg",
            data: {
                val: t.data.selresult,
                erjid: e,
                jcx_id2: t.data.jcx_id,
                jxopenid: wx.getStorageSync("openid"),
                duox: 1,
                xm_id: a
            },
            success: function(t) {
                console.log(t);
                var a = getCurrentPages();
                a[a.length - 2].setData({
                    jcx_id: t.data.data
                }), wx.navigateBack({
                    delta: 1
                });
            }
        })) : app.util.request({
            url: "entry/wxapp/Savejcjg",
            data: {
                val: t.data.selresult,
                erjid: e,
                jxopenid: wx.getStorageSync("openid"),
                duox: 1,
                xm_id: a
            },
            success: function(t) {
                console.log(t);
                var a = getCurrentPages();
                a[a.length - 2].setData({
                    jcx_id: t.data.data
                }), wx.navigateBack({
                    delta: 1
                });
            }
        }) : void 0 !== t.data.jcx_id ? (console.log(t.data.jcx_id), app.util.request({
            url: "entry/wxapp/Savejcjg",
            data: {
                val: t.data.result,
                erjid: e,
                jcx_id2: t.data.jcx_id,
                jxopenid: wx.getStorageSync("openid"),
                xm_id: a
            },
            success: function(t) {
                console.log(t);
                var a = getCurrentPages();
                a[a.length - 2].setData({
                    jcx_id: t.data.data
                }), wx.navigateBack({
                    delta: 1
                });
            }
        })) : app.util.request({
            url: "entry/wxapp/Savejcjg",
            data: {
                val: t.data.result,
                erjid: e,
                jxopenid: wx.getStorageSync("openid"),
                xm_id: a
            },
            success: function(t) {
                console.log(t);
                var a = getCurrentPages();
                a[a.length - 2].setData({
                    jcx_id: t.data.data
                }), wx.navigateBack({
                    delta: 1
                });
            }
        });
    },
    quedingdw: function(t) {
        this.setData({
            dex: t.currentTarget.dataset.index,
            xuanzekuang: !1
        });
    },
    selmul: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.selresult;
        e[a].seltrue = !e[a].seltrue, console.log(e), this.setData({
            selresult: e
        });
    },
    onLoad: function(s) {
        var n = this, t = s.xm_id, d = s.erjid, a = s.multtypes, l = wx.getStorageSync("color"), e = s.multsel;
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: l
        }), void 0 !== s.jcx_id ? (app.util.request({
            url: "entry/wxapp/Getdatajcjg",
            data: {
                jcx_id: s.jcx_id
            },
            success: function(t) {
                console.log(t), 1 == t.data.data.duox && n.setData({
                    selresult: t.data.data.contents
                }), n.setData({
                    bgc: l,
                    result: t.data.data.contents,
                    multsel: e,
                    jcx_id: s.jcx_id
                });
            }
        }), n.setData({
            jcx_id: s.jcx_id
        })) : app.util.request({
            url: "entry/wxapp/Getjcjg",
            data: {
                xm_id: t
            },
            success: function(t) {
                console.log(t);
                var a = t.data.data;
                if (1 == s.multsel) {
                    for (var e = 0; e < a.length; e++) a[e].dwnum = "";
                    n.setData({
                        result: a
                    });
                } else if (0 == s.multsel) {
                    for (e = 0; e < a.length; e++) a[e].seltrue = !1;
                    n.setData({
                        selresult: a
                    });
                }
                n.setData({
                    bgc: l,
                    multsel: s.multsel,
                    erjid: d
                }), console.log(s.multsel);
            }
        }), n.setData({
            bgc: l,
            multsel: s.multsel,
            erjid: d,
            multtypes: a,
            xm_id: t
        });
    },
    submitbtns: function(t) {
        var a = this, e = t.detail.value, s = a.data.erjid;
        if (void 0 !== a.data.jcx_id ? console.log(a.data.jcx_id) : app.util.request({
            url: "entry/wxapp/Savejcjg",
            data: {
                val: e,
                erjid: s,
                jxopenid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t);
            }
        }), 0 == a.data.multsel) a.data.selresult; else if (1 == a.data.multsel) a.data.result;
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});