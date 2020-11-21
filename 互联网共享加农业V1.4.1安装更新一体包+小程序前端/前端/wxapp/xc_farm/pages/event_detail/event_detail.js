var _WxValidate = require("../../../utils/WxValidate.js"), _WxValidate2 = _interopRequireDefault(_WxValidate);

function _interopRequireDefault(a) {
    return a && a.__esModule ? a : {
        default: a
    };
}

var common = require("../common/common.js"), app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

function sign(a) {
    var t = a.data.namevalue, e = a.data.phonevalue, n = a.data.numbervalue, s = "";
    if (("" == n || isNaN(n)) && (s = "请输入正确的报名人数"), "" == e || null == e) s = "请输入联系电话"; else {
        /^(((13[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/.test(e) || (s = "请输入正确的联系电话");
    }
    "" != t && null != t || (s = "请输入您的姓名"), "" == s ? a.setData({
        submit: !0
    }) : wx.showModal({
        title: "错误",
        content: s
    });
}

function wxpay(a, t) {
    a.appId;
    var e = a.timeStamp.toString(), n = a.package, s = a.nonceStr, i = a.paySign.toUpperCase();
    wx.requestPayment({
        timeStamp: e,
        nonceStr: s,
        package: n,
        signType: "MD5",
        paySign: i,
        success: function(a) {
            wx.showToast({
                title: "报名成功",
                icon: "success",
                duration: 2e3
            }), setTimeout(function() {
                wx.reLaunch({
                    url: "../my_event/my_event"
                });
            }, 2e3);
        }
    });
}

Page({
    data: {
        tab: [ "活动详情", "报名列表" ],
        tabCurr: 0,
        signList: [ {
            img: "../../images/user.jpg",
            name: "微信昵称",
            time: "2018/04/15 19:00",
            num: 2
        }, {
            img: "../../images/user.jpg",
            name: "微信昵称",
            time: "2018/04/15 19:00",
            num: 2
        }, {
            img: "../../images/user.jpg",
            name: "微信昵称",
            time: "2018/04/15 19:00",
            num: 2
        }, {
            img: "../../images/user.jpg",
            name: "微信昵称",
            time: "2018/04/15 19:00",
            num: 2
        }, {
            img: "../../images/user.jpg",
            name: "微信昵称",
            time: "2018/04/15 19:00",
            num: 2
        }, {
            img: "../../images/user.jpg",
            name: "微信昵称",
            time: "2018/04/15 19:00",
            num: 2
        } ],
        showPay: !1,
        numbervalue: 1,
        namevalue: "",
        phonevalue: "",
        submit: !1,
        can_load: !0,
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    changeTab: function(a) {
        var t = a.currentTarget.id;
        this.setData({
            tabCurr: t
        });
    },
    callFunc: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.list.mobile
        });
    },
    showPay: function() {
        this.setData({
            showPay: !0,
            shadow: !0
        });
    },
    closePay: function() {
        this.setData({
            showPay: !1,
            shadow: !1
        });
    },
    getname: function() {
        var t = this;
        wx.chooseAddress({
            success: function(a) {
                t.setData({
                    namevalue: a.userName
                });
            }
        });
    },
    getphone: function() {
        var t = this;
        wx.chooseAddress({
            success: function(a) {
                t.setData({
                    phonevalue: a.telNumber
                });
            }
        });
    },
    mapFunc: function() {
        wx.openLocation({
            latitude: parseFloat(this.data.list.latitude),
            longitude: parseFloat(this.data.list.longitude),
            scale: 28
        });
    },
    input: function(a) {
        var t = this, e = a.currentTarget.dataset.name, n = a.detail.value;
        switch (e) {
          case "name":
            t.setData({
                namevalue: n
            });
            break;

          case "mobile":
            t.setData({
                phonevalue: n
            });
            break;

          case "numbervalue":
            t.setData({
                numbervalue: n
            });
        }
    },
    submit: function(t) {
        var e = this;
        sign(e), common.is_bind(function() {
            if (e.data.submit && e.data.can_load) {
                e.setData({
                    can_load: !1
                });
                var a = {
                    id: e.data.list.id,
                    name: e.data.namevalue,
                    mobile: e.data.phonevalue,
                    member: e.data.numbervalue,
                    form_id: t.detail.formId,
                    plan_date: e.data.plan_date
                };
                app.util.request({
                    url: "entry/wxapp/sign",
                    method: "POST",
                    data: a,
                    success: function(a) {
                        console.log(a);
                        var t = a.data;
                        console.log(e.data.can_load), "" != t.data && (1 == t.data.status ? "" != t.data.errno && null != t.data.errno ? wx.showModal({
                            title: "错误",
                            content: t.data.message,
                            showCancel: !1
                        }) : wxpay(t.data, e) : 2 == t.data.status && (wx.showToast({
                            title: "报名成功",
                            icon: "success",
                            duration: 2e3
                        }), setTimeout(function() {
                            wx.reLaunch({
                                url: "../my_event/my_event"
                            });
                        }, 2e3)));
                    },
                    complete: function(a) {
                        e.setData({
                            can_load: !0
                        });
                    }
                });
            }
        });
    },
    bindDateChange: function(a) {
        this.setData({
            plan_date: a.detail.value
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "active_detail",
                id: a.id
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data && (e.setData({
                    list: t.data,
                    plan_date: t.data.start_time
                }), "" != t.data.content && null != t.data.content)) WxParse.wxParse("article", "html", t.data.content, e, 0);
            }
        }), app.util.request({
            url: "entry/wxapp/order",
            showLoading: !1,
            method: "POST",
            data: {
                op: "sign",
                id: a.id,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    order: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReachBottom: function() {
        var e = this;
        e.data.isbottom || 1 != e.data.tabCurr || app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "sign",
                id: e.data.list.id,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    order: e.data.order.concat(t.data),
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "active_detail",
                id: e.data.list.id
            },
            success: function(a) {
                var t = a.data;
                if (wx.stopPullDownRefresh(), "" != t.data && (e.setData({
                    list: t.data
                }), "" != t.data.content && null != t.data.content)) WxParse.wxParse("article", "html", t.data.content, e, 0);
            }
        });
    },
    onShareAppMessage: function() {
        var a = this, t = app.config.webname + "-" + a.data.list.name;
        "" != a.data.list.share_title && null != a.data.list.share_title && (t = a.data.list.share_title);
        var e = "";
        return "" != a.data.list.share_img && null != a.data.list.share_img && (e = a.data.list.share_img), 
        {
            title: t,
            imageUrl: e,
            path: "/xc_farm/pages/event_detail/event_det?&id=" + a.data.list.id,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});