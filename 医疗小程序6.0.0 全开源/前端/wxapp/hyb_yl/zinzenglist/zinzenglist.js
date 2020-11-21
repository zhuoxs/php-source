var app = getApp();

Page({
    data: {
        modalbtns: !0,
        current: 0,
        xinxi: [ {
            src: "../images/list1.png",
            tit: "病人信息"
        }, {
            src: "../images/list2.png",
            tit: "诊疗信息"
        }, {
            src: "../images/list3.png",
            tit: "联系人信息"
        }, {
            src: "../images/list1.png",
            tit: "病人信息"
        }, {
            src: "../images/list2.png",
            tit: "诊疗信息"
        }, {
            src: "../images/list3.png",
            tit: "联系人信息"
        } ]
    },
    lookimgs: function(t) {
        console.log(t);
        var a = t.target.dataset.src, e = t.target.dataset.arr;
        wx.previewImage({
            current: a,
            urls: e
        });
    },
    closemodalbtns: function(t) {
        this.setData({
            modalbtns: !0
        });
    },
    typesclick: function(t) {
        var a = this, e = t.currentTarget.dataset.id, i = t.currentTarget.dataset.ifkq, n = t.currentTarget.dataset.dex, s = a.data.openid;
        if (app.util.request({
            url: "entry/wxapp/Jdlist",
            data: {
                fuleiid: e,
                openid: s
            },
            success: function(t) {
                a.setData({
                    dlist: t.data.data
                });
            }
        }), n == this.data.current) return !0;
        this.setData({
            current: t.currentTarget.dataset.dex
        }), a.setData({
            erjid: e,
            ifkq: i
        });
    },
    alldiy: function(t) {
        var a = this;
        console.log(t);
        var e = t.currentTarget.dataset.id, i = t.currentTarget.dataset.ifkq, n = t.currentTarget.dataset.erjid;
        1 == i ? app.util.request({
            url: "entry/wxapp/Sanji",
            data: {
                id: e
            },
            success: function(t) {
                a.setData({
                    sanji: t.data.data,
                    modalbtns: !1
                });
            }
        }) : wx.navigateTo({
            url: "/hyb_yl/jddiy/jddiy?erjid=" + e + "&ejdiv=" + n
        });
    },
    deleteimgs: function(t) {
        var a = this, e = t.currentTarget.dataset.dex, i = t.currentTarget.dataset.jd_id, n = a.data.dlist;
        wx.showModal({
            content: "删除后不可恢复",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Delinfo",
                    data: {
                        jd_id: i
                    },
                    success: function(t) {
                        console.log(t), n.splice(e, 1), a.setData({
                            dlist: n
                        });
                    }
                });
            }
        });
    },
    onLoad: function(t) {
        var a = this, e = t.id, i = t.name, n = t.icon, s = t.ksdesc;
        "undefined" !== t.huzopenid ? a.setData({
            openid: t.huzopenid,
            disnone: t.huzopenid
        }) : a.setData({
            openid: wx.getStorageSync("openid")
        }), a.setData({
            id: e,
            name: i,
            icon: n,
            ksdesc: s
        }), app.util.request({
            url: "entry/wxapp/Scurl",
            success: function(t) {
                a.setData({
                    scurl: t.data.data
                });
            }
        });
        var d = t.name;
        wx.setNavigationBarTitle({
            title: d
        });
    },
    onReady: function() {
        this.getAllerjifenl();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getAllerjifenl: function() {
        var n = this, t = n.data.id, s = n.data.openid;
        app.util.request({
            url: "entry/wxapp/Allerjifenl",
            data: {
                id: t,
                openid: s
            },
            success: function(t) {
                var a = t.data.data, e = a[0].id, i = s;
                app.util.request({
                    url: "entry/wxapp/Jdlist",
                    data: {
                        fuleiid: e,
                        openid: i
                    },
                    success: function(t) {
                        n.setData({
                            dlist: t.data.data
                        });
                    }
                }), n.setData({
                    allerj: a
                });
            }
        });
    },
    speck: function(t) {
        var a = t.currentTarget.dataset.jd_id;
        wx.navigateTo({
            url: "/hyb_yl/jddiy/jddiy?jd_id=" + a
        });
    }
});