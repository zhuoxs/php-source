var _extends = Object.assign || function(a) {
    for (var t = 1; t < arguments.length; t++) {
        var e = arguments[t];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (a[i] = e[i]);
    }
    return a;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js");

function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp(), WxParse = require("../components/wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: {
        showPact: !1,
        showBuy: !1,
        username: "",
        tel: "",
        prevent: !1,
        sharekey: !1,
        posterFlagA: !1,
        posterFlagB: !1,
        schoolChoose: 0,
        left: 0,
        helpUid: 0,
        downTime: {},
        bargainkey: !1,
        ismecut: !1,
        ajax: !1
    },
    onLoad: function(a) {
        this.setData({
            options: a
        });
        var t = decodeURIComponent(a.scene);
        0 < t ? this.setData({
            cid: t
        }) : this.setData({
            cid: a.cid
        });
    },
    onShow: function() {
        "yzpx_sun/pages/buybargain/buybargain" == app.globalData.backUrl && (app.globalData.backUrl = "", 
        this.onloadData({
            detail: {
                login: 1
            }
        }));
    },
    onloadData: function(a, n) {
        var o = this, s = null;
        a.detail.login && (null != this.data.options.helpUid && this.data.options.helpUid != wx.getStorageSync("userInfo").wxInfo.id ? this.setData({
            helpUid: this.data.options.helpUid
        }) : this.setData({
            helpUid: 0
        }), this.setData({
            login: a.detail.login
        }), this.checkUrl().then(function(a) {
            return s = 0 < o.data.helpUid ? {
                cid: o.data.cid,
                uid: o.data.helpUid,
                help_uid: wx.getStorageSync("userInfo").wxInfo.id
            } : {
                cid: o.data.cid,
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                help_uid: 0
            }, (0, _api.BargainInfoData)(s);
        }).then(function(a) {
            if (1 != n && 0 < s.help_uid - 0 && 0 < a.ishelp - 0 && o.tips("您已为他帮砍了！"), WxParse.wxParse("content", "html", a.info.content, o, 0), 
            o.setData({
                info: a
            }), o.downTime(), 0 < a.bid - 0) {
                var t = a.kjinfo.now_money, e = a.info.money, i = parseInt((e - t) / e * 690);
                o.setData({
                    left: i
                });
            }
        }).catch(function(a) {
            -1 === a.code ? o.tips(a.msg) : o.tips("false");
        }));
    },
    downTime: function() {
        var a = this;
        clearInterval(d);
        var t = Math.floor(new Date().getTime() / 1e3 - 0), e = this.data.info.info.end_time - 0, i = Math.floor(e - t), n = 0, o = 0, s = 0, r = 0, d = (new Date(), 
        setInterval(function() {
            if (--i <= 0) return a.setData({
                downTime: {
                    D: 0,
                    H: 0,
                    M: 0,
                    S: 0,
                    over: 1
                }
            }), void clearInterval(d);
            n = Math.floor(i / 86400), o = Math.floor(i / 60 / 60 % 24), s = Math.floor(i / 60 % 60), 
            r = Math.floor(i % 60), o = 9 < o ? o : "0" + o, s = 9 < s ? s : "0" + s, r = 9 < r ? r : "0" + r, 
            a.setData({
                downTime: {
                    D: n,
                    H: o,
                    M: s,
                    S: r,
                    over: 0
                }
            });
        }, 1e3));
    },
    onLessonTab: function(a) {
        var t = this.data.helpUid;
        if (1 == (null == this.data.info.kjinfo ? 0 : this.data.info.kjinfo.isbuy - 0) && 0 == t) {
            var e = a.currentTarget.dataset.idx, i = this.data.info.info.lesson_list[e].id;
            this.navTo("../lesson/lesson?lid=" + i);
        } else wx.showToast({
            title: "请先购买本课程，才能查看课时详情",
            icon: "none",
            duration: 2e3
        });
    },
    onTelTab: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.info.teacher.tel
        });
    },
    onCollectTab: function(a) {
        var t = this, e = (wx.getStorageSync("userInfo"), {
            type: a.currentTarget.dataset.type,
            typeid: this.data.cid,
            uid: wx.getStorageSync("userInfo").wxInfo.id,
            act: 0 === this.data.info.iscollect ? 1 : 2,
            actid: this.data.info.iscollect
        });
        (0, _api.CollectData)(e).then(function(a) {
            t.setData(_defineProperty({}, "info.iscollect", 1 === e.act ? a.actid : 0));
        }).catch(function(a) {
            -1 === a.code ? t.tips(a.msg) : t.tips("false");
        });
    },
    getUserName: function(a) {
        var t = a.detail.value.trim();
        this.setData({
            username: t
        });
    },
    getTel: function(a) {
        var t = a.detail.value.trim();
        this.setData({
            tel: t
        });
    },
    onBuyTab: function() {
        0 == this.data.info.kjinfo.isbuy && this.navTo("../buybargain/buybargain?cid=" + this.data.cid);
    },
    toggleShare: function() {
        this.setData({
            sharekey: !this.data.sharekey
        });
    },
    createPoster: function(a) {
        var t = a.detail;
        this.setData({
            posterUrl: t.url,
            posterFlagA: !0
        }), this.data.posterFlagB && this.onShowPosterTab(), (0, _api.DelimgData)({
            img: this.data.qrimg
        }).then(function(a) {
            console.log("ok");
        }).catch(function(a) {
            console.log("fail");
        });
    },
    onHomeTab: function() {
        this.lunchTo("../home/home");
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
    onChangeSchoolTab: function(a) {
        this.setData({
            schoolChoose: a.detail.value
        });
    },
    onJoinBargainTab: function() {
        var t = this;
        if (!this.data.ajax) {
            this.data.ajax = !0;
            var a = {
                cid: this.data.cid,
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                headurl: wx.getStorageSync("userInfo").wxInfo.headimg,
                username: wx.getStorageSync("userInfo").wxInfo.user_name
            };
            (0, _api.JoinBargainData)(a).then(function(a) {
                t.data.ajax = !1, t.setData(_defineProperty({
                    cutmsg: a,
                    ismecut: !0
                }, "info.bid", a.bid)), t.toggleBargain(), t.onloadData({
                    detail: {
                        login: 1
                    }
                });
            }).catch(function(a) {
                t.data.ajax = !1, -1 === a.code ? t.tips(a.msg) : t.tips("false");
            });
        }
    },
    toggleBargain: function() {
        this.setData({
            bargainkey: !this.data.bargainkey
        });
    },
    onHelpTab: function() {
        var t = this;
        if (!this.data.ajax) {
            this.data.ajax = !0;
            var a = {
                bid: this.data.info.bid,
                cid: this.data.cid,
                help_uid: wx.getStorageSync("userInfo").wxInfo.id,
                uid: this.data.info.kjinfo.uid,
                headurl: wx.getStorageSync("userInfo").wxInfo.headimg,
                username: wx.getStorageSync("userInfo").wxInfo.user_name
            };
            (0, _api.HelpBargainData)(a).then(function(a) {
                t.data.ajax = !1, t.setData({
                    cutmsg: a,
                    ismecut: !1
                }), t.onloadData({
                    detail: {
                        login: 1
                    }
                }, 1), t.toggleBargain();
            }).catch(function(a) {
                t.data.ajax = !1, -1 === a.code ? t.tips(a.msg) : t.tips("false");
            });
        }
    },
    onButtonTab: function(a) {
        switch (a.currentTarget.dataset.status - 0) {
          case 0:
            this.onJoinBargainTab();
            break;

          case 2:
            this.setData(_defineProperty({
                helpUid: 0
            }, "options.helpUid", 0)), this.onloadData({
                detail: {
                    login: 1
                }
            });
            break;

          case 3:
            this.onHelpListTab();
            break;

          case 4:
            this.onHelpTab();
            break;

          case 7:
            this.onBuyTab();
        }
    },
    onHelpListTab: function() {
        var a = null;
        a = 0 < this.data.helpUid ? this.data.helpUid : wx.getStorageSync("userInfo").wxInfo.id, 
        this.navTo("../helplist/helplist?cid=" + this.data.cid + "&uid=" + a);
    },
    onShareAppMessage: function() {
        return {
            title: this.data.info.info.share_title,
            path: "/yzpx_sun/pages/bargain/bargain?cid=" + this.data.cid + "&helpUid=" + wx.getStorageSync("userInfo").wxInfo.id
        };
    }
}));