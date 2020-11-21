function a(a) {
    var e = a.data.wxSearchData;
    e.view.isShow = !1, a.setData({
        wxSearchData: e
    });
}

function e(a) {
    var e = [];
    try {
        if (e = wx.getStorageSync("wxSearchHisKeys")) {
            var t = a.data.wxSearchData;
            t.his = e, a.setData({
                wxSearchData: t
            });
        }
    } catch (a) {}
}

var t = [], c = [];

module.exports = {
    init: function(a, t, c, i, r, s) {
        var n = {}, h = {
            barHeight: t,
            isShow: !1
        };
        h.isShowSearchKey = void 0 === i || i, h.isShowSearchHistory = void 0 === r || r, 
        n.keys = c, wx.getSystemInfo({
            success: function(e) {
                var c = e.windowHeight;
                h.seachHeight = c - t, n.view = h, a.setData({
                    wxSearchData: n
                });
            }
        }), "function" == typeof s && s(), e(a);
    },
    initColor: function(a) {
        t = a;
    },
    initMindKeys: function(a) {
        c = a;
    },
    wxSearchInput: function(a, e, t) {
        var i = e.data.wxSearchData, r = a.detail.value, s = [];
        if (void 0 === r || 0 == r.length) ; else for (var n = 0; n < c.length; n++) {
            var h = c[n];
            h.indexOf(r) > -1 && s.push(h);
        }
        i.value = r, i.mindKeys = s, e.setData({
            wxSearchData: i
        });
    },
    wxSearchFocus: function(a, e, t) {
        var c = e.data.wxSearchData;
        c.view.isShow = !0, e.setData({
            wxSearchData: c
        }), "function" == typeof t && t();
    },
    wxSearchBlur: function(a, e, t) {
        var c = e.data.wxSearchData;
        c.value = a.detail.value, e.setData({
            wxSearchData: c
        }), "function" == typeof t && t();
    },
    wxSearchKeyTap: function(a, e, t) {
        var c = e.data.wxSearchData;
        c.value = a.target.dataset.key, e.setData({
            wxSearchData: c
        }), "function" == typeof t && t();
    },
    wxSearchAddHisKey: function(t) {
        a(t);
        var c = t.data.wxSearchData.value;
        if (void 0 !== c && 0 != c.length) {
            var i = wx.getStorageSync("wxSearchHisKeys");
            i ? (i.indexOf(c) < 0 && i.unshift(c), wx.setStorage({
                key: "wxSearchHisKeys",
                data: i,
                success: function() {
                    e(t);
                }
            })) : ((i = []).push(c), wx.setStorage({
                key: "wxSearchHisKeys",
                data: i,
                success: function() {
                    e(t);
                }
            }));
        }
    },
    wxSearchDeleteKey: function(a, t) {
        var c = a.target.dataset.key, i = wx.getStorageSync("wxSearchHisKeys");
        i.splice(i.indexOf(c), 1), wx.setStorage({
            key: "wxSearchHisKeys",
            data: i,
            success: function() {
                e(t);
            }
        });
    },
    wxSearchDeleteAll: function(a) {
        wx.removeStorage({
            key: "wxSearchHisKeys",
            success: function(e) {
                var t = [], c = a.data.wxSearchData;
                c.his = t, a.setData({
                    wxSearchData: c
                });
            }
        });
    },
    wxSearchHiddenPancel: a
};