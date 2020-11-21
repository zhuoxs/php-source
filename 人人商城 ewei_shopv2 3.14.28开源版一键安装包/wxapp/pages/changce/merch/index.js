var t = getApp(),
    a = t.requirejs("core"),
    e = t.requirejs("jquery");
Page({
    data: {
        cates: [],
        cateid: 0,
        page: 1,
        loading: !1,
        loaded: !1,
        list: [],
        keyword: "",
        disopt: [],
        range: 0,
        approot: t.globalData.approot
    },
    onLoad: function(e) {
        var i = this;
        e.cateid && i.setData({
            cateid: e.cateid
        });
        var s = t.getCache("mypos");
        s ? (i.setData({
            mypos: s
        }), i.getList()) : wx.getLocation({
            type: "wgs84",
            success: function(a) {
                t.setCache("mypos", {
                    lat: a.latitude,
                    lng: a.longitude,
                    speed: a.speed,
                    accuracy: a.accuracy
                }, 7200), i.setData({
                    mypos: {
                        lat: a.latitude,
                        lng: a.longitude,
                        speed: a.speed,
                        accuracy: a.accuracy
                    }
                }), i.getList()
            },
            fail: function(t) {
                a.alert("取消位置信息将无法定位商家距离！"), i.setData({
                    mypos: {
                        lat: "",
                        lng: ""
                    }
                }), i.getList()
            }
        })
    },
    getCate: function() {
        var t = this;
        a.get("sale/coupon/getCouponCate", {}, function(a) {
            a.list.length > 0 && t.setData({
                cates: a.list
            })
        })
    },
    getList: function() {
        var t = this;
        a.loading(), this.setData({
            loading: !0
        }), a.get("changce/merch/get_list", {
            page: this.data.page,
            cateid: this.data.cateid,
            keyword: this.data.keyword,
            lat: this.data.mypos.lat,
            lng: this.data.mypos.lng,
            range: this.data.range
        }, function(e) {
            var i = {
                loading: !1,
                total: e.total,
                pagesize: e.pagesize,
                cates: e.cates,
                disopt: e.disopt
            };
            e.list.length > 0 && (i.page = t.data.page + 1, i.list = t.data.list.concat(e.list), e.list.length < e.pagesize && (i.loaded = !0), t.setSpeed(e.list)), t.setData(i), a.hideLoading()
        })
    },
    changeMode: function() {
        "block" == this.data.listmode ? this.setData({
            listmode: ""
        }) : this.setData({
            listmode: "block"
        })
    },
    bindSearch: function(t) {
        t.target, this.setData({
            list: [],
            loading: !0,
            loaded: !1
        });
        var a = e.trim(t.detail.value),
            i = this.data.defaults;
        "" != a ? (i.keywords = a, this.setData({
            page: 1,
            params: i,
            fromsearch: !1
        }), this.getList(), this.setRecord(a)) : (i.keywords = "", this.setData({
            page: 1,
            params: i,
            listorder: "",
            fromsearch: !1
        }), this.getList())
    },
    bindInput: function(t) {
        var a = e.trim(t.detail.value);
        this.setData({
            page: 1,
            list: [],
            loading: !0,
            loaded: !1,
            keyword: a,
            fromsearch: !0
        }), this.getList()
    },
    bindFocus: function(t) {
        "" == e.trim(t.detail.value) && this.setData({
            fromsearch: !0
        })
    },
    bindback: function() {
        this.setData({
            fromsearch: !1,
            keyword: ""
        }), this.getList()
    },
    showFilter: function() {
        this.setData({
            isFilterShow: !this.data.isFilterShow,
            isNearShow: !1
        })
    },
    bindCategoryEvents: function(t) {
        var a = t.target.dataset.id;
        this.setData({
            list: [],
            page: 1,
            loading: !0,
            loaded: !1,
            category_parent_selected: a,
            cateid: a,
            selcatename: t.target.dataset.title,
            isFilterShow: !1,
            isNearShow: !1
        }), this.getList()
    },
    showNear: function() {
        this.setData({
            isFilterShow: !1,
            isNearShow: !this.data.isNearShow
        })
    },
    bindDisEvents: function(t) {
        var a = t.target.dataset.id;
        this.setData({
            list: [],
            page: 1,
            loading: !0,
            loaded: !1,
            range: a,
            selrangename: t.target.dataset.title,
            isFilterShow: !1,
            isNearShow: !1
        }), this.getList()
    },
    setSpeed: function(t) {
        if (t && !(t.length < 1)) for (var a in t) {
            var e = t[a];
            if (!isNaN(e.lastratio)) {
                var i = e.lastratio / 100 * 2.5,
                    s = wx.createContext();
                s.beginPath(), s.arc(34, 35, 30, .5 * Math.PI, 2.5 * Math.PI), s.setFillStyle("rgba(0,0,0,0)"), s.setStrokeStyle("rgba(0,0,0,0.2)"), s.setLineWidth(4), s.stroke(), s.beginPath(), s.arc(34, 35, 30, .5 * Math.PI, i * Math.PI), s.setFillStyle("rgba(0,0,0,0)"), s.setStrokeStyle("#ffffff"), s.setLineWidth(4), s.setLineCap("round"), s.stroke();
                var o = "coupon-" + e.id;
                wx.drawCanvas({
                    canvasId: o,
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
    }
});