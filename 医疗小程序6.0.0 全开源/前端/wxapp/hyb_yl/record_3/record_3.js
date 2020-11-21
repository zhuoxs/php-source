var app = getApp();

Page({
    data: {
        current: 0,
        tabArr: [],
        pageCountWrap: [],
        secArr: [],
        img_arr: [],
        info: [],
        currentPage: 1,
        pageCount: 0
    },
    chooseCheck: function(e) {
        for (var a = e.currentTarget.dataset.index, t = e.currentTarget.dataset.indexs, r = this.data.secArr, o = 0; o < r[t].secArr1.length; o++) 1 == r[t].secArr1[o].displaytype && (r[t].secArr1[o].items[a].checked = !r[t].secArr1[o].items[a].checked, 
        console.log(r[t].secArr1[o]), r[t].secArr1[o].items[a].checked ? r[t].secArr1[o].description += r[t].secArr1[o].items[a].title + ";" : r[t].secArr1[o].description = r[t].secArr1[o].description.replace(r[t].secArr1[o].items[a].title + ";", ""));
        console.log(r), this.setData({
            secArr: r
        });
    },
    onLoad: function(e) {
        var l = this, a = e.str, t = JSON.parse(a), r = JSON.parse(e.val);
        console.log(r);
        var o = r.title, s = r.pic, i = r.hzid, c = r.hospital, n = r.dates;
        console.log(n);
        var d = wx.getStorageSync("color"), p = l.data.currentPage, g = l.data.pageCount;
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: d
        }), wx.setNavigationBarTitle({
            title: t[0].name
        });
        var u = t[0].projectArr, h = u[0].id;
        console.log(u), app.util.request({
            url: "entry/wxapp/Getzlinfo",
            cachetime: "0",
            data: {
                zlid: h,
                page: 10
            },
            success: function(e) {
                console.log(e);
                var a = e.data.data, t = {}, r = JSON.parse(JSON.stringify(e.data.data));
                t.secArr1 = [], g = Math.ceil(r.length / 10);
                for (var o = 10 * (p - 1), s = 10 * p; o < s; o++) r[o] && t.secArr1.push(r[o]);
                t.id = h;
                var i = l.data.tabArr;
                t.name = i[0].projectArr[0].name;
                for (var c = 0; c < a.length; c++) {
                    if (console.log(a[c].displaytype), 2 == r[c].displaytype) {
                        r[c].picker = {}, r[c].picker.items = [], r[c].picker.displayorder = "", console.log(r[c].items);
                        for (o = 0, s = r[c].items.length; o < s; o++) console.log(1), r[c].picker.items[o] = r[c].items[o].title;
                    }
                    0 == r[c].displaytype && (r[c].radio = {}, r[c].radio.items = [], r[c].radio.displayorder = "", 
                    console.log(r[c].items), r[c].radio.items = r[c].items);
                }
                var n = l.data.secArr;
                console.log(n), n.push(t), console.log(n, a), app.globalData.secArr1 = n[l.data.pageCountWrap.length].secArr1, 
                l.setData({
                    secArr: n,
                    pageCountWrap: l.data.pageCountWrap.concat([ l.data.pageCountWrap.length ]),
                    currentShow: l.data.pageCountWrap.length,
                    currentErji: n[0].id,
                    pageCount: g,
                    currentPage: p + 1,
                    data: e.data.data,
                    currentEr: 0
                });
            }
        });
        var A = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(e) {
                console.log(e), l.setData({
                    url: e.data
                });
            }
        }), l.setData({
            tabArr: t,
            time: n,
            hospital: c,
            hzid: i,
            org_pic: s,
            title: o,
            uniacid: A
        });
        d = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: d
        }), l.setData({
            backgroundColor: d
        });
        e.con;
    },
    remove: function(e, a) {
        for (var t = 0; t < e.length; t++) if (e[t] == a) return !1;
        return !0;
    },
    lineClick: function(e) {
        console.log(e);
        var a = this.data.secArr, t = e.currentTarget.dataset.indexs, r = e.currentTarget.dataset.idx;
        a[t].secArr1[r].description = e.detail.value, this.setData({
            secArr: a
        });
    },
    nextClick: function() {
        wx.navigateBack({
            delta: 4
        });
    },
    choosePhoto: function(e) {
        var a = this, t = a.data.secArr;
        console.log(t);
        e.currentTarget.dataset.index;
        var r = e.currentTarget.dataset.indexs, o = e.currentTarget.dataset.idx;
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                t[r].secArr1[o].items = t[r].secArr1[o].items.concat(e.tempFilePaths), t[r].secArr1[o].description = t[r].secArr1[o].items, 
                9 <= t[r].secArr1[o].items.length && (t[r].secArr1[o].items.length = 9), console.log(t), 
                a.setData({
                    secArr: t
                });
            }
        });
    },
    upload: function() {
        var e = this.data.uniacid;
        console.log(this.data.img_arr);
        for (var a = 0; a < this.data.img_arr.length; a++) wx.uploadFile({
            url: this.data.url + "app/index.php?i=" + e + "&c=entry&a=wxapp&do=Upload&m=hyb_bm",
            filePath: this.data.img_arr[a],
            name: "upfile",
            formData: adds,
            success: function(e) {
                console.log(e);
            }
        });
        this.setData({
            formdata: ""
        });
    },
    delClick: function(e) {
        var a = this.data.secArr, t = e.currentTarget.dataset.index, r = e.currentTarget.dataset.indexs, o = e.currentTarget.dataset.idx;
        a[r].secArr1[o].items.splice(t, 1), this.setData({
            secArr: a
        });
    },
    subClick: function(e) {
        var l = this, a = l.data.hzid, t = l.data.org_pic, r = l.data.time, o = l.data.hospital, s = l.data.title, i = e.detail.value, c = this.data.secArr, d = l.data.current, n = l.data.tabArr, p = l.data.currentErji, g = l.data.currentEr, u = i.bg_id;
        console.log(n, d), (C = {}).id = n[d].id, C.name = n[d].name, console.log(p, c);
        for (var h = 0, A = c.length; h < A; h++) c[h].id == p && (C.data = c[h]);
        console.log(c);
        for (h = 0; h < C.data.secArr1.length; h++) delete C.data.secArr1[h].uniacid, delete C.data.secArr1[h].activityid, 
        delete C.data.secArr1[h].content, delete C.data.secArr1[h].displayorder, delete C.data.secArr1[h].essential, 
        delete C.data.secArr1[h].fieldstype, 3 != C.data.secArr1[h].displaytype && (delete C.data.secArr1[h].highStandard, 
        delete C.data.secArr1[h].lowStandard), 0 != C.data.secArr1[h].displaytype && 2 != C.data.secArr1[h].displaytype && 1 != C.data.secArr1[h].displaytype && delete C.data.secArr1[h].items;
        console.log(C), app.util.request({
            url: "entry/wxapp/Getvalues",
            data: {
                hzid: a,
                org_pic: t,
                time: r,
                hospital: o,
                title: s,
                bg_id: u,
                values: C,
                useropenid: wx.getStorageSync("openid")
            },
            success: function(e) {
                console.log(e);
                var a = e.data.data;
                l.setData({
                    bg_id: a
                });
            }
        });
        var f = l.data.data, m = l.data.currentPage, y = l.data.pageCount;
        if (l.pageRemove(l.data.pageCountWrap, l.data.currentShow + 1)) if (console.log(1), 
        y < m) if (console.log(g, n[d].projectArr), g < n[d].projectArr.length - 1) console.log(2), 
        app.util.request({
            url: "entry/wxapp/Zdybd",
            data: {
                id: n[d].projectArr[g + 1].id
            },
            success: function(e) {
                console.log(e);
                var a = e.data.data, t = {}, r = JSON.parse(JSON.stringify(e.data.data));
                t.secArr1 = [];
                y = Math.ceil(r.length / 10);
                for (var o = 0, s = 10; o < s; o++) r[o] && t.secArr1.push(r[o]);
                var i = l.data.tabArr;
                t.id = i[d].projectArr[g + 1].id, t.name = i[d].projectArr[g + 1].name;
                for (var c = 0; c < a.length; c++) {
                    if (console.log(a[c].displaytype), 2 == r[c].displaytype) {
                        r[c].picker = {}, r[c].picker.items = [], r[c].picker.displayorder = "", console.log(r[c].items);
                        for (o = 0, s = r[c].items.length; o < s; o++) console.log(1), r[c].picker.items[o] = r[c].items[o].title;
                    }
                    0 == r[c].displaytype && (r[c].radio = {}, r[c].radio.items = [], r[c].radio.displayorder = "", 
                    console.log(r[c].items), r[c].radio.items = r[c].items);
                }
                var n = l.data.secArr;
                console.log(n, l.data.currentShow), n.push(t), console.log(n, a), app.globalData.secArr1 = n[l.data.pageCountWrap.length].secArr1, 
                l.setData({
                    secArr: n,
                    pageCountWrap: l.data.pageCountWrap.concat([ l.data.pageCountWrap.length ]),
                    currentShow: l.data.pageCountWrap.length,
                    currentErji: i[d].projectArr[g + 1].id,
                    pageCount: y,
                    currentPage: 2,
                    data: e.data.data,
                    currentEr: g + 1
                });
            }
        }), console.log(n[d].projectArr[g + 1].id); else {
            console.log("fdsjfsklfsklfsl klskj foiw rfoiwe sl ");
            g = 0;
            if (console.log(n[d + 1]), n[d + 1]) {
                var v = n[d + 1].id;
                console.log(v, n), app.util.request({
                    url: "entry/wxapp/Getzlinfo",
                    cachetime: "0",
                    data: {
                        zlid: n[d + 1].projectArr[g].id
                    },
                    success: function(e) {
                        console.log(e);
                        var a = e.data.data, t = {}, r = JSON.parse(JSON.stringify(e.data.data));
                        t.secArr1 = [];
                        y = Math.ceil(r.length / 10);
                        for (var o = 0, s = 10; o < s; o++) r[o] && t.secArr1.push(r[o]);
                        var i = l.data.tabArr;
                        console.log(i, d, g), t.id = i[d + 1].projectArr[g].id, t.name = i[d + 1].projectArr[g].name;
                        for (var c = 0; c < a.length; c++) {
                            if (console.log(a[c].displaytype), 2 == r[c].displaytype) {
                                r[c].picker = {}, r[c].picker.items = [], r[c].picker.displayorder = "", console.log(r[c].items);
                                for (o = 0, s = r[c].items.length; o < s; o++) console.log(1), r[c].picker.items[o] = r[c].items[o].title;
                            }
                            0 == r[c].displaytype && (r[c].radio = {}, r[c].radio.items = [], r[c].radio.displayorder = "", 
                            console.log(r[c].items), r[c].radio.items = r[c].items);
                        }
                        var n = l.data.secArr;
                        console.log(n), n.push(t), console.log(n, a), app.globalData.secArr1 = n[l.data.pageCountWrap.length].secArr1, 
                        l.setData({
                            secArr: n,
                            pageCountWrap: l.data.pageCountWrap.concat([ l.data.pageCountWrap.length ]),
                            currentShow: l.data.pageCountWrap.length,
                            currentErji: i[d + 1].projectArr[g].id,
                            pageCount: y,
                            currentPage: 2,
                            data: e.data.data,
                            currentEr: g,
                            current: d + 1
                        });
                    }
                });
            } else wx.showModal({
                content: "已全部填写完毕",
                success: function(e) {
                    e.confirm && wx.navigateBack({
                        delta: 4
                    });
                }
            });
        } else {
            var C = {}, k = JSON.parse(JSON.stringify(f));
            C.secArr1 = [];
            var w = 10 * (m - 1);
            for (A = 10 * m; w < A; w++) k[w] && C.secArr1.push(k[w]);
            n = l.data.tabArr;
            C.name = n[0].projectArr[0].name;
            for (h = 0; h < f.length; h++) {
                if (2 == k[h].displaytype) {
                    k[h].picker = {}, k[h].picker.items = [], k[h].picker.displayorder = "";
                    for (w = 0, A = k[h].items.length; w < A; w++) k[h].picker.items[w] = k[h].items[w].title;
                }
                0 == k[h].displaytype && (k[h].radio = {}, k[h].radio.items = [], k[h].radio.displayorder = "", 
                k[h].radio.items = k[h].items);
            }
            c = l.data.secArr;
            C.id = l.data.currentErji, c.push(C), app.globalData.secArr1 = c[l.data.pageCountWrap.length].secArr1, 
            l.setData({
                secArr: c,
                pageCountWrap: l.data.pageCountWrap.concat([ l.data.pageCountWrap.length ]),
                currentShow: l.data.pageCountWrap.length,
                currentPage: m + 1
            });
        } else console.log(2), l.setData({
            currentShow: l.data.currentShow + 1
        });
    },
    pageRemove: function(e, a) {
        console.log(e, a);
        for (var t = 0; t < e.length; t++) if (e[t] == a) return console.log(e[t], a), !1;
        return !0;
    },
    lastClick: function() {
        var e = this.data.tabArr, a = this.data.current, t = this.data.currentEr;
        console.log(e, t), 0 == t && (0 < a && a--, t = e[a].projectArr.length - 1, this.setData({
            currentEr: t,
            current: a
        })), console.log(e), this.setData({
            currentShow: this.data.currentShow - 1
        });
    },
    radioChange: function(e) {
        console.log(e);
        var a = this.data.secArr, t = e.currentTarget.dataset.idx;
        a[e.currentTarget.dataset.indexs].secArr1[t].description = e.detail.value, console.log(a), 
        this.setData({
            secArr: a
        });
    },
    bloodClick: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value);
        var a = this.data.secArr, t = e.currentTarget.dataset.idx, r = e.currentTarget.dataset.indexs;
        console.log(a[r]), a[r].secArr1[t].picker.displayorder = e.detail.value, a[r].secArr1[t].description = a[r].secArr1[t].picker.items[e.detail.value], 
        this.setData({
            secArr: a
        });
    },
    onReady: function() {},
    onShow: function() {
        console.log(2);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});