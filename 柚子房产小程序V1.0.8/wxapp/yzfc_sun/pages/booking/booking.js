var _extends = Object.assign || function(e) {
    for (var t = 1; t < arguments.length; t++) {
        var a = arguments[t];
        for (var i in a) Object.prototype.hasOwnProperty.call(a, i) && (e[i] = a[i]);
    }
    return e;
}, _reload = require("../../resource/js/reload.js"), _rewx = require("../../resource/js/rewx.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data, {
        houseType: [ "一居", "两居", "三居", "四居", "五居", "五居以上" ],
        chooseHouse: 0,
        ajax: !1
    }),
    onLoad: function(e) {
        var t = new Date().getTime() / 1e3 + 1800;
        this.setData({
            hid: e.hid,
            date: (0, _rewx.getFullDate)(t),
            time: (0, _rewx.getFullTime)(t)
        });
    },
    onloadData: function(e) {
        var t = this;
        e.detail.login && this.checkUrl().then(function(e) {
            return (0, _api.HouseDetailsData)({
                hid: t.data.hid
            });
        }).then(function(e) {
            t.setData({
                show: !0,
                info: e
            });
        }).catch(function(e) {
            -1 === e.code ? t.tips(e.msg) : t.tips("false");
        });
    },
    bindHouseChange: function(e) {
        this.setData({
            chooseHouse: e.detail.value
        });
    },
    bindDateChange: function(e) {
        this.setData({
            date: e.detail.value
        });
    },
    bindTimeChange: function(e) {
        this.setData({
            time: e.detail.value
        });
    },
    onSendTab: function(e) {
        var t = this, a = e.detail.formId, i = e.detail.value;
        if (i.username.trim().length < 1) this.tips("请输入正确的姓名！"); else if (/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(i.tel)) {
            var s = (0, _rewx.getTimeStr)(i.date + " " + i.time), n = {
                formId: a,
                hid: this.data.hid,
                username: i.username,
                tel: i.tel,
                ordertime: s,
                room: i.room - 0 + 1,
                uid: wx.getStorageSync("fcInfo").wxInfo.id
            };
            this.data.ajax || (this.setData({
                ajax: !0
            }), (0, _api.HouseOrderData)(n).then(function(e) {
                t.setData({
                    ajax: !1
                }), wx.showModal({
                    title: "提示",
                    content: "恭喜您，预约成功！",
                    showCancel: !1,
                    success: function(e) {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }).catch(function(e) {
                t.setData({
                    ajax: !1
                }), -1 === e.code ? t.tips(e.msg) : t.tips("false");
            }));
        } else this.tips("请输入正确的手机号码！");
    }
}));