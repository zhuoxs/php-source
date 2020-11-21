var app = getApp(), Toast = require("../../libs/zanui/toast/toast"), Toptips = require("../../libs/zanui/toptips/index");

Page({
    data: {
        levels: [ {
            value: "1",
            name: "好评"
        }, {
            value: "2",
            name: "中评"
        }, {
            value: "3",
            name: "差评"
        } ],
        checkedValue: "1",
        activeColor: "#f60",
        showName: !1,
        TabCur: 0,
        completed: !1
    },
    onLoad: function(t) {
        var a = this;
        if (app.viewCount(), t.orderid && a.setData({
            orderId: t.orderid
        }), t.ct_uid) {
            var e = wx.getStorageSync("loading_img");
            e && a.setData({
                loadingImg: e
            }), a.setData({
                showlist: !0,
                uid: t.ct_uid,
                one: t.one,
                two: t.two,
                three: t.three,
                total: parseInt(t.one) + parseInt(t.two) + parseInt(t.three)
            }), a.getCommentList(t.ct_uid);
        }
    },
    tabSelect: function(t) {
        this.setData({
            TabCur: t.currentTarget.dataset.level
        }), this.getCommentList(this.data.uid, this.data.TabCur);
    },
    getCommentList: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "", e = this;
        app.util.request({
            url: "entry/wxapp/order",
            cachetime: "0",
            data: {
                act: "comment_list",
                uid: t,
                level: a,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? e.setData({
                    list: t.data.data ? t.data.data : [],
                    completed: !0
                }) : e.showIconToast(t.data.errmsg);
            },
            fail: function(t) {
                e.showIconToast(t.data.errmsg);
            }
        });
    },
    setSwitch: function(t) {
        this.setData({
            showName: !this.data.showName
        });
    },
    handleSelectChange: function(t) {
        this.setData({
            checkedValue: t.detail.value
        });
    },
    commentSubmit: function(t) {
        var a = this, e = t.detail.formId;
        app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: e,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        });
        var o = t.detail.value.content;
        o ? app.util.request({
            url: "entry/wxapp/order",
            cachetime: "0",
            data: {
                act: "comment",
                level: a.data.checkedValue,
                content: o,
                anonymous: a.data.showName ? 1 : 0,
                orderid: a.data.orderId,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? (a.showIconToast("评价成功", "success"), setTimeout(function() {
                    wx.redirectTo({
                        url: "../my_order/index?type=buy"
                    });
                }, 1500)) : a.showIconToast(t.data.errmsg);
            },
            fail: function(t) {
                a.showIconToast(t.data.errmsg);
            }
        }) : Toptips("请输入评价内容");
    },
    showIconToast: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: a,
            message: t,
            selector: "#zan-toast"
        });
    }
});