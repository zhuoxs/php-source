var app = getApp();

Page({
    data: {
        all: [ {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152360015252.png",
            title: "可口可乐可口可乐可口可乐可口可乐可口可乐可口可乐",
            price: "2.50",
            num: "1"
        }, {
            ordernum: "2018032015479354825176",
            status: "0",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152360015252.png",
            title: "可口可乐",
            price: "2.50",
            num: "1"
        }, {
            ordernum: "2018032015479354825176",
            status: "2",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152360015252.png",
            title: "可口可乐",
            price: "2.50",
            num: "1"
        } ],
        showModel: !1,
        express: [ "中通", "顺丰", "圆通", "申通", "韵达", "EMS", "邮政", "德邦", "天天", "宅急送", "优速", "汇通", "速尔", "全峰" ],
        index: 0,
        code: "",
        curPage: 1,
        pagesize: 6,
        list: []
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), this.setData({
            url: wx.getStorageSync("url")
        });
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getOrder() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        });
    },
    getOrder: function() {
        var o = this, i = o.data.curPage, r = o.data.list;
        app.util.request({
            url: "entry/wxapp/getOrder",
            cachetime: "0",
            data: {
                show_index: 1,
                page: i,
                pagesize: o.data.pagesize
            },
            success: function(t) {
                var e = t.data.length == o.data.pagesize;
                if (1 == i) r = t.data; else for (var a in t.data) r.push(t.data[a]);
                i += 1, o.setData({
                    list: r,
                    curPage: i,
                    hasMore: e
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        this.getOrder();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    bindPickerChange: function(t) {
        console.log("picker发送选择改变，携带值为", t.detail.value), this.setData({
            index: t.detail.value
        });
    },
    showModel: function(t) {
        console.log(t), this.setData({
            showModel: !this.data.showModel,
            id: t.currentTarget.dataset.id,
            index: t.currentTarget.dataset.index
        });
    },
    getCode: function(t) {
        this.setData({
            code: t.detail.value
        });
    },
    formSubmit: function(t) {
        var e = this, a = e.data.id, o = e.data.index, i = t.detail.value.shipname, r = t.detail.value.shipnum;
        if ("" != r) {
            var n = e.data.order;
            app.util.request({
                url: "entry/wxapp/setOrderFahuo",
                cachetime: "0",
                data: {
                    id: a,
                    express_delivery: i,
                    express_orderformid: r
                },
                success: function(t) {
                    0 == t.data.errcode && (n[parseInt(o)].order_status = 2, wx.showToast({
                        title: t.data.errmsg,
                        icon: "success",
                        duration: 2e3,
                        success: function() {},
                        complete: function() {
                            e.setData({
                                order: n,
                                showModel: !1
                            });
                        }
                    }));
                }
            });
        } else wx.showToast({
            title: "请输入快递单号",
            icon: "none"
        });
    },
    toOrderdet: function(t) {
        wx.navigateTo({
            url: "../orderdet/orderdet?order_id=" + t.currentTarget.dataset.id + "&uid=" + t.currentTarget.dataset.uid
        });
    }
});