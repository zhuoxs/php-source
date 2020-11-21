var app = getApp();

Page({
    data: {
        departmentArr: [],
        arr: [],
        didArr: [],
        none: [ {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/微信图片_20180727121929.png",
            con: "暂无信息"
        } ]
    },
    onLoad: function(t) {
        var r = t.id, a = JSON.parse(t.val), e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        }), this.setData({
            backgroundColor: e,
            id: r,
            val: a
        });
        var o = t.con;
        this.setData({
            con: o
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
        var t = this, r = t.data.departmentArr, a = JSON.stringify(t.data.val), e = JSON.parse(JSON.stringify(r));
        console.log(r);
        for (var o = 0; o < e.length; o++) {
            for (var n = 0; n < e[o].projectArr.length; n++) e[o].projectArr[n].checked || (e[o].projectArr.splice(n, 1), 
            n--);
            0 == e[o].projectArr.length && (e.splice(o, 1), o--);
        }
        console.log(e);
        var c = JSON.stringify(e);
        wx.navigateTo({
            url: "/hyb_yl/record_3/record_3?con=" + t.data.con + "&str=" + c + "&val=" + a
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