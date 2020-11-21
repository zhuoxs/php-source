var app = getApp();

Page({
    data: {
        curHdIndex: 2,
        show: !1,
        page: 1,
        limit: 5,
        olist: [],
        check: {
            checkAll: !0
        }
    },
    onLoad: function(a) {
        this.setData({
            curHdIndex: a.id ? a.id : 2,
            myleader_id: a.myleaderid
        });
        var t = wx.getStorageSync("userInfo");
        t ? this.setData({
            uInfo: t
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var t = encodeURIComponent("/sqtg_sun/pages/public/pages/myorder/myorder?id=0");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else a.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    onShow: function() {
        this.setData({
            page: 1
        }), this.loadData();
    },
    loadData: function() {
        var s = this, o = s.data.olist, d = s.data.limit, i = s.data.page;
        app.ajax({
            url: "Cleader|getOrderStates",
            success: function(a) {
                s.setData({
                    nav: a.data
                });
            }
        }), app.ajax({
            url: "Cleader|getOrders",
            data: {
                leader_id: s.data.myleader_id,
                page: i,
                limit: d,
                state: s.data.curHdIndex
            },
            success: function(a) {
                var t = !(!a.data || a.data.length < d);
                if (1 == i) o = a.data; else for (var e in a.data) o.push(a.data[e]);
                i += 1, s.setData({
                    olist: o,
                    show: !0,
                    hasMore: t,
                    page: i,
                    imgroot: a.other.img_root
                });
            }
        });
    },
    swichNav: function(a) {
        var t = a.currentTarget.dataset.state;
        this.setData({
            curHdIndex: t,
            page: 1
        }), this.loadData();
    },
    onReachBottom: function() {
        this.data.hasMore ? this.loadData() : wx.showToast({
            title: "没有更多订单啦~",
            icon: "none"
        });
    },
    confirmAttr: function(a) {
        var t = a.currentTarget.dataset.index, e = JSON.parse(JSON.stringify(this.data.olist[t]));
        this.setData({
            goods: e,
            confirmAttr: !0
        });
    },
    getSinglePlat: function(a) {
        var t = this, e = t.data.check, s = t.data.goods, o = a.currentTarget.dataset.index;
        console.log(o), e.checkAll = !0, s.attrs[o].status = !s.attrs[o].status, t.setData({
            goods: s
        });
    },
    lastNum: function() {
        var t = this, a = t.data.goods, e = [];
        for (var s in a.attrs) e.push({
            goods_id: a.id,
            attr_ids: s,
            attr_names: a.attrs[s].attr_names,
            num: a.attrs[s].num
        });
        app.ajax({
            url: "Cleader|receiveGoodses",
            data: {
                leader_id: t.data.myleader_id,
                goodses: JSON.stringify(e)
            },
            success: function(a) {
                a.code || (t.setData({
                    curHdIndex: 3,
                    page: 1,
                    confirmAttr: !1
                }), t.loadData());
            }
        });
    },
    close: function() {
        this.setData({
            confirmAttr: !1
        });
    }
});