var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var o = arguments[a];
        for (var e in o) Object.prototype.hasOwnProperty.call(o, e) && (t[e] = o[e]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        ticketFlag: !1,
        schoolChoose: 0,
        choose: 0,
        username: "",
        tel: ""
    },
    onLoad: function(t) {
        this.setData({
            cid: t.cid
        });
    },
    onloadData: function() {
        var o = this, t = {
            cid: this.data.cid,
            uid: wx.getStorageSync("userInfo").wxInfo.id
        };
        (0, _api.CourseDetailsData)(t).then(function(t) {
            o.setData({
                info: t
            });
            var a = {
                money: o.data.info.info.nowmoney,
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                sid: o.data.info.teacher[o.data.schoolChoose].sid
            };
            return (0, _api.CanUseData)(a);
        }).then(function(t) {
            o.setData({
                ticket: t,
                choose: 0
            }), t.length < 1 && o.setData({
                choose: -1
            }), o.setData({
                showmoney: -1 != o.data.choose ? (o.data.info.info.nowmoney - o.data.ticket[o.data.choose].money).toFixed(2) : o.data.info.info.nowmoney
            });
        }).catch(function(t) {
            -1 === t.code ? o.tips(t.msg) : o.tips("false");
        });
    },
    closeTicket: function() {
        this.setData({
            ticketFlag: !this.data.ticketFlag
        });
    },
    onChangeSchoolTab: function(t) {
        this.setData({
            schoolChoose: t.detail.value
        }), this.setData({
            choose: 0
        }), this.getTicketAjax();
    },
    getTicketAjax: function() {
        var a = this, t = {
            money: this.data.info.info.nowmoney,
            uid: wx.getStorageSync("userInfo").wxInfo.id,
            sid: this.data.info.teacher[this.data.schoolChoose].sid
        };
        (0, _api.CanUseData)(t).then(function(t) {
            a.setData({
                ticket: t
            }), t.length < 1 && a.setData({
                choose: -1
            }), a.setData({
                showmoney: -1 != a.data.choose ? (a.data.info.info.nowmoney - a.data.ticket[a.data.choose].money).toFixed(2) : a.data.info.info.nowmoney
            });
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
    chooseTicketTab: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            choose: a
        }), this.setData({
            showmoney: -1 != this.data.choose ? (this.data.info.info.nowmoney - this.data.ticket[this.data.choose].money).toFixed(2) : this.data.info.info.nowmoney
        }), this.closeTicket();
    },
    delTicketTab: function() {
        this.setData({
            choose: -1
        }), this.setData({
            showmoney: -1 != this.data.choose ? (this.data.info.info.nowmoney - this.data.ticket[this.data.choose].money).toFixed(2) : this.data.info.info.nowmoney
        }), this.closeTicket();
    },
    onSendBuyTab: function(t) {
        var a = this, i = t.detail.formId, n = wx.getStorageSync("userInfo"), o = {
            cid: this.data.cid,
            uid: n.wxInfo.id,
            username: this.data.username,
            tel: this.data.tel,
            headurl: n.wxInfo.headimg,
            formId: i,
            sid: this.data.info.teacher[this.data.schoolChoose].sid
        };
        -1 != this.data.choose && 0 < this.data.ticket.length && (o.coupon_money = this.data.ticket[this.data.choose].money), 
        o.username.length < 2 ? wx.showToast({
            title: "请填写正确姓名！",
            icon: "none",
            duration: 2e3
        }) : o.tel.length < 11 ? wx.showToast({
            title: "请填写正确手机号码！",
            icon: "none",
            duration: 2e3
        }) : (0, _api.CourseSignData)(o).then(function(t) {
            var o = a;
            if (0 == a.data.info.info.nowmoney) return wx.showToast({
                title: "恭喜您，报名课程成功！",
                icon: "none",
                duration: 2e3
            }), void setTimeout(function() {
                wx.navigateBack({
                    delta: 1
                });
            }, 1e3);
            var e = t.sid;
            wx.requestPayment({
                timeStamp: t.timeStamp,
                nonceStr: t.nonceStr,
                package: t.package,
                signType: t.signType,
                paySign: t.paySign,
                success: function(t) {
                    var a = {
                        sid: e,
                        formId: i,
                        cid: o.data.cid,
                        uid: n.wxInfo.id
                    };
                    -1 != o.data.choose && (a.couponid = o.data.ticket[o.data.choose].couponid, a.coupon_money = o.data.ticket[o.data.choose].money), 
                    (0, _api.PaySuccessData)(a).then(function(t) {
                        wx.showToast({
                            title: "恭喜您，购买课程成功！",
                            icon: "none",
                            duration: 2e3
                        }), setTimeout(function() {
                            wx.navigateBack({
                                delta: 1
                            });
                        }, 1e3);
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
    }
}));