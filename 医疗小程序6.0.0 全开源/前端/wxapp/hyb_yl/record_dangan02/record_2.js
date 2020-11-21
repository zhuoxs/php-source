var app = getApp();

Page({
    data: {
        departmentArr: [],
        arr: [],
        didArr: []
    },
    onLoad: function(t) {
        var r = t.id, a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        }), this.setData({
            backgroundColor: a,
            id: r
        });
        var e = t.con;
        this.setData({
            con: e
        });
    },
    chooseProject: function(t) {
        var r = this, a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.idx, o = (t.currentTarget.dataset.id, 
        r.data.departmentArr), n = t.currentTarget.dataset.did;
        r.data.didArr, r.data.arr;
        console.log(o, n), o[a].projectArr[e].checked = !o[a].projectArr[e].checked, console.log(o), 
        r.setData({
            departmentArr: o
        });
    },
    deepcopy: function(r) {
        function t(t) {
            return r.apply(this, arguments);
        }
        return t.toString = function() {
            return r.toString();
        }, t;
    }(function(t) {
        for (var r = [], a = 0, e = t.length; a < e; a++) t[a] instanceof Array ? r[a] = deepcopy(t[a]) : r[a] = t[a];
        return r;
    }),
    nextClick: function() {
        var t = this.data.departmentArr, r = JSON.parse(JSON.stringify(t));
        console.log(t);
        for (var a = 0; a < r.length; a++) {
            for (var e = 0; e < r[a].projectArr.length; e++) r[a].projectArr[e].checked || (r[a].projectArr.splice(e, 1), 
            e--);
            0 == r[a].projectArr.length && (r.splice(a, 1), a--);
        }
        console.log(r);
        var o = JSON.stringify(r);
        wx.navigateTo({
            url: "/hyb_yl/record_3/record_3?con=" + this.data.con + "&str=" + o
        });
    },
    onReady: function() {
        this.getSelpar(), this.getAllparzilei();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getAllparzilei: function() {
        var e = this, t = e.data.id;
        app.util.request({
            url: "entry/wxapp/Allparzilei",
            data: {
                id: t
            },
            success: function(t) {
                console.log(t);
                for (var r = 0; r < t.data.data.length; r++) for (var a = 0; a < t.data.data[r].projectArr.length; a++) t.data.data[r].projectArr[a].checked = !1;
                e.setData({
                    departmentArr: t.data.data
                });
            }
        });
    },
    getSelpar: function() {
        var r = this, t = r.data.id;
        app.util.request({
            url: "entry/wxapp/Selpar",
            data: {
                id: t
            },
            success: function(t) {
                console.log(t), r.setData({
                    resdata: t.data.data
                });
            }
        });
    }
});