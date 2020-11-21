function _defineProperty(t, e, n) {
    return e in t ? Object.defineProperty(t, e, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = n, t;
}

var Page = require("../../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        list3: [ {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            name: "精美礼物礼品",
            num: 2,
            stock: 100,
            price: "167.00",
            playBtn: !1,
            noUse: !0,
            inputValue: ""
        }, {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            name: "精美礼物礼品",
            num: 2,
            stock: 100,
            price: "167.00",
            playBtn: !1,
            noUse: !0,
            inputValue: ""
        } ]
    },
    onLoad: function(t) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindKeyInput: function(t) {
        var e = t.currentTarget.dataset.index, n = (this.data.list3, "list3[" + e + "].inputValue");
        this.setData(_defineProperty({}, n, t.detail.value));
    },
    noUse: function(t) {
        var e = this, n = t.currentTarget.dataset.index, i = (e.data.list3, "list3[" + n + "].noUse");
        wx.showModal({
            title: "提示",
            content: "确定停用吗？",
            success: function(t) {
                t.confirm && e.setData(_defineProperty({}, i, !1));
            }
        });
    },
    replenish: function(t) {
        var e = t.currentTarget.dataset.index, n = (this.data.list3, "list3[" + e + "].playBtn");
        this.setData(_defineProperty({}, n, !0));
    },
    addStock: function(t) {
        var e, n = t.currentTarget.dataset.index, i = this.data.list3, a = i[n].stock + Number(i[n].inputValue), o = "list3[" + n + "].stock", r = "list3[" + n + "].inputValue", s = "list3[" + n + "].playBtn";
        this.setData((_defineProperty(e = {}, o, a), _defineProperty(e, r, 0), _defineProperty(e, s, !1), 
        e));
    },
    goDetail: function(t) {
        wx.redirectTo({
            url: "../../../gift/giftlistdetail/giftlistdetail"
        });
    }
});