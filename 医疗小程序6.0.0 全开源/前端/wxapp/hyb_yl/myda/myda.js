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
        var t = e.zid, a = e.qid, n = e.fromuser, r = e.user_openid, o = wx.getStorageSync("openid");
        this.setData({
            zid: t,
            qid: a,
            user_openid: r,
            openid: o,
            fromuser: n
        });
    },
    yulan: function(e) {
        console.log(e);
        var t = e.target.dataset.index, a = (e.currentTarget.dataset.idx, this.data.qs);
        console.log(a);
        var n = a.user_picture[t], r = a.user_picture;
        wx.previewImage({
            current: n,
            urls: r
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
    }
}, "hideClick", function() {
    this.setData({
        overFlow1: ""
    });
}), _defineProperty(_Page, "onReady", function() {
    this.getAllquestion();
}), _defineProperty(_Page, "onShow", function() {}), _defineProperty(_Page, "onHide", function() {}), 
_defineProperty(_Page, "onUnload", function() {}), _defineProperty(_Page, "onPullDownRefresh", function() {}), 
_defineProperty(_Page, "onReachBottom", function() {}), _defineProperty(_Page, "onShareAppMessage", function() {}), 
_defineProperty(_Page, "getAllquestion", function() {
    var a = this, e = a.data.zid, t = a.data.fromuser, n = a.data.user_openid, r = a.data.qid;
    console.log(e, n, r), app.util.request({
        url: "entry/wxapp/Allquestion",
        data: {
            qid: r,
            zid: e,
            user_openid: n,
            fromuser: t
        },
        success: function(e) {
            if (console.log(e), 1 == e.data.data.if_over) var t = !0; else t = !1;
            a.setData({
                paySH: t,
                qs: e.data.data
            });
        }
    });
}), _Page));