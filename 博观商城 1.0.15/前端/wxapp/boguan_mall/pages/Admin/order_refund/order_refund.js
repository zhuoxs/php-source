var e = require("../../../utils/base.js"), t = require("../../../../api.js"), a = (require("../../../../siteinfo.js"), 
new e.Base()), d = getApp();

Page({
    data: {
        orderIndex: 0,
        kind: "seller",
        page: 1,
        size: 10,
        loadmore: !0,
        orderList: [],
        selectedFlag: [ !1, !1, !1 ]
    },
    onLoad: function(e) {
        d.pageOnLoad(), this.setData({
            orderIndex: e.sindex || 0,
            kind: e.kind || "seller"
        }), this.getOrder(e.kind);
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getOrder(this.data.kind);
    },
    switch: function(e) {
        var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.kind;
        this.setData({
            orderIndex: t,
            kind: a,
            page: 1,
            size: 10,
            orderList: [],
            refundOrder: []
        }), this.getOrder(a);
    },
    getOrder: function(e) {
        var d = this;
        wx.showLoading({
            title: "请稍后"
        });
        var r = {
            url: t.mobile.mobile_refund,
            data: {
                type: e || this.data.kind,
                page: this.data.page,
                size: this.data.size
            },
            method: "GET"
        };
        a.getData(r, function(e) {
            var t = d;
            d.data.orderList;
            1 == e.errorCode ? (t.data.orderList.push.apply(t.data.orderList, e.data.data), 
            t.setData({
                orderList: t.data.orderList,
                loadmore: !0
            }), e.data.data.length < t.data.size && t.setData({
                loadmore: !1
            })) : 10001 == e.error_code || 0 == e.error_code && (t.setData({
                loadmore: !1
            }), wx.showModal({
                title: "提示",
                showCancel: !1,
                content: e.msg,
                success: function(e) {
                    wx.reLaunch({
                        url: "../../Tab/index/index"
                    });
                }
            })), wx.hideLoading();
        });
    },
    moreUp: function(e) {
        var t = e.currentTarget.dataset.index;
        this.data.selectedFlag[t] ? this.data.selectedFlag[t] = !1 : this.data.selectedFlag[t] = !0, 
        this.setData({
            selectedFlag: this.data.selectedFlag
        });
    },
    navigatorLink: function(e) {
        console.log(e), d.navClick(e, this);
    }
});