var _Page;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        id: 1,
        nav: {
            nav_list: [ {
                con: "全部"
            }, {
                con: "已回答"
            }, {
                con: "未回答"
            } ],
            currentTab: 0
        },
        values: ""
    },
    swichNav: function(e) {
        var t = this.data.nav;
        t.currentTab = e.currentTarget.dataset.current, this.setData({
            nav: t
        });
    },
    onLoad: function(e) {
        var t = e.zid, a = e.qid, n = e.user_openid;
        this.setData({
            zid: t,
            qid: a,
            user_openid: n
        });
    },
    yulan: function(e) {
        console.log(e);
        var t = e.target.dataset.index, a = (e.currentTarget.dataset.idx, this.data.qs);
        console.log(a);
        var n = a.user_picture[t], i = a.user_picture;
        wx.previewImage({
            current: n,
            urls: i
        });
    },
    zanClick: function(e) {
        var t = this.data.qs;
        console.log(e);
        var a = e.currentTarget.dataset.index;
        t[a].checked = !t[a].checked, this.setData({
            wendaArr: t
        });
    },
    switchChange: function(e) {
        var t = e.detail.value, a = this.data.qid;
        if (console.log("switch2 发生 change 事件，携带值为", e.detail.value), e.detail.value) {
            n = this.data.values;
            app.util.request({
                url: "entry/wxapp/Delover",
                data: {
                    qid: a,
                    state: t
                },
                success: function(e) {
                    console.log(e);
                }
            });
        } else {
            var n = "";
            app.util.request({
                url: "entry/wxapp/Delover",
                data: {
                    qid: a,
                    state: t
                },
                success: function(e) {
                    console.log(e);
                }
            });
        }
        this.setData({
            paySH: e.detail.value,
            values: n
        });
    },
    confirm: function(e) {
        console.log(e);
        var t = this, a = (t.data.zid, t.data.user_openid, e.detail.value.money);
        e.detail.value.kid;
        app.util.request({
            url: "entry/wxapp/Saveover",
            data: {
                gbmoney: a,
                qid1: e.detail.value.qid
            },
            success: function(e) {
                console.log(e), t.setData({
                    siwth: e.data.data
                });
            }
        }), setTimeout(function() {
            wx.hideLoading(), wx.showToast({
                title: "保存成功"
            });
        }, 500);
    },
    tiwenClick: function(e) {
        console.log(e);
        var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.qid;
        this.setData({
            overFlow1: "true",
            index: t,
            focus: !0,
            qid: a
        });
    },
    hideClick: function() {
        this.setData({
            overFlow1: ""
        });
    },
    inputClick: function(e) {
        var t = e.detail.value;
        this.setData({
            value: t
        });
    },
    faClick: function(e) {
        var t = this, a = t.data.qs, n = t.data.value, i = (t.data.index, t.data.qid), r = e.currentTarget.dataset.p_id, o = e.currentTarget.dataset.q_docthumb, s = e.currentTarget.dataset.z_name, u = e.currentTarget.dataset.z_thumbs, d = e.currentTarget.dataset.z_zhiwu, c = e.currentTarget.dataset.docopenid, l = e.currentTarget.dataset.user, p = u;
        console.log(a), app.util.request({
            url: "entry/wxapp/Fromque",
            data: {
                question: n,
                parentid: i,
                q_dname: s,
                fromuser: l,
                user_openid: c,
                q_thumb: p,
                q_zhiwei: d,
                p_id: r,
                q_docthumb: o
            },
            success: function(e) {
                console.log(e);
            }
        });
        n = "";
        t.setData({
            qs: a,
            value: n,
            overFlow1: ""
        });
    }
}, "hideClick", function() {
    this.setData({
        overFlow1: ""
    });
}), _defineProperty(_Page, "buling", function(e) {
    return e = 10 < e ? e : "0" + e, console.log(e), e;
}), _defineProperty(_Page, "onReady", function() {
    this.getAllquestion();
}), _defineProperty(_Page, "onShow", function() {}), _defineProperty(_Page, "onHide", function() {}), 
_defineProperty(_Page, "onUnload", function() {}), _defineProperty(_Page, "onPullDownRefresh", function() {}), 
_defineProperty(_Page, "onReachBottom", function() {}), _defineProperty(_Page, "onShareAppMessage", function() {}), 
_defineProperty(_Page, "getAllquestion", function() {
    var a = this, e = a.data.zid, t = wx.getStorageSync("openid"), n = a.data.user_openid, i = a.data.qid;
    app.util.request({
        url: "entry/wxapp/Allquestion",
        data: {
            qid: i,
            zid: e,
            user_openid: n,
            fromuser: t
        },
        success: function(e) {
            if (console.log(e.data.data.if_over), 1 == e.data.data.if_over) var t = !0; else t = !1;
            a.setData({
                paySH: t,
                qs: e.data.data
            });
        }
    });
}), _Page));