var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var o in e) Object.prototype.hasOwnProperty.call(e, o) && (t[o] = e[o]);
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
        showPact: !1,
        showBuy: !1,
        username: "",
        tel: "",
        prevent: !1,
        sharekey: !1,
        posterFlagA: !1,
        posterFlagB: !1,
        schoolChoose: 0
    },
    onLoad: function(t) {
        var a = decodeURIComponent(t.scene);
        0 < a ? this.setData({
            cid: a
        }) : this.setData({
            cid: t.cid
        });
        var e = wx.getStorageSync("isshare");
        this.setData({
            isshare: e
        });
    },
    onShow: function() {
        "yzpx_sun/pages/buylesson/buylesson" == app.globalData.backUrl && (app.globalData.backUrl = "", 
        this.onloadData({
            detail: {
                login: 1
            }
        }));
    },
    onloadData: function(t) {
        var e = this;
        t.detail.login && (this.setData({
            login: t.detail.login
        }), this.checkUrl().then(function(t) {
            var a = {
                cid: e.data.cid,
                uid: wx.getStorageSync("userInfo").wxInfo.id
            };
            return (0, _api.CourseDetailsData)(a);
        }).then(function(t) {
            WxParse.wxParse("content", "html", t.info.content, e, 0), e.setData({
                info: t
            });
            var a = {
                scene: e.data.cid,
                page: "yzpx_sun/pages/class/class"
            };
            return (0, _api.QrpicData)(a);
        }).then(function(t) {
            e.setData({
                qrimg: t.img,
                posterinfo: {
                    avatar: wx.getStorageSync("userInfo").wxInfo.headimg,
                    banner: e.data.imgLink + e.data.info.info.img,
                    title: e.data.info.info.title,
                    hot: "人气：" + e.data.info.info.signnum_xn,
                    qr: e.data.imgLink + t.img,
                    time: "开课时间：" + e.data.info.showTime + "/共" + e.data.info.lesson_num + "课时",
                    teacher: "讲课老师：" + e.data.info.teacher.name
                }
            });
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        }));
    },
    onLessonTab: function(t) {
        if (this.data.info.isbuy < 0) {
            var a = t.currentTarget.dataset.idx, e = this.data.info.lesson_list[a].id;
            this.navTo("../lesson/lesson?lid=" + e);
        } else wx.showToast({
            title: "请先报名本课程，才能查看课时详情",
            icon: "none",
            duration: 2e3
        });
    },
    onTelTab: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.info.teacher.tel
        });
    },
    onCollectTab: function(t) {
        var a = this, e = (wx.getStorageSync("userInfo"), {
            type: t.currentTarget.dataset.type,
            typeid: this.data.cid,
            uid: wx.getStorageSync("userInfo").wxInfo.id,
            act: 0 === this.data.info.iscollect ? 1 : 2,
            actid: this.data.info.iscollect
        });
        (0, _api.CollectData)(e).then(function(t) {
            a.setData(_defineProperty({}, "info.iscollect", 1 === e.act ? t.actid : 0));
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    getUserName: function(t) {
        var a = t.detail.value.trim();
        this.setData({
            username: a
        });
    },
    getTel: function(t) {
        var a = t.detail.value.trim();
        this.setData({
            tel: a
        });
    },
    onBuyTab: function() {
        0 <= this.data.info.isbuy && this.navTo("../buylesson/buylesson?cid=" + this.data.cid);
    },
    onPactTab: function() {
        0 === this.data.info.isorder && this.setData({
            showPact: !this.data.showPact
        });
    },
    onSendPactTab: function(t) {
        var a = this, e = t.detail.formId, o = wx.getStorageSync("userInfo"), i = {
            cid: this.data.cid,
            uid: o.wxInfo.id,
            username: this.data.username,
            tel: this.data.tel,
            formId: e,
            sid: this.data.info.teacher[this.data.schoolChoose].sid
        };
        i.username.length < 2 ? wx.showToast({
            title: "请填写正确姓名！",
            icon: "none",
            duration: 2e3
        }) : i.tel.length < 11 ? wx.showToast({
            title: "请填写正确手机号码！",
            icon: "none",
            duration: 2e3
        }) : (0, _api.CourseOrderData)(i).then(function(t) {
            wx.showToast({
                title: "恭喜您，预约课程成功！",
                icon: "none",
                duration: 2e3
            }), a.setData(_defineProperty({
                showPact: !a.data.showPact
            }, "info.isorder", 1));
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
    },
    onSendBuyTab: function(t) {
        var a = this, o = this, i = t.detail.formId, n = wx.getStorageSync("userInfo"), e = {
            cid: this.data.cid,
            uid: n.wxInfo.id,
            username: this.data.username,
            tel: this.data.tel,
            headurl: n.wxInfo.headimg,
            formId: i,
            sid: this.data.info.teacher[this.data.schoolChoose].sid
        };
        e.username.length < 2 ? wx.showToast({
            title: "请填写正确姓名！",
            icon: "none",
            duration: 2e3
        }) : e.tel.length < 11 ? wx.showToast({
            title: "请填写正确手机号码！",
            icon: "none",
            duration: 2e3
        }) : (0, _api.CourseSignData)(e).then(function(t) {
            if (0 == a.data.info.info.nowmoney) return a.setData(_defineProperty({
                showBuy: !a.data.showBuy
            }, "info.isbuy", -1)), void wx.showToast({
                title: "恭喜您，报名课程成功！",
                icon: "none",
                duration: 2e3
            });
            var e = t.sid;
            wx.requestPayment({
                timeStamp: t.timeStamp,
                nonceStr: t.nonceStr,
                package: t.package,
                signType: t.signType,
                paySign: t.paySign,
                success: function(t) {
                    wx.showToast({
                        title: "恭喜您，购买课程成功！",
                        icon: "none",
                        duration: 2e3
                    });
                    var a = {
                        sid: e,
                        formId: i,
                        cid: o.data.cid,
                        uid: n.wxInfo.id
                    };
                    (0, _api.PaySuccessData)(a).then(function(t) {
                        o.setData(_defineProperty({
                            showBuy: !o.data.showBuy
                        }, "info.isbuy", -1));
                    });
                }
            });
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
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
    onChangeSchoolTab: function(t) {
        this.setData({
            schoolChoose: t.detail.value
        });
    },
    onHomeTab: function() {
        this.lunchTo("../home/home");
    },
    onShareAppMessage: function() {
        return this.toggleShare(), {
            title: this.data.info.info.title,
            path: "/yzpx_sun/pages/class/class?cid=" + this.data.cid
        };
    }
}));