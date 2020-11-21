var _data;

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page({
    data: (_data = {
        currenttab: 1,
        shopId: "",
        type: 1,
        imgAdd: "",
        judge: !1
    }, _defineProperty(_data, "type", 1), _defineProperty(_data, "getCommodityData", []), 
    _defineProperty(_data, "page", 1), _defineProperty(_data, "limit", 10), _defineProperty(_data, "hasMore", !0), 
    _data),
    onLoad: function(t) {
        var a = this;
        this.setData({
            shopId: t.shopId
        }), app.ajax({
            url: "cgoods|getStoreGoodses",
            data: {
                store_id: t.shopId,
                check_state: a.data.type
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    getCommodityData: t.data,
                    imgAdd: t.other.img_root
                });
            }
        });
    },
    getCommodityData: function(t) {
        var a = this;
        if (a.setData({
            page: 1,
            limit: 10,
            hasMore: !0
        }), t) {
            if (this.data.currenttab == t.currentTarget.dataset.tabid) return !1;
            this.setData({
                currenttab: t.currentTarget.dataset.tabid,
                type: t.currentTarget.dataset.tabid
            });
        }
        app.ajax({
            url: "cgoods|getStoreGoodses",
            data: {
                store_id: a.data.shopId,
                check_state: t.currentTarget.dataset.tabid
            },
            success: function(t) {
                console.log(t), a.setData({
                    getCommodityData: t.data
                });
            }
        });
    },
    upperShelf: function(a) {
        var e = this;
        console.log(a.currentTarget.dataset.commodityid);
        var o = a.currentTarget.dataset.commodityid;
        console.log(a.currentTarget.dataset.stateid), app.ajax({
            url: "Cgoods|save",
            data: {
                id: a.currentTarget.dataset.commodityid,
                state: a.currentTarget.dataset.stateid,
                check_state: 1
            },
            success: function(t) {
                console.log(e.data.getCommodityData), 1 == a.currentTarget.dataset.stateid ? (wx.showToast({
                    title: "上架成功",
                    icon: "none",
                    duration: 2e3
                }), e.data.getCommodityData.forEach(function(t, a) {
                    t.id == o && (console.log(t), console.log(a), e.data.getCommodityData[a].state = 1), 
                    e.setData({
                        getCommodityData: e.data.getCommodityData
                    });
                })) : (wx.showToast({
                    title: "下架成功",
                    icon: "none",
                    duration: 2e3
                }), e.data.getCommodityData.forEach(function(t, a) {
                    t.id == o && (console.log(t), console.log(a), e.data.getCommodityData[a].state = 0);
                }), console.log(e.data.getCommodityData), e.setData({
                    getCommodityData: e.data.getCommodityData
                }));
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var d = this;
        console.log("上拉触底"), d.data.hasMore ? (d.setData({
            page: ++d.data.page,
            limit: d.data.limit
        }), app.ajax({
            url: "cgoods|getStoreGoodses",
            data: {
                store_id: d.data.shopId,
                check_state: d.data.type,
                page: d.data.page,
                limit: d.data.limit
            },
            success: function(t) {
                console.log(t);
                var a = d.data.getCommodityData.concat(t.data), e = parseInt(t.other.count), o = d.data.page * d.data.limit < e;
                d.setData({
                    getCommodityData: a,
                    hasMore: o
                });
            }
        })) : wx.showToast({
            title: "没有更多数据了",
            icon: "none"
        });
    },
    onShareAppMessage: function() {}
});