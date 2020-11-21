var xunh, app = getApp();

Page({
    data: {
        imgUrls: [],
        indicatorDots: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3
    },
    onPullDownRefresh: function() {
        this.getinfos(), this.getpingt(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this, e = t.shareid;
        a.setData({
            shareid: e
        }), a.getpingt();
        var i = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: i,
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarTitle({
                    title: a.data.baseinfo.name
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            },
            fail: function(t) {}
        });
        var o = 0;
        t.fxsid && (o = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), app.util.getUserInfo(a.getinfos, o);
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                });
            }
        });
    },
    daojishi: function() {
        var t, a, e, i, o, s = this, r = s.data.overtime, n = new Date().getTime(), d = 1e3 * parseInt(r) - n;
        0 == d && clearInterval(xunh), 0 <= d ? (a = Math.floor(d / 1e3 / 60 / 60 / 24), 
        e = Math.floor(d / 1e3 / 60 / 60 % 24) < 10 ? "0" + Math.floor(d / 1e3 / 60 / 60 % 24) : Math.floor(d / 1e3 / 60 / 60 % 24), 
        i = Math.floor(d / 1e3 / 60 % 60) < 10 ? "0" + Math.floor(d / 1e3 / 60 % 60) : Math.floor(d / 1e3 / 60 % 60), 
        o = Math.floor(d / 1e3 % 60) < 10 ? "0" + Math.floor(d / 1e3 % 60) : Math.floor(d / 1e3 % 60)) : o = i = e = a = 0, 
        t = a + "天" + e + ":" + i + ":" + o, s.setData({
            daojishi: t
        }), xunh = setTimeout(function() {
            s.daojishi();
        }, 1e3);
    },
    ptorder: function() {
        wx.navigateTo({
            url: "/sudu8_page_plugin_pt/orderlist/orderlist"
        });
    },
    getpingt: function() {
        var p = this, t = p.data.shareid;
        app.util.request({
            url: "entry/wxapp/pingtuan",
            data: {
                shareid: t
            },
            success: function(t) {
                for (var a = t.data.data.products, e = t.data.data.lists, i = t.data.data.share, o = t.data.data.products.pt_min, s = t.data.data.products.pt_max, r = e.length, n = {
                    infoimg: "/sudu8_page/resource/img/pe.png"
                }, d = [], u = 0; u < i.pt_max; u++) e[u] ? d.push(e[u]) : d.push(n);
                p.setData({
                    products: a,
                    share: i,
                    lists: d,
                    min: o,
                    max: s,
                    now: r,
                    overtime: t.data.data.overtime,
                    labels: t.data.data.labels
                }), p.daojishi();
            }
        });
    },
    onShareAppMessage: function() {
        var t = this.data.shareid, a = this.data.products, e = "/sudu8_page_plugin_pt/products/products?shareid=" + t + "&id=" + a.id;
        return {
            title: a.title,
            path: e
        };
    }
});