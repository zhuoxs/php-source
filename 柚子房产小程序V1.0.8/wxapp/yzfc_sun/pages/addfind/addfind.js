var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var n in e) Object.prototype.hasOwnProperty.call(e, n) && (t[n] = e[n]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data, {
        navChoose: 0,
        pic: [],
        txt: "",
        ajax: !1
    }),
    onLoad: function() {
        var t = wx.getStorageSync("config");
        this.setData({
            color: t.color
        });
    },
    onloadData: function(t) {
        var a = this;
        t.detail.login && this.checkUrl().then(function(t) {
            return (0, _api.FindClassifyData)();
        }).then(function(t) {
            a.setData({
                nav: t,
                show: !0
            });
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    getPic: function(t) {
        JSON.stringify(t.detail);
        this.setData({
            pic: t.detail
        });
    },
    getTxt: function(t) {
        this.setData({
            txt: t.detail.value.trim()
        });
    },
    onNavTab: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            navChoose: a
        });
    },
    onSendTab: function() {
        var a = this, t = wx.getStorageSync("fcInfo").wxInfo, e = {
            uid: t.id,
            cid: this.data.nav[this.data.navChoose].id,
            content: this.data.txt,
            img: this.data.pic,
            username: t.username,
            headurl: t.headurl
        };
        e.content.length < 1 ? this.tips("请您输入您要发布的内容！") : e.img.length < 1 ? this.tips("至少要发布一张图片！") : this.data.ajax || (this.setData({
            ajax: !0
        }), (0, _api.FindAddData)(e).then(function(t) {
            a.setData({
                ajax: !1
            }), wx.showModal({
                title: "提示",
                content: "发布成功！",
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