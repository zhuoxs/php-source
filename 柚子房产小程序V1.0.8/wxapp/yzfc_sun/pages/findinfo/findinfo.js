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

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data, {
        ajax: !1,
        content: ""
    }),
    onLoad: function(t) {
        this.setData({
            fid: t.fid
        });
    },
    onloadData: function(t) {
        var a = this;
        if (t.detail.login) {
            var e = {
                page: this.data.list.page,
                length: this.data.list.length,
                fid: this.data.fid
            };
            this.checkUrl().then(function(t) {
                return (0, _api.FindDetailsData)({
                    fid: a.data.fid
                });
            }).then(function(t) {
                return a.setData({
                    info: t
                }), (0, _api.FindComListData)(e);
            }).then(function(t) {
                a.dealList(t, e.page), a.setData({
                    show: !0
                });
            }).catch(function(t) {
                -1 === t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    },
    getListData: function() {
        var a = this;
        if (this.data.list.over) this.tips("已全部加载完。"); else {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                page: this.data.list.page,
                length: this.data.list.length,
                fid: this.data.fid
            };
            (0, _api.FindComListData)(e).then(function(t) {
                a.dealList(t, e.page);
            }).catch(function(t) {
                -1 == t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    previewImage: function(t) {
        var a = t.currentTarget.dataset.idx, e = [], i = !0, n = !1, s = void 0;
        try {
            for (var o, r = this.data.info.img[Symbol.iterator](); !(i = (o = r.next()).done); i = !0) {
                var d = o.value;
                e.push(this.data.imgLink + d);
            }
        } catch (t) {
            n = !0, s = t;
        } finally {
            try {
                !i && r.return && r.return();
            } finally {
                if (n) throw s;
            }
        }
        wx.previewImage({
            current: e[a],
            urls: e
        });
    },
    getContent: function(t) {
        this.setData({
            content: t.detail.value.trim()
        });
    },
    onSendTab: function() {
        var a = this, e = this, t = wx.getStorageSync("fcInfo").wxInfo, i = {
            uid: t.id,
            content: this.data.content,
            username: t.username,
            headurl: t.headurl,
            fid: this.data.fid
        };
        i.content.length < 1 ? this.tips("请输入评论内容！") : this.data.ajax || (this.setData({
            ajax: !0
        }), (0, _api.FindComAddData)(i).then(function(t) {
            a.setData({
                ajax: !1
            }), wx.showModal({
                title: "提示",
                content: "评论成功！",
                showCancel: !1,
                success: function(t) {
                    e.setData({
                        content: "",
                        list: {
                            load: !1,
                            over: !1,
                            page: 1,
                            length: 10,
                            none: !1,
                            data: []
                        }
                    }), e.getListData();
                }
            });
        }).catch(function(t) {
            a.setData({
                ajax: !1
            }), -1 == t.code ? a.tips(t.msg) : a.tips("false");
        }));
    }
}));