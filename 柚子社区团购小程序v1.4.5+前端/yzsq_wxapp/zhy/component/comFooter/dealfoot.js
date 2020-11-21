function dealFootNav(e, t) {
    var o = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0;
    if (e.length < 1 && 1 == o) var i = [ {
        img: "../../resource/images/footnav/a.png",
        imgh: "../../resource/images/footnav/ah.png",
        icon: "",
        txt: "首页",
        link: "/sqtg_sun/pages/home/index/index",
        path: "",
        appid: "",
        types: 1,
        typeid: "",
        choose: !1
    }, {
        img: "../../resource/images/footnav/d.png",
        imgh: "../../resource/images/footnav/dh.png",
        icon: "",
        txt: "购物车",
        link: "/sqtg_sun/pages/home/shopcar/shopcar",
        path: "",
        appid: "",
        types: 1,
        typeid: "",
        choose: !1
    }, {
        img: "../../resource/images/footnav/e.png",
        imgh: "../../resource/images/footnav/eh.png",
        icon: "",
        txt: "我的",
        link: "/sqtg_sun/pages/home/my/my",
        path: "",
        appid: "",
        types: 1,
        typeid: "",
        choose: !1
    } ]; else {
        i = [];
        console.log(e);
        for (var a = 0; a < e.length; a++) {
            var s = e[a].clickago_icon, p = e[a].clickafter_icon, n = e[a].pic, g = /https\:\/\//;
            g.test(s) || (s = t + s), g.test(p) || (p = t + p), g.test(n) || (n = t + n);
            var r = {
                img: s,
                imgh: p,
                icon: n,
                txt: e[a].title,
                link: e[a].url,
                path: e[a].path,
                appid: e[a].appid,
                types: e[a].link_type,
                typeid: e[a].url_typeid,
                choose: !1
            };
            i.push(r);
        }
    }
    return i;
}

module.exports = {
    dealFootNav: dealFootNav
};