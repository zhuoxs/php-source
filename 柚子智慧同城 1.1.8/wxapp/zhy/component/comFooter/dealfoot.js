module.exports = {
    dealFootNav: function(e, i, t) {
        if (e.length < 1 && 1 != t) s = [ {
            img: "/zhy/resource/images/nav/a.png",
            imgh: "/zhy/resource/images/nav/ah.png",
            icon: "",
            txt: "首页",
            link: "/pages/home/home",
            path: "",
            appid: "",
            types: 1,
            typeid: "",
            choose: !1
        }, {
            img: "/zhy/resource/images/nav/d.png",
            imgh: "/zhy/resource/images/nav/dh.png",
            icon: "",
            txt: "商家",
            link: "/pages/merchants/merchants",
            path: "",
            appid: "",
            types: 1,
            typeid: "",
            choose: !1
        }, {
            img: "/zhy/resource/images/release.png",
            imgh: "/zhy/resource/images/release.png",
            icon: "",
            txt: "发布",
            link: "/pages/release/release",
            path: "",
            appid: "",
            types: 1,
            typeid: "",
            choose: !1
        }, {
            img: "/zhy/resource/images/nav/f.png",
            imgh: "/zhy/resource/images/nav/fh.png",
            icon: "",
            txt: "圈子",
            link: "/pages/circle/circle",
            path: "",
            appid: "",
            types: 1,
            typeid: "",
            choose: !1
        }, {
            img: "/zhy/resource/images/nav/e.png",
            imgh: "/zhy/resource/images/nav/eh.png",
            icon: "",
            txt: "我的",
            link: "/pages/mine/mine",
            path: "",
            appid: "",
            types: 1,
            typeid: "",
            choose: !1
        } ]; else for (var s = [], p = 0; p < e.length; p++) {
            var a = e[p].clickago_icon, h = e[p].clickafter_icon, n = e[p].pic, r = /https\:\/\//, g = /zhy\/resource\//;
            r.test(a) || g.test(a) || (a = i + a), r.test(h) || g.test(h) || (h = i + h), r.test(n) || g.test(n) || (n = i + n);
            var o = {
                img: a,
                imgh: h,
                icon: n,
                txt: e[p].title,
                link: e[p].url,
                path: e[p].path,
                appid: e[p].appid,
                types: e[p].link_type,
                typeid: e[p].url_typeid,
                choose: !1
            };
            s.push(o);
        }
        return s;
    }
};