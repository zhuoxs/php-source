var app = getApp();

Page({
    data: {
        currenttab: 0,
        navArr: [ {
            name: "普通",
            func: "getGoods"
        }, {
            name: "拼团",
            func: "getPinGoods"
        } ],
        page: 1,
        pinPage: 1,
        limit: 5,
        olist: [],
        count: 0
    },
    onloadDataTel: function(t) {
        if (t) {
            if (this.data.currenttab == t.currentTarget.dataset.tabid) return !1;
            this.setData({
                currenttab: t.currentTarget.dataset.tabid,
                page: 1,
                pinPage: 1
            }), this.data.key ? this.loadData() : this.setData({
                olist: []
            });
        }
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("linkaddress");
        this.setData({
            linkaddress: a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        0 < this.data.count && this.data.olist.length < this.data.count ? (console.log(this.data.count), 
        console.log(this.data.olist.length), this.loadData()) : wx.showToast({
            title: "没有更多商品啦~",
            icon: "none"
        });
    },
    onShareAppMessage: function() {},
    bindKeyInput: function(t) {
        this.data.currenttab;
        this.data.key = t.detail.value;
    },
    loadData: function() {
        var t = this.data.currenttab;
        this[this.data.navArr[t].func](this.data.key);
    },
    getGoods: function(t) {
        var o = this, n = o.data.olist, i = o.data.limit, s = o.data.page, a = wx.getStorageSync("linkaddress");
        app.ajax({
            url: "Cleader|goodsSelect",
            data: {
                leader_id: a.id,
                page: s,
                limit: i,
                key: t
            },
            success: function(t) {
                console.log(t);
                var a = !(t.data.length < i);
                if (1 == s) n = t.data; else for (var e in t.data) n.push(t.data[e]);
                s += 1, o.setData({
                    olist: n,
                    show: !0,
                    hasMore: a,
                    page: s,
                    imgroot: t.other.img_root,
                    count: t.other.count,
                    type: 0
                });
            }
        });
    },
    getPinGoods: function(t) {
        var o = this, n = o.data.olist, i = o.data.limit, s = o.data.pinPage, a = wx.getStorageSync("linkaddress");
        app.ajax({
            url: "Cleader|pingoodsSelect",
            data: {
                leader_id: a.id,
                page: s,
                limit: i,
                key: t
            },
            success: function(t) {
                console.log(t);
                var a = !(t.data.length < i);
                if (1 == s) n = t.data; else for (var e in t.data) n.push(t.data[e]);
                s += 1, o.setData({
                    olist: n,
                    show: !0,
                    hasMore: a,
                    pinPage: s,
                    imgroot: t.other.img_root,
                    count: t.other.count,
                    type: 1
                });
            }
        });
    },
    search: function() {
        this.setData({
            page: 1,
            pinPage: 1
        }), this.data.key ? (this.loadData(), console.log("aa")) : this.setData({
            olist: []
        });
    },
    detail: function(t) {
        if (0 == this.data.type) {
            var a = "/sqtg_sun/pages/zkx/pages/classifydetail/classifydetail?id=" + t.currentTarget.dataset.id;
            app.lunchTo(a);
        } else {
            console.log("拼团");
            var e = "/sqtg_sun/pages/plugin/spell/info/info?id=" + t.currentTarget.dataset.id + "-0";
            app.lunchTo(e);
        }
    }
});