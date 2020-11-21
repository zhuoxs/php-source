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
    onLoad: function(t) {
        this.setData({
            curHdIndex: t.id ? t.id : 2,
            myleader_id: t.myleaderid
        });
        var a = wx.getStorageSync("userInfo");
        a ? this.setData({
            uInfo: a
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/public/pages/myorder/myorder?id=0");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    onShow: function() {
        this.setData({
            page: 1
        }), this.loadData();
    },
    loadData: function() {
        var s = this, o = s.data.olist, i = s.data.limit, n = s.data.page;
        app.ajax({
            url: "Cleader|getOrderStates",
            success: function(t) {
                s.setData({
                    nav: t.data
                });
            }
        }), app.ajax({
            url: "Cleader|getPinorders",
            data: {
                leader_id: s.data.myleader_id,
                page: n,
                limit: i,
                state: s.data.curHdIndex
            },
            success: function(t) {
                console.log(t);
                var a = !(!t.data || t.data.length < i);
                if (1 == n) o = t.data; else for (var e in t.data) o.push(t.data[e]);
                n += 1, s.setData({
                    olist: o,
                    show: !0,
                    hasMore: a,
                    page: n,
                    imgroot: t.other.img_root
                });
            }
        });
    },
    swichNav: function(t) {
        var a = t.currentTarget.dataset.state;
        this.setData({
            curHdIndex: a,
            page: 1
        }), this.loadData();
    },
    onReachBottom: function() {
        this.data.hasMore ? this.loadData() : wx.showToast({
            title: "没有更多订单啦~",
            icon: "none"
        });
    },
    confirmAttr: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.olist[a];
        console.log(e), this.setData({
            goods: e,
            confirmAttr: !0
        });
    },
    confirmAttrReceive: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.olist[a];
        console.log(e), this.setData({
            goods: e,
            confirmAttrReceive: !0
        });
    },
    getSinglePlat: function(t) {
        var a = this, e = a.data.check, s = a.data.goods, o = t.currentTarget.dataset.index;
        console.log(o), e.checkAll = !0, s.attrs[o].status = !s.attrs[o].status, a.setData({
            goods: s
        });
    },
    lastNum: function() {
        var a = this, t = a.data.goods;
        app.ajax({
            url: "Cleader|receivePingoodses",
            data: {
                leader_id: a.data.myleader_id,
                pinorder_id: t.id
            },
            success: function(t) {
                t.code || (a.setData({
                    curHdIndex: 3,
                    page: 1,
                    confirmAttr: !1
                }), a.loadData());
            }
        });
    },
    close: function() {
        this.setData({
            confirmAttr: !1
        });
    },
    onBtnTab: function(t) {
        var a = t.currentTarget.dataset.headsid + "-" + t.currentTarget.dataset.goodsid + "-" + t.currentTarget.dataset.userid + "-" + t.currentTarget.dataset.leaderid;
        app.navTo("/sqtg_sun/pages/plugin/spell/join/join?id=" + a);
    }
});