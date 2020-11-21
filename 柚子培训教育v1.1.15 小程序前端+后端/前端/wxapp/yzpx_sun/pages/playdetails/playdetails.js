var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js");

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), WxParse = require("../components/wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: {
        reply: "",
        prevent: !1,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 4,
            data: []
        },
        isload: !1,
        sharekey: !1,
        posterFlagA: !1,
        posterFlagB: !1
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("isshare");
        this.setData({
            isshare: a
        });
        var e = decodeURIComponent(t.scene);
        0 < e ? this.setData({
            bid: e
        }) : this.setData({
            bid: t.bid
        });
    },
    onloadData: function(t) {
        var i = this;
        t.detail.login && (this.setData({
            login: t.detail.login
        }), this.checkUrl().then(function(t) {
            wx.showShareMenu();
            var a = wx.getStorageSync("userInfo"), e = {
                bid: i.data.bid,
                uid: a.wxInfo.id
            };
            return (0, _api.BreakDetailsData)(e);
        }).then(function(t) {
            WxParse.wxParse("content", "html", t.info.content, i, 0), i.setData({
                info: t
            });
            var a = {
                scene: i.data.bid,
                page: "yzpx_sun/pages/playdetails/playdetails"
            };
            return (0, _api.QrpicData)(a);
        }).then(function(t) {
            i.setData({
                qrimg: t.img,
                posterinfo: {
                    avatar: wx.getStorageSync("userInfo").wxInfo.headimg,
                    banner: i.data.imgLink + i.data.info.info.img,
                    title: i.data.info.info.title,
                    hot: i.data.info.info.readnum + "人浏览",
                    qr: i.data.imgLink + t.img,
                    time: "发布时间：" + i.data.info.info.createtime
                }
            }), i.getListData();
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        }));
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var t = {
                bid: this.data.bid,
                page: this.data.list.page,
                length: this.data.list.length
            };
            (0, _api.BreakComListData)(t).then(function(t) {
                a.data.isload = !0, a.dealList(t);
            });
        }
    },
    onReachBottom: function() {
        this.data.isload && this.getListData();
    },
    getReply: function(t) {
        var a = t.detail.value.trim();
        this.setData({
            reply: a
        });
    },
    onReplyTab: function() {
        var i = this;
        this.setData({
            prevent: !0
        });
        var t = wx.getStorageSync("userInfo"), n = {
            uid: t.wxInfo.id,
            username: t.wxInfo.user_name,
            headurl: t.wxInfo.headimg,
            bid: this.data.bid,
            content: this.data.reply
        };
        (0, _api.BreakComData)(n).then(function(t) {
            var a, e = {
                username: n.username,
                headurl: n.headurl,
                content: n.content,
                createtime: "刚刚"
            };
            i.data.list.data.unshift(e), i.setData((_defineProperty(a = {
                prevent: !1,
                reply: ""
            }, "list.data", i.data.list.data), _defineProperty(a, "info.info.comnum", i.data.info.info.comnum - 0 + 1), 
            a)), wx.showToast({
                title: "评论成功！",
                icon: "none",
                duration: 2e3
            });
        }).catch(function(t) {
            i.setData({
                prevent: !1
            }), wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
    },
    onCollectTab: function(t) {
        var i = this, a = wx.getStorageSync("userInfo"), n = t.currentTarget.dataset.type, o = {
            type: n,
            typeid: this.data.bid,
            uid: a.wxInfo.id
        };
        "1" === n ? (o.act = 0 === this.data.info.iscollect ? 1 : 2, o.actid = this.data.info.iscollect) : (o.act = 0 === this.data.info.iszan ? 1 : 2, 
        o.actid = this.data.info.iszan), (0, _api.CollectData)(o).then(function(t) {
            if ("1" === n) i.setData(_defineProperty({}, "info.iscollect", 1 === o.act ? t.actid : 0)); else {
                var a, e = 1 === o.act ? i.data.info.info.zannum - 0 + 1 : i.data.info.info.zannum - 1;
                i.setData((_defineProperty(a = {}, "info.iszan", 1 === o.act ? t.actid : 0), _defineProperty(a, "info.info.zannum", e), 
                a));
            }
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
    },
    onPlayDetailsTab: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.info.rec[a].id;
        this.reTo("../playdetails/playdetails?bid=" + e);
    },
    toggleShare: function() {
        this.setData({
            sharekey: !this.data.sharekey
        });
    },
    createPoster: function(t) {
        var a = t.detail;
        this.setData({
            posterUrl: a.url,
            posterFlagA: !0
        }), this.data.posterFlagB && this.onShowPosterTab(), (0, _api.DelimgData)({
            img: this.data.qrimg
        }).then(function(t) {
            console.log("ok");
        }).catch(function(t) {
            console.log("fail");
        });
    },
    onShowPosterTab: function() {
        this.data.posterFlagA ? (this.toggleShare(), wx.previewImage({
            current: this.data.posterUrl,
            urls: [ this.data.posterUrl ]
        }), wx.hideLoading()) : (wx.showLoading({
            title: "海报生成中..."
        }), this.setData({
            posterFlagB: !0
        }));
    },
    onHomeTab: function() {
        this.lunchTo("../home/home");
    },
    onShareAppMessage: function() {
        return this.setData({
            sharekey: !1
        }), {
            title: this.data.info.info.title,
            path: "/yzpx_sun/pages/playdetails/playdetails?bid=" + this.data.bid
        };
    }
}));