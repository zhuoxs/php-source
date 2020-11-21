Page({
    data: {
        historyList: []
    },
    onLoad: function(t) {
        var a = this;
        wx.getStorage({
            key: "history",
            success: function(t) {
                var i = t.data || [];
                a.setData({
                    historyList: i
                });
            }
        });
    },
    search: function(t) {
        var a = t.detail.value, i = this.data.historyList;
        if (i.length > 0) {
            var s = !1;
            i.map(function(t) {
                t == a && (s = !0);
            }), s || i.unshift(a);
        } else i.unshift(keyWord);
        wx.setStorage({
            key: "history",
            data: i
        }), wx.navigateTo({
            url: "../proList/index?goods_name=" + a
        });
    },
    clearHistory: function() {
        var t = this;
        wx.removeStorage({
            key: "history",
            success: function(a) {
                t.setData({
                    historyList: []
                });
            }
        });
    },
    formSubmit: function(t) {
        var a = t.detail.value.keyWord, i = this.data.historyList;
        if (i.length > 0) {
            var s = !1;
            i.map(function(t) {
                t == a && (s = !0);
            }), s || i.unshift(a);
        } else i.unshift(a);
        wx.setStorage({
            key: "history",
            data: i
        }), wx.navigateTo({
            url: "../proList/index?goods_name=" + a
        });
    },
    intoGoodsList: function(t) {
        wx.navigateTo({
            url: "../proList/index?goods_name=" + t.currentTarget.dataset.goodsname
        });
    }
});