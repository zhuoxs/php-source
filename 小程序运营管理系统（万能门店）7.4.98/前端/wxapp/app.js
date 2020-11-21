App({
    onLaunch: function() {
        var s = this;
        wx.getSystemInfo({
            success: function(e) {
                wx.setStorageSync("systemInfo", e);
                var i = e.windowWidth, o = e.windowHeight;
                s.globalData.ww = i, s.globalData.hh = o, -1 != e.model.search("iPhone X") && (s.globalData.isIphoneX = !0), 
                "ios" == e.platform ? s.globalData.isios = !0 : s.globalData.isios = !1;
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onError: function() {},
    util: require("sudu8_page/resource/js/util.js"),
    siteInfo: require("siteinfo.js"),
    bezier: function(e, i) {
        for (var o, s, t, a = [], n = 0; n <= i; n++) {
            for (t = e.slice(0), s = []; o = t.shift(); ) if (t.length) s.push(u([ o, t[0] ], n / i)); else {
                if (!(1 < s.length)) break;
                t = s, s = [];
            }
            a.push(s[0]);
        }
        function u(e, i) {
            var o, s, t, a, n, u, r, g;
            return o = e[0], a = (s = e[1]).x - o.x, n = s.y - o.y, t = Math.pow(Math.pow(a, 2) + Math.pow(n, 2), .5), 
            u = n / a, r = Math.atan(u), g = t * i, {
                x: o.x + g * Math.cos(r),
                y: o.y + g * Math.sin(r)
            };
        }
        return {
            bezier_points: a
        };
    },
    globalData: {
        isIphoneX: !1,
        userInfo: null,
        i_tel: "../../sudu8_page/resource/img/i_tel.png",
        i_add: "../../sudu8_page/resource/img/i_add.png",
        i_time: "../../sudu8_page/resource/img/i_time.png",
        close: "../../sudu8_page/resource/img/c.png",
        v_ico: "../../sudu8_page/resource/img/p.png",
        i_view: "../../sudu8_page/resource/img/i_view.png"
    }
});