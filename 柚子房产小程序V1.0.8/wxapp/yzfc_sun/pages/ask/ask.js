var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var n in e) Object.prototype.hasOwnProperty.call(e, n) && (t[n] = e[n]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data, {
        ajax: !1,
        question: ""
    }),
    onLoad: function() {},
    onloadData: function(t) {
        var a = this;
        t.detail.login && this.checkUrl().then(function(t) {
            a.setData({
                show: !0
            });
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    getQuestion: function(t) {
        this.setData({
            question: t.detail.value.trim()
        });
    },
    onSendTab: function() {
        var a = this, t = {
            uid: wx.getStorageSync("fcInfo").wxInfo.id,
            question: this.data.question
        };
        t.question.length < 1 ? this.tips("请输入您的问题！") : this.data.ajax || (this.setData({
            ajax: !0
        }), (0, _api.AskQuestionData)(t).then(function(t) {
            a.setData({
                ajax: !1
            }), wx.showModal({
                title: "提示",
                content: "您已成功提问，请耐心等候回答！",
                showCancel: !1,
                success: function(t) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            });
        }).catch(function(t) {
            a.setData({
                ajax: !1
            }), -1 === t.code ? a.tips(t.msg) : a.tips("false");
        }));
    }
}));