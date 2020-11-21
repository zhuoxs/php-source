var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var i in a) Object.prototype.hasOwnProperty.call(a, i) && (t[i] = a[i]);
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
        var e = this, t = {
            cid: this.data.cid,
            uid: wx.getStorageSync("userInfo").wxInfo.id,
            help_uid: 0
        };
        (0, _api.BargainInfoData)(t).then(function(t) {
            e.setData({
                info: t
            });
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        });
    },
    closeTicket: function() {
        this.setData({
            ticketFlag: !this.data.ticketFlag
        });
    },
    getUserName: function(t) {
        var e = t.detail.value.trim();
        this.setData({
            username: e
        });
    },
    getTel: function(t) {
        var e = t.detail.value.trim();
        this.setData({
            tel: e
        });
    },
    chooseTicketTab: function(t) {
        var e = t.currentTarget.dataset.idx;
        this.setData({
            choose: e
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
        var e = this, a = t.detail.formId, i = wx.getStorageSync("userInfo"), n = {
            cid: this.data.cid,
            bid: this.data.info.bid,
            uid: i.wxInfo.id,
            sign_username: this.data.username,
            sign_tel: this.data.tel,
            headurl: i.wxInfo.headimg,
            formId: a
        };
        n.sign_username.length < 2 ? wx.showToast({
            title: "请填写正确姓名！",
            icon: "none",
            duration: 2e3
        }) : n.sign_tel.length < 11 ? wx.showToast({
            title: "请填写正确手机号码！",
            icon: "none",
            duration: 2e3
        }) : (0, _api.BargainPayData)(n).then(function(t) {
            if (e.data.info.kjinfo.now_money - 0 <= 0) return wx.showToast({
                title: "恭喜您，报名课程成功！",
                icon: "none",
                duration: 2e3
            }), void setTimeout(function() {
                wx.navigateBack({
                    delta: 1
                });
            }, 1e3);
            t.sid;
            wx.requestPayment({
                timeStamp: t.timeStamp,
                nonceStr: t.nonceStr,
                package: t.package,
                signType: t.signType,
                paySign: t.paySign,
                success: function(t) {
                    var e = {
                        formId: a,
                        sign_username: n.sign_username,
                        sign_tel: n.sign_tel,
                        bid: n.bid
                    };
                    (0, _api.BargainPaySuccessData)(e).then(function(t) {
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