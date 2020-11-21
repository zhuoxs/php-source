var a = require("../../../utils/base.js"), t = require("../../../../api.js"), e = new a.Base();

Page({
    data: {
        page: 1,
        size: 20,
        orderList: [],
        loadmore: !0,
        selectedFlag: [ !1, !1, !1 ]
    },
    onLoad: function(a) {
        var t = a.keyword;
        this.setData({
            keyword: t
        }), this.getOrder(t);
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getOrder(this.data.keyword);
    },
    getOrder: function(a) {
        var d = this;
        wx.showLoading({
            title: "请稍后",
            mask: !0
        });
        var s = {
            url: t.mobile.m_rder_search,
            data: {
                keyword: a,
                page: this.data.page,
                size: this.data.size
            },
            method: "GET"
        };
        e.getData(s, function(a) {
            console.log(a);
            var t = d;
            d.data.orderList;
            1 == a.errorCode && (t.data.orderList.push.apply(t.data.orderList, a.data.data), 
            t.setData({
                orderList: t.data.orderList,
                loadmore: !0
            }), a.data.data.length < t.data.size && t.setData({
                loadmore: !1
            })), wx.hideLoading();
        });
    },
    moreUp: function(a) {
        var t = a.currentTarget.dataset.index;
        this.data.selectedFlag[t] ? this.data.selectedFlag[t] = !1 : this.data.selectedFlag[t] = !0, 
        this.setData({
            selectedFlag: this.data.selectedFlag
        });
    }
});