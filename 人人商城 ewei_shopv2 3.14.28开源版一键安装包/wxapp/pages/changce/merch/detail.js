var t = getApp(),
    a = t.requirejs("core");
t.requirejs("jquery");
Page({
    data: {
        merchid: 0,
        merch: [],
        cateid: 0,
        page: 1,
        isnew: 0,
        isrecommand: 0,
        loading: !1,
        loaded: !1,
        list: [],
        approot: t.globalData.approot
    },
    onLoad: function(t) {
        this.setData({
            merchid: t.id
        }), this.getMerch(), this.getList()
    },
    getMerch: function() {
        var t = this;
        a.get("changce/merch/get_detail", {
            id: t.data.merchid
        }, function(a) {
            t.setData({
                merch: a.merch
            })
        })
    },
    getList: function() {
        var t = this;
        a.loading(), this.setData({
            loading: !0
        }), a.get("changce/merch/goods_list", {
            page: this.data.page,
            cateid: this.data.cateid,
            id: t.data.merchid,
            isnew: this.data.isnew,
            isrecommand: this.data.isrecommand
        }, function(e) {
            var i = {
                loading: !1,
                total: e.total,
                pagesize: e.pagesize
            };
            e.list.length > 0 && (i.page = t.data.page + 1, i.list = t.data.list.concat(e.list), e.list.length < e.pagesize && (i.loaded = !0), t.setSpeed(e.list)), t.setData(i), a.hideLoading()
        })
    },
    clickrec: function() {
        this.setData({
            isrecommand: 1,
            isnew: 0,
            page: 1,
            loading: !1,
            loaded: !1,
            list: []
        }), this.getList()
    },
    clicknew: function() {
        this.setData({
            isrecommand: 0,
            isnew: 1,
            page: 1,
            loading: !1,
            loaded: !1,
            list: []
        }), this.getList()
    },
    clickall: function() {
        this.setData({
            isrecommand: 0,
            isnew: 0,
            page: 1,
            loading: !1,
            loaded: !1,
            list: []
        }), this.getList()
    },
    setSpeed: function(t) {
        if (t && !(t.length < 1)) for (var a in t) {
            var e = t[a];
            if (!isNaN(e.lastratio)) {
                var i = e.lastratio / 100 * 2.5,
                    s = wx.createContext();
                s.beginPath(), s.arc(34, 35, 30, .5 * Math.PI, 2.5 * Math.PI), s.setFillStyle("rgba(0,0,0,0)"), s.setStrokeStyle("rgba(0,0,0,0.2)"), s.setLineWidth(4), s.stroke(), s.beginPath(), s.arc(34, 35, 30, .5 * Math.PI, i * Math.PI), s.setFillStyle("rgba(0,0,0,0)"), s.setStrokeStyle("#ffffff"), s.setLineWidth(4), s.setLineCap("round"), s.stroke();
                var n = "coupon-" + e.id;
                wx.drawCanvas({
                    canvasId: n,
                    actions: s.getActions()
                })
            }
        }
    },
    bindTab: function(t) {
        var e = a.pdata(t).cateid;
        this.setData({
            cateid: e,
            page: 1,
            list: []
        }), this.getList()
    },
    onReachBottom: function() {
        this.data.loaded || this.data.list.length == this.data.total || this.getList()
    },
    jump: function(t) {
        var e = a.pdata(t).id;
        e > 0 && wx.navigateTo({
            url: "/pages/sale/coupon/detail/index?id=" + e
        })
    },
    goBack: function(t) {
        wx.navigateBack({})
    }
});